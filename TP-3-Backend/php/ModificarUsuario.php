<?php
require_once('FuncionesBDD.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$alumno = null;

// Si viene el ID por GET → buscar datos del alumno
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // seguridad
    $Conexion = ConectarServidor();
    SeleccionarBDD($Conexion);

    $sql = "SELECT * FROM Alumno WHERE id = $id";
    $resultado = mysqli_query($Conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $alumno = mysqli_fetch_assoc($resultado);
    } else {
        echo "<div class='alert alert-danger'>No se encontró el alumno.</div>";
    }

    Desconectar(null, $Conexion);
}

// Si se envió el formulario de actualización → procesar POST
if (isset($_POST['BotonUpdate'])) {
    ActualizarAlumno();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Modificacion de usuario</title>
</head>
<body>
  <header style="background-color: blue; height: 100px;">
        <img src="../img/logo.jfif" alt="" style="width: 100px;height: 100px;">
    </header>
  <h1>Modificar Usuario</h1>
  <form id="formModificar" style="border: 1px solid black; padding: 10px; border-radius: 15px;"name="formulario" method="post" action="ModificarUsuario.php" class="p-3 border rounded">
    <input type="hidden" name="id" value="<?= $alumno['id'] ?>">
    <label class="form-label">Tipo doc</label>
    <select  id="tipo_documento" class="form-select" name="tipo">
      <option value="LE" <?= (($alumno['Tipo_Documento'] ?? '') == 'LE') ? 'selected' : '' ?>>LE</option>
      <option value="LC" <?= (($alumno['Tipo_Documento']?? '') == 'LC') ? 'selected' : '' ?>>LC</option>
      <option value="DNI"<?= (($alumno['Tipo_Documento']?? '') == 'DNI') ? 'selected' : '' ?>>DNI</option>
    </select>
    <label class="form-label">Numero de documento</label>
    <input type="text" id="nro_documento" placeholder="Numero de documento" class="form-control" value="<?= $alumno['Nro_Documento'] ?? '' ?>" name="dni">
    <label class="form-label">Nombre</label>
    <input type="text" id="nombre" placeholder="Nombre" required class="form-control" value="<?= $alumno['Nombre'] ?? '' ?>" name="nombre"/>
     <label class="form-label">Apellido</label>
    <input type="text" id="apellido" placeholder="Apellido" required class="form-control" name="apellido" value="<?= $alumno['Apellido'] ?? '' ?>"/>
    <label class="form-label">Anio</label>
    <select id="anio" required class="form-select" name="anio" >
      <?php
            for ($i = 1; $i <= 7; $i++) {
                $selected = (($alumno['Anio'] ?? '') == $i) ? 'selected' : '';
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
    </select>
    <label class="form-label">Division</label>
    <select id="division" required class="form-select" name="divi">
      <?php
            for ($i = 1; $i <= 8; $i++) {
                $selected = (($alumno['Division']?? '' )== $i) ? 'selected' : '';
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
    </select>
    <br>
    <button type="submit" class="btn btn-primary" name="BotonUpdate">Guardar cambios</button>
    <button type="reset" class="btn btn-danger">Borrar datos</button>
  </form>
  
</body>
</html>