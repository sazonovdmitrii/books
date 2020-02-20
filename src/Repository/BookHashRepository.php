<?php

namespace App\Repository;

use App\Entity\BookHash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BookHash|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookHash|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookHash[]    findAll()
 * @method BookHash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookHashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookHash::class);
    }

    // /**
    //  * @return BookHash[] Returns an array of BookHash objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookHash
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
