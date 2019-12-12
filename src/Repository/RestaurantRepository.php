<?php

namespace App\Repository;

use App\Entity\Restaurant;
use App\Form\SearchRestaurantType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function findRestaurants($data)
    {

        $builder = $this->createQueryBuilder('r')
            ->orWhere('r.name LIKE :input')
            ->setParameter('input', '%' . $data[SearchRestaurantType::NAME] . '%')
            ->orderBy('r.name', 'ASC');


        if (!empty($data[SearchRestaurantType::TYPE])) {
            $builder
                ->andWhere('r.type = :type')
                ->orderBy('r.name', 'ASC')
                ->setParameter('type', $data[SearchRestaurantType::TYPE]);
        }

        return $builder->getQuery()->getResult();
    }

    public function findType()
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('r.type')
            ->groupBy('r.type')
            ->orderBy('r.type', 'ASC');

        $result = $qb
            ->getQuery()
            ->getArrayResult();

        return array_column($result, 'type');
    }

}
