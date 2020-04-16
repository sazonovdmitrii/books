<?php

namespace App\Mailer;

use App\Entity\Project;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\BookService;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var string
     */
    private $mailFrom;

    public function __construct(
        \Swift_Mailer $mailer,
        \Twig_Environment $twig,
        UsersRepository $usersRepository,
        string $mailFrom
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->usersRepository = $usersRepository;
        $this->mailFrom = $mailFrom;
    }

    public function sendDownloadingLink(
        Users $user,
        Project $project,
        BookService $bookService
    ) {
        $body = $this->twig->render('emails/downloading_link.html.twig', [
            'link' => $bookService->generateLink($project, $user),
            'project' => $project,
            'user' => $user
        ]);

        $message = (new \Swift_Message())
            ->setSubject('Hello test letter')
            ->setFrom($this->mailFrom)
            ->setTo('sazon@nxt.ru')
            ->setBody($body);

        $this->mailer->send($message);
    }
}