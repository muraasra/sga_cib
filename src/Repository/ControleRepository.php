<?php

namespace App\Repository;

use App\Entity\Controle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Controle>
 *
 * @method Controle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Controle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Controle[]    findAll()
 * @method Controle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Controle::class);
    }
    public function findByCourrierDemandeId($value): array
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.courrier_demande = :val')
               ->setParameter('val', $value)
               ->orderBy('c.id', 'ASC')
               
               ->getQuery()
               ->getResult()
               
           ;
       }
//    /**
//     * @return Controle[] Returns an array of Controle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Controle
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
