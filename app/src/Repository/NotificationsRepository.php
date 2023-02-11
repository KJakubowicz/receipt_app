<?php

namespace App\Repository;

use App\Entity\Notifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notifications>
 *
 * @method Notifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notifications[]    findAll()
 * @method Notifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notifications::class);
    }

    public function save(Notifications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Notifications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * findByUserId
     *
     * @param  mixed $id
     * @return array
     */
    public function findByUserId($id): array
    {
        $query = $this->getEntityManager()->createQuery('
            Select n.id, n.type, n.content, n.readed, n.id_user, u.name, u.surname
            From App\Entity\Notifications n
            Left join App\Entity\User u 
            With u.id = n.id_user
            Where n.id_owner = :id
        ')
        ->setParameter('id', $id);

        return $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
