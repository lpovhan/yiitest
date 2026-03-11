<?php

$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
//$db['dsn'] = 'mysql:host='.$_ENV['DB_HOST'].';dbname=' . $_ENV['DB_DATABASE'];

return $db;
