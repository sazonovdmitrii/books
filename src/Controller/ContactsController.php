<?php

namespace App\Controller;

use App\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactsController extends AbstractController
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function index(Request $request)
    {
        $feedback = new Feedback();

        $form = $this->createFormBuilder($feedback)
            ->add('firstname', TextType::class, [
                'label' => 'Имя',
                'class' => 'form-control'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Фамилия'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Сообщение'
            ])
            ->add('save', SubmitType::class, ['label' => 'Отправить'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($feedback);
            $entityManager->flush();

            $this->addFlash('success', 'Спасибо за Ваше обращение! Мы с вами свяжемся в ближайшее время');

            return $this->redirectToRoute('contacts');
        }

        return $this->render('contacts.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
