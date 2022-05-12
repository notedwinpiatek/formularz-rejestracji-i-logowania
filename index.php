<?php

$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

$email = filter_var($email, FILTER_SANITIZE_EMAIL); 

$db = new mysqli("localhost", "root", "", "auth");
$q = "SELECT * FROM user WHERE email = $email";
$db->query($q);

$q = $db->prepare("SELECT * FROM user WHERE email = ?");

$q->bind_param("s", $email);
$q->execute();
$result = $q->get_result();


?>
<form action="index.php" method="get">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput" required>
    <label for="passwordInput">Password:</label>
    <input type="password" name="password" id="passwordInput" required>
    <input type="submit" value="Zaloguj">
</form>