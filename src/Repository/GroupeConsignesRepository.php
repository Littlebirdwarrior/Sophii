<?php

namespace App\Repository;

use App\Entity\GroupeConsignes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupeConsignes>
 *
 * @method GroupeConsignes|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeConsignes|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeConsignes[]    findAll()
 * @method GroupeConsignes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeConsignesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeConsignes::class);
    }

    public function save(GroupeConsignes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GroupeConsignes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getNonConsigne($groupe_consignes_id)
    {
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        $subQuery->select('c.id')
            ->from('App\Entity\Consigne', 'c')
            ->join('c.groupesconsignes', 'gc')
            ->where('gc.id = :id')//ou le pares
            ->setParameter('id', $groupe_consignes_id);

        $qb = $entityManager->createQueryBuilder();

        $qb->select('nc')
            ->from('App\Entity\Consigne', 'nc')
            ->where($qb->expr()->notIn('nc.id', $subQuery->getDQL()))
            ->orderBy('nc.libelle', 'ASC')
            ->setParameter('id', $groupe_consignes_id);

        return $qb->getQuery()->getResult();

    }

//    /**
//     * @return GroupeConsignes[] Returns an array of GroupeConsignes objects
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

//    public function findOneBySomeField($value): ?GroupeConsignes
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
