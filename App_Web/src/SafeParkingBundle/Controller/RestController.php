<?php

namespace SafeParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RestController extends Controller
{
    public function loginAction($email, $password)
    {
        $gardienRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Gardien');
        $emailResult = $gardienRepository->findOneByEmail($email);
        if($emailResult != null){
            if($emailResult->getPassword() == $password){
                $response = new Response('{"message":"ok"}');
                $response->headers->set('Content-Type', 'application/json');
            }else{
                $response = new Response('{"message":"ko"}');
                $response->headers->set('Content-Type', 'application/json');
            }
        }else{
            $response = new Response('{"message":"ko"}');
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}
