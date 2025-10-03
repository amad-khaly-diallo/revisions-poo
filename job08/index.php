<?php
require_once 'Product.php';
require_once 'config.php';


// instantiate a Product
$product = new Product();
echo "<pre>";
echo "<br>";
echo "<h2> Afficher tous les produits de la base de données </h2>";
var_dump($product->findAll());
echo "</pre>";
