<?php

namespace App\Repository;

use App\Entity\Mangas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mangas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mangas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mangas[]    findAll()
 * @method Mangas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangasRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mangas::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.something = :value')->setParameter('value', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
