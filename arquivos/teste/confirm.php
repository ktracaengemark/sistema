<?php

$mysqli = mysqli_connect('45.55.249.18', 'usuario', '20BrrQ15', 'app') or die("Database Error");

$passkey = $_GET['passkey'];
$sql = "UPDATE Sis_Usuario SET Codigo=NULL WHERE Codigo='$passkey'";
$result = mysqli_query($mysqli, $sql) or die(mysqli_error());
if ($result) {
    echo '<div>Your account is now active. You may now <a href="login.php">Log in</a></div>';
} else {
    echo "Some error occur.";
}
?>