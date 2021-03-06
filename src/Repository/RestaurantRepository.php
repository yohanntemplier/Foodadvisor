<?php

namespace App\Repository;

use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use App\Form\SearchRestaurantType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

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

    /**
     * @param RestaurantSearch $search
     * @return array
     */
    public function findAllRestaurantsQuery(RestaurantSearch $search): Array
    {
        $query = $this->findRestaurantsQuery();

        if($search->getName()){
            $query = $query
                ->andWhere('r.name LIKE :name')
                ->setParameter('name', '%' . $search->getName() . '%')
                ->orderBy('r.name', 'ASC');
        }

        if($search->getType()){
            $query = $query
                ->andWhere('r.type LIKE :type')
                ->setParameter('type', '%' . $search->getType() . '%')
                ->orderBy('r.name', 'ASC');
        }

        if($search->getCost()){
            $query = $query
                ->andWhere('r.cost LIKE :cost')
                ->setParameter('cost', '%' . $search->getCost() . '%')
                ->orderBy('r.name', 'ASC');
        }

        if($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query=$query
                ->select('r')
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((r.lat - :lat) * pi()/180 / 2), 2) +COS(r.lat *      
     pi()/180) * COS(:lat * pi()/180) * POWER(SIN((r.lng - :lng) * pi()/180 / 2), 2) )) ) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
        }

        return $query->getQuery()->getResult();
    }

    public function RestaurantPerName()
    {
        $builder = $this->createQueryBuilder('r')
            ->orderBy('r.name', 'ASC');

        return $builder->getQuery()->getResult();
    }

    public function findLatest(): array
    {
        return $this->findRestaurantIDQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    private function findRestaurantsQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.name', 'ASC');
    }

    private function findRestaurantIDQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC');
    }
}

