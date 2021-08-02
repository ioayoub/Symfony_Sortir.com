<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Trips;
use Doctrine\ORM\Query;
use App\Entity\TripSearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Trips|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trips|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trips[]    findAll()
 * @method Trips[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trips::class);
    }

    public function getAllTrips(TripSearch $search, $userId)
    {
        $query = $this->createQueryBuilder('t');

        if ($search->getCampusSearch() != null) {
            $query = $query->andWhere('t.organizer = :organizer');
            $query->setParameter('organizer', $search->getCampusSearch());
        }

        if ($search->getManualSearch() != null) {
            $query = $query->andWhere('t.name = :name');
            $query->setParameter('name', $search->getManualSearch());
        }

        if ($search->getStartDateSearch() != null) {
            $query = $query->andWhere('t.dateStart >= :dateStart');
            $query->setParameter('dateStart', $search->getStartDateSearch());
        }

        if ($search->getEndDateSearch() != null) {
            $query = $query->andWhere('t.limitRegisterDate <= :limitRegisterDate');
            $query->setParameter('limitRegisterDate', $search->getEndDateSearch());
        }

        if ($search->getIsOrganizerSearch()) {
            $query = $query->andWhere('t.isOrganizer = :isOrganizer');
            $query->setParameter('isOrganizer', $userId);
        }

        if ($search->getIsSubscribedSearch() != null) {
            $query = $query->andWhere('t.isSubscribed MEMBER OF :isSubscribed');
            $query->setParameter('isSubcribed', $userId());
        }

        if ($search->getIsNotSubscribedSearch() != null) {
            $query = $query->andWhere(':isNotSubscribed NOT MEMBER OF t.user');
            $query->setParameter('isNotSubscribed', $userId);
        }

        if ($search->getIsOutdatedSearch()) {
            $query = $query->andWhere('t.state <= :state');
            $query->setParameter('state', 5);
        }



        dump($query->getQuery()->getDQL());
        return  $query->getQuery()->getResult();
    }


    // /**
    //  * @return Trips[] Returns an array of Trips objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trips
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
