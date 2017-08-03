<?php

require __DIR__ . '/../vendor/autoload.php';

use Expense\Repository;

// Debug
if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    ini_set('display_errors', 1);
}

$repo = new Repository();
$records = $repo->getAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">

    <title>Expense Tracker</title>
</head>
<body>
    <div class="container">
        <h2>This is expense tracker</h2>
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
    </div>
</body>
</html>
