<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function findProgramsBySession($session) {

        // Initialisation du QueryBuilder avec l'alias 's' pour l'entité Session
        return $this->createQueryBuilder('s')
            // Jointure interne avec l'entité 'Programmes' (alias 'sp') associée à 'Session'
            ->innerJoin('s.programmes', 'sp')
            // Jointure interne avec l'entité 'Unit' (alias 'su') associée à 'Programmes'
            ->innerJoin('sp.unit', 'su')
            // Sélection des entités 'Session', 'Programmes' et 'Unit' pour les inclure dans la requête
            ->addSelect('s', 'sp', 'su')
            // Ajout d'une condition pour filtrer par l'identifiant de la session
            ->where('s.id = :id')
            // Définition du paramètre ':id' avec la valeur de l'argument de l'entité $session
            ->setParameter('id', $session)
            // Construction et exécution de la requête
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function listTraineesNotInSession($id)    {

        $em = $this->getEntityManager();
        $sub  = $this->createQueryBuilder('a');

        $qb = $sub;

        $qb->select('t')
          ->from('App\Entity\Trainee', 't')
          ->leftJoin('t.sessions', 'ts')
          ->andWhere('ts.id = :id');

        $sub = $em->createQueryBuilder('b');

        $sub->select('st')
             ->from('App\Entity\Trainee', 'st')
             ->where($sub->expr()->notIn('st.id',  $qb->getDQL()))

             ->setParameter('id', $id);

        $query = $sub->getQuery();
        return $query->getResult();
       }

    //    /**
    //     * @return Session[] Returns an array of Session objects
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

    //    public function findOneBySomeField($value): ?Session
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
