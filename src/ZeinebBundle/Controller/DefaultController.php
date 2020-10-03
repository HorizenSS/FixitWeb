<?php

namespace ZeinebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZeinebBundle:Default:index.html.twig');
    }
}
