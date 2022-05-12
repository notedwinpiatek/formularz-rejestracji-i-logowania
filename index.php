<?php

$passwd = "tajneHaslo";

$hash = password_hash($passwd, PASSWORD_ARGON2I);

echo $hash;

?>
<form action="index.php" method="get">
    <label for="emailInput">Email:</label>
    <input type="email" name="email" id="emailInput" required>
    <label for="passwordInput">Password:</label>
    <input type="password" name="password" id="passwordInput" required>
    <input type="submit" value="Zaloguj">
</form>