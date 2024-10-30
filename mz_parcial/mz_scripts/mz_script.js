// sistema de comentarios
function mz_mostrarFormularioComentario(id_publicacion) {
    const divComentarios = document.getElementById(`comentarios_${id_publicacion}`);
    divComentarios.innerHTML = `
        <form action="mz_comentarios.php" method="POST" class="mz_form_comentario">
            <input type="hidden" name="id_publicacion" value="${id_publicacion}">
            <textarea name="comentario" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    `;
}
