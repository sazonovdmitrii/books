<?php

namespace App\Controller;

use App\Repository\BlockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 *
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="root")
     * @param BlockRepository $blockRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(
        BlockRepository $blockRepository
    ) {
        $top_block = $blockRepository->findById(['id' => 3]);
        return $this->render('index.html.twig', [
            'top_block' => $top_block[0],
            'controller_name' => 'RootController',
        ]);
    }

    /**
     * @Route("/locale/{locale}", name="locale")
     */
    public function locale($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);
        return $this->redirect($request->headers->get('referer'));
    }
}
