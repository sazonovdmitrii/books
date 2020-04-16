<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Project;
use App\Entity\Transaction;
use App\Entity\Users;
use App\Lp\PaymentBundle\Service\PaymentInterface;
use App\Repository\OrdersRepository;
use App\Repository\ProjectRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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
        PaymentInterface $paymentService,
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        OrdersRepository $ordersRepository
    ) {
        if($projectId = $request->get('projectId')) {
            $order = new Orders();

            $order->setExternalPaymentId(md5(time().rand(0,10)));

            $user = $usersRepository->findOneBy(['email' => $request->get('email')]);

            if(!$user) {
                $user = new Users();
                $user->setEmail($request->get('email'));
                $user->setPassword('email');
                $entityManager->persist($user);
                $entityManager->flush();
            }
            $order->setUser($user);

            $project = $projectRepository->find($projectId);

            $order->setProject($project);
            $order->setPrice($project->getPrice());
            $entityManager->persist($order);
            $entityManager->flush();

            $paymentLink = $paymentService->setOrder($order)->getPaymentLink($project);

            $order = $ordersRepository->find($order->getId());
            $order->setPaymentLink($paymentLink->getConfirmation()->getConfirmationUrl());

            $transaction = new Transaction();
            $transaction->setExternalId($paymentLink->getId());

            $entityManager->persist($transaction);
            $entityManager->flush();

            $order->setTransaction($transaction);

            $entityManager->persist($order);
            $entityManager->flush();

            return $this->json([
                'link' => $paymentLink->getConfirmation()->getConfirmationUrl()
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
