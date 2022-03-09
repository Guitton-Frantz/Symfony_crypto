<?php

namespace App\Repository;

use App\Entity\Cryptomonnaie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cryptomonnaie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cryptomonnaie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cryptomonnaie[]    findAll()
 * @method Cryptomonnaie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptomonnaieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cryptomonnaie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Cryptomonnaie $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Cryptomonnaie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * @return Cryptomonnaie[]
     */
    public function getCryptomonnaies(): array
    {
        $qb = $this->createQueryBuilder('c');
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Cryptomonnaie[] Returns an array of Cryptomonnaie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cryptomonnaie
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
