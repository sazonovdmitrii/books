<?php

namespace App\Lp\PaymentBundle\Service\Methods;

use YandexCheckout\Client;

/**
 * Class YandexKassa
 *
 * @package App\Lp\PaymentBundle\Service\Methods
 */
class YandexKassa implements PaymentMethodInterface
{
    private $config;
    /**
     * @param $order
     * @return mixed
     * @throws \YandexCheckout\Common\Exceptions\ApiException
     * @throws \YandexCheckout\Common\Exceptions\BadApiRequestException
     * @throws \YandexCheckout\Common\Exceptions\ForbiddenException
     * @throws \YandexCheckout\Common\Exceptions\InternalServerError
     * @throws \YandexCheckout\Common\Exceptions\NotFoundException
     * @throws \YandexCheckout\Common\Exceptions\ResponseProcessingException
     * @throws \YandexCheckout\Common\Exceptions\TooManyRequestsException
     * @throws \YandexCheckout\Common\Exceptions\UnauthorizedException
     */
    public function getPaymentLink($order)

    {
        $client = new Client();
        $client->setAuth(
            $this->config->get('yandex_shop_id'),
            $this->config->get('yandex_secret_key')
        );

        $idempotenceKey = uniqid('', true);

        $orderId =  md5(time().rand(0,10));

        $response = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $order->getPrice(),
                    'currency' => 'RUB',
                ),
                'capture' => true,
                'payment_method_data' => array(
                    'type' => 'bank_card',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => $this->config->get('yandex_return_url') . '?orderId=' . $orderId
                ),
                'description' => 'Заказ ' . $orderId,
            ),
            $idempotenceKey
        );

        return $response->getConfirmation()->getConfirmationUrl();
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $config
     * @return $this|mixed
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return string
     */
    public function code()
    {
        return 'yandex';
    }
}