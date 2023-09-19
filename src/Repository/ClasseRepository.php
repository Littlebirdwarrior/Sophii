<?php

namespace App\Repository;

use App\Entity\Classe;
use App\Entity\Eleve;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @extends ServiceEntityRepository<Classe>
 *
 * @method Classe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classe[]    findAll()
 * @method Classe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    public function save(Classe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Classe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getNonEleve($classe_id)
    {
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        $subQuery->select('e.id')
            ->from('App\Entity\Eleve', 'e')
            ->join('e.classe', 'c')
            ->where('c.id = :id')//ou le pares
            ->setParameter('id', $classe_id);

        $qb = $entityManager->createQueryBuilder();

        $qb->select('ne')
            ->from('App\Entity\Eleve', 'ne')
            ->where($qb->expr()->notIn('ne.id', $subQuery->getDQL()))
            ->orderBy('ne.nom', 'ASC')
            ->setParameter('id', $classe_id);

        return $qb->getQuery()->getResult();

    }

    public function getNonEns($classe_id)
    {
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        $subQuery->select('u.id')
            ->from('App\Entity\User', 'u')
            ->join('u.classe', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $classe_id);

        $qb = $entityManager->createQueryBuilder();

        $qb->select('nu')
            ->from('App\Entity\User', 'nu')
            ->where($qb->expr()->notIn('nu.id', $subQuery->getDQL()))
            ->andWhere("nu.roles LIKE '%ROLE_ENS%'")
            ->orderBy('nu.nom', 'ASC')
            ->setParameter('id', $classe_id);

        return $qb->getQuery()->getResult();

    }


//    /**
//     * @return Classe[] Returns an array of Classe objects
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

//    public function findOneBySomeField($value): ?Classe
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
