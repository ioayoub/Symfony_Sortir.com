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
            $query =
                $query
                ->andWhere('t.organizer = :organizer')
                ->setParameter('organizer', $search->getCampusSearch());
        }

        if ($search->getManualSearch() != null) {
            $query =
                $query
                ->andWhere('t.name = :name')
                ->setParameter('name', $search->getManualSearch());
        }

        if ($search->getStartDateSearch() != null) {
            $query =
                $query
                ->andWhere('t.dateStart >= :dateStart')
                ->setParameter('dateStart', $search->getStartDateSearch());
        }

        if ($search->getEndDateSearch() != null) {
            $query =
                $query
                ->andWhere('t.limitRegisterDate <= :limitRegisterDate')
                ->setParameter('limitRegisterDate', $search->getEndDateSearch());
        }

        if ($search->getIsOrganizerSearch()) {
            $query =
                $query
                ->andWhere('t.isOrganizer = :isOrganizer')
                ->setParameter('isOrganizer', $userId);
        }

        if ($search->getIsSubscribedSearch() != null) {
            $query =
                $query
                ->andWhere(':isSubscribed MEMBER OF t.isSubscribed')
                ->setParameter('isSubscribed', $userId);
        }
        if ($search->getIsNotSubscribedSearch() != null) {
            $query =
                $query
                ->andWhere('NOT :isNotSubscribed MEMBER OF t.isSubscribed')
                ->setParameter('isNotSubscribed', $userId);
        }

        if ($search->getIsOutdatedSearch()) {
            $query = $query
                ->andWhere('t.state <= :state')
                ->setParameter('state', 5);
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
