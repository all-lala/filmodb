<?php

namespace Alala\MoviedbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AlalaMoviedbBundle:Default:index.html.twig');
    }
}
