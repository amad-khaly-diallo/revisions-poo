<?php

declare(strict_types=1);

require_once 'config.php';

/* -------------------- Produit abstrait -------------------- */
abstract class AbstractProduct
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
    public function getId(): ?int
    {
        return $this->id;
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

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(string $desc): void
    {
        $this->description = $desc;
    }

    /** @return Product[] */
    public function getProducts(): array
    {
        if ($this->id === null) return [];

        $db = new ConnectDB();
        $pdo = $db->connect();
        $stmt = $pdo->prepare("SELECT * FROM product WHERE category_id=:id");
        $stmt->execute([':id' => $this->id]);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($all as $data) {
            $products[] = new class(
                (int)$data['id'],
                $data['name'],
                json_decode($data['photos'], true) ?: [],
                (float)$data['price'],
                $data['description'],
                (int)$data['quantity'],
                new DateTime($data['created_at']),
                new DateTime($data['updated_at']),
                $data['category_id']
            ) extends AbstractProduct {
                public function create(): static
                {
                    return $this;
                }
                public function update(): bool
                {
                    return true;
                }
                public function findOneById(int $id): ?static
                {
                    return $this;
                }
                public function findAll(): array
                {
                    return [$this];
                }
            };
        }

        return $products;
    }
}