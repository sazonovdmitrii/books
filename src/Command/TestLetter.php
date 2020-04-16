<?php
namespace App\Command;

use App\Mailer\Mailer;
use App\Repository\ProjectRepository;
use App\Repository\UsersRepository;
use App\Service\BookService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class TestLetter extends Command
{
    protected static $defaultName = 'swiftmailer:testletter';
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var BookService
     */
    private $bookService;

    protected function configure()
    {
        $this
            ->setDescription('Test Letter')
            ->setHelp('Restore Password Test Letter');
    }

    public function __construct(Mailer $mailer, UsersRepository $usersRepository, ProjectRepository $projectRepository, BookService $bookService)
    {
        $this->mailer = $mailer;
        $this->usersRepository = $usersRepository;
        parent::__construct();
        $this->projectRepository = $projectRepository;
        $this->bookService = $bookService;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->mailer->sendDownloadingLink($this->usersRepository->find(1), $this->projectRepository->find(2), $this->bookService);
        $output->writeln('Success');
    }
}