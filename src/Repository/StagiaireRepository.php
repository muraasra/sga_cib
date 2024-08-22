<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stagiaire>
 *
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

//    /**
//     * @return Stagiaire[] Returns an array of Stagiaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Stagiaire
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByData($data): array
{
    $qb = $this->createQueryBuilder('s')
    ->leftJoin('s.stages','st')
    ->addSelect('st')
    ->leftJoin('s.user','en')
    ->addSelect('en');
    if (!empty($data['nom'])){
      $qb->andWhere('s.nom LIKE :nom')
            ->setParameter('nom', '%'.$data['nom'].'%');
    }

    if (!empty($data['expediteur'])){
      $qb->andWhere('s.expediteur LIKE :expediteur')
            ->setParameter('expediteur', '%'.$data['expediteur'].'%');
    }
    
    if (!empty($data['filiere'])){
      $qb->andWhere('s.filiere LIKE :filiere')
            ->setParameter('filiere', '%'.$data['filiere'].'%');
    }
    if (!empty($data['niveau'])){
        $qb->andWhere('s.niveau LIKE :niveau')
              ->setParameter('niveau', '%'.$data['niveau'].'%');
      }
    if (!empty($data['theme'])){
        $qb->andWhere('st.theme LIKE :theme')
              ->setParameter('theme', '%'.$data['theme'].'%');
      }
    if (!empty($data['encadreur'])){
        $qb->andWhere('en.nom LIKE :encadreur')
        ->andWhere('en.prenom LIKE :encadreur')
              ->setParameter('encadreur', '%'.$data['encadreur'].'%');
      }
    if(!empty($data['dateDebut'])){
      $qb->andWhere('s.date_debut >= :dateDebut')
            ->setParameter('dateDebut', $data['dateDebut']);
    }
    if(!empty($data['dateFin'])){
      $qb->andWhere('s.date_fin <= :dateFin')
            ->setParameter('dateFin', $data['dateFin']);
    }

        
    return   $qb->getQuery()
        ->getResult()
    ;
 
}
}
