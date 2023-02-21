<?php

namespace App\Repository;

use App\Entity\Don;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Don>
 *
 * @method Don|null find($id, $lockMode = null, $lockVersion = null)
 * @method Don|null findOneBy(array $criteria, array $orderBy = null)
 * @method Don[]    findAll()
 * @method Don[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Don::class);
    }

    public function save(Don $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Don $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByUser($user)
    {
        return $this->createQueryBuilder('d')
            ->where('d.iduserdon = :user')
            ->setParameter('user', $user)
            ->orderBy('d.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findValidDon()
    {
        return $this->createQueryBuilder('d')
            ->where('d.etat = :valide')
            ->setParameter('valide', 1)
            ->orderBy('d.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findLastDon()
    {
        return $this->createQueryBuilder('d')
            ->where('d.etat = :valide')
            ->setParameter('valide', 1)
            ->orderBy('d.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
