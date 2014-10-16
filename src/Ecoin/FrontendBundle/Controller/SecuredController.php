<?php

namespace Ecoin\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecuredController extends Controller
{   
    public function deniedAction()
    {
        return $this->render('BackendBundle:Secured:denied.html.twig');
    }
}
