<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MangasRepository")
 *  @Vich\Uploadable
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
     * @ORM\OneToMany(targetEntity="Copy", mappedBy="manga", cascade={"persist"} )
     */
    private $copies;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $cover;

    /**
     * @Vich\UploadableField(mapping="manga_covers", fileNameProperty="cover")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string")
     */
    private $genre;

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

    public function setImageFile(File $cover = null)
    {
        $this->imageFile = $cover;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($cover) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
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
    public function setCover($cover)
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
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCopies()
    {
        return $this->copies;
    }

    /**
     * @param mixed $copies
     */
    public function setCopies($copies): void
    {
        $this->copies = $copies;
    }

    public function addCopy(Copy $copy)
    {
        $this->copies->add($copy);
    }

    public function __construct() {
        $this->copies = new ArrayCollection();
        $this->isActive = true;
    }

    public function canBorrow()
    {
        $availableCopies = array_filter($this->copies->toArray(), function (Copy $copy) {
            return !$copy->getBorrowedBy();
        });

        return \count($availableCopies) >= 1;
    }

}
