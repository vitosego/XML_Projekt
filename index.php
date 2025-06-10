<?php
session_start(); 

$loginError = ""; 


if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
    header('Location: recipes_list.php'); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $xmlFilePath = 'podaci/users.xml';
    if (!file_exists($xmlFilePath)) {
        $loginError = "Greška: Datoteka korisničkih podataka nije pronađena.";
    } else {
        $usersXml = simplexml_load_file($xmlFilePath);

        if ($usersXml === false) {
            libxml_use_internal_errors(true);
            simplexml_load_file($xmlFilePath);
            $errors = libxml_get_errors();
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->message;
            }
            libxml_clear_errors();
            $loginError = "Greška pri učitavanju korisničkih podataka: " . implode(", ", $errorMessages);
        } else {
            $foundUser = false;
            foreach ($usersXml->user as $user) {
                if ((string)$user->username === $username && (string)$user->password === $password) {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['username'] = (string)$user->username;
                    $_SESSION['role'] = (string)$user->uloga;
                    $foundUser = true;
                    header('Location: recipes_list.php');
                    exit();
                }
            }
            if (!$foundUser) {
                $loginError = "Pogrešno korisničko ime ili lozinka.";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kolekcija Recepata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Prijavite se</h2>
        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="username">Korisničko ime:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Lozinka:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Prijava</button>
        </form>
        <?php if (!empty($loginError)): ?>
            <p class="error-message"><?php echo $loginError; ?></p>
        <?php endif; ?>

        <div class="login-hint">
            <p>Isprobajte sljedeće kombinacije:</p>
            <ul>
                <li>Korisničko ime: <strong>user1</strong>, Lozinka: <strong>12345</strong></li>
                <li>Korisničko ime: <strong>admin</strong>, Lozinka: <strong>adminpass</strong></li>
                <li>Korisničko ime: <strong>profesor</strong>, Lozinka: <strong>fakultet</strong></li>
            </ul>
        </div>
        </div>
</body>
</html>