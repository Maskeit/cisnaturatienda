<?php
// config.php
return [
    'db_host' => 'localhost',
    'db_name' => 'cisnaturatienda',
    'db_user' => 'root',
    'db_passwd' => 'root',
    'db_port' => strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 3306 : 8889
];
