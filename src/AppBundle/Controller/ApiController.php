<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    /**
     * @Route("/api/subentzioak")
     */
    public function subentzioakAction()
    {
        $serializer = $this->container->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $subentzioak = $em->getRepository( 'AppBundle:Subentzioa' )->findAll();

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');

        $response->setContent( $serializer->serialize( $subentzioak, 'json' ) );
        $response->setStatusCode( 200 );


        return $response;

    }

    /**
     * @Route("/api/konzesioak")
     */
    public function konzesioakAction()
    {
        $serializer = $this->container->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $konzesioak = $em->getRepository( 'AppBundle:Konzesioa' )->findAll();


        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');

        $response->setContent( $serializer->serialize( $konzesioak, 'json' ) );
        $response->setStatusCode( 200 );


        return $response;
    }

}
