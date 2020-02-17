<?php
namespace App\Service\Twig;

/**
 * Class Language
 *
 * @package App\Service\Twig
 */
class Language
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Language constructor.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->request->getCurrentRequest()->getSession()->get('_locale');
    }
}