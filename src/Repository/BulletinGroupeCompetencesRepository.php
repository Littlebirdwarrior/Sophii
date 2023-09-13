<?php

namespace App\Repository;

use App\Entity\BulletinGroupeCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BulletinGroupeCompetences>
 *
 * @method BulletinGroupeCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method BulletinGroupeCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method BulletinGroupeCompetences[]    findAll()
 * @method BulletinGroupeCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BulletinGroupeCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BulletinGroupeCompetences::class);
    }

    public function save(BulletinGroupeCompetences $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BulletinGroupeCompetences $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BulletinGroupeCompetences[] Returns an array of BulletinGroupeCompetences objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BulletinGroupeCompetences
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
