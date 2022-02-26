<?php
$pdo = null;
try {
    $pdo = new PDO('mysql:host=mysql;dbname=database', 'root', 'root');
} catch (PDOException $e) {
    print $e->getMessage();
    die();
}
var_dump($pdo);
