<?php


namespace App\Services;


use App\Entity\Event;
use App\Entity\EventNotificationSubscriber;
use App\Enum\EventStateEnum;
use Doctrine\ORM\EntityManagerInterface;

class EventNotificationService
{
    /**
     * @var OneSignalService
     */
    protected $oss;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * EventNotificationService constructor.
     * @param OneSignalService $oss
     */
    public function __construct(EntityManagerInterface $em, OneSignalService $oss)
    {
        $this->oss = $oss;
        $this->em = $em;
    }

    public function notifyScoreChange(Event $event) {
        $subscribers = $this->em->getRepository('App:EventNotificationSubscriber')
            ->findBy(['event' => $event]);

        $recipients = [];
        /** @var EventNotificationSubscriber $sub */
        foreach($subscribers as $sub) {
            $recipients[] = $sub->getPlayerId();
        }

        $scoreByName = [];
        $scores = $event->getScores();
        $scoreByName[$scores[0]->getCollege()->getName()] = $scores[0]->getScore();
        $scoreByName[$scores[1]->getCollege()->getName()] = $scores[1]->getScore();

        $this->oss->sendMessage(
            $event->getGroup()->getSport()->getName() . ': ' . $event->getCompetitor1()->getName() . ' ['.$scoreByName[$event->getCompetitor1()->getName()].']' . ' VS '. '['.$scoreByName[$event->getCompetitor2()->getName()].'] ' . $event->getCompetitor2()->getName(),
            $recipients
        );
    }

    public function notifyStateChange(Event $event) {
        $subscribers = $this->em->getRepository('App:EventNotificationSubscriber')
            ->findBy(['event' => $event]);

        $recipients = [];
        /** @var EventNotificationSubscriber $sub */
        foreach($subscribers as $sub) {
            $recipients[] = $sub->getPlayerId();
        }

        if($event->getState() == EventStateEnum::STATE_ENDED) {
            $this->oss->sendMessage($event->getGroup()->getSport()->getName() . ': ' . $event->getCompetitor1()->getName() . ' VS ' . $event->getCompetitor2()->getName() . ' just ended.',
                $recipients);
        }
        else if($event->getState() == EventStateEnum::STATE_PROGRESS) {
            $this->oss->sendMessage($event->getGroup()->getSport()->getName() . ': ' . $event->getCompetitor1()->getName() . ' VS ' . $event->getCompetitor2()->getName() . ' just started.',
                $recipients);
        }
    }
}