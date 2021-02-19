<?php

namespace App\Repository;

use App\Entity\CommentaireForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentaireForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireForum[]    findAll()
 * @method CommentaireForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireForum::class);
    }

    // /**
    //  * @return CommentaireForum[] Returns an array of CommentaireForum objects
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
    public function findOneBySomeField($value): ?CommentaireForum
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
