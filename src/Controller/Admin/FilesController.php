<?php

namespace App\Controller\Admin;

use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilesController extends AdminController
{
    private $entityManager;

    private $fileUploader;

    public function __construct(
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader  = $fileUploader;
    }

    /**
     * @Route("/admin/files/upload", methods={"POST","HEAD"})
     */
    public function upload(Request $request)
    {
        $files = [];
        if ($type = $request->request->get('type', false)) {
            $className = 'App\\Entity\\' . $type;
            if (class_exists($className)) {
                foreach ($request->files->all() as $file) {
                    $fileName = $this->fileUploader
                        ->setTargetDirectory($this->getPath($type))
                        ->upload($file);
                    if(!$request->request->get('no_persist', false)) {
                        $entity = new $className;
                        $entity->setPath($fileName);
                        $this->entityManager->persist($entity);
                        $this->entityManager->flush();
                    }
                    $files[] = [
                        'id'   => (isset($entity)) ? $entity->getId() : 0,
                        'path' => $this->getUrl($type) . '/' . $fileName
                    ];
                }
            }
        }
        $response = new Response();
        $response->setContent(json_encode($files));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/admin/files/upload_once", methods={"POST","HEAD"})
     */
    public function upload_once(Request $request)
    {
        if ($type = $request->request->get('type', false)) {
            $file     = $request->files->get('file');
            $fileName = $this->fileUploader
                ->setTargetDirectory($this->getPath($type))
                ->upload($file);
        }
        $response = new Response();
        $response->setContent(
            json_encode(
                ['files' => $this->getUrl($type) . '/' . $fileName]
            )
        );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/admin/files/delete", methods={"POST","HEAD"})
     */
    public function delete(Request $request)
    {
        $type = $request->query->get('type');

        $file = $this->entityManager
            ->getRepository('App:' . $type)
            ->find((int)$request->query->get('eid'));

        if ($file) {
            $this->entityManager->remove($file);
            $this->entityManager->flush();
        }

        @unlink($this->getPath($type) . '/' . $file->getPath());

        $response = new Response();
        $response->setContent(json_encode([]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getPath($type)
    {
        return $this->getParameter('app.path.' . $type);
    }

    public function getUrl($type)
    {
        return $this->getParameter('app.url.' . $type);
    }
}
