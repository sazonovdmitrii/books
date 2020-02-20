<?php
namespace App\Service;

use App\Entity\BookHash;
use App\Entity\Project;
use App\Entity\Users;
use App\Repository\BookHashRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class BookService
 *
 * @package App\Service
 */
class BookService
{
    /**
     * @var BookHashRepository
     */
    private $bookHashRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        BookHashRepository $bookHashRepository,
        EntityManager $entityManager
    ) {
        $this->bookHashRepository = $bookHashRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Project $project
     * @param Users $user
     * @return string
     */
    private function generateHash(Project $project, Users $user)
    {
        return md5(sha1($project->getId() . $project->getLink() . $user->getEmail() . time()));
    }

    /**
     * @param Project $project
     * @param Users $user
     * @return string|null
     */
    public function generateLink(Project $project, Users $user)
    {
        $hash = new BookHash();

        $hash->setProject($project);
        $hash->setHash($this->generateHash($project, $user));

        $this->entityManager->persist($hash);
        $this->entityManager->flush();

        return $hash->getHash();
    }
}