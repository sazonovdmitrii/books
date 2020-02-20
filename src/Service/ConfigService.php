<?php

namespace App\Service;

use App\Repository\ConfigurationRepository;

class ConfigService
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function get($option)
    {
        $option = $this->configurationRepository->findOneBy(['name' => $option]);
        if($option) {
            return $option->getValue();
        }
        return false;
    }
}