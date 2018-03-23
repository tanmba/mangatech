<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProviderRepository")
 */
class UserProvider
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
}
