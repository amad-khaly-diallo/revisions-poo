<?php
require __DIR__ . '/vendor/autoload.php';

use Khalyamad\Job15\Category;


// On crée une catégorie avec un id existant en base
$category = new Category(1, "Informatique", "Catégorie de produits informatiques");

// On récupère la collection de produits
$productsCollection = $category->getProducts();

// Affiche le nombre de produits
echo "Catégorie : " . $category->getName() . "<br>";
echo "<br>--------------------------<br>";

// Parcours de tous les produits
foreach ($productsCollection->getAll() as $product) {
    echo "Produit : " . $product->getName() . "<br>";
    echo "Prix : " . $product->getPrice() . " €<br>";
    echo "Quantité : " . $product->getQuantity() . "<br>";
    echo "--------------------------<br>";
}