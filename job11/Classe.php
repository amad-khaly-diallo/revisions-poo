<?php

require_once 'config.php';

class Product
{
    private $id;
    private $name;
    private $photos;
    private $price;
    private $description;
    private $quantity;
    private $createdAt;
    private $updatedAt;
    private $category_id;

    public function __construct($id = null, $name = 'unknown', $photos = ["https://picsum.photos/200/300"], $price = 0.0, $description = 'No description', $quantity = 0, $createdAt = null, $updatedAt = null, $category_id = null)
    {
        $this->id = $id ?? null;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->createdAt = ($createdAt instanceof DateTime) ? $createdAt : new DateTime();
        $this->updatedAt = ($updatedAt instanceof DateTime) ? $updatedAt : new DateTime();
    }

    // ----- GETTERS / SETTERS -----
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }
    public function getPhotos() { return $this->photos; }
    public function setPhotos($photos) { $this->photos = $photos; }
    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }
    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }
    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt($createdAt) { $this->createdAt = $createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }
    public function setUpdatedAt($updatedAt) { $this->updatedAt = $updatedAt; }
    public function getCategoryId() { return $this->category_id; }
    public function setCategoryId($category_id) { $this->category_id = $category_id; }

    // ----- CRUD -----
    public function create()
    {
        $sql = "INSERT INTO product (name, photos, price, description, quantity, created_at, updated_at, category_id)
                VALUES (:name, :photos, :price, :description, :quantity, :created_at, :updated_at, :category_id)";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        $now = new DateTime();

        $stmt->execute([
            ':name'        => $this->name,
            ':photos'      => json_encode($this->photos),
            ':price'       => $this->price,
            ':description' => $this->description,
            ':quantity'    => $this->quantity,
            ':category_id' => $this->category_id,
            ':created_at'  => $now->format('Y-m-d H:i:s'),
            ':updated_at'  => $now->format('Y-m-d H:i:s')
        ]);

        // Mettre à jour l'objet actuel
        $this->id = $pdo->lastInsertId();
        $this->createdAt = $now;
        $this->updatedAt = $now;

        return $this;
    }

    public function update()
    {
        $sql = "UPDATE product SET
                    name = :name,
                    photos = :photos,
                    price = :price,
                    description = :description,
                    quantity = :quantity,
                    updated_at = :updated_at,
                    category_id = :category_id
                WHERE id = :id";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        $this->updatedAt = new DateTime(); // maj auto

        return $stmt->execute([
            ':id'          => $this->id,
            ':name'        => $this->name,
            ':photos'      => json_encode($this->photos),
            ':price'       => $this->price,
            ':description' => $this->description,
            ':quantity'    => $this->quantity,
            ':updated_at'  => $this->updatedAt->format('Y-m-d H:i:s'),
            ':category_id' => $this->category_id
        ]);
    }

    public function findOneById($id)
    {
        $sql = "SELECT * FROM product WHERE id = :id LIMIT 1";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return false;

        return new Product(
            $data['id'],
            $data['name'],
            json_decode($data['photos'], true),
            $data['price'],
            $data['description'],
            $data['quantity'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at']),
            $data['category_id']
        );
    }

    public function findAll()
    {
        $sql = "SELECT * FROM product";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($all as $data) {
            $products[] = new Product(
                $data['id'],
                $data['name'],
                json_decode($data['photos'], true),
                $data['price'],
                $data['description'],
                $data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id']
            );
        }

        return $products;
    }

    public function getCategory()
    {
        if ($this->category_id === null) return null;

        $sql = "SELECT * FROM category WHERE id = :category_id";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':category_id' => $this->category_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new Category(
            $data['id'],
            $data['name'],
            $data['description'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at'])
        );
    }
}

class Category
{
    private $id;
    private $name;
    private $description;
    private $createdAt;
    private $updatedAt;

    public function __construct($id = null, $name = 'unknown', $description = 'No description', $createdAt = null, $updatedAt = null)
    {
        $this->id = $id ?? null;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = ($createdAt instanceof DateTime) ? $createdAt : new DateTime();
        $this->updatedAt = ($updatedAt instanceof DateTime) ? $updatedAt : new DateTime();
    }

    public function gets()
    {
        $sql = "SELECT * FROM product WHERE category_id = :category_id";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':category_id' => $this->id]);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($all as $data) {
            $products[] = new Product(
                $data['id'],
                $data['name'],
                json_decode($data['photos'], true),
                $data['price'],
                $data['description'],
                $data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id']
            );
        }

        return $products;
    }

    // ----- GETTERS / SETTERS -----
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }
    public function setId($id) { $this->id = $id; }
    public function setName($name) { $this->name = $name; }
    public function setDescription($desc) { $this->description = $desc; }
    public function setCreatedAt($dt) { $this->createdAt = $dt; }
    public function setUpdatedAt($dt) { $this->updatedAt = $dt; }
}


class Clothing extends Product {
    private $size;
    private $color;
    private $type;
    private $material_fee;

    public function __construct(
        $id = null,
        $name = 'unknown',
        $photos = ["https://picsum.photos/200/300"],
        $price = 0.0,
        $description = 'No description',
        $quantity = 0,
        $createdAt = null,
        $updatedAt = null,
        $category_id = null,
        $size = 'M',
        $color = 'No color',
        $type = 'No type',
        $material_fee = 0
    ) {
        // Appeller le constructeur parent pour les propriétés de Product
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);

        // Propriétés spécifiques à Clothing
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    // ----- GETTERS -----
    public function getSize() { return $this->size; }
    public function getColor() { return $this->color; }
    public function getType() { return $this->type; }
    public function getMaterialFee() { return $this->material_fee; }

    // ----- SETTERS -----
    public function setSize($size) { $this->size = $size; }
    public function setColor($color) { $this->color = $color; }
    public function setType($type) { $this->type = $type; }
    public function setMaterialFee($fee) { $this->material_fee = $fee; }
}


class Electronic extends Product
{
    private $brand;
    private $warranty_fee;

    public function __construct(
        $id = null,
        $name = 'unknown',
        $photos = ["https://picsum.photos/200/300"],
        $price = 0.0,
        $description = 'No description',
        $quantity = 0,
        $createdAt = null,
        $updatedAt = null,
        $category_id = null,
        $brand = 'No brand',
        $warranty_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);

        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    // Getters / Setters
    public function getBrand() { return $this->brand; }
    public function setBrand($b) { $this->brand = $b; }

    public function getWarrantyFee() { return $this->warranty_fee; }
    public function setWarrantyFee($w) { $this->warranty_fee = $w; }
}
