<?php
declare(strict_types=1);

require_once 'Classe.php';

// ----- Test pour Clothing -----
echo "<h2>Test Clothing</h2>";

$clothing = new Clothing(
    null,
    "T-Shirt Test",
    ["https://picsum.photos/200/300", "https://picsum.photos/200/301"],
    29.99,
    "T-shirt de test",
    10,
    null,
    null,
    1,
    "L",
    "Blue",
    "T-Shirt",
    5
);

// Création en BDD
$clothing->create();

// Affichage
echo "<strong>Nom :</strong> " . htmlspecialchars($clothing->getName()) . "<br>";
echo "<strong>Prix :</strong> $" . $clothing->getPrice() . "<br>";
echo "<strong>Quantité :</strong> " . $clothing->getQuantity() . "<br>";
echo "<strong>Taille :</strong> " . $clothing->getSize() . "<br>";
echo "<strong>Couleur :</strong> " . $clothing->getColor() . "<br>";
echo "<strong>Type :</strong> " . $clothing->getType() . "<br>";
echo "<strong>Frais matière :</strong> " . $clothing->getMaterialFee() . "<br>";

$foundClothing = $clothing->findOneById($clothing->getId());
if ($foundClothing) {
    echo "<em>Produit Clothing récupéré avec findOneById</em><br>";
} else {
    echo "<em>Échec récupération Clothing</em><br>";
}

// ----- Test pour Electronic -----
echo "<h2>Test Electronic</h2>";

$electronic = new Electronic(
    null,
    "Casque Test",
    ["https://picsum.photos/200/310"],
    99.99,
    "Casque de test",
    5,
    null,
    null,
    2,
    "BrandX",
    12
);

// Création en BDD
$electronic->create();

// Affichage
echo "<strong>Nom :</strong> " . htmlspecialchars($electronic->getName()) . "<br>";
echo "<strong>Prix :</strong> $" . $electronic->getPrice() . "<br>";
echo "<strong>Quantité :</strong> " . $electronic->getQuantity() . "<br>";
echo "<strong>Marque :</strong> " . $electronic->getBrand() . "<br>";
echo "<strong>Frais garantie :</strong> " . $electronic->getWarrantyFee() . "<br>";

$foundElectronic = $electronic->findOneById($electronic->getId());
if ($foundElectronic) {
    echo "<em>Produit Electronic récupéré avec findOneById</em><br>";
} else {
    echo "<em>Échec récupération Electronic</em><br>";
}
