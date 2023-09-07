<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $user = $this->security->getUser();

        if ($this->isGranted('ROLE_ADMIN', $user)) {
            return $this->render('home/admin.html.twig');
        } elseif ($this->isGranted('ROLE_ENS', $user)) {
            return $this->render('home/ens.html.twig');
        } elseif ($this->isGranted('ROLE_PARENT', $user)) {
            return $this->render('home/parent.html.twig');
        } else {
            return $this->render('home/index.html.twig');
        }


    }
}

