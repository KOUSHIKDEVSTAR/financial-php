<?php

function getUsers()
{
    return json_decode(file_get_contents(__DIR__ . '/users.json'), true);
}
function getAccount()
{
    return json_decode(file_get_contents(__DIR__ . '/account.json'), true);
}

function getUserById($id)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}
function getAccountById($id)
{
    $users = getAccount();
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}

function createUser($data)
{
    $users = getUsers();

    $data['id'] = rand(1000000, 2000000);
    $data['account'] = [];
    $data['balance'] = 0;

    $users[] = $data;

    putJson($users);

    return $data;
}

function updateUser($data, $id)
{
    $updateUser = [];
    $users = getUsers();
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $users[$i] = $updateUser = array_merge($user, $data);
        }
    }

    putJson($users);

    return $updateUser;
}

function deleteUser($id)
{
    $users = getUsers();

    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            array_splice($users, $i, 1);
        }
    }

    putJson($users);
}

function uploadImage($file, $user)
{
    if (isset($_FILES['picture']) && $_FILES['picture']['name']) {
        if (!is_dir(__DIR__ . "/images")) {
            mkdir(__DIR__ . "/images");
        }
        // Get the file extension from the filename
        $fileName = $file['name'];
        // Search for the dot in the filename
        $dotPosition = strpos($fileName, '.');
        // Take the substring from the dot position till the end of the string
        $extension = substr($fileName, $dotPosition + 1);

        move_uploaded_file($file['tmp_name'], __DIR__ . "/images/${user['id']}.$extension");

        $user['extension'] = $extension;
        updateUser($user, $user['id']);
    }
}

function putJson($users)
{
    file_put_contents(__DIR__ . '/users.json', json_encode($users, JSON_PRETTY_PRINT));
}
function accJson($users)
{
    file_put_contents(__DIR__ . '/account.json', json_encode($users, JSON_PRETTY_PRINT));
}

function validateUser($user, &$errors)
{
    $isValid = true;
    // Start of validation
    if (!$user['name']) {
        $isValid = false;
        $errors['name'] = 'Name is mandatory';
    }
    if ($user['email'] && !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $errors['email'] = 'This must be a valid email address';
    }

    if (!filter_var($user['phone'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['phone'] = 'This must be a valid phone number';
    }
    // End Of validation

    return $isValid;
}

function validateUserDeposit($user, &$errors)
{
    $isValid = true;
    // Start of validation
    if (!filter_var($user['ammount'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['ammount'] = 'Ammount is mandatory or valid number';
    }
    // End Of validation
    return $isValid;
}


function depositUser($data,$id)
{
   
    $accounts = getAccount(); 
    $users = getUsers();
    $accounts[] =  $data;
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
           
            $acc=$user['account'];
            $updateUserAccount['account'] = array_merge($acc, $data);
            unset($user['account']);
            unset($user['balance']);
            $updateUser = array_merge($user,$updateUserAccount);
            $updateUserAccountBalance['balance']=$users[$i]['balance'] + $data[0]['ammount'];
            $users[$i] = $updateUser = array_merge($updateUser,$updateUserAccountBalance);
           
            
        }
    }
   
    putJson($users);
    return $accounts;
}
function validateUserWithdrawal($user, &$errors)
{
    $isValid = true;
    // Start of validation
    if (!filter_var($user['withdrawalammount'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['withdrawalammount'] = 'Ammount is mandatory or valid number';
    }
    // End Of validation
    return $isValid;
}
function withdrawalUser($data,$id)
{
   
    
    $users = getUsers();
    $accounts[] =  $data;

    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $acc=$user['account'];
            $updateUserAccount['account'] = array_merge($acc, $data);
            unset($user['account']);
            unset($user['balance']);
            $updateUser = array_merge($user,$updateUserAccount);
            $updateUserAccountBalance['balance']=$users[$i]['balance'] - $data[0]['withdrawals_ammount'];
            $users[$i] = $updateUser = array_merge($updateUser,$updateUserAccountBalance);
           
            
        }
    }
    putJson($users);
    return $accounts;
}

function validateUserTransfer($user, &$errors)
{
    $isValid = true;
    if (!$user['transfer_account']) {
        $isValid = false;
        $errors['name'] = 'Name is mandatory';
    }
    // Start of validation
    if (!filter_var($user['withdrawalammount'], FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['withdrawalammount'] = 'Ammount is mandatory or valid number';
    }
    // End Of validation
    return $isValid;
}
function transferUser($data,$id)
{
    $transfer_account_id =$data['0']['transfer_account'];
    unset($data['0']['transfer_account']);
    transferUserAccount($data,$transfer_account_id);
   
    $users = getUsers();
    $accounts[] =  $data;
    
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $acc=$user['account'];
            $updateUserAccount['account'] = array_merge($acc, $data);
            unset($user['account']);
            unset($user['balance']);
            $updateUser = array_merge($user,$updateUserAccount);
            $updateUserAccountBalance['balance']=$users[$i]['balance'] - $data[0]['withdrawals_ammount'];
            $users[$i] = $updateUser = array_merge($updateUser,$updateUserAccountBalance);
           
            
        }
    }
  
    putJson($users);
    return $accounts;
}
function transferUserAccount($data,$id)

{  
    $newData['ammount'] = $data['0']['withdrawals_ammount'];
    $newData['depositDate'] = $data['0']['withdrawals_date'];
    $newData['withdrawals_ammount'] = "";
    $newData['withdrawals_date'] = "";
    $newDatat[]=$newData;
    $accounts = getAccount(); 
    $users = getUsers();
    $accounts[] =  $newData;
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $acc=$user['account'];
            $updateUserAccount['account'] = array_merge($acc, $newDatat);
            unset($user['account']);
            unset($user['balance']);
            $updateUser = array_merge($user,$updateUserAccount);
            $updateUserAccountBalance['balance']=$users[$i]['balance'] + $newDatat[0]['ammount'];
            $users[$i] = $updateUser = array_merge($updateUser,$updateUserAccountBalance);
           
            
        }
    }
 
    putJson($users);
    return $accounts;
}