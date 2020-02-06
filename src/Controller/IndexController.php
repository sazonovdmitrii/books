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
        $page = $pageRepository->find(1);
//        $content = $page->getContent();
$blocks = $blockRepository->findAll();
foreach($blocks as $block) {
    var_dump($block->getId());
}
die();
        $allBlocks = [
            'slider_block' => '
                <div class="slider">...</div>
            ',
        ];

        $content = '
            <div style="width:100%">{{ slider_block }}</div>
            <div style="width:50%">{{ goals_block }}</div>
            <div style="width:50%">{{ poings_block }}</div>
        ';
        var_dump($content);die;

        return $this->render('index.html.twig', [
            'controller_name' => 'RootController',
        ]);
    }
}
