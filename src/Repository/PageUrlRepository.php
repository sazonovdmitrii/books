<?php

namespace App\Repository;

use App\Entity\PageUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PageUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageUrl[]    findAll()
 * @method PageUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageUrlRepository extends ServiceEntityRepository
{
    /**
     * PageUrlRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageUrl::class);
    }

    /**
     * @param string $url
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUrl(string $url)
    {
        return $this->createQueryBuilder('u')
            ->where('u.url = :url')
            ->setParameter('url', $url)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
