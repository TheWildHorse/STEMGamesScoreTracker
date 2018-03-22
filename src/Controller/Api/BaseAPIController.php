<?php


namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class APIController
 * @package ApiBundle\Controller
 */
class BaseAPIController extends Controller
{

    /**
     * Serializes provided object to JSON
     * @param $object
     * @param int $statusCode
     * @param null $error
     * @return mixed
     */
    protected function jsonResponse($object, $statusCode = 200, $error = null)
    {
        $serializer = $this->container->get('jms_serializer');
        $contentArray = [
            'success' => $statusCode === 200,
            'data' => $object,
            'error' => $error,
        ];
        $content =  $serializer->serialize($contentArray, 'json');
        $response = new Response($content, $statusCode);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}