<?php
error_reporting(0);//ELIMINAR WARNINGS DEL SERVIDOR.
	header('Cache-Control: no cache'); //NO ALMACENAR EN CACHÉ LOS DATOS DE LA PÁGINA.
	header('Content-Type: text/html; charset=ISO-8859-1'); //PONER ACENTOS EN LA PÁGINA
	//mysql_query('SET NAMES "UTF-8"');//REALIZAR BÚSQUEDA CON ACENTOS.
	session_start(); //INICIO DE SESIÓN.
	session_cache_limiter('private_no_expire'); //CACHÉ SIN EXPIRACIÓN.
		
	#VARIABLES DE SESIÓN.	
    $_SESSION['noms'];
    $_SESSION['apes'];
	$_SESSION['dnis'];
	$_SESSION['anios'];
    $_SESSION['tipos'];
    $_SESSION['divis'];

    function ConectarServidor(){
        $link;

        $link = mysqli_connect('localhost', 'root') or die("Error al conectar con el servidor ".mysql_error());

        return $link;
    }

    function SeleccionarBDD($Conexion){
        
        $bdd = mysqli_select_db($Conexion, 'tecnica6moron') or die ("Error al seleccionar base de datos ".mysql_error());

        return $bdd;
    }

    function Desconectar($resultado,$Conexion){
		
		if($Conexion)
			
		mysqli_close($Conexion);
}

    function TodosAlumnos(){
        if($_POST['dni']){
            try{
                $Conexion = ConectarServidor();
                $tabla = SeleccionarBDD($Conexion);
                $dni = $_POST['dni'];
                $sql = "select * from Alumnos where Nro_Documento = ".$dni;

                $resultado = mysqli_query($Conexion, $sql) or die ("Error al ejecutar consulta");

                if($row = mysqli_fetch_array($resultado)){
                $id = $row[0];
				$nom = $row[1];
				$ape = $row[2]; 
                $dni = $row[3];
                $anio = $row[4];
                $edad = $row[5];
                $tipo = $row[6];
				}
            }
            catch (Exception $e) {
                echo "Error en la función mostrar";
            }
            Desconectar($resultado,$Conexion);
        }
    }

    function InsertarAlumno(){
    try {
        
        $Conexion = ConectarServidor();
        SeleccionarBDD($Conexion); 

       
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $nroDocumento = $_POST['dni'] ?? '';
        $anio = isset($_POST['anio']) ? intval($_POST['anio']) : 0;
        $division = isset($_POST['divi']) ? intval($_POST['divi']) : 0;
        $tipo = $_POST['tipo'] ?? '';

        
        $stmt = $Conexion->prepare("CALL InsertarAlumno(?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error en prepare(): " . $Conexion->error);
        }

        
        $stmt->bind_param("ssiiss", $apellido, $nombre, $anio, $division, $tipo, $nroDocumento);

        
        $ok = $stmt->execute();

       
        if (method_exists($Conexion, 'next_result')) {
            $Conexion->next_result();
        }

       
        if ($ok) {
            echo "Alumno insertado correctamente.";
        } else {
            echo "No se pudo registrar al alumno correctamente. Error: " . $stmt->error;
        }
    } catch (Exception $e) {
        echo "Error al ejecutar insert: " . $e->getMessage();
    } finally {
      
        
       Desconectar($stmt, $Conexion);
    }
}

   function ActualizarAlumno() {
    try {
        $Conexion = ConectarServidor();
        SeleccionarBDD($Conexion);

        $id = intval($_POST['id']);
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $dni = $_POST['dni'];
        $anio = $_POST['anio'];
        $divi = $_POST['divi'];
        $tipo = $_POST['tipo'];

        $stmt = $Conexion->prepare("CALL ActualizarAlumno(?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issiiss", $id, $apellido, $nombre, $anio, $divi, $tipo, $dni);
$stmt->execute();


        if ($stmt) {
            echo "<div class='alert alert-success mt-3'>Alumno actualizado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>No se pudo actualizar el alumno.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger mt-3'>Error: " . $e->getMessage() . "</div>";
    }

    Desconectar(null, $Conexion);
}
    
    function EliminarAlumno(){
        if($_POST['BotonDelete']){
            try{
                $NombreConexion = ConectarServidor();
		        $tabla = SeleccionarBaseDeDatos($NombreConexion);
		        $sql = "delete from persona where NrodeDocumento = ".$_SESSION['dnis'];
		        $resultado = mysqli_query($NombreConexion,$sql) or die("ERROR al ejecutar query delete".mysql_error()); 
		
            if($resultado){
                echo "Alumno Eliminado correctamente.";
                LimpiarVarSession();
                }
            else
                echo "No se pudo eliminar el alumno correctamente.";   		  
            }
            
            catch(Exception $e){
                echo "Error al ejecutar delete.";
            }
            
            Desconectar($resultado,$Conexion); 
            header("Location: " . $_SERVER['HTTP_REFERER']); 
            }
        }

        function LimpiarVarSession(){
	
        $_SESSION['dnis'] = '';
        $_SESSION['ayns'] = '';
        $_SESSION['edads'] = '';
	
}
?>