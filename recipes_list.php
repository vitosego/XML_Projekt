<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: index.php'); 
    exit();
}


$recipesXml = simplexml_load_file('podaci/recipes.xml');

if ($recipesXml === false) {
    die("Greška pri učitavanju recepata.");
}

$filteredRecipes = [];


$filterCategory = $_GET['category'] ?? '';
$filterMainIngredient = $_GET['mainIngredient'] ?? ''; 


foreach ($recipesXml->recipe as $recipe) {
    $showRecipe = true;


    if (!empty($filterCategory) && strtolower((string)$recipe->category) !== strtolower($filterCategory)) {
        $showRecipe = false;
    }

    if (!empty($filterMainIngredient) && !str_contains(strtolower((string)$recipe->mainIngredients), strtolower($filterMainIngredient))) {
        $showRecipe = false;
    }

    if ($showRecipe) {
        $filteredRecipes[] = $recipe;
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

?>
<?php
include 'header.php';
?>

    <main>
        <aside class="sidebar">
            <h3>Filtriraj recepte</h3>
            <form method="GET" action="recipes_list.php">
                <div class="filter-group">
                    <h4>Kategorija obroka:</h4>
                    <select id="mealCategoryFilter" name="category">
                        <option value="">Sve kategorije</option>
                        <option value="doručak" <?php if ($filterCategory === 'doručak') echo 'selected'; ?>>Doručak</option>
                        <option value="ručak" <?php if ($filterCategory === 'ručak') echo 'selected'; ?>>Ručak</option>
                        <option value="večera" <?php if ($filterCategory === 'večera') echo 'selected'; ?>>Večera</option>
                    </select>
                </div>

                <div class="filter-group">
                    <h4>Glavni sastojak:</h4>
                    <input type="text" id="mainIngredientFilter" name="mainIngredient" placeholder="Npr. piletina, riža" value="<?php echo htmlspecialchars($filterMainIngredient); ?>">
                </div>
                <button type="submit">Primijeni filtere</button>
                <a href="recipes_list.php" class="button" style="margin-top:10px; background-color:#6c757d; display:block; text-align:center;">Poništi filtere</a>
            </form>
        </aside>

        <section class="recipe-list">
            <?php if (empty($filteredRecipes)): ?>
                <p>Nema recepata koji odgovaraju odabranim filterima.</p>
            <?php else: ?>
                <?php foreach ($filteredRecipes as $recipe): ?>
                    <div class="recipe-card">
                        <div class="recipe-card-image" style="background-image: url('<?php echo htmlspecialchars((string)$recipe->image); ?>');"></div>
                        <div class="recipe-card-content">
                            <h3><?php echo htmlspecialchars((string)$recipe->title); ?></h3>
                            <p>Kategorija: <?php echo htmlspecialchars((string)$recipe->category); ?></p>
                            <p class="ingredients-preview">Glavni sastojci: <?php echo htmlspecialchars((string)$recipe->mainIngredients); ?></p>
                            <a href="recipe_detail.php?id=<?php echo htmlspecialchars((string)$recipe['id']); ?>" class="details-link">Detalji</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>