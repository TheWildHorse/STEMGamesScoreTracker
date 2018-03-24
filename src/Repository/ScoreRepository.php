<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Score::class);
    }


    public function clearScores(Event $event)
    {
        return $this->createQueryBuilder('s')
            ->where('s.event = :event')->setParameter('event', $event)
            ->delete()
            ->getQuery()
            ->getResult()
        ;
    }

}
