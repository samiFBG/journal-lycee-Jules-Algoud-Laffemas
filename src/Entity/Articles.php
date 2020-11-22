<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 * @UniqueEntity("title")
 */
class Articles
{
    const month=[
        1=> 'Janvier',
        2=> 'Fevrier',
        3=> 'Mars',
        4=> 'Avril',
        5=> 'Mai',
        6=> 'Juin',
        7=> 'Juiller',
        8=> 'Aout',
        9=> 'Septembre',
        10=> 'Octobre',
        11=> 'Novembre',
        12=> 'Decembre',
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=5)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     *
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
     *
     */
    private $created_at;



    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $titleslug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorieslug;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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
        $this->setTitleSlug($title);
        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;
        $this->setCategorieslug($categorie);

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

    public function setTitleslug()
    {

        $this->titleslug = (new Slugify())->slugify($this->title);

        return $this;
    }

    public function getCategorieslug(): ?string
    {
        return $this->categorieslug;
    }

    public function setCategorieslug()
    {
        $this->categorieslug = (new Slugify())->slugify($this->categorie);

        return $this;
    }

    public function getYears(): ?string
    {
        $years = date_format($this->created_at,'Y');
        return   $years;
    }



    public function getMonth(): ?string
    {
        $month = date_format($this->created_at,'m');
        return $month;
    }

    public function getMonthname():string
    {
        return self::month[$this->getMonth()] ;
    }

    public function getDay(): ?string
    {
       $day = date_format($this->created_at,'d');
        return $day;
    }
    public function getTimeh(): ?string
    {
        $timeh = date_format($this->created_at,'H');
        return $timeh;
    }
    public function getTimem(): ?string
    {
        $timem = date_format($this->created_at,'i');
        return $timem;
    }
    public function getSlugtitle(){
        return  $slugify =(new Slugify())->slugify($this->title);
    }
    public function getSlugcategorie(){
        return  $slugify =(new Slugify())->slugify($this->categorie);
    }

    public function getEdityears(): ?string
    {
        $years = date_format($this->update_at,'Y');
        return   $years;
    }
    public function getEditmonth(): ?string
    {

        $month = date_format($this->update_at,'m');
        return $month;
    }

    public function getEditMonthname():string
    {
        return self::month[$this->getEditmonth()] ;
    }

    public function getEditday(): ?string
    {
        $day = date_format($this->update_at,'d');
        return $day;
    }

    public function getEdittimeh(): ?string
    {
        $timeh = date_format($this->update_at,'H');
        return $timeh;
    }
    public function getEdittimem(): ?string
    {
        $timem = date_format($this->update_at,'i');
        return $timem;
    }

    public function getEdittime(): ?string
    {if (!isset($this->update_at)){
        return null;
    }else{
        return 1;
    }

    }


    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }




}
