<?php

namespace App\Repository;

use App\Entity\Friends;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Friends>
 *
 * @method Friends|null find($id, $lockMode = null, $lockVersion = null)
 * @method Friends|null findOneBy(array $criteria, array $orderBy = null)
 * @method Friends[]    findAll()
 * @method Friends[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Friends::class);
    }

    public function save(Friends $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Friends $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUserId($id): array
    {
        $query = $this->getEntityManager()->createQuery("
            Select
                f.id,
                coalesce(u2.name, u.name) name,
                coalesce(u2.surname, u.surname) surname
            From App\Entity\Friends f
            Left join App\Entity\User u 
                With u.id = f.id_user
                And u.id != :id
            Left join App\Entity\User u2
                With u2.id = f.id_owner
                And u2.id != :id
            Where 
                f.id_owner = :id AND
                f.confirmed = :confirmed 
                OR
                f.id_user = :id AND
                f.confirmed = :confirmed
        ")
        ->setParameter('id', $id)
        ->setParameter('confirmed', 1);

        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findFriendsByUserId($id): array
    {
        $query = $this->getEntityManager()->createQuery("
            Select
                coalesce(u2.id, u.id) id,
                coalesce(u2.name, u.name) name,
                coalesce(u2.surname, u.surname) surname
            From App\Entity\Friends f
            Left join App\Entity\User u 
                With u.id = f.id_user
                And u.id != :id
            Left join App\Entity\User u2
                With u2.id = f.id_owner
                And u2.id != :id
            Where 
                f.id_owner = :id AND
                f.confirmed = :confirmed 
                OR
                f.id_user = :id AND
                f.confirmed = :confirmed
        ")
        ->setParameter('id', $id)
        ->setParameter('confirmed', 1);

        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    public function findFriendById($id, $id_user): Friends
    {
        $query = $this->getEntityManager()->createQuery('
            Select f
            From App\Entity\Friends f
            Where f.id_owner = :id
            And f.id_user = :id_user
        ')
        ->setParameter('id', $id)
        ->setParameter('id_user', $id_user);

        return $query->getSingleResult();
    }
//    /**
//     * @return Friends[] Returns an array of Friends objects
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

//    public function findOneBySomeField($value): ?Friends
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
