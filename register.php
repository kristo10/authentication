<?php
include "db.php";

$errors=[];

if (isset($_POST['Submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (isset($email) && !empty($email) && isset($password) && !empty($password) && isset($confirm_password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $password = password_hash($password,PASSWORD_BCRYPT);
            $confirm_password = password_hash($confirm_password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `users` (`email`, `password`) VALUE ('$email', '$password')";
            if ($conn->query($sql)) {
                $_SESSION['user_email'] = $email;
                $_SESSION['is_logged_in'] = TRUE;
                setcookie('user_email',$_SESSION['user_email'], time() + 120);
                setcookie('is_logged_in',$_SESSION['is_logged_in'], time() + 120);

                header("Location: homepage.php");
            } else {
                $errors[] = "Register faild";
            }
        } else {
            $errors[] = "Password and Confirm Password doesn't match";
        }
    } else {
        $errors[] = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PHP</title>
</head>
<body>
    <h1>Register</h1>
    <?php
        echo "<ul>";
        if (count($errors)) {
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
        } 
        echo "</ul>";
    ?>
    <form method="POST" action="">
        <table>
            <label>Email: </label>
            <input type="emial" name="email" placeholder="Enter your email" /><br><br>

            <label>Password: </label>
            <input type="password" name="password" placeholder="Enter your password" /> <br><br>

            <label>Confirm Password: </label>
            <input type="password" name="confirm_password" placeholder="Enter your password" /> <br><br>

            <button type="submit" name="Submit">Register</button>
            <a href="login.php">Login </a>
        </table>
    </form>
</body>
</html>