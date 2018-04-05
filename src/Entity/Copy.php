<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CopyRepository")
 */
class Copy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="copies", cascade={"persist"} )
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Mangas", inversedBy="copies", cascade={"persist"} )
     */
    private $manga;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"} )
     */
    private $borrowedBy;

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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getManga()
    {
        return $this->manga;
    }

    /**
     * @param mixed $manga
     */
    public function setManga($manga): void
    {
        $this->manga = $manga;
    }

    /**
     * @return mixed
     */
    public function getBorrowedBy()
    {
        return $this->borrowedBy;
    }

    /**
     * @param mixed $borrowedBy
     */
    public function setBorrowedBy($borrowedBy): void
    {
        $this->borrowedBy = $borrowedBy;
    }

}
