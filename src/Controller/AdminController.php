<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;

/**
 * Class AdminController
 *
 * @package App\Controller
 */
class AdminController extends BaseAdminController
{
    /**
     * @param $entity
     */
    protected function persistEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param $entity
     */
    protected function updateEntity($entity)
    {
        $this->em->flush();
    }

    /**
     * @param $entity
     */
    protected function removeEntity($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param $className
     * @return mixed
     */
    public function repository($className)
    {
        return $this->getDoctrine()->getRepository($className);
    }


}
