<?php

namespace SafeParkingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProprietaireController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
