<?php include 'partial/header.php'; ?>

<h2>This is expense tracker</h2>
<a href="logout.php">Logout</a>

<div>
    <form action="new_expense.php" class="form-inline" method="post">
        <div class="form-group">
            <label for="new-expense-title">Title</label>
            <input type="text" class="form-control" id="new-expense-title" name="new-expense-title" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="new-expense-amount">Amount</label>
            <input type="number" step="0.01" class="form-control" id="new-expense-amount" name="new-expense-amount" placeholder="Amount">
        </div>
        <button type="submit" class="btn btn-default">Create</button>
    </form>
</div>

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
            <td><?= htmlentities($record->getTitle()); ?></td>
            <td><?= $record->getAmount(); ?></td>
            <td><?= $record->getCreatedAt()->format('Y-m-d H:i:s'); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php include 'partial/footer.php'; ?>