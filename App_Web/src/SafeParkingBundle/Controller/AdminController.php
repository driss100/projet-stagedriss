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
        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');

        $proprietaires = $proprietaireRepository->findAll();

        return $this->render('SafeParkingBundle:Admin:index.html.twig', array(
            'proprietaires' => $proprietaires
        ));
    }

    public function addProprietaireAction(Request $request)
    {
        $proprietaire = new Proprietaire();

        $form = $this->get('form.factory')->create(ProprietaireType::class, $proprietaire);

        $form->handleRequest($request);
        
        if($form->get('cancel')->isClicked()){
            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Propriétaire bien enregistré.');

            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }


        return $this->render('SafeParkingBundle:Admin:addProprietaire.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function editProprietaireAction($id, Request $request){
        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');

        $proprietaire = $proprietaireRepository->find($id);

        $form = $this->get('form.factory')->create(ProprietaireType::class, $proprietaire);
        $form->remove('password');

        $form->handleRequest($request);

        if($form->get('cancel')->isClicked()){
            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($proprietaire);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Propriétaire bien enregistré.');

            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }


        return $this->render('SafeParkingBundle:Admin:editProprietaire.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteProprietaireAction($id){
        $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Proprietaire');

        $proprietaire = $proprietaireRepository->find($id);

        $this->getDoctrine()->getManager()->remove($proprietaire);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));

    }
}
