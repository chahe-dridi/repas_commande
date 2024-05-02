<?php

namespace App\Repository;

use App\Entity\InformationPersonnele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InformationPersonnele>
 *
 * @method InformationPersonnele|null find($id, $lockMode = null, $lockVersion = null)
 * @method InformationPersonnele|null findOneBy(array $criteria, array $orderBy = null)
 * @method InformationPersonnele[]    findAll()
 * @method InformationPersonnele[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformationPersonneleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InformationPersonnele::class);
    }

//    /**
//     * @return InformationPersonnele[] Returns an array of InformationPersonnele objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InformationPersonnele
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByUserId($id): array
  {
     return $this->createQueryBuilder('i')
          ->andWhere('i.user = :val')
        ->setParameter('val', $id)
         ->orderBy('i.id', 'ASC')
      ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
  }
}
