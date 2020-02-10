<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

/**
 * Class AdminController
 *
 * @package App\Controller
 */
class AdminController extends BaseAdminController
{
    protected function persistEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    protected function updateEntity($entity)
    {
        $this->em->flush();
    }

    protected function removeEntity($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
