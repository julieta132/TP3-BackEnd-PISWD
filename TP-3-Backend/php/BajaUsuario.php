<?php
require_once('FuncionesBDD.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$alumno = null;
$Conexion = ConectarServidor();
    SeleccionarBDD($Conexion);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);
    
    $stmt = $Conexion->prepare("CALL EliminarAlumno(?)");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: TodosUsuarios.php?msg=eliminado");
        exit;
    } else {
        $error = "Error al eliminar: " . $stmt->error;
    }
}

// SI VIENE POR GET MOSTRAR DATOS
if (!isset($_GET["id"])) {
    die("No se recibio ID");
}

$id = intval($_GET["id"]);
$stmt = $Conexion->prepare("SELECT * FROM alumno WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();


if (!$usuario) {
    die("Usuario no encontrado");
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
  <title>Baja de usuario</title>
</head>
<body>
  <header style="background-color: blue; height: 100px;">
    <img src="../img/logo.jfif" alt="" style="width: 100px;height: 100px;">
  </header>
  <div class="container mt-4">
  <h1>Eliminar Usuario</h1>

  <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <div class="card p-3">
      <p><strong><?= $usuario["Nombre"] . " " . $usuario["Apellido"] ?></strong></p>
      <p>Documento: <?= $usuario["Tipo_Documento"] . " " . $usuario["Nro_Documento"] ?></p>
      <p>Anio: <?= $usuario["Anio"] ?> - Division: <?= $usuario["Division"] ?></p>
  </div>

  <form method="POST" class="mt-3">
      <input type="hidden" name="id" value="<?= $usuario["id"] ?>">
      <button type="submit" class="btn btn-danger"
              onclick="return confirm('¿Seguro que queres eliminar este usuario?')">
          Eliminar
      </button>
  </form>

  <a href="listado.php" class="btn btn-secondary mt-2">Cancelar</a>
</div>

</body>
</html>
