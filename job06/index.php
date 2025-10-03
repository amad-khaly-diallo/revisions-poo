<?php
require_once 'Product.php';
require_once 'config.php';

$sql = "SELECT * FROM category WHERE id = 7";

try {
    $pdo = $db->connect();
    $stmt = $pdo->query($sql);
    $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// instantiate a Category object using the fetched data
$category = new Category(
    $categoryData['id'],
    $categoryData['name'],
    $categoryData['description'],
    new DateTime($categoryData['created_at']),
    new DateTime($categoryData['updated_at']),
);
// display category details
echo "<pre>";
echo "<h2> Nom de la Catégorie </h2>";
var_dump($category->getName());
echo "<h2> Description de la Catégorie </h2>";
var_dump($category->getDescription());

echo "<h2> Date de Création de la Catégorie </h2>";
var_dump($category->getCreatedAt());
echo "<h2> Date de Mise à Jour de la Catégorie </h2>";
var_dump($category->getUpdatedAt());
echo "<h2> afficher les Produits de la Catégorie </h2>";
var_dump($category->getProducts());
echo "</pre>";