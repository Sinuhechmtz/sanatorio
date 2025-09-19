<?php
// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ===== CONFIGURACIÓN =====
    // ¡IMPORTANTE! Reemplaza esta dirección con el correo donde quieres recibir los mensajes.
    $recipient_email = "tu-correo@sanatoriodurango.com"; 
    
    // Asunto del correo que recibirás
    $subject = "Nuevo Mensaje de Contacto desde la Página Web";

    // ===== RECOLECCIÓN DE DATOS (con saneamiento básico) =====
    $nombre = strip_tags(trim($_POST["nombre"]));
    $apellido = strip_tags(trim($_POST["apellido"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $tel_casa = strip_tags(trim($_POST["tel_casa"]));
    $tel_celular = strip_tags(trim($_POST["tel_celular"]));
    $mensaje = trim($_POST["mensaje"]);

    // ===== VALIDACIÓN BÁSICA =====
    // Verifica que los campos requeridos no estén vacíos y que el email sea válido.
    if (empty($nombre) || empty($apellido) || empty($tel_celular) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Si hay un error, redirige de vuelta con un estado de error.
        header("Location: contacto.html?status=error");
        exit;
    }

    // ===== CONSTRUCCIÓN DEL CUERPO DEL CORREO =====
    // Aquí se organiza la información que llegará a tu bandeja de entrada.
    $email_content = "Has recibido un nuevo mensaje de contacto:\n\n";
    $email_content .= "Nombre Completo: $nombre $apellido\n";
    $email_content .= "Correo Electrónico: $email\n";
    $email_content .= "Teléfono Casa: $tel_casa\n";
    $email_content .= "Teléfono Celular: $tel_celular\n\n";
    $email_content .= "Mensaje:\n$mensaje\n";

    // ===== CONSTRUCCIÓN DE LAS CABECERAS DEL CORREO =====
    // Esto ayuda a que el correo no sea marcado como spam.
    $email_headers = "From: $nombre $apellido <$email>";

    // ===== ENVÍO DEL CORREO =====
    // Utiliza la función mail() de PHP para enviar el correo.
    if (mail($recipient_email, $subject, $email_content, $email_headers)) {
        // Si el correo se envió con éxito, redirige a la página de contacto con un estado de éxito.
        header("Location: contacto.html?status=success");
    } else {
        // Si hubo un error en el envío, redirige con un estado de error.
        header("Location: contacto.html?status=error");
    }

} else {
    // Si alguien intenta acceder a este archivo directamente, lo redirige.
    header("Location: contacto.html");
}
?>
