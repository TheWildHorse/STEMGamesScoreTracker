<?php


namespace App\Controller\Api;

use App\Entity\Group;
use App\Enum\RankingTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends BaseAPIController
{

    /**
     * @Route(path="/api/results", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns all results categorized by sport, group, event sorted in the correct order."
     * )
     * @SWG\Tag(name="results")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getResults() {
        $fsCache = new FilesystemCache();
        if(!$fsCache->has('result.full')) {

            $sports = $this->getDoctrine()->getRepository('App:Sport')->findAll();

            foreach ($sports as $sport) {
                /** @var Group $group */
                foreach ($sport->getGroups() as $group) {
                    $events = $group->getEvents()->getValues();
                    usort($events, function ($event1, $event2) {
                        return $event1->getStartTime() <=> $event2->getStartTime();
                    });
                    $group->setEvents(new ArrayCollection($events));
                    foreach ($group->getEvents() as $event) {
                        $scores = $event->getScores()->getValues();
                        usort($scores, function ($score1, $score2) use ($sport) {
                            if ($sport->getRankingType() === RankingTypeEnum::TYPE_HIGHER_BETTER) {
                                return $score2->getScore() <=> $score1->getScore();
                            }
                            return $score1->getScore() <=> $score2->getScore();
                        });
                        $event->setScores(new ArrayCollection($scores));
                    }
                }
            }

            $fsCache->set('result.full', $sports, 30);
        }

        return $this->jsonResponse($fsCache->get('result.full'));
    }

}