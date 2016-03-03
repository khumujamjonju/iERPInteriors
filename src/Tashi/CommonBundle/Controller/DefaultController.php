<?php

namespace Tashi\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TashiCommonBundle:Default:index.html.twig', array('name' => $name));
    }
}
