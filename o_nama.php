<?php
include 'header.php';

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: index.php');
    exit();
}
?>

<div class="content-container">
    <h2>O nama</h2>
    <p>Dobrodošli u Kolekciju Recepata! Ova stranica nastala je kao projekt s ciljem demonstracije web aplikacije temeljene na PHP-u i XML-u. Ovdje možete pregledavati razne recepte i istraživati kulinarske ideje.</p>

    <h3>Naša lokacija:</h3>
    <p>Borongajska cesta 83f, 10000, Zagreb</p>

    <div class="map-container">
        <iframe
            src="https://maps.google.com/maps?q=Borongajska%20cesta%2083f,%2010000,%20Zagreb&t=&z=14&ie=UTF8&iwloc=&output=embed"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

<?php include 'footer.php'; ?>