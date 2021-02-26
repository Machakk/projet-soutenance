<?php

namespace App\Repository;

use App\Entity\Skills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Skills|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skills|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skills[]    findAll()
 * @method Skills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skills::class);
    }

    // /**
    //  * @return Skills[] Returns an array of Skills objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Skills
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // /**
    //  *  @return Skills[]
    //  */
    // public function findByUser($user){
    //     return $query = $this->createQueryBuilder('n')
    //     ->join('n.id', 's', 'WITH', 's := id')
    //     ->setParameter('user',$user)
    //     ->getQuery()
    //     ->getResult();
    // }

    /*
    SELECT skills.id, skills.imageskill, skills.title 
    FROM skills, users, skills_users
    WHERE skills.id = skills_users.skills_id 
    AND users.id = skills_users.users_id 
     */

    public function findskills(){
        $em = $this->getContainer()->get('doctrine')->getManager();
        $repository = $em->getRepository('Users::class');
        $query = $repository->createQueryBuilder('u')
                ->innerJoin('u.skills', 's')
                ->where('s.id = :skills_id')
                ->setParameter('skills_id',5)
                ->getQuery()->getResult();
    }
}
