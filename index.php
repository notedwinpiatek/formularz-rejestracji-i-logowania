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



?>
<form action="index.php" method="get">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput" required>
    <label for="passwordInput">Password:</label>
    <input type="password" name="password" id="passwordInput" required>
    <input type="submit" value="Zaloguj">
</form>