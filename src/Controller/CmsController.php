<?php

namespace App\Controller;

use App\Repository\PageUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ContentService;

class CmsController extends AbstractController
{
    public function page(
        string $slug,
        PageUrlRepository $pageUrlRepository,
        ContentService $contentService
    ) {
        $pageUrl = $pageUrlRepository->findByUrl($slug . '/');

        if($pageUrl) {
            return $this->render('page.html.twig', [
                'page' => $contentService->wrap($pageUrl->getEntity())
            ]);
        }
    }
}
