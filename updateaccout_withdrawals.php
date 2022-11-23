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

    $account['ammount']="";
    $account['depositDate']="";
    $account['withdrawals_ammount']=$_POST['withdrawalammount'];
    $account['withdrawals_date']=$_POST['withdrawalDate'];
    $user_data[]=$account;
    $user = array_merge($user, $_POST);
    $isValid = validateUserWithdrawal($user, $errors);
    if ($isValid) {
        $user = withdrawalUser($user_data, $userId);
        header("Location: index.php");
    }
    
}

?>

<?php include '_form_withdrawals.php' ?>
