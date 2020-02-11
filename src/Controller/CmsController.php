<?php

namespace App\Controller;

use App\Repository\PageUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ContentService;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class CmsController
 *
 * @package App\Controller
 */
class CmsController extends AbstractController
{
    /**
     * @param string $slug
     * @param PageUrlRepository $pageUrlRepository
     * @param ContentService $contentService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
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
