<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: index.php');
    exit();
}

$recipeId = $_GET['id'] ?? '';
$currentRecipe = null;
$recipesXmlPath = 'podaci/recipes.xml';

if (file_exists($recipesXmlPath)) {
    $recipesXml = simplexml_load_file($recipesXmlPath);

    if ($recipesXml !== false) {
        foreach ($recipesXml->recipe as $recipe) {
            if ((string)$recipe['id'] === $recipeId) {
                $currentRecipe = $recipe;
                break;
            }
        }
    }
}

if (!$currentRecipe) {
    header('Location: recipes_list.php'); 
    exit();
}
?>
<?php
include 'header.php';
?>

    <main class="recipe-detail-main"> <div class="recipe-detail-container">
            <h2><?php echo htmlspecialchars((string)$currentRecipe->title); ?></h2>
            <p><strong>Kategorija:</strong> <?php echo htmlspecialchars((string)$currentRecipe->category); ?></p>

            <h3>Sastojci:</h3>
            <ul>
                <?php foreach ($currentRecipe->ingredients->item as $item): ?>
                    <li><?php echo htmlspecialchars((string)$item); ?></li>
                <?php endforeach; ?>
            </ul>

            <h3>Upute:</h3>
            <ol>
                <?php foreach ($currentRecipe->instructions->step as $step): ?>
                    <li><?php echo htmlspecialchars((string)$step); ?></li>
                <?php endforeach; ?>
            </ol>

            <a href="recipes_list.php" class="button">← Natrag na recepte</a>
        </div>

        <?php if (!empty($currentRecipe->image)): ?>
            <div class="recipe-detail-image-container">
                <img src="<?php echo htmlspecialchars((string)$currentRecipe->image); ?>" alt="<?php echo htmlspecialchars((string)$currentRecipe->title); ?>">
            </div>
        <?php endif; ?>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>