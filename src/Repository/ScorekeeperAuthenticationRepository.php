<?php

namespace App\Repository;

use App\Entity\ScorekeeperAuthentication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScorekeeperAuthentication|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScorekeeperAuthentication|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScorekeeperAuthentication[]    findAll()
 * @method ScorekeeperAuthentication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScorekeeperAuthenticationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScorekeeperAuthentication::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
