<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use App\Service\RequestFilterService;
use App\Entity\Configuration;
use App\Repository\ConfigurationRepository;

class ConfigurationController extends BaseAdminController
{
    private $_template = 'admin/Configuration/form.html.twig';

    /**
     * @var RequestFilterService
     */
    private $filterService;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    public function __construct(
        RequestFilterService $filterService,
        EntityManagerInterface $entityManager,
        ConfigurationRepository $configurationRepository
    ) {
        $this->filterService = $filterService;
        $this->entityManager = $entityManager;
        $this->configurationRepository = $configurationRepository;
    }

    public function saveAction()
    {
        $parameters = $this->filterService->filterQuery($this->request->query);
        $this->configurationRepository->flush();

        foreach($parameters as $name => $value) {
            $configuration = new Configuration();
            $configuration->setName($name);
            $configuration->setValue($value);
            $this->entityManager->persist($configuration);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
        return $this->redirectToReferrer();
    }

    protected function renderTemplate($actionName, $templatePath, array $parameters = array())
    {
        $list = $this->configurationRepository->findAll();
        foreach($list as $item) {
            $parameters['list'][$item->getName()] = $item->getValue();
        }
        return $this->render($this->_template, $parameters);
    }
}
