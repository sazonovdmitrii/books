<?php

namespace App\Controller;

use App\Repository\BookHashRepository;
use App\Repository\ProjectRepository;
use App\Repository\UsersRepository;
use App\Service\BookService;
use App\Service\ConfigService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookController
 *
 * @package App\Controller
 */
class BookController extends AbstractController
{
    /**
     * @Route("/book/generate/{userId}/{projectId}", name="book_generate")
     */
    public function generate(
        $userId,
        $projectId,
        UsersRepository $usersRepository,
        ProjectRepository $projectRepository,
        BookService $bookService
    ) {
        $user = $usersRepository->find($userId);
        $project = $projectRepository->find($projectId);
        $hash = $bookService->generateLink($project, $user);

        $response = new Response();
        $response->setContent(
            json_encode([
                'hash' => '/book/download/' . $hash,
            ])
        );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/book/download/{hash}", name="book_download")
     */
    public function download(
        $hash,
        Request $request,
        BookHashRepository $bookHashRepository,
        ConfigService $configService
    ) {
        $bookHash = $bookHashRepository->findOneBy(['hash' => $hash]);

        if($bookHash) {
            $expirationTime = $bookHash->getCreated()->modify('+ ' . $configService->get('book_lifetime') . ' minutes');
            $now = new \DateTime();

            if($now < $expirationTime) {
                $response = new BinaryFileResponse(
                    $this->getParameter('kernel.project_dir') . '/public' . $bookHash->getProject()->getLink()
                );
                $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
                return $response;
            } {
                throw $this->createNotFoundException('The book link is expired');
            }
        }
        throw $this->createNotFoundException('The book link is not exists');
    }
}
