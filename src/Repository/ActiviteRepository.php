<?php

namespace App\Repository;

use App\Entity\Activite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activite>
 *
 * @method Activite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activite[]    findAll()
 * @method Activite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activite::class);
    }

    public function save(Activite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Activite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//Personnel

    /**
     * Afficher les groupe de compétences non-inclus dans l'activité
     */
    public function getListGroupComp($activite_id)
    {
        //j'appelle la classe EntityManager qui contiens la fonction createQueryBuilder
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        // Sélectionner tous les groupes de competences attribués à une activite dont l'id est passé en paramètre (sous requête)
        $subQuery->select('g.id')
            ->from('App\Entity\GroupeCompetences', 'g')
            ->join('g.activites', 'a')
            ->where('a.id = :id')//ou le pares
            ->setParameter('id', $activite_id);

        $qb = $entityManager->createQueryBuilder();

        // requête principale (query builder)  : Sélectionner tous les groupe de compétences qui ne sont pas dans le résultat précédent (les non-inclus dans l'activité, donc) en utilisant le resultat de la sous requete (le where exclut les enfants qui ont un ID qui est dans la sous-requête.)
        $qb->select('ngc')
            ->from('App\Entity\GroupeCompetences', 'ngc')
            ->where($qb->expr()->notIn('ngc.id', $subQuery->getDQL()))
            ->orderBy('ngc.titre', 'ASC')
            ->setParameter('id', $activite_id);

        //fonction exécute la requête et renvoie le résultat sous forme d'un tableau d'objets Activite
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Activite[] Returns an array of Activite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Activite
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
