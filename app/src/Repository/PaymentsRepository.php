<?php

namespace App\Repository;

use App\Entity\Payments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payments>
 *
 * @method Payments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payments[]    findAll()
 * @method Payments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payments::class);
    }

    public function save(Payments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Payments $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByIdUser($id_user): array
    {
        $query = $this->getEntityManager()->createQuery("
            Select p.id, p.name, p.price, p.id_user, p.status,
                concat(u.name, ' ', u.surname) friend
            From App\Entity\Payments p
            Left join App\Entity\User u
            With u.id = p.id_friend
            Where p.id_user = :id_user
        ")->setParameter('id_user', $id_user);
        
        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

//    /**
//     * @return Payments[] Returns an array of Payments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Payments
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
