<?php

namespace App\Repository;

use App\Entity\EventNotificationSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventNotificationSubscriber|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventNotificationSubscriber|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventNotificationSubscriber[]    findAll()
 * @method EventNotificationSubscriber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventNotificationSubscriberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventNotificationSubscriber::class);
    }


    public function unsubscribeAllForPlayerId($playerId)
    {
        return $this->createQueryBuilder('e')
            ->where('e.playerId = :value')->setParameter('value', $playerId)
            ->delete()
            ->getQuery()
            ->execute()
        ;
    }

}
