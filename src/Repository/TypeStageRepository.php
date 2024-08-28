<?php

namespace App\Repository;

use App\Entity\TypeStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeStage>
 *
 * @method TypeStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeStage[]    findAll()
 * @method TypeStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeStage::class);
    }

//    /**
//     * @return TypeStage[] Returns an array of TypeStage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeStage
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
