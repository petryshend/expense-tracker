<?php

require __DIR__ . '/../vendor/autoload.php';

use DataBase\Connection;
use Expense\Repository;

session_start();

// Debug
if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$config = include __DIR__ . '/../app/config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

$connection = new Connection(
    $config['db']['driver'],
    $config['db']['host'],
    $config['db']['port'],
    $config['db']['dbname'],
    $config['db']['username'],
    $config['db']['password']
);
$repo = new Repository($connection);
$records = $repo->getAll();

?>

<?php include __DIR__ . '/../templates/header.php'; ?>

<h2>This is expense tracker</h2>
<a href="logout.php">Logout</a>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Amount</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($records as $record): ?>
            <tr>
                <td><?= $record->getId(); ?></td>
                <td><?= $record->getTitle(); ?></td>
                <td><?= $record->getAmount(); ?></td>
                <td><?= $record->getCreatedAt()->format('Y-m-d H:i:s'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../templates/footer.php'; ?>
