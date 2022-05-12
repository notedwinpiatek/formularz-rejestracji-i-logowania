<?php
if(isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL); 

    $db = new mysqli("localhost", "root", "", "auth");
    $q = "SELECT * FROM user WHERE email = $email";
    $db->query($q);

    $q = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");

    $q->bind_param("s", $email);
    $q->execute();
    $result = $q->get_result();

    $userRow = $result->fetch_assoc();
    if($userRow == null) {  
        echo "Błędny login lub hasło <br>";
    } else {
        if(password_verify($password, $userRow['passwordHash'])) {
            echo "Zalogowano pomyślnie <br>";
        } else {
            echo "Błędny login lub hasło <br>";
        }
    } 
}
if(isset($_REQUEST['action']) && isset($_REQUEST['action'])) {
    $db = new mysqli("localhost", "root", "", "auth");
    $email = $_REQUEST['email'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL); 

    $password = $_REQUEST['password'];
    $passwordRepeat = $_REQUEST['passwordRepeat'];
    
    if($password == $passwordRepeat){
        $q = $db->prepare("INSERT INTO user VALUES (NULL, ?, ?");
        $passwordHash = password_hash($password, PASSWORD_ARGON2I);
        $q->bind_param("ss", $email, $passwordHash);
        $result = $q->execute();
        if($result) {
            echo "Account created correctly";
        } else {
            echo "Something went wrong!";
        }
    } else {
        echo "Passwords are not identical - try again!";
    }
}
?>
<h1>Log in</h1>
<form action="index.php" method="get">
<label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput" required>
    <label for="passwordInput">Password:</label>
    <input type="password" name="password" id="passwordInput" required>
    <input type="hidden" name="action" value="login">
    <input type="submit" value="Log in">
</form>
<h1>Register</h1>
<form action="index.php" method="post">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput" required>
    <label for="passwordInput">Password:</label>
    <input type="password" name="password" id="passwordInput" required>
    <label for="passwordRepeat">Confirm password:</label>
    <input type="password" name="passwordRepeat" id="passwordRepeatInput" required>
    <input type="submit" value="Register">
</form>