<?php
include 'partials/header.php';
require __DIR__ . '/users/users.php';

if (!isset($_GET['id'])) {
    include "partials/not_found.php";
    exit;
}
$userId = $_GET['id'];

$user = getUserById($userId);
$user_acc = $user['account'];
// echo "<pre>";
// print_r($user_acc);
// exit();
if (!$user) {
    include "partials/not_found.php";
    exit;
}

?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>View User: <b><?= $user['name'] ?></b></h3>
        </div>
        <div class="card-body">
            <a class="btn btn-secondary" href="index.php">Back</a>
            <a class="btn btn-secondary" href="update.php?id=<?= $user['id'] ?>">Update</a>
            <a class="btn btn-secondary" href="updateaccout_deposits.php?id=<?= $user['id'] ?>">Deposits</a>
            <a class="btn btn-secondary" href="updateaccout_withdrawals.php?id=<?= $user['id'] ?>">Withdrawals</a>
            <a class="btn btn-secondary" href="updateaccout_transfer.php?id=<?= $user['id'] ?>">Account transfer</a>
            <form style="display: inline-block" method="POST" action="delete.php">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button class="btn btn-danger">Delete</button>
            </form>
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <th>Name:</th>
                    <td><?= $user['name'] ?></td>
                </tr>

                <tr>
                    <th>Email:</th>
                    <td><?= $user['email'] ?></td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td><?= $user['phone'] ?></td>
                </tr>
                <tr>
                    <th>ACC Bal:</th>
                    <td><?= $user['balance'] ?></td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="card-header">
            <h3>User: <b>Deposits and Withdrawals</b></h3>
        </div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>SL No.</th>
                <th>Deposits ammount</th>
                <th>Deposit Date</th>
                <th>Withdrawals ammount</th>
                <th>Withdrawals Date</th>

            </tr>
        </thead>
        <tbody>
            <?php $k=1;?>
            <?php foreach ($user_acc as $i => $user): ?>
            
            <tr>

                <td><?= $k; ?></td>
                <td><?= $user['ammount'] ?></td>
                <td><?= $user['depositDate'] ?></td>
                <td><?= $user['withdrawals_ammount'] ?></td>
                <td><?= $user['withdrawals_date'] ?></td>

            </tr>
            <?php $k++;?>
            <?php endforeach;; ?>


        </tbody>
    </table>
</div>


<?php include 'partials/footer.php' ?>