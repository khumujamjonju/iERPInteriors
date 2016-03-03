<?php

namespace Tashi\SystemSettingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TashiSystemSettingBundle:Default:index.html.twig', array('name' => $name));
    }
}
