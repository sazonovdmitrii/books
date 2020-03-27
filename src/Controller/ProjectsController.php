<?php

namespace App\Controller;

use App\Entity\Project;
use App\Lp\PaymentBundle\Service\PaymentInterface;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
    public function projects(ProjectRepository $projectRepository)
    {
        return $this->render('projects.html.twig', [
            'projects_books' => $projectRepository->findBy(
                ['crowdfunding' => Project::CROWDFUNDING_TYPE_NO]
            ),
            'crowdfunding_projects' => $projectRepository->findBy(
                ['crowdfunding' => Project::CROWDFUNDING_TYPE_YES]
            ),
        ]);
    }

    /**
     * @Route("/projects/payment", name="project_payment")
     * @param ProjectRepository $projectRepository
     * @param Request $request
     * @param PaymentInterface $paymentService
     * @return mixed
     */
    public function payment(
        ProjectRepository $projectRepository,
        Request $request,
        PaymentInterface $paymentService
    ) {
        if($projectId = $request->get('projectId')) {
            $project = $projectRepository->find($projectId);
            return $this->json([
                'link' => $paymentService->setOrder($project)->getPaymentLink($project)
            ]);
        }
        exit;
    }

    /**
     * @Route("/projects/{slug}", name="project")
     * @param string $slug
     * @param ProjectRepository $projectRepository
     * @return Response
     */
    public function page($slug, ProjectRepository $projectRepository)
    {
        return $this->render('project.html.twig', [
            'project' => $projectRepository->findOneBy(
                ['url' =>  $slug]
            )
        ]);
    }
}
