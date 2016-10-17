<?php

function login_valid(mysqli $conn, $username) {
    $username = $conn->real_escape_string($username);
    
    $req_result = $conn->query("SELECT * FROM admins where name = '$username'");
    
    if ($req_result === false || $req_result->num_rows != 1) {
        return false;
    } else {
        $req_result->close();
        return true;
    }
}

function user_valid(mysqli $conn, $username, $password) {
    $username = $conn->real_escape_string($username);
    $password = md5($conn->real_escape_string($password));
    
    $req_result = $conn->query("SELECT * FROM admins where name = '$username' AND password = '$password'");
    
    if ($req_result === false || $req_result->num_rows != 1) {
        return false;
    } else {
        // $row = $req_result->fetch_assoc(); // add logged in info later?
        $req_result->close();
        return true;
    }
}

function create_user(mysqli $conn, $username, $password) {
    $username = $conn->real_escape_string($username);
    $password = md5($conn->real_escape_string($password));
    
    if (login_valid($conn, $username)) {
        return false;   // user already exists!
    }
    
    $req_result = $conn->query("INSERT INTO admins (name, password) VALUES('$username', '$password')");
    
    if ($req_result === false) {
        echo mysqli_error($conn);
        return false;
    } else {
        return true;
    }
}

function login_user(mysqli $conn, $username, $password) {
    session_start();
        
    if (user_valid($conn, $username, $password)) {
        
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    
        if (isset($_SESSION['login_error'])) {
            $_SESSION['login_error'] = false;
        }
        
        return true;
    }
    
    $_SESSION['login_error'] = true;
    
    return false;
}

function is_logged_in() {
    session_start();
    
    return session_status() == PHP_SESSION_ACTIVE
        && isset($_SESSION['username'])
        && isset($_SESSION['password'])
        && (!isset($_SESSION['login_error']) || !$_SESSION['login_error']);
}

function logout_user() {
    if (is_logged_in()) {
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) { // destroy session cookies
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 41000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
        }
        
        session_destroy();
    }
}
?>