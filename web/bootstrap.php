<?php

use DataBase\Connection;
use Expense\Repository;

session_start();

// Debug
if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

$config = include __DIR__ . '/../app/config.php';
$connection = new Connection(
    $config['db']['driver'],
    $config['db']['host'],
    $config['db']['port'],
    $config['db']['dbname'],
    $config['db']['username'],
    $config['db']['password']
);
$expenses = new Repository($connection);