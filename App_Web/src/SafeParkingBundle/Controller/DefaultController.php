<?php

namespace SafeParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeParkingBundle:Home:index.html.twig');
    }
}
