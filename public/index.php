<?php

// Función para detectar el idioma del usuario
function detectUserLocale() {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // Detecta el idioma principal
    $supportedLanguages = ['en', 'es']; // Idiomas soportados por la app

    // Verifica si el idioma detectado es compatible con los soportados
    if (in_array($lang, $supportedLanguages)) {
        return $lang;
    } else {
        return 'en'; // Idioma predeterminado
    }
}

// Detectar y configurar el idioma
$locale = detectUserLocale();
switch ($locale) {
    case 'es':
        putenv("LC_ALL=es_ES.UTF-8");
        setlocale(LC_ALL, "es_ES.UTF-8");
        break;
    case 'en':
    default:
        putenv("LC_ALL=en_US.UTF-8");
        setlocale(LC_ALL, "en_US.UTF-8");
        break;
}

// Configurar el dominio y el directorio de traducción
bindtextdomain("messages", __DIR__ . "/locale");
textdomain("messages");

// Rutas de vistas según la solicitud
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/views/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;

    case '/users':
        require __DIR__ . $viewDir . 'users.php';
        break;

    case '/contact':
        require __DIR__ . $viewDir . 'contact.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
        break;
}
?>

