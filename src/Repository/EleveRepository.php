<?php

namespace App\Repository;

use App\Entity\Eleve;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Eleve>
 *
 * @method Eleve|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eleve|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eleve[]    findAll()
 * @method Eleve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EleveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleve::class);
    }

    public function save(Eleve $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Eleve $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    //methode perso

    public function findBySearch(SearchData $searchData)
    {
        // Créez un QueryBuilder à partir de la table des élèves (entité "Eleve" avec alias "e")
        $data = $this->createQueryBuilder('e')
            ->addOrderBy('e.nom', 'ASC'); // Triez les élèves par nom en ordre décroissant

        // Si un terme de recherche ("q") est spécifié dans l'objet SearchData
        if (!empty($searchData->q)) {
            // Ajoutez une clause WHERE pour rechercher le terme de recherche dans le nom de l'élève
            $data = $data
                ->where('e.nom LIKE :q')
                ->orWhere('e.prenom LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }

        // Exécutez la requête DQL et retournez les résultats
        return $data->getQuery()->getResult();
    }



//    /**
//     * @return Eleve[] Returns an array of Eleve objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Eleve
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
