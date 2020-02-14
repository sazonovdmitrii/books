<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectsController
 *
 * @package App\Controller
 */
class ProjectsController extends AbstractController
{
    /**
     * @Route("/projects/{slug}", name="project")
     */
    public function page(
        string $slug,
        ProjectRepository $projectRepository
    ) {
        $project = $projectRepository->findOneBy(['url' => '/' . $slug]);

        if($project) {
            return $this->render('project.html.twig', [
                'project' => $project
            ]);
        }
    }
}
