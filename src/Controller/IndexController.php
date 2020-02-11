<?php

namespace App\Controller;

use App\Repository\BlockRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="root")
     */
    public function index(PageRepository $pageRepository, BlockRepository $blockRepository)
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'RootController',
        ]);
    }
}
