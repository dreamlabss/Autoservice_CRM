<?php

namespace App\Repository;

use App\Entity\PartInstall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartInstall>
 *
 * @method PartInstall|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartInstall|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartInstall[]    findAll()
 * @method PartInstall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartInstallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartInstall::class);
    }

    public function save(PartInstall $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PartInstall $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PartInstall[] Returns an array of PartInstall objects
//     */
    public function findByIdBasket($id): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.basket = :id')
            ->setParameter('id', $id)
            ->leftJoin('p.detail','detail')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?PartInstall
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
