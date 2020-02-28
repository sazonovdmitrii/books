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
     * @Route("/projects/", name="projects")
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function projects(
        ProjectRepository $projectRepository
    ) {
        $projects = $projectRepository->findBy(array(), array('crowdfunding' => 'ASC'));

        if($projects) {
            return $this->render('projects.html.twig', [
                'projects' => $projects
            ]);
        }
    }

    /**
     * @Route("/projects/{slug}", name="project")
     * @param string $slug
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function page(
        string $slug,
        ProjectRepository $projectRepository
    ) {
        $project = $projectRepository->findOneBy(['url' =>  $slug]);

        if($project) {
            return $this->render('project.html.twig', [
                'project' => $project
            ]);
        }
    }


}
