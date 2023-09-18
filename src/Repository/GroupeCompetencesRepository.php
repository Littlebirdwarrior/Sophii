<?php

namespace App\Repository;

use App\Entity\GroupeCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupeCompetences>
 *
 * @method GroupeCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeCompetences[]    findAll()
 * @method GroupeCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeCompetences::class);
    }

    public function save(GroupeCompetences $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GroupeCompetences $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getNonComp($groupe_competences_id)
    {
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        $subQuery->select('c.id')
            ->from('App\Entity\Competence', 'c')
            ->join('c.groupecompetences', 'gc')
            ->where('gc.id = :id')//ou le pares
            ->setParameter('id', $groupe_competences_id);

        $qb = $entityManager->createQueryBuilder();

        $qb->select('nc')
            ->from('App\Entity\Competence', 'nc')
            ->where($qb->expr()->notIn('nc.id', $subQuery->getDQL()))
            ->orderBy('nc.libelle', 'ASC')
            ->setParameter('id', $groupe_competences_id);

        return $qb->getQuery()->getResult();

    }

//    /**
//     * @return GroupeCompetences[] Returns an array of GroupeCompetences objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GroupeCompetences
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
