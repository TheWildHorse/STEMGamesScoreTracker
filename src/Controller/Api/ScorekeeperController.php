<?php


namespace App\Controller\Api;

use App\Entity\Group;
use App\Entity\Score;
use App\Enum\EventTypeEnum;
use App\Enum\RankingTypeEnum;
use App\Services\EventNotificationService;
use Doctrine\Common\Collections\ArrayCollection;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScorekeeperController extends BaseAPIController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Saves the scores for a certain event via the scorekeeper code."
     * )
     * @SWG\Tag(name="scorekeeper")
     * @Route(path="/scorekeeper/{code}/{eventId}", methods={"POST"},  name="scorekeeper.editor.save")
     */
    public function saveScores(Request $request, EventNotificationService $ens, $code, $eventId) {
        $keeper = $this->getDoctrine()
            ->getRepository('App:ScorekeeperAuthentication')
            ->findOneBy(['code' => $code]);
        if($keeper === null) {
            return $this->redirect('/');
        }

        $event = $this->getDoctrine()
            ->getRepository('App:Event')
            ->findOneBy([
                'group' => $keeper->getGroup(),
                'id' => $eventId
            ]);
        if($event === null) {
            return $this->redirect('/');
        }

        $data = json_decode($request->getContent());
        $scores = [];
        foreach ($data as $entry) {
            $this->getDoctrine()->getRepository('App:Score')->clearScores($event);
            $college = $this->getDoctrine()->getRepository('App:College')
                ->find($entry->collegeId);

            $score = new Score();
            $score->setScore($entry->score);
            $score->setCollege($college);
            $score->setTeamName($entry->teamName);
            $scores[] = $score;
        }
        $event->setScores($scores);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($event);
        $em->flush();

        if($event->getGroup()->getSport()->getEventType() === EventTypeEnum::TYPE_1V1) {
            $ens->notifyScoreChange($event);
        }

        return $this->jsonResponse(['success' => true]);
    }

    /**
     * @SWG\Response(
     *     response=200,
     *     description="Saves the scores for a certain event via the scorekeeper code."
     * )
     * @SWG\Tag(name="scorekeeper")
     * @Route(path="/scorekeeper/{code}/{eventId}/state", methods={"POST"},  name="scorekeeper.editor.state.save")
     * @param Request $request
     * @param $code
     * @param $eventId
     * @return mixed|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveState(Request $request, EventNotificationService $ens, $code, $eventId) {
        $keeper = $this->getDoctrine()
            ->getRepository('App:ScorekeeperAuthentication')
            ->findOneBy(['code' => $code]);
        if($keeper === null) {
            return $this->redirect('/');
        }

        $event = $this->getDoctrine()
            ->getRepository('App:Event')
            ->findOneBy([
                'group' => $keeper->getGroup(),
                'id' => $eventId
            ]);
        if($event === null) {
            return $this->redirect('/');
        }

        $event->setState($request->get('id'));
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($event);
        $em->flush();

        if($event->getGroup()->getSport()->getEventType() === EventTypeEnum::TYPE_1V1) {
            $ens->notifyStateChange($event);
        }

        return $this->jsonResponse(['success' => true]);
    }

}