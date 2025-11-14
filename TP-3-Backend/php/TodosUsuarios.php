<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="../css/estilos.css">
  <title>Lista de usuarios</title>
</head>
<body>
   <header style="background-color: blue; height: 100px;">
        <img src="../img/logo.jfif" alt="" style="widtd: 100px;height: 100px;">
    </header>
    <div class="container">
  <h1>Lista de Usuarios</h1>
  <p id="cantidadUsuarios"></p>
  <?php
   $Conexion=mysqli_connect('localhost','root') or die("error ".mysql_error());

	$tabla=mysqli_select_db($Conexion,'tecnica6moron') or die("error ".mysql_error());
	
$sql = "CALL SeleccionarTodosLosAlumnos()";
	$resultado=mysqli_query($Conexion,$sql) or die("error ".mysql_error());
  ?>
  <div>
  <table class="table table-light table-striped" style=" border-radius: 15px;">
    <tdead>
        <tr>
            <th>Id</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Anio</th>
            <th>Division</th>
            <th>Tipo Doc</th>
            <th>Documento</th>
            <th>Acciones</th>
        </tr>
        <?php
        $i = 0;
        while($row = mysqli_fetch_array($resultado))
            {
        echo "<tr>";
        echo "<td>".$row[0]."</td>";
        echo "<td>".$row[1]."</td>";
        echo "<td>".$row[2]."</td>";
        echo "<td>".$row[3]."</td>";
        echo "<td>".$row[4]."</td>";
        echo "<td>".$row[5]."</td>";
        echo "<td>".$row[6]."</td>";
        $i ++;
        echo "<td><a href='ModificarUsuario.php?id={$row['id']}' class='btn btn-secondary'>Editar</a>";
        echo "<a href='BajaUsuario.php?id={$row['id']}' class='btn btn-danger'>Eliminar</a></td>";
        echo "</tr>";
            }
        ?>
      
    </tdead>
    <tbody id="tablaUsuarios"></tbody>
  </table>
  </div>
  <?php
   echo "<br><center>Total de alumnos : ".$i."</center>";
	
	
	//LIBERAR CONEXIÓN A BDD.
	mysqli_free_result($resultado);
	
	//LIBERAR CONEXIÓN AL SERVIDOR.
	mysqli_close($Conexion);
	
  ?>
  <br>
  <a href="AltaUsuario.php" class="btn btn-primary">Agregar un usuario</a>
  </div>
  
</body>
</html>