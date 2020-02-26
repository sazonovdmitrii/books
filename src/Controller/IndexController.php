<?php

namespace App\Controller;

use App\Repository\BlockRepository;
use App\Repository\ProjectRepository;
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
     * @param ProjectRepository $projectRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(
        BlockRepository $blockRepository,
        ProjectRepository $projectRepository
    ) {
        $top_block = $blockRepository->findBy(['id' => 3]);
        $projects = $projectRepository->findAll();
        return $this->render('index.html.twig', [
            'top_block' => $top_block[0],
            'projects' => $projects,
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
