<?php

namespace App\Lp\PaymentBundle\Controller;

use App\Entity\Transaction;
use App\Mailer\Mailer;
use App\Repository\OrdersRepository;
use App\Repository\TransactionRepository;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use App\Repository\ProjectRepository;

/**
 * Class YandexController
 *
 * @package App\Lp\PaymentBundle\Controller
 */
class YandexController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * YandexController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        TransactionRepository $transactionRepository,
        UsersRepository $usersRepository,
        ProjectRepository $projectRepository
    ) {
        $this->entityManager = $entityManager;
        $this->usersRepository = $usersRepository;
        $this->projectRepository = $projectRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        return $this->json(['success' => 200]);
    }

    public function success(Request $request, OrdersRepository $ordersRepository)
    {
        $order = $ordersRepository->findOneBy(
            ['external_payment_id' => $request->get('orderId')]
        );
        return $this->render('@LpPayment/order/success.html.twig', [
            'order' => $order
        ]);
    }

    public function transaction(
        EntityManagerInterface $entityManager,
        TransactionRepository $transactionRepository,
        OrdersRepository $ordersRepository,
        BookService $bookService,
        Mailer $mailer
    ) {
        $source = file_get_contents('php://input');
        $transactionData = json_decode($source);
        if($transactionData->object->id) {
            $transaction = $transactionRepository
                ->findOneBy(['external_id' => $transactionData->object->id]);
            if($transaction && $transaction->getId()) {
                $transaction->setData($source);
                $transaction->setType('yandex');
                $transaction->setEvent($transactionData->event);
                $transaction->setExternalId($transactionData->object->id);
                $transaction->setStatus($transactionData->object->status);
                $transaction->setAmount($transactionData->object->amount->value);
                $transaction->setCapturedAt($transactionData->object->created_at);
                if($transactionData->object->status != 'canceled') {
                    $transaction->setTriggeredAt($transactionData->object->captured_at);
                    $transaction->setCardFirst($transactionData->object->payment_method->card->first6);
                    $transaction->setCardLast($transactionData->object->payment_method->card->last4);
                    $transaction->setTitle($transactionData->object->payment_method->title);
                }
                $transaction->setDescription($transactionData->object->description);
                $transaction->setMethod($transactionData->object->payment_method->type);

                $entityManager->persist($transaction);
                $entityManager->flush();
            }
            if($transaction->getStatus() == 'succeeded') {
                $order = $ordersRepository->findOneBy(
                    ['transaction' => $transaction->getId()]
                );
                if($order && $order->getId()) {
                    $mailer->sendDownloadingLink($order->getUser(), $order->getProject(), $bookService, $order->getId() . '-' . $transaction->getId());
                }
            }
        }

        return $this->json(['success' => 200]);
    }
}