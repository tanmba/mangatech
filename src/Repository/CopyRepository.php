<?php

namespace App\Repository;

use App\Entity\Copy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Copy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Copy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Copy[]    findAll()
 * @method Copy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CopyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Copy::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getMangasCopies($mangasId)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.manga', 'm')
            ->where('m.id = :id')
            ->setParameter('id', $mangasId)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getUserCopies($userId)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getByUserAndManga($userId, $mangaId)
    {
        return $this
            ->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->leftJoin('c.manga', 'm')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('m.id = :mangaId')
            ->setParameter('mangaId', $mangaId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
