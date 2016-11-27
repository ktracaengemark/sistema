<?php

session_start();

$mysqli = mysqli_connect('45.55.249.18', 'usuario', '20BrrQ15', 'app') or die("Database Error");

if (isset($_POST['submit'])) {
    //whether the email is blank
    if ($_POST['email'] == '') {
        $_SESSION['error']['email'] = "E-mail is required.";
    } else {
        //whether the email format is correct
        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $_POST['email'])) {
            //if it has the correct format whether the email has already exist
            $email = $_POST['email'];
            $sql1 = "SELECT * FROM Sis_Usuario WHERE Email = '$email'";
            $result1 = mysqli_query($mysqli, $sql1) or die(mysqli_error());
            if (mysqli_num_rows($result1) > 0) {
                $_SESSION['error']['email'] = "This Email is already used.";
            }
        } else {
            //this error will set if the email format is not correct
            $_SESSION['error']['email'] = "Your email is not valid.";
        }
    }
    //whether the password is blank
    if ($_POST['password'] == '') {
        $_SESSION['error']['password'] = "Password is required.";
    }

    //if the error exist, we will go to registration form
    if (isset($_SESSION['error'])) {
        header("Location: index.php");
        exit;
    } else {
        
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $com_code = md5(uniqid(rand()));

        $sql2 = "INSERT INTO Sis_Usuario (Email, Senha, Codigo) VALUES ('$email', '$password', '$com_code')";
        $result2 = mysqli_query($mysqli, $sql2) or die(mysqli_error());

        if ($result2) {
            $to = $email;
            $subject = "Confirmation from TutsforWeb to $username";
            $header = "TutsforWeb: Confirmation from TutsforWeb";
            $message = "Please click the link below to verify and activate your account. rn";
            $message .= "http://www.yourname.com/confirm.php?passkey=$com_code";

            $sentmail = mail($to, $subject, $message, $header);

            if ($sentmail) {
                echo "Your Confirmation link Has Been Sent To Your Email Address.";
            } else {
                echo "Cannot send Confirmation link to your e-mail address";
            }
        }
    }
}
?>