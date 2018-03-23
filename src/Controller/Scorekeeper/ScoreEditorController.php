<?php


namespace App\Controller\Scorekeeper;


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
        return 'test';
    }

}