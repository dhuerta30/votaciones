<?php 
require "conexion.php"; 
  
function obtenerDatosTabla($tabla) {
    $db = conexion();
    $stmt = $db->prepare("SELECT * FROM $tabla");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$candidato = obtenerDatosTabla("candidato");
$region = obtenerDatosTabla("region");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Sistema de Votación</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- Select2 v4.1.0-rc.0 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="bg-warning">

  <div class="container bg-light p-5">
    <h3 class="mt-4">Formulario de Votación</h3>
    <form id="votacionForm" action="procesar_voto.php" method="post">
      <div class="form-group">
        <label for="nombre">Nombre y Apellido:</label>
        <input type="text" id="nombre" name="nombre" class="form-control">
      </div>

      <div class="form-group">
        <label for="alias">Alias:</label>
        <input type="text" id="alias" name="alias" class="form-control">
      </div>

      <div class="form-group">
        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" class="form-control">
      </div>

      <div class="form-group">
        <label for="correo">Email:</label>
        <input type="text" id="correo" name="correo" class="form-control">
      </div>

      <div class="form-group">
        <label for="region">Región:</label>
        <select id="region" name="region" class="form-control">
          <option value="0">Seleccionar</option>
          <?php foreach($region as $regiones): ?>
              <option value="<?=$regiones['id_region']?>"><?=$regiones["nombre_region"]?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="comuna">Comuna:</label>
        <select id="comuna" name="comuna" class="form-control">
          <option value="0">Seleccionar</option>
        </select>
      </div>

      <div class="form-group">
        <label for="candidato">Candidato:</label>
        <select id="candidato" name="candidato" class="form-control">
          <option value="0">Seleccionar</option>
          <?php foreach($candidato as $candidatos): ?>
              <option value="<?=$candidatos['id_candidato']?>"><?=$candidatos["nombre_candidato"]?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label>¿Cómo se enteró de nosotros?</label><br>
        <div class="form-check">
          <input type="checkbox" name="entero[]" value="web" class="form-check-input">
          <label class="form-check-label">Web</label>
        </div>
        <div class="form-check">
          <input type="checkbox" name="entero[]" value="tv" class="form-check-input">
          <label class="form-check-label">Tv</label>
        </div>
        <div class="form-check">
          <input type="checkbox" name="entero[]" value="redes_sociales" class="form-check-input">
          <label class="form-check-label">Redes Sociales</label>
        </div>
        <div class="form-check">
          <input type="checkbox" name="entero[]" value="amigo" class="form-check-input">
          <label class="form-check-label">Amigo</label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Votar</button>
    </form>
  </div>

  <div id="spinner" style="display: none;">
    <img width="100" src="https://thumbs.gfycat.com/EnchantingInbornDogwoodtwigborer-size_restricted.gif" alt="Cargando...">
  </div>

  <div id="resultado"></div>
 
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
