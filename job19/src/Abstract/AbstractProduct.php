<?php

namespace Khalyamad\Job15\Abstract;

use Khalyamad\Job15\config\ConnectDB;
use Khalyamad\Job15\EntityCollection;
use Khalyamad\Job15\Interface\EntityInterface;
use DateTime;
use Exception;
use PDO;

require_once(__DIR__ . '/../../config/config.php');

/* -------------------- Produit abstrait -------------------- */
abstract class AbstractProduct implements EntityInterface
{
    protected ?int $id;
    protected string $name;
    /** @var array<int,string> */
    protected array $photos;
    protected float $price;
    protected string $description;
    protected int $quantity;
    protected DateTime $createdAt;
    protected DateTime $updatedAt;
    protected ?int $category_id;
    protected ?int $product_id; // Ajouté pour lier aux tables spécifiques

    public function __construct(
        string $name = 'unknown',
        array $photos = ["https://picsum.photos/200/300"],
        float $price = 0.0,
        string $description = 'No description',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        ?int $category_id = null
    ) {
        $this->id = null;
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
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    /** @return array<int,string> */
    public function getPhotos(): array
    {
        return $this->photos;
    }
    /** @param array<int,string> $photos */
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }
    public function setCategoryId(?int $category_id): void
    {
        $this->category_id = $category_id;
    }

    // ----- Méthodes abstraites -----
    abstract public function create(): static;
    abstract public function update(): bool;
    abstract public function findOneById(int $id): ?static;
    /** @return static[] */
    abstract public function findAll(): array;

    // ----- Méthodes communes -----
    public function getCategory(): ?Category
    {
        if ($this->category_id === null) return null;

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM category WHERE id=:id");
        $stmt->execute([':id' => $this->category_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;

        return new Category(
            (int)$data['id'],
            $data['name'],
            $data['description'],
            new DateTime($data['created_at']),
            new DateTime($data['updated_at'])
        );
    }

    protected function executeBaseCreate(): void
    {
        $sql = "INSERT INTO product (name, photos, price, description, quantity, created_at, updated_at, category_id)
                VALUES (:name, :photos, :price, :description, :quantity, :created_at, :updated_at, :category_id)";
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);

        $now = new DateTime();
        $stmt->execute([
            ':name' => $this->name,
            ':photos' => json_encode($this->photos),
            ':price' => $this->price,
            ':description' => $this->description,
            ':quantity' => $this->quantity,
            ':category_id' => $this->category_id,
            ':created_at' => $now->format('Y-m-d H:i:s'),
            ':updated_at' => $now->format('Y-m-d H:i:s')
        ]);

        $this->id = (int)$pdo->lastInsertId();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    protected function executeBaseUpdate(): bool
    {
        if ($this->id === null) throw new Exception("Cannot update product without id.");

        $sql = "UPDATE product SET
                    name=:name,
                    photos=:photos,
                    price=:price,
                    description=:description,
                    quantity=:quantity,
                    updated_at=:updated_at,
                    category_id=:category_id
                WHERE id=:id";

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $this->updatedAt = new DateTime();

        return $stmt->execute([
            ':id' => $this->id,
            ':name' => $this->name,
            ':photos' => json_encode($this->photos),
            ':price' => $this->price,
            ':description' => $this->description,
            ':quantity' => $this->quantity,
            ':updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
            ':category_id' => $this->category_id
        ]);
    }

    public function save($id)
    {
        $sql = 'SELECT id FROM product WHERE id = :id';
        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($id) {
            return $this->update();
        } else {
            return $this->create();
        }
    }
}
