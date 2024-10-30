<?php
session_start();
require 'mz_php/mz_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_publicacion = intval($_POST['id_publicacion']);
    $nombre_usuario = htmlspecialchars(trim($_POST['nombre_usuario']));
    $comentario = htmlspecialchars(trim($_POST['comentario']));

    $query = "INSERT INTO mz_comentarios (id_publicacion, nombre_usuario, comentario, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $mz_conexion->prepare($query);
    $stmt->bind_param('iss', $id_publicacion, $nombre_usuario, $comentario);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al agregar el comentario: " . $stmt->error;
    }
}
?>
