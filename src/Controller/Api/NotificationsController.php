<?php


namespace App\Controller\Api;

use App\Entity\EventNotificationSubscriber;
use App\Entity\Group;
use App\Entity\Score;
use App\Enum\RankingTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationsController extends BaseAPIController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Subscribes the user to notifications for a list of events."
     * )
     * @SWG\Tag(name="notification-subscribe")
     * @Route(path="/notifications/subscribe", methods={"POST"},  name="notifications.subscribe")
     */
    public function saveScores(Request $request, EntityManagerInterface $em) {
        $eventSubscriptionsRepo = $this->getDoctrine()->getRepository('App:EventNotificationSubscriber');
        $eventSubscriptionsRepo->unsubscribeAllForPlayerId($request->get('playerId'));

        $eventRepo = $this->getDoctrine()->getRepository('App:Event');

        $eventsToSubscribe = $request->get('events');
        if(empty($eventsToSubscribe)) {
            return $this->jsonResponse(['success' => true]);
        }
        foreach($eventsToSubscribe as $e) {
            $eventSubscription = new EventNotificationSubscriber();
            $eventSubscription->setPlayerId($request->get('playerId'));
            $eventSubscription->setEvent($eventRepo->find($e));
            $em->persist($eventSubscription);
        }
        $em->flush();

        return $this->jsonResponse(['success' => true]);
    }

}