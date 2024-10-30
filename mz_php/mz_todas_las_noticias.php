<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tierra Colorada</title>
    <link rel="stylesheet" href="../mz_styles/mz_mundo.css">
    <script src="mz_script.js" defer></script>
</head>
<body>
    <header class="mz_header">
        <h1>Recorre el Mundo con Nosotros!</h1>
        <nav class="mz_nav">
            <a href="/MZ_PARCIAL/index.php">Inicio</a>
            <a href="mz_noticias_misiones.php">Noticias de Misiones</a>
            <a href="mz_todas_las_noticias.php">Todas las Noticias</a>
        </nav>
    </header>   
    <main class="mz_main">
        <section class="mz_publicaciones">
            <h2>Publicaciones Recientes a Nivel Mundial</h2>
            <?php
            require 'mz_conexion.php';
            $publicaciones = [
                [
                    'id' => 1,
                    'titulo' => 'Crisis Climática Global: Acciones Urgentes',
                    'contenido' => 'Los líderes mundiales se reúnen para discutir acciones necesarias contra el cambio climático.'
                ],
                [
                    'id' => 2,
                    'titulo' => 'Innovaciones Tecnológicas en la Medicina',
                    'contenido' => 'Investigadores desarrollan nuevas tecnologías para tratar enfermedades incurables.'
                ],
                [
                    'id' => 3,
                    'titulo' => 'Conflictos Internacionales y su Impacto',
                    'contenido' => 'Analizamos cómo los conflictos en diversas regiones afectan la economía global.'
                ],
                [
                    'id' => 4,
                    'titulo' => 'Avances en Energías Renovables',
                    'contenido' => 'El mundo se mueve hacia fuentes de energía más sostenibles y limpias.'
                ],
                [
                    'id' => 5,
                    'titulo' => 'Cultura y Arte: Un Encuentro Global',
                    'contenido' => 'Exposiciones de arte y eventos culturales conectan a personas de todo el mundo.'
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
                        echo "<p>Comentario agregado exitosamente.</p>";
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
