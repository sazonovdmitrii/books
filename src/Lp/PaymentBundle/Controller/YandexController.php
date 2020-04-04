<?php

namespace App\Lp\PaymentBundle\Controller;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

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
        TransactionRepository $transactionRepository
    ) {
        $this->entityManager = $entityManager;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        return $this->json(['success' => 200]);
    }

    public function success()
    {
        return $this->json(['success' => 200]);
    }

    public function transaction(
        EntityManagerInterface $entityManager
    ) {
        $transaction = new Transaction();

        $transaction->setType('yandex');

        $source = file_get_contents('php://input');
        $transaction->setData($source);

        $transactionData = json_decode($source);
        $transaction->setEvent($transactionData->event);
        $transaction->setExternalId($transactionData->object->id);
        $transaction->setStatus($transactionData->object->status);
        $transaction->setAmount($transactionData->object->amount->value);
        $transaction->setCapturedAt($transactionData->object->created_at);
        $transaction->setTriggeredAt($transactionData->object->captured_at);
        $transaction->setDescription($transactionData->object->description);
        $transaction->setMethod($transactionData->object->payment_method->type);
        $transaction->setCardFirst($transactionData->object->payment_method->card->first6);
        $transaction->setCardLast($transactionData->object->payment_method->card->last4);
        $transaction->setTitle($transactionData->object->payment_method->title);

        $entityManager->persist($transaction);
        $entityManager->flush();

        return $this->json(['success' => 200]);
    }
}