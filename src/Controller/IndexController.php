<?php

namespace App\Controller;

use App\Repository\BlockRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;

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
        $top_blocks = $blockRepository->findBy(['name' => 'slider_block']);
        $projects = $projectRepository->findBy(['crowdfunding' => Project::CROWDFUNDING_TYPE_NO]);
        $crowdfundingProjects = $projectRepository->findBy(['crowdfunding' => Project::CROWDFUNDING_TYPE_YES]);
        return $this->render('index.html.twig', [
            'top_block' => $top_blocks[0],
            #'projects' => $projects,
            'crowdfunding_projects' => $crowdfundingProjects,
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
