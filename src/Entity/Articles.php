<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=1000000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $authore;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleslug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorieslug;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $years;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $month;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $day;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;

    public function __construct(){
        $this->created_at = New \DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }


    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->Categorie = $categorie;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAuthore(): ?string
    {
        return $this->authore;
    }

    public function setAuthore(string $authore): self
    {
        $this->authore = $authore;

        return $this;
    }



    public function getTitleslug(): ?string
    {
      return $this->titleslug;
    }

    public function setTitleslug(string $titleslug): self
    {
        $this->titleslug = $titleslug;

        return $this;
    }

    public function getCategorieslug(): ?string
    {
        return $this->categorieslug;
    }

    public function setCategorieslug(string $categorieslug): self
    {
        $this->categorieslug = $categorieslug;

        return $this;
    }

    public function getYears(): ?string
    {
        return $this->years;
    }

    public function setYears(string $years): self
    {
        $this->years = $years;

        return $this;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }
    public function setMonth(string $month): self
    {
        $this->months = $month;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }
    public function getSlugtitle(){
        return  $slugify =(new Slugify())->slugify($this->title);
    }
    public function getSlugcategorie(){
        return  $slugify =(new Slugify())->slugify($this->categorie);
    }
}
