<?php
require "conexion.php";

$region = $_POST['region'];

$db = conexion();
$stmt = $db->prepare("SELECT * FROM comuna WHERE id_region = :region");
$stmt->bindParam(':region', $region, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);