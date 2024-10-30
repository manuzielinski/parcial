<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Blog de Paradigmas</title>
    <link rel="stylesheet" href="mz_styles/mz_styles.css">
    <script src="mz_script.js" defer></script>
</head>
<body>
    <header class="mz_header">
        <h1>Bienvenidos al Blog de MANU!</h1>
        <nav class="mz_nav">
            <a href="index.php">Inicio</a>
            <a href="mz_php/mz_noticias_misiones.php">Noticias de Misiones</a>
            <a href="mz_php/mz_todas_las_noticias.php">Todas las Noticias</a>
        </nav>
    </header>
    <main class="mz_main">
        <section class="mz_publicaciones">
            <h2>Publicaciones Recientes</h2>
            <?php
            require 'mz_php/mz_conexion.php';
            $publicaciones = [
                [
                    'id' => 1,
                    'titulo' => 'La importancia de los Paradigmas',
                    'contenido' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum.'
                ],
                [
                    'id' => 2,
                    'titulo' => 'Evolución de la Tecnología',
                    'contenido' => 'Praesent scelerisque, sapien nec tincidunt fermentum, dolor lacus convallis risus, ac luctus metus neque at urna.'
                ],
                [
                    'id' => 3,
                    'titulo' => 'El Futuro del Aprendizaje',
                    'contenido' => 'Suspendisse potenti. Vivamus hendrerit, odio a cursus suscipit, massa ligula pretium nunc, vel ultrices odio ex ac nulla.'
                ],
                [
                    'id' => 4,
                    'titulo' => 'Innovaciones en la Educación',
                    'contenido' => 'Nunc feugiat, nisi a placerat dignissim, urna felis condimentum nunc, vitae ullamcorper risus elit ut erat.'
                ],
                [
                    'id' => 5,
                    'titulo' => 'Métodos de Enseñanza Modernos',
                    'contenido' => 'Duis varius, justo eget bibendum scelerisque, dolor elit convallis risus, vel tincidunt nunc augue a odio.'
                ]
            ];

            foreach ($publicaciones as $row_publicacion) {
                echo "<article class='mz_articulo'>";
                echo "<h3>" . htmlspecialchars($row_publicacion['titulo']) . "</h3>";
                echo "<p>" . htmlspecialchars($row_publicacion['contenido']) . "</p>";
                echo "<button onclick='mz_mostrarFormularioComentario(" . $row_publicacion['id'] . ")' class='mz_boton_comentar'>Comentar</button>";
                echo "<div id='formulario_comentario_" . $row_publicacion['id'] . "' style='display:none;'>";
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='id_publicacion' value='" . $row_publicacion['id'] . "'>";
                echo "<label for='nombre_usuario'>Nombre:</label>";
                echo "<input type='text' name='nombre_usuario' required>";
                echo "<br>";
                echo "<label for='comentario'>Comentario:</label>";
                echo "<textarea name='comentario' required></textarea>";
                echo "<br>";
                echo "<button type='submit'>Agregar Comentario</button>";
                echo "</form>";
                echo "</div>";
                $id_publicacion = $row_publicacion['id'];
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_publicacion']) && $_POST['id_publicacion'] == $id_publicacion) {
                    $nombre_usuario = $mz_conexion->real_escape_string($_POST['nombre_usuario']);
                    $comentario = $mz_conexion->real_escape_string($_POST['comentario']);

                    $query_insert = "INSERT INTO mz_comentarios (id_publicacion, nombre_usuario, comentario) VALUES ($id_publicacion, '$nombre_usuario', '$comentario')";
                    if ($mz_conexion->query($query_insert) === TRUE) {
                        echo "<p>Comentarios Agregados:</p>";
                    } else {
                        echo "<p>Error al agregar el comentario: " . $mz_conexion->error . "</p>";
                    }
                }
                $query_comentarios = "SELECT * FROM mz_comentarios WHERE id_publicacion = $id_publicacion ORDER BY fecha DESC";
                $result_comentarios = $mz_conexion->query($query_comentarios);

                echo "<div id='comentarios_" . $id_publicacion . "'>";
                while ($row_comentario = $result_comentarios->fetch_assoc()) {
                    echo "<div class='comentario'>";
                    echo "<strong>" . htmlspecialchars($row_comentario['nombre_usuario']) . ":</strong> ";
                    echo "<p>" . htmlspecialchars($row_comentario['comentario']) . "</p>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</article>";
            }
            ?>
        </section>
    </main>
    <script>
        function mz_mostrarFormularioComentario(id) {
            const formulario = document.getElementById('formulario_comentario_' + id);
            if (formulario.style.display === "none") {
                formulario.style.display = "block";
            } else {
                formulario.style.display = "none";
            }
        }
    </script>
</body>
</html>
