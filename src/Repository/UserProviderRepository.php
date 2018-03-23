<?php

namespace App\Repository;

use App\Entity\UserProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserProvider|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProvider|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProvider[]    findAll()
 * @method UserProvider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProviderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserProvider::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
