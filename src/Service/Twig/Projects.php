<?php

namespace App\Service\Twig;

use App\Entity\Project;
use App\Repository\ProjectRepository;

class Projects
{

    private $projectRepository;


    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getProjects()
    {
        $projects = $this->projectRepository->findBy(['crowdfunding' => Project::CROWDFUNDING_TYPE_NO]);
        return $projects;
    }

    public function getCroudfindingProjects()
    {
        $projects = $this->projectRepository->findBy(['crowdfunding' => Project::CROWDFUNDING_TYPE_YES]);
        return $projects;
    }
}