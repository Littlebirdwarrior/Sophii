<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

    //Personnel

    /**
     * Afficher les parents
     */

    public function findParents()
    {
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

        $qb->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.roles LIKE :role')
            ->orderBy('u.nom', 'ASC')
            ->setParameter('role', '%ROLE_PARENT%');

        return $qb->getQuery()->getResult();
    }

    /**
     * Afficher les parents
     */

    public function findEnseignants()
    {
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQueryBuilder();

        $qb->select('u')
            ->from('App\Entity\User', 'u')
            ->where('u.roles LIKE :role')
            ->orderBy('u.nom', 'ASC')
            ->setParameter('role', '%ROLE_ENS%');

        return $qb->getQuery()->getResult();
    }


    /**
     * Afficher les élèves sans parents (afin de pouvoir en ajouter).
     */
    public function getNonEnfant($user_id)
    {
        //j'appelle la classe EntityManager qui contiens la fonction createQueryBuilder
        $entityManager = $this->getEntityManager();

        $subQuery = $entityManager->createQueryBuilder();

        // Sélectionner tous les enfants attribués à un parent dont l'id est passé en paramètre (sous requête)
        $subQuery->select('e.id')
            ->from('App\Entity\Eleve', 'e')
            ->join('e.parents', 'p')
            ->where('p.id = :id')//ou le pares
            ->setParameter('id', $user_id);

        $qb = $entityManager->createQueryBuilder();

        // requête principale (query builder)  : Sélectionner tous les enfants qui ne sont pas dans le résultat précédent (les non-enfant, donc) en utilisant le resultat de la sous requete (le where exclut les enfants qui ont un ID qui est dans la sous-requête.)
        $qb->select('ne')
            ->from('App\Entity\Eleve', 'ne')
            ->where($qb->expr()->notIn('ne.id', $subQuery->getDQL()))
            ->orderBy('ne.nom', 'ASC')
            ->setParameter('id', $user_id);

        //fonction exécute la requête et renvoie le résultat sous forme d'un tableau d'objets Intern
        return $qb->getQuery()->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
//    public function findParents(): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('JSON_EXTRACT(u.roles)')
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
