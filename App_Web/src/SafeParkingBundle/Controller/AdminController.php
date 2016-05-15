<?php

namespace SafeParkingBundle\Controller;

use SafeParkingBundle\Entity\Proprietaire;
use SafeParkingBundle\Form\ProprietaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {
        /*
         * Gestion d'accès à la page avec le rôle admin
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'admin') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }

        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');

        $proprietaires = $proprietaireRepository->findAll();

        return $this->render('SafeParkingBundle:Admin:index.html.twig', array(
            'proprietaires' => $proprietaires
        ));
    }

    public function addProprietaireAction(Request $request)
    {
        /*
         * Gestion d'accès à la page avec le rôle admin
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'admin') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }


        $proprietaire = new Proprietaire();

        $form = $this->get('form.factory')->create(ProprietaireType::class, $proprietaire);
        $form->remove('login');
        $form->handleRequest($request);
        
        if($form->get('cancel')->isClicked()){
            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Le propriétaire a bien été enregistré.');

            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }


        return $this->render('SafeParkingBundle:Admin:addProprietaire.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function editProprietaireAction($id, Request $request){
        /*
         * Gestion d'accès à la page avec le rôle admin
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'admin') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }


        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');

        $proprietaire = $proprietaireRepository->find($id);

        $form = $this->get('form.factory')->create(ProprietaireType::class, $proprietaire);
        $form->remove('password');
        $form->remove('login');

        $form->handleRequest($request);

        if($form->get('cancel')->isClicked()){
            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Le propriétaire a bien été modifié.');

            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }


        return $this->render('SafeParkingBundle:Admin:editProprietaire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteProprietaireAction($id){
        /*
         * Gestion d'accès à la page avec le rôle admin
         */
        $session = $this->get('session');

        if( $session->has('role') && $session->get('role') == 'admin') {

        }else{
            $this->get('session')->getFlashBag()->add('error', 'Vous n\'avez pas le droit d\'accéder à cette page 
            avec le rôle de votre compte. Veuillez vous connecter autant qu\'administrateur');
            return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
        }


        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');

        $proprietaire = $proprietaireRepository->find($id);

        $this->getDoctrine()->getManager()->remove($proprietaire);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));

    }
}
