<?php

namespace App\Repository;

use App\Entity\Kit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Kit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kit[]    findAll()
 * @method Kit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Kit::class);
    }

    // /**
    //  * @return Kit[] Returns an array of Kit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kit
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
