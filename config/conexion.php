<?php
declare(strict_types=1);

/** Devuelve la conexión MySQLi usando las credenciales de config.php. */
function conexion(): mysqli
{
    static $db = null;

    if ($db === null) {
        $config = require __DIR__ . '/config.php';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
        $db->set_charset('utf8mb4');
    }

    return $db;
}
