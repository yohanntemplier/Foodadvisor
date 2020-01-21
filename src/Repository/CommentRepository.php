<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @param Restaurant $restaurant
     * @return float|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findAverageOfAllActiveReviewsForOneRestaurant(Restaurant $restaurant) : ?float
    {
        return $this->createQueryBuilder('c')
            ->select('AVG(c.note) AS moyenne')
            ->andWhere('c.restaurants = :restaurant')
            ->andWhere('c.isActive = true')
            ->setParameter('restaurant', $restaurant)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findActiveComment()
    {
        $builder = $this->createQueryBuilder('c')
            ->orderBy('c.date', 'DESC')
            ->andWhere('c.isActive = true');

        return $builder->getQuery()->getResult();
    }

    public function findNotActiveComment()
    {
        $builder = $this->createQueryBuilder('c')
            ->orderBy('c.date', 'DESC')
            ->andWhere('c.isActive = false');

        return $builder->getQuery()->getResult();
    }
}
