<?php


namespace App\Controller\PublicFacing;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends Controller
{
    /**
     * @Route(path="/", name="public_facing.homepage")
     * @return string
     */
    public function getHomepage()
    {
        $sports = $this->getDoctrine()
            ->getRepository('App:Sport')
            ->findAll();

        return $this->render('PublicFacing/homepage.html.twig', [
            'sports' => $sports,
        ]);
    }
}