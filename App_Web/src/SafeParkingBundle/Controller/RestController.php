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
        if ($emailResult != null) {
            if ($emailResult->getPassword() == $password) {
                $response = new Response('{"message":"ok", "garage":"' . $emailResult->getParking()->getNom() . '", 
                "id":' . $emailResult->getParking()->getId() . '}');
                $response->headers->set('Content-Type', 'application/json');
            } else {
                $response = new Response('{"message":"ko"}');
                $response->headers->set('Content-Type', 'application/json');
            }
        } else {
            $response = new Response('{"message":"ko"}');
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }

    public function infoAction($id)
    {
        $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');
        $garage = $garageRepository->find($id);
        $response = new Response('{"occupe":'.$garage->getNbPlacePrise().', "libre":'.$garage->getNbPlaceLibre()
            .', "reserve":'.$garage->getNbPlaceReserve().'}');
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }

    public function addAction($id){
        $em = $this->getDoctrine()->getManager();


        $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');
        $garage = $garageRepository->find($id);

        $place = $garage->getNbPlaceTotal();

        $occupe = $garage->getNbPlacePrise();

        $libre = $garage->getNbPlaceLibre();

        if($occupe == $place){

        }else{
            $occupe = $occupe +1;
            $libre = $libre -1;
            $garage->setNbPlacePrise($occupe);
            $garage->setNbPlaceLibre($libre);
            $em->persist($garage);
            $em->flush();
        }

        $garage = $garageRepository->find($id);
        $response = new Response('{"occupe":'.$garage->getNbPlacePrise().', "libre":'.$garage->getNbPlaceLibre()
            .', "reserve":'.$garage->getNbPlaceReserve().'}');
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }

    public function subAction($id){
        $em = $this->getDoctrine()->getManager();


        $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');
        $garage = $garageRepository->find($id);

        $occupe = $garage->getNbPlacePrise();

        $libre = $garage->getNbPlaceLibre();

        if($libre == 0){

        }else{
            $occupe = $occupe -1;
            $libre = $libre +1;
            $garage->setNbPlacePrise($occupe);
            $garage->setNbPlaceLibre($libre);
            $em->persist($garage);
            $em->flush();
        }

        $garage = $garageRepository->find($id);
        $response = new Response('{"occupe":'.$garage->getNbPlacePrise().', "libre":'.$garage->getNbPlaceLibre()
            .', "reserve":'.$garage->getNbPlaceReserve().'}');
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }

    public function addresAction($id){
        $em = $this->getDoctrine()->getManager();


        $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');
        $garage = $garageRepository->find($id);

        $place = $garage->getNbPlaceTotal();

        $reserve = $garage->getNbPlaceReserve();

        $occupe = $garage->getNbPlacePrise();

        $libre = $garage->getNbPlaceLibre();

        if($occupe == $place){

        }else{
            $occupe = $occupe +1;
            $reserve = $reserve +1;
            $libre = $libre -1;
            $garage->setNbPlacePrise($occupe);
            $garage->setNbPlaceLibre($libre);
            $garage->setNbPlaceReserve($reserve);
            $em->persist($garage);
            $em->flush();
        }

        $garage = $garageRepository->find($id);
        $response = new Response('{"occupe":'.$garage->getNbPlacePrise().', "libre":'.$garage->getNbPlaceLibre()
            .', "reserve":'.$garage->getNbPlaceReserve().'}');
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }

    public function subresAction($id){
        $em = $this->getDoctrine()->getManager();


        $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');
        $garage = $garageRepository->find($id);

        $occupe = $garage->getNbPlacePrise();

        $libre = $garage->getNbPlaceLibre();

        $reserve = $garage->getNbPlaceReserve();

        if($libre == 0){

        }else{
            $occupe = $occupe -1;
            $reserve = $reserve -1;
            $libre = $libre +1;
            $garage->setNbPlacePrise($occupe);
            $garage->setNbPlaceLibre($libre);
            $garage->setNbPlaceReserve($reserve);
            $em->persist($garage);
            $em->flush();
        }

        $garage = $garageRepository->find($id);
        $response = new Response('{"occupe":'.$garage->getNbPlacePrise().', "libre":'.$garage->getNbPlaceLibre()
            .', "reserve":'.$garage->getNbPlaceReserve().'}');
        $response->headers->set('Content-type', 'application/json');
        return $response;
    }
}
