<?php

namespace SafeParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SafeParkingBundle\Entity\Admin;
use SafeParkingBundle\Form\AdminType;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $this->get('session');

        if($session->get('role') == 'admin'){
            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }elseif($session->get('role') == 'proprietaire'){
            /*
             * redirection vers le dashboard des propriétaires
             */
            //à changer avec la bonne url
            return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }



        $admin = new Admin();

        $form = $this->get('form.factory')->create(AdminType::class, $admin);


        $form->handleRequest($request);

        if($form->isValid()){

            $adminRepository = $this->getDoctrine()->getManager()->getRepository('SafeParkingBundle:Admin');
            $proprietaireRepository = $this->getDoctrine()->getManager()->getRepository
            ('SafeParkingBundle:Proprietaire');


            $emailResult = $adminRepository->findOneByEmail($admin->getEmail());
            if($emailResult != null){
                if($emailResult->getPassword() == $admin->getPassword()){
                    /**
                     * Il faut remplir les variables de session
                     */
                    $session->set('role', 'admin');
                    $session->set('email', $emailResult);

                    return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
                }else{
                    $this->get('session')->getFlashBag()->add('error', 'Le mot de passe ne correspond pas à l\'e-mail
                     que vous avez saisi.');
                    return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
                }
            }else{
                $emailResult = $proprietaireRepository->findOneByEmail($admin->getEmail());
                if($emailResult != null){
                    if($emailResult->getPassword() == $admin->getPassword()){
                        /**
                         * Il faut remplir les variables de session
                         * et renvoyer vers la page dashboard des propriétaires
                         */
                        $session->set('role', 'proprietaire');
                        $session->set('email', $emailResult);

                        //à changer avec la bonne url
                        return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));

                    }else{
                        $this->get('session')->getFlashBag()->add('error', 'Le mot de passe ne correspond pas à l\'e-mail
                     que vous avez saisi.');
                        return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
                    }
                }else{
                    $this->get('session')->getFlashBag()->add('error', 'Aucun compte n\'est enregistré avec cet e-mail. 
                Veuillez contactez l\'administrateur pour toute information supplémentaire');
                    return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
                }
            }

            //return $this->redirect($this->generateUrl('safe_parking_admin_homepage'));
        }


        return $this->render('SafeParkingBundle:Login:login.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function logoutAction(){
        $session = $this->get('session');

        if($session->has('role') && $session->has('email')){
            $session->remove('role');
            $session->remove('email');
            $session->clear();
        }

        return $this->redirect($this->generateUrl('safe_parking_login_loginpage'));
    }
}
