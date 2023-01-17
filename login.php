<?php
include "db.php";

$errors=[];

if (isset($_POST['Submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (isset($email) && !empty($email) && isset($password) && !empty($password)) {
        $sql = "SELECT * FROM `users` WHERE `email` = '$email'";
        if ($result=$conn->query($sql)) {
            if ($result->num_rows > 0 ) {
                $row = $result->fetch_assoc();
                if (password_verify($password,$row['password'])) {
                    $_SESSION['user_email'] = $email;
                    $_SESSION['is_logged_in'] = true;
                    setcookie('user_email',$_SESSION['user_email'], time() + 120);
                    setcookie('is_logged_in',$_SESSION['is_logged_in'], time() + 120);

                    header("Location: homepage.php");
                } else {
                    $errors[] = "Password incorrect";
                }
            }
        } else {
            $errors[] = "Login faild";
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
    <title>Login - PHP</title>
</head>
<body>
    <h1>Login</h1>
    <!-- Kjo pjese na sherben per te treguar kur vendosim passwordin gabim d.m.th echo -->
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

            <button type="submit" name="Submit">Login</button>
            <a href="register.php">Register</a>
        </table>
    </form>
</body>
</html>

