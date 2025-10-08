<?php
declare(strict_types=1);

require_once 'config.php';


class Product
{
    private ?int $id;
    private string $name;
    /** @var array<int,string> */
    private array $photos;
    private float $price;
    private string $description;
    private int $quantity;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private ?int $category_id;

    public function __construct(
        ?int $id = null,
        string $name = 'unknown',
        array $photos = ["https://picsum.photos/200/300"],
        float $price = 0.0,
        string $description = 'No description',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        ?int $category_id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // ----- GETTERS / SETTERS -----
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    /**
     * @return array<int,string>
     */
    public function getPhotos(): array { return $this->photos; }

    /**
     * @param array<int,string> $photos
     */
    public function setPhotos(array $photos): void { $this->photos = $photos; }

    public function getPrice(): float { return $this->price; }
    public function setPrice(float $price): void { $this->price = $price; }

    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    public function getQuantity(): int { return $this->quantity; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }

    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function setCreatedAt(DateTime $createdAt): void { $this->createdAt = $createdAt; }

    public function getUpdatedAt(): DateTime { return $this->updatedAt; }
    public function setUpdatedAt(DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }

    public function getCategoryId(): ?int { return $this->category_id; }
    public function setCategoryId(?int $category_id): void { $this->category_id = $category_id; }

    // ----- CRUD -----
    public function create(): self
    {
        $sql = "INSERT INTO product (name, photos, price, description, quantity, created_at, updated_at, category_id)
                VALUES (:name, :photos, :price, :description, :quantity, :created_at, :updated_at, :category_id)";

        $db = new ConnectDB();
        $pdo = $db->connect(); // doit retourner PDO
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
        $this->id = (int)$pdo->lastInsertId();
        $this->createdAt = $now;
        $this->updatedAt = $now;

        return $this;
    }

    public function update(): bool
    {
        if ($this->id === null) {
            throw new Exception("Cannot update product without id.");
        }

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

    public function findOneById(int $id): ?Product
    {
        $sql = "SELECT * FROM product WHERE id = :id LIMIT 1";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) return null;

        return new Product(
            (int)$data['id'],
            (string)$data['name'],
            json_decode((string)$data['photos'], true) ?: [],
            (float)$data['price'],
            (string)$data['description'],
            (int)$data['quantity'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at']),
            $data['category_id'] !== null ? (int)$data['category_id'] : null
        );
    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM product";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($all as $data) {
            $products[] = new Product(
                (int)$data['id'],
                (string)$data['name'],
                json_decode((string)$data['photos'], true) ?: [],
                (float)$data['price'],
                (string)$data['description'],
                (int)$data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id'] !== null ? (int)$data['category_id'] : null
            );
        }

        return $products;
    }

    public function getCategory(): ?Category
    {
        if ($this->category_id === null) return null;

        $sql = "SELECT * FROM category WHERE id = :category_id";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':category_id' => $this->category_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) return null;

        return new Category(
            (int)$data['id'],
            (string)$data['name'],
            (string)$data['description'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at'])
        );
    }
}

/* -------------------- Category -------------------- */

class Category
{
    private ?int $id;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        ?int $id = null,
        string $name = 'unknown',
        string $description = 'No description',
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    /**
     * Retourne les produits liés à cette catégorie
     * @return Product[]
     */
    public function gets(): array
    {
        if ($this->id === null) return [];

        $sql = "SELECT * FROM product WHERE category_id = :category_id";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':category_id' => $this->id]);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($all as $data) {
            $products[] = new Product(
                (int)$data['id'],
                (string)$data['name'],
                json_decode((string)$data['photos'], true) ?: [],
                (float)$data['price'],
                (string)$data['description'],
                (int)$data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id'] !== null ? (int)$data['category_id'] : null
            );
        }

        return $products;
    }

    // ----- GETTERS / SETTERS -----
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $desc): void { $this->description = $desc; }
    public function setCreatedAt(DateTime $dt): void { $this->createdAt = $dt; }
    public function setUpdatedAt(DateTime $dt): void { $this->updatedAt = $dt; }
}

/* -------------------- Clothing (hérite Product) -------------------- */

class Clothing extends Product
{
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

    public function __construct(
        ?int $id = null,
        string $name = 'unknown',
        array $photos = ["https://picsum.photos/200/300"],
        float $price = 0.0,
        string $description = 'No description',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        ?int $category_id = null,
        string $size = 'M',
        string $color = 'No color',
        string $type = 'No type',
        int $material_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);

        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    // ----- GETTERS -----
    public function getSize(): string { return $this->size; }
    public function getColor(): string { return $this->color; }
    public function getType(): string { return $this->type; }
    public function getMaterialFee(): int { return $this->material_fee; }

    // ----- SETTERS -----
    public function setSize(string $size): void { $this->size = $size; }
    public function setColor(string $color): void { $this->color = $color; }
    public function setType(string $type): void { $this->type = $type; }
    public function setMaterialFee(int $fee): void { $this->material_fee = $fee; }

    public function create(): self
    {
        // D'abord, créer le produit de base (met à jour $this->id)
        parent::create();

        // Ensuite, insérer les données spécifiques à Clothing
        $sql = "INSERT INTO clothing (product_id, size, color, type, material_fee)
                VALUES (:product_id, :size, :color, :type, :material_fee)";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':product_id'   => $this->getId(),
            ':size'         => $this->size,
            ':color'        => $this->color,
            ':type'         => $this->type,
            ':material_fee' => $this->material_fee
        ]);

        return $this;
    }

    public function findOneById(int $id): ?Clothing
    {
        $sql = "SELECT p.*, c.size, c.color, c.type, c.material_fee
                FROM product p
                JOIN clothing c ON p.id = c.product_id
                WHERE p.id = :id
                LIMIT 1";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) return null;

        return new Clothing(
            (int)$data['id'],
            (string)$data['name'],
            json_decode((string)$data['photos'], true) ?: [],
            (float)$data['price'],
            (string)$data['description'],
            (int)$data['quantity'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at']),
            $data['category_id'] !== null ? (int)$data['category_id'] : null,
            (string)$data['size'],
            (string)$data['color'],
            (string)$data['type'],
            (int)$data['material_fee']
        );
    }

    /**
     * @return Clothing[]
     */
    public function findAll(): array
    {
        $sql = "SELECT p.*, c.size, c.color, c.type, c.material_fee
                FROM product p
                JOIN clothing c ON p.id = c.product_id";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clothingItems = [];
        foreach ($all as $data) {
            $clothingItems[] = new Clothing(
                (int)$data['id'],
                (string)$data['name'],
                json_decode((string)$data['photos'], true) ?: [],
                (float)$data['price'],
                (string)$data['description'],
                (int)$data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id'] !== null ? (int)$data['category_id'] : null,
                (string)$data['size'],
                (string)$data['color'],
                (string)$data['type'],
                (int)$data['material_fee']
            );
        }

        return $clothingItems;
    }

    public function update(): bool
    {
        if ($this->getId() === null) {
            throw new Exception("Cannot update clothing without product id.");
        }

        // Mettre à jour le produit de base
        parent::update();

        // Mettre à jour les données spécifiques à Clothing
        $sql = "UPDATE clothing SET
                    size = :size,
                    color = :color,
                    type = :type,
                    material_fee = :material_fee
                WHERE product_id = :product_id";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':product_id'   => $this->getId(),
            ':size'         => $this->size,
            ':color'        => $this->color,
            ':type'         => $this->type,
            ':material_fee' => $this->material_fee
        ]);
    }
}

/* -------------------- Electronic (hérite Product) -------------------- */

class Electronic extends Product
{
    private string $brand;
    private int $warranty_fee;

    public function __construct(
        ?int $id = null,
        string $name = 'unknown',
        array $photos = ["https://picsum.photos/200/300"],
        float $price = 0.0,
        string $description = 'No description',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        ?int $category_id = null,
        string $brand = 'No brand',
        int $warranty_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);

        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    // Getters / Setters
    public function getBrand(): string { return $this->brand; }
    public function setBrand(string $b): void { $this->brand = $b; }

    public function getWarrantyFee(): int { return $this->warranty_fee; }
    public function setWarrantyFee(int $w): void { $this->warranty_fee = $w; }

    public function create(): self
    {
        parent::create();

        $sql = "INSERT INTO electronic (product_id, brand, warranty_fee)
                VALUES (:product_id, :brand, :warranty_fee)";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':product_id'   => $this->getId(),
            ':brand'        => $this->brand,
            ':warranty_fee' => $this->warranty_fee
        ]);

        return $this;
    }

    public function findOneById(int $id): ?Electronic
    {
        $sql = "SELECT p.*, e.brand, e.warranty_fee
                FROM product p
                JOIN electronic e ON p.id = e.product_id
                WHERE p.id = :id
                LIMIT 1";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data === false) return null;

        return new Electronic(
            (int)$data['id'],
            (string)$data['name'],
            json_decode((string)$data['photos'], true) ?: [],
            (float)$data['price'],
            (string)$data['description'],
            (int)$data['quantity'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at']),
            $data['category_id'] !== null ? (int)$data['category_id'] : null,
            (string)$data['brand'],
            (int)$data['warranty_fee']
        );
    }

    /**
     * @return Electronic[]
     */
    public function findAll(): array
    {
        $sql = "SELECT p.*, e.brand, e.warranty_fee
                FROM product p
                JOIN electronic e ON p.id = e.product_id";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $electronicItems = [];
        foreach ($all as $data) {
            $electronicItems[] = new Electronic(
                (int)$data['id'],
                (string)$data['name'],
                json_decode((string)$data['photos'], true) ?: [],
                (float)$data['price'],
                (string)$data['description'],
                (int)$data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id'] !== null ? (int)$data['category_id'] : null,
                (string)$data['brand'],
                (int)$data['warranty_fee']
            );
        }

        return $electronicItems;
    }

    public function update(): bool
    {
        if ($this->getId() === null) {
            throw new Exception("Cannot update electronic without product id.");
        }

        parent::update();

        $sql = "UPDATE electronic SET
                    brand = :brand,
                    warranty_fee = :warranty_fee
                WHERE product_id = :product_id";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':product_id'   => $this->getId(),
            ':brand'        => $this->brand,
            ':warranty_fee' => $this->warranty_fee
        ]);
    }
}
