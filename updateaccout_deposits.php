<?php
include 'partials/header.php';
require __DIR__ . '/users/users.php';

if (!isset($_GET['id'])) {
    include "partials/not_found.php";
    exit;
}
$userId = $_GET['id'];

$user = getUserById($userId);

if (!$user) {
    include "partials/not_found.php";
    exit;
}

$errors = [
    'ammount' => "",
    
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $account['ammount']=$_POST['ammount'];
    $account['depositDate']=$_POST['depositDate'];
    $account['withdrawals_ammount']="";
    $account['withdrawals_date']="";
    $user_data[]=$account;
    $user = array_merge($user, $_POST);
    $isValid = validateUserDeposit($user, $errors);
    if ($isValid) {
        $user = depositUser($user_data, $userId);
        header("Location: index.php");
    }
    
}

?>

<?php include '_form_deposits.php' ?>
