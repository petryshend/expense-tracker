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
