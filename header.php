<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kolekcija Recepata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <h1>Kolekcija Recepata</h1>
        <nav>
            <a href="recipes_list.php">Početna</a>
            <a href="o_nama.php">O nama</a>
            <a href="logout.php">Odjava</a>
        </nav>
    </header>
    <main>
    </main> </body>
</html>