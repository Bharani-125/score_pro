<?php
include 'config.php';

try {
    $connect = new PDO(
        "mysql:host=" . $config['db']['host'] . ";dbname=" . $config['db']['dbname'], 
        $config['db']['username'], $config['db']['password']
    );
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}    