<?php
require_once 'Product.php';
require_once 'config.php';

// Créer un produit
$product = new Product(
    null,
    "Test product",
    ["https://picsum.photos/200/300", "https://picsum.photos/200/301"],
    99.99,
    "This is a test product",
    10,
    null,
    null,
    1
);

// Enregistrer en BDD
$newProduct = $product->create();

// Affichage initial
echo "<h2>Produit créé</h2>";
echo "<strong>Nom :</strong> " . htmlspecialchars($newProduct->getName()) . "<br>";
echo "<strong>Quantité :</strong> " . $newProduct->getQuantity() . "<br>";

// ---- Update du produit ----
$newProduct->setName("Produit mis à jour");
$newProduct->setPrice(149.99);
$newProduct->setQuantity(20);
$newProduct->update();

// Affichage après update
echo "<h2>Produit mis à jour</h2>";
echo "<strong>Nom :</strong> " . htmlspecialchars($newProduct->getName()) . "<br>";
echo "<strong>Prix :</strong> $" . number_format($newProduct->getPrice(), 2) . "<br>";
echo "<strong>Quantité :</strong> " . $newProduct->getQuantity() . "<br>";

// Afficher les photos
echo "<h3>Photos :</h3>";
foreach ($newProduct->getPhotos() as $photo) {
    echo "<img src='" . htmlspecialchars($photo) . "' alt='Photo produit' style='width:150px;margin:5px;'>";
}
