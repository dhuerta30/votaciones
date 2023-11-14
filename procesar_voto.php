<?php
require "conexion.php";

$nombre = $_POST['nombre'];
$alias = $_POST['alias'];
$rut = $_POST['rut'];
$email = $_POST['correo'];
$region = $_POST['region'];
$comuna = $_POST['comuna'];
$candidato = $_POST['candidato'];
$entero = isset($_POST['entero']) ? implode(", ", $_POST['entero']) : "";

if (empty($alias)) {
    $response = array("success" => false, "message" => "El campo Alias es obligatorio");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$db = conexion();
$stmt = $db->prepare("SELECT COUNT(*) AS total FROM voto WHERE rut = :rut");
$stmt->bindParam(":rut", $rut);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

function contieneLetras($str) {
    return preg_match('/[a-zA-Z]/', $str);
}

function contieneNumeros($str) {
    return preg_match('/[0-9]/', $str);
}

if (strlen($alias) <= 5) {
    $response = array("success" => false, "message" => "El alias debe tener más de 5 caracteres");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} 

if (!contieneLetras($alias) || !contieneNumeros($alias)) {
    $response = array("success" => false, "message" => "El alias debe contener al menos una letra y al menos un número");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$regex = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/";
if (!preg_match($regex, $email)) {
    $response = array("success" => false, "message" => "Correo electrónico inválido");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

if ($result['total'] > 0) {
    $response = array("success" => false, "message" => "El RUT ya ha sido registrado previamente.");
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$stmt = $db->prepare("INSERT INTO voto (nombre, alias, rut, email, region, comuna, candidato, como_se_entero) VALUES (:nombre, :alias, :rut, :email, :region, :comuna, :candidato, :como_se_entero)");
$stmt->bindParam(":nombre", $nombre);
$stmt->bindParam(":alias", $alias);
$stmt->bindParam(":rut", $rut);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":region", $region);
$stmt->bindParam(":comuna", $comuna);
$stmt->bindParam(":candidato", $candidato);
$stmt->bindParam(":como_se_entero", $entero);
$resultado = $stmt->execute();

if ($resultado) {
    $response = array("success" => true, "message" => "¡Gracias por tu voto!");
} else {
    $response = array("success" => false, "message" => "Error al guardar el voto");
}

header('Content-Type: application/json');
echo json_encode($response);
