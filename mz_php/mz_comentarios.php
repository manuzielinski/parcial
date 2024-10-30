<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $id_publicacion = $_POST['id_publicacion'];
    $comentario = $_POST['comentario'];

    $query = "INSERT INTO mz_comentarios (id_publicacion, id_usuario, comentario) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("iis", $id_publicacion, $id_usuario, $comentario);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
