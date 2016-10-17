<?php
require_once(dirname(__FILE__) . "/common/login_functions.php");

if (is_logged_in()) {
    logout_user();
}

header('Location: login.php');
?>