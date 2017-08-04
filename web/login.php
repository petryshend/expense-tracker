<?php

    $config = include __DIR__ . '/../app/config.php';

    session_start();
    $errors = [];
    $validUsername = false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['username'])) {
            $errors[] = 'You must enter username';
        } else {
            if ($_POST['username'] !== $config['login']['username']) {
                $errors[] = 'Username is wrong';
            } else {
                $validUsername = true;
            }
        }
        $validPassword = false;
        if (!isset($_POST['password'])) {
            $errors[] = 'You must enter password';;
        } else {
            if ($_POST['password'] !== $config['login']['password']) {
                $errors[] = 'Password is wrong';
            } else {
                $validPassword = true;
            }
        }

        if ($validUsername && $validPassword) {
            $_SESSION['username'] = $_POST['username'];
            header('Location: index.php');
        }
    }
?>

<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="col-md-4 col-md-offset-4">
    <h3>Login to Expense Tracker</h3>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>

<div class="col-md-4 col-md-offset-4">
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>

