<?php

namespace App\Repository;

use App\Entity\Courrier;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Response;

/**
 * @extends ServiceEntityRepository<Courrier>
 *
 * @method Courrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Courrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Courrier[]    findAll()
 * @method Courrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Courrier::class);
    }


    public function findByData($data): array
       {
           $qb = $this->createQueryBuilder('c');
           if (!empty($data['numeroOrdre'])){
             $qb->andWhere('c.numero_odre LIKE :numeroOrdre')
                   ->setParameter('numeroOrdre', '%'.$data['numeroOrdre'].'%');
           }

           if (!empty($data['expediteur'])){
             $qb->andWhere('c.expediteur LIKE :expediteur')
                   ->setParameter('expediteur', '%'.$data['expediteur'].'%');
           }
           
           if (!empty($data['destinataire'])){
             $qb->andWhere('c.destinataire LIKE :destinataire')
                   ->setParameter('destinataire', '%'.$data['destinataire'].'%');
           }
           if(!empty($data['dateDebut'])){
             $qb->andWhere('c.date_debut >= :dateDebut')
                   ->setParameter('dateDebut', $data['dateDebut']);
           }
           if(!empty($data['dateFin'])){
             $qb->andWhere('c.date_fin <= :dateFin')
                   ->setParameter('dateFin', $data['dateFin']);
           }

               
           return   $qb->getQuery()
               ->getResult()
           ;
        
       }
    public function findByDate($dateReception)
       {
        
            return  $this->createQueryBuilder('c')
            
              ->andWhere('c.date_reception LIKE :date')
              ->setParameter('date', '%'.$dateReception.'%')
              ->getQuery()
              ->getResult();
       }

//    /**
//     * @return Courrier[] Returns an array of Courrier objects
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

//    public function findOneBySomeField($value): ?Courrier
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
