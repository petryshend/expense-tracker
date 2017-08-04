<?php

require __DIR__ . '/../vendor/autoload.php';
require 'bootstrap.php';

$records = $expenses->getAll();
?>

<?php include __DIR__ . '/../templates/header.php'; ?>
<?php include __DIR__ . '/../templates/expense_list.php'; ?>
<?php include __DIR__ . '/../templates/footer.php'; ?>
