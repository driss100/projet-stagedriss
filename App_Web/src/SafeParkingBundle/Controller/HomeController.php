<?php

namespace SafeParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('SafeParkingBundle:Home:index.html.twig');
    }
}
