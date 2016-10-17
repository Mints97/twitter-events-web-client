<?php
require_once(dirname(__FILE__) . "/backend/db_config.php");
require_once(dirname(__FILE__) . "/common/login_functions.php");

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false || $conn->connect_error) {
    $_SESSION['create_user_error'] = true;
    header('Location: login.php');
}

if (isset($_POST['username']) && isset($_POST['password']) && !is_logged_in()) {
    if (login_user($conn, $_POST['username'], $_POST['password']) && is_logged_in()) {
        header('Location: index.php');
    } else {
        $_SESSION['login_error'] = true;
        header('Location: login.php');
    }
} else {
    $_SESSION['login_error'] = true;
    header('Location: login.php');
}

$conn->close();
?>