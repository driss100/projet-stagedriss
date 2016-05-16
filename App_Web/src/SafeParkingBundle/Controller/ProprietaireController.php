<?php

namespace SafeParkingBundle\Controller;

use SafeParkingBundle\Entity\Garage;
use SafeParkingBundle\Entity\Gardien;
use SafeParkingBundle\Form\GarageType;
use SafeParkingBundle\Form\GardienType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProprietaireController extends Controller
{
    public function indexAction()
    {
        /*
         * Gestion d'accès à la page avec le rôle propriétaire
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant que proprietaire');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');
        $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');
        $gardienRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Gardien');

        $email = $session->get('email');

        $proprietaire = $proprietaireRepository->findOneByEmail($email);

        $garages = $garageRepository
            ->findBy(array('proprietaire' => $proprietaire))
        ;

        $gardiens = $gardienRepository
            ->findBy(array('proprietaire' => $proprietaire));

        //var_dump($garages[0]->getGardiens());die;

        //var_dump($garages);die;

        return $this->render('SafeParkingBundle:Proprietaire:index.html.twig', array(
            'proprietaire' => $proprietaire,
            'garages'      => $garages,
            'gardiens'     => $gardiens,
        ));

    }

    public function addGarageAction(Request $request){
        /**
         * Gestion de contrôle d'accès via les rôles
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        $garage = new Garage();

        $form = $this->get('form.factory')->create(GarageType::class, $garage);
        $form->handleRequest($request);

        if($form->get('cancel')->isClicked()){
            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $proprietaire = $this->getDoctrine()->getManager()->getRepository
            ('SafeParkingBundle:Proprietaire')->findOneByEmail($this->get('session')->get('email'));
            $garage->setNbPlaceLibre($garage->getNbPlaceTotal());
            $garage->setNbPlacePrise(0);
            $garage->setNbPlaceReserve(0);
            $garage->setProprietaire($proprietaire);
            $em->persist($garage);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Le garage a bien été enregistré.');

            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }


        return $this->render('SafeParkingBundle:Proprietaire:addGarage.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function addGardienAction(Request $request){
        /**
         * Gestion de contrôle d'accès via les rôles
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        $gardien = new Gardien();

        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');
        $proprietaire = $proprietaireRepository->findOneByEmail($this->get('session')->get('email'));

        $form = $this->createForm(new GardienType($proprietaire), $gardien);
        $form->handleRequest($request);

        if($form->get('cancel')->isClicked()){
            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');
            $proprietaire = $proprietaireRepository->findOneByEmail($this->get('session')->get('email'));
            $gardien->setProprietaire($proprietaire);
            $em->persist($gardien);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Le gardien a bien été enregistré.');

            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }


        return $this->render('SafeParkingBundle:Proprietaire:addGardien.html.twig', array(
            'form' => $form->createView(),
        ));


    }

    public function editGarageAction(Request $request, $id){

        /**
         * Gestion de contrôle d'accès via les rôles
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        /**
         * Gestion de contrôle d'autorisation
         */
        $flag =false;
        $email = $session->get('email');
        $proprietaire = $this->getDoctrine()->getRepository('SafeParkingBundle:Proprietaire')->findOneByEmail($email);
        $garages = $this->getDoctrine()->getRepository('SafeParkingBundle:Garage')->findBy((array('proprietaire' =>
            $proprietaire)));
        foreach ($garages as $garage){
            if($garage->getId() == $id){
                //var_dump("test");die;
                $flag = true;
                break;
            }
        }

        if($flag){
            //var_dump("test");die;
            $garage = $this->getDoctrine()->getRepository('SafeParkingBundle:Garage')->find($id);

            $form = $this->get('form.factory')->create(GarageType::class, $garage);
            $form->handleRequest($request);

            if($form->get('cancel')->isClicked()){
                return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
            }

            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $proprietaire = $this->getDoctrine()->getManager()->getRepository
                ('SafeParkingBundle:Proprietaire')->findOneByEmail($this->get('session')->get('email'));
                $garage->setNbPlaceLibre($garage->getNbPlaceTotal());
                $garage->setNbPlacePrise(0);
                $garage->setNbPlaceReserve(0);
                $garage->setProprietaire($proprietaire);
                $em->persist($garage);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Le garage a bien été enregistré.');

                return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
            }


            return $this->render('SafeParkingBundle:Proprietaire:editGarage.html.twig', array(
                'form' => $form->createView(),
            ));
        }else{
            //var_dump("test");die;
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit de modifier ce garage');
            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }

    
    }

    public function editGardienAction(Request $request, $id){
        /**
         * Gérer les droits d'accès
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        /**
         * Gestion de contrôle d'autorisation
         */
        $flag =false;
        $email = $session->get('email');
        $proprietaire = $this->getDoctrine()->getRepository('SafeParkingBundle:Proprietaire')->findOneByEmail($email);
        $gardiens = $this->getDoctrine()->getRepository('SafeParkingBundle:Gardien')->findBy((array('proprietaire' =>
            $proprietaire)));
        foreach ($gardiens as $gardien){
            if($gardien->getId() == $id){
                //var_dump("test");die;
                $flag = true;
                break;
            }
        }

        if($flag){
            $gardien = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Gardien')->find($id);

            $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');
            $proprietaire = $proprietaireRepository->findOneByEmail($this->get('session')->get('email'));

            $form = $this->createForm(new GardienType($proprietaire), $gardien);
            $form->remove('password');

            $form->handleRequest($request);

            if($form->get('cancel')->isClicked()){
                return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
            }

            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($gardien);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Le propriétaire a bien été modifié.');

                return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
            }


            return $this->render('SafeParkingBundle:Proprietaire:editGardien.html.twig', array(
                'form' => $form->createView(),
            ));

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit de modifier ce gardien');
            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }

    }

    public function deleteGarageAction($id){
        /**
         * Gérer les droits d'accès
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        /**
         * Gestion de contrôle d'autorisation
         */
        $flag =false;
        $email = $session->get('email');
        $proprietaire = $this->getDoctrine()->getRepository('SafeParkingBundle:Proprietaire')->findOneByEmail($email);
        $garages = $this->getDoctrine()->getRepository('SafeParkingBundle:Garage')->findBy((array('proprietaire' =>
            $proprietaire)));
        foreach ($garages as $garage){
            if($garage->getId() == $id){
                //var_dump("test");die;
                $flag = true;
                break;
            }
        }

        if($flag){
            $garageRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Garage');

            $garage = $garageRepository->find($id);

            $this->getDoctrine()->getManager()->remove($garage);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit de supprimer ce garage');
            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }



    }

    public function deleteGardienAction($id){
        /**
         * Gérer les droits d'accès
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'proprietaire') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        /**
         * Gestion de contrôle d'autorisation
         */
        $flag =false;
        $email = $session->get('email');
        $proprietaire = $this->getDoctrine()->getRepository('SafeParkingBundle:Proprietaire')->findOneByEmail($email);
        $gardiens = $this->getDoctrine()->getRepository('SafeParkingBundle:Gardien')->findBy((array('proprietaire' =>
            $proprietaire)));
        foreach ($gardiens as $gardien){
            if($gardien->getId() == $id){
                //var_dump("test");die;
                $flag = true;
                break;
            }
        }
        if($flag){
            $gardienRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Gardien');

            $gardien = $gardienRepository->find($id);

            $this->getDoctrine()->getManager()->remove($gardien);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit de supprimer ce gardien');
            return $this->redirect($this->generateUrl('safe_parking_proprietaire_homepage'));
        }





    }
}
