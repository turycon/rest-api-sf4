<?php

namespace App\Repository;

use App\Entity\ProjectProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProjectProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectProfile[]    findAll()
 * @method ProjectProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectProfileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProjectProfile::class);
    }

    // /**
    //  * @return ProjectProfile[] Returns an array of ProjectProfile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectProfile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
