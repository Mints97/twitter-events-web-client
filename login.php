<?php
require_once(dirname(__FILE__) . "/common/login_functions.php");

if(is_logged_in()) {
    header('Location: index.php');
    exit();
}

?>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Twitter Events Admin Login</title>
</head>
<html>
    <body id="loginBackground">
        <p>
            <?php if (isset($_SESSION['login_error']) && $_SESSION['login_error']) { echo '<p>ERROR! Invalid credentials</p>'; } ?>
            
            <h3>Twitter Events Web Client</h3>
            <div id="loginPanel">
                <form method="post" action="login_provider.php">
                    
                    <table>
                        <tr>
                            <h4>Sign in</h4>
                        </tr>
                        <tr>
                            <td>User Name:</td>
                            <td><input type="text" name="username"/></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password"/></td>
                        </tr>
                    </table>
                    <input type="submit" value="Log in" class="button"/>
                </form>
            </div>
        </p>
    </body>
</html>