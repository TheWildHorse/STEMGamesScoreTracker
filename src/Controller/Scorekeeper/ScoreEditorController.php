<?php


namespace App\Controller\Scorekeeper;


use App\Enum\EventStateEnum;
use App\Enum\EventTypeEnum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ScoreEditorController extends Controller
{

    /**
     * @Route(path="/scorekeeper/{code}", methods={"GET"},  name="scorekeeper.editor")
     * @param Request $request
     * @return string
     */
    public function getScoreEditor(Request $request, $code) {
        $keeper = $this->getDoctrine()
            ->getRepository('App:ScorekeeperAuthentication')
            ->findOneBy(['code' => $code]);

        if($keeper === null) {
            return $this->redirect('/');
        }

        return $this->render('Scorekeeper/event_picker.html.twig', [
            'events' => $keeper->getGroup()->getEvents(),
            'code' => $code,
        ]);
    }

    /**
     * @Route(path="/scorekeeper/{code}/{eventId}", methods={"GET"},  name="scorekeeper.editor.event")
     * @param Request $request
     * @return string
     */
    public function getScoreEditorForEvent(Request $request, $code, $eventId) {
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

        if($event->getGroup()->getSport()->getEventType() === EventTypeEnum::TYPE_1V1) {
            $competitor1Score = 0;
            $competitor2Score = 0;

            foreach ($event->getScores() as $score) {
                if($score->getCollege() === $event->getCompetitor1()) {
                    $competitor1Score = $score->getScore();
                }
                else if($score->getCollege() === $event->getCompetitor2()) {
                    $competitor2Score = $score->getScore();
                }
            }

            return $this->render('Scorekeeper/editor_1v1.html.twig', [
                'event' => $event,
                'competitor1Score' => $competitor1Score,
                'competitor2Score' => $competitor2Score,
                'code' => $code,
            ]);
        }

        $colleges = $this->getDoctrine()
            ->getRepository('App:College')
            ->findAll();
        return $this->render('Scorekeeper/editor_placements.html.twig', [
            'event' => $event,
            'code' => $code,
            'colleges' => $colleges,
        ]);
    }

}