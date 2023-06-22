<?php
// Configuración de la base de datos
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_DATABASE', 'fintek');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_CHARSET', 'utf8mb4');

function getDBConnection()
{
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_DATABASE . ';charset=' . DB_CHARSET;

    try {
        $db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo 'Error de conexión: ' . $e->getMessage();
        die();
    }
}
?>