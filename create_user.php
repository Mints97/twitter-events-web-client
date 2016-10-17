<?php
require_once(dirname(__FILE__) . "/common/login_functions.php");

if(!is_logged_in()) {
    header('Location: login.php');
    exit();
}

?>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Twitter Events Admin Panel</title>
</head>
<html>
    <body>
        <p>
<?php 
if (isset($_SESSION['create_user_error']) && $_SESSION['create_user_error']) {
    echo '<p>Error creating user!</p>';
    $_SESSION['create_user_error'] = false;
}
?>
        <div id="loginPanel">
            <form method="post" action="create_user_provider.php">
                <table>
                    <tr>
                            <h4>Create New User</h4>
                        </tr>
                    <tr>
                        <td>New Username:</td>
                        <td><input type="text" name="username"/></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password"/></td>
                    </tr>
                </table>
                <input class="button"type="submit" value="Create User" />
                
            </form>
            <form method="post" action="index.php">
              <input class = "button" type="submit" value="Back" />
            </form>
            </div>
        </p>
    </body>
</html>