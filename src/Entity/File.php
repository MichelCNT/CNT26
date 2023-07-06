<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255)]
    private ?string $filePath = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'files')]
    private ?self $file = null;

    #[ORM\OneToMany(mappedBy: 'file', targetEntity: self::class)]
    private Collection $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFile(): ?self
    {
        return $this->file;
    }

    public function setFile(?self $file): static
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(self $file): static
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setFile($this);
        }

        return $this;
    }

    public function removeFile(self $file): static
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getFile() === $this) {
                $file->setFile(null);
            }
        }

        return $this;
    }

    public function getFileBasePath(): string
    {
        return "/" . Article::UPLOAD_IMAGES_BASE_PATH . "/" . $this->getFilePath();
    }

    public function getSlug(): ?string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
