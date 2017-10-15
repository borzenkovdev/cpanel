<?php
$errors = [];

$id = intval($_GET['id']);

$login = intval($_GET['login']);

$email = test_input($_GET['email']);
if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

$password = $_GET['password'];

//Must be a minimum of 6 characters
//Must contain at least 1 number
//Must contain at least one uppercase character
//Must contain at least one lowercase character
if(! preg_match('^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$', $password)) {
    $errors[] = "Invalid password format - In password must be numbers, uppercase and lowercase characters. Length must be a minimum 6 ";
}

if (empty($errors)) {
    $query = "insert into user ('login', 'password', 'email') values($login, $password, $email)";

    try {
        $result = mysql_query($connect, $query);
    } catch (Exception $e) {
        echo $e->getMessage(), "\n";
    }

    mysql_close($connect);

    if ($result) {
        $row = mysql_fetch_assoc($result);
        header("location: http://example.com/view.php?id=" . $row['id']);
    } else {
        $message  = 'Неверный запрос: ' . mysql_error() . "\n";
        $message .= 'Запрос целиком: ' . $query;
        die($message);
    }
} else {
    foreach($errors as $error) {
        echo $error . "\n";
    }
}





