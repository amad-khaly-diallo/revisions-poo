<?php
require_once 'Product.php';
require_once 'config.php';

$sql = "SELECT * FROM product WHERE id = 17";

try {
    $pdo = $db->connect();
    $stmt = $pdo->query($sql);
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// instantiate a Product object using the fetched data
$product = new Product(
    $productData['id'],
    $productData['name'],
    json_decode($productData['photos'], true),
    $productData['price'],
    $productData['description'],
    $productData['quantity'],
    new DateTime($productData['created_at']),
    new DateTime($productData['updated_at']),
    $productData['category_id']
);
// display product details
echo "<pre>";
echo "<h2> Nom du Produit </h2>";
var_dump($product->getProductName());
echo "<h2> Photos du Produit </h2>";
var_dump($product->getProductPhotos());
echo "<h2> Prix du Produit </h2>";
var_dump($product->getProductPrice());
echo "<h2> Description du Produit </h2>";
var_dump($product->getProductDescription());
echo "<h2> Quantité du Produit </h2>";
var_dump($product->getProductQuantity());
echo "<h2> Date de Création du Produit </h2>";
var_dump($product->getProductCreatedAt());
echo "<h2> Date de Mise à Jour du Produit </h2>";
var_dump($product->getProductUpdatedAt());
echo "<h2> ID de la Catégorie du Produit </h2>";
var_dump($product->getProductCategoryId());
echo "<h2> afficher la Catégorie du Produit </h2>";
var_dump($product->getCategory());
echo "</pre>";
