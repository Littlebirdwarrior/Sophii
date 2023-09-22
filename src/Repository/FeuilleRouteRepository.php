<?php

namespace App\Repository;

use App\Entity\FeuilleRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeuilleRoute>
 *
 * @method FeuilleRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeuilleRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeuilleRoute[]    findAll()
 * @method FeuilleRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeuilleRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeuilleRoute::class);
    }

    public function save(FeuilleRoute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FeuilleRoute $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Ajouter les activités.
     */
    public function getNonActivite($feuille_route_id)
    {
        //j'appelle la classe EntityManager qui contiens la fonction createQueryBuilder
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        // Sélectionner toutes les activites attribués à une feuille de route dont l'id est passé en paramètre (sous requête)
        $subQuery->select('a.id')
            ->from('App\Entity\Activite', 'a')
            ->join('a.feuillesroute', 'fr')
            ->where('fr.id = :id')//ou le pares
            ->setParameter('id', $feuille_route_id);

        $qb = $entityManager->createQueryBuilder();

        // requête principale (query builder)  : Sélectionner toutes les activités qui ne sont pas dans le résultat précédent (les non-enfant, donc) en utilisant le resultat de la sous requete (le where exclut les activites qui ont un ID qui est dans la sous-requête.)
        $qb->select('na')
            ->from('App\Entity\Activite', 'na')
            ->where($qb->expr()->notIn('na.id', $subQuery->getDQL()))
            ->orderBy('na.titre', 'ASC')
            ->setParameter('id', $feuille_route_id);

        //fonction exécute la requête et renvoie le résultat sous forme d'un tableau d'objets Intern
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return FeuilleRoute[] Returns an array of FeuilleRoute objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FeuilleRoute
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
