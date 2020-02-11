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
    /**
     * @param object $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function persistEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param object $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function updateEntity($entity)
    {
        $this->em->flush();
    }

    /**
     * @param object $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function removeEntity($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
