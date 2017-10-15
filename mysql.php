<?php
$errors = [];

$id = intval($_GET['id']);
$email = trim($_GET['email']);
$login = trim($_GET['login']);
$password = trim($_GET['password']);

//check email
$emailCheck = test_input($email);
if (! filter_var($emailCheck, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

//check password
if(! preg_match('^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$', $password)) {
    $errors[] = "Invalid password format - In password must be numbers, uppercase and lowercase characters. Length must be a minimum 6 ";
}

//check login
if(! preg_match('/^[a-zA-Z0-9]{5,30}$/', $login)) {
    $errors[] = "Invalid login format - login password can be numbers, uppercase and lowercase characters. Length must be a minimum 5, max 30. Dont use special characters, like /^@&*%^()%!%*&? ";
}

if (empty($errors)) {
    $query = "insert into user ('login', 'password', 'email') values($login, $password, $email)";

    try {
        $result = mysql_query($connect, $query);
    } catch (Exception $e) {
        echo $e->getMessage(), "\n";
    } finally {
        mysql_close($connect);
    }

    if ($result) {
        $row = mysql_fetch_assoc($result);
        header("location: http://example.com/view.php?id=" . $row['id']);
    } else {
        $message  = 'Wrong query: ' . mysql_error() . "\n";
        $message .= 'Query: ' . $query;
        die($message);
    }
} else {
    foreach($errors as $error) {
        echo $error . "\n";
    }
}





