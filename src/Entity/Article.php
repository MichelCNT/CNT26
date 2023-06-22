<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    public const CATEGORIES = ['Information', 'Manifestation', 'Lutte'];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $Text = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[Assert\Length(
        min: 2,
        max: 15
    )]
    #[ORM\Column(length: 255)]
    private ?string $author = null;


    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private ?int $category = null;

    #[Assert\Length(
        min: 10,
        max: 20
    )]
    #[ORM\Column(length: 50)]
    private ?string $shortTitle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): static
    {
        $this->Text = $Text;

        return $this;
    }

    public function getCreated_at(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreated_at(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): string {
        return (new Slugify())->slugify($this->title);
    }

    public function getCategoryName(): string {
        return self::CATEGORIES[$this->getCategory()];
    }

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(string $shortTitle): static
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }
}
