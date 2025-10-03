<?php
require_once 'Product.php';
$category1 = new Category(1, "Smartphones", "Tous les smartphones", new DateTime(), new DateTime());

$product1 = new Product();

// Afficher la catégorie du produit
echo "<pre>";
var_dump($product1->getProductName());
echo "</pre>";
