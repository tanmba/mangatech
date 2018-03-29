<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangasRepository")
 */
class Mangas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\Column(type="string")
     */
    private $cover;

    /**
     * @ORM\Column(type="string")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string")
     */
    private $genre;

    /**
     * @ORM\Column(type="date")
     */
    private $date_loan;

    /**
     * @ORM\Column(type="date")
     */
    private $date_back;

    /**
     * @ORM\Column(type="boolean")
     */
    private $availability;

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return mixed
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * @param mixed $synopsis
     */
    public function setSynopsis($synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param mixed $availability
     */
    public function setAvailability($availability): void
    {
        $this->availability = $availability;
    }

    /**
     * @return mixed
     */
    public function getDateLoan()
    {
        return $this->date_loan;
    }

    /**
     * @param mixed $date_loan
     */
    public function setDateLoan($date_loan)
    {
        $this->date_loan = $date_loan;
    }

    /**
     * @return mixed
     */
    public function getDateBack()
    {
        return $this->date_back;
    }

    /**
     * @param mixed $date_back
     */
    public function setDateBack($date_back)
    {
        $this->date_back = $date_back;
    }

}
