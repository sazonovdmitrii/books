<?php

namespace App\Controller;

use App\Repository\BlockRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CmsController extends AbstractController
{
    public function page()
    {
        return $this->render('page.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
