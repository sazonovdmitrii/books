<?php
namespace App\Service;

use App\Entity\Page;

class ContentService
{
    public function wrap(Page $page)
    {
        $content = $page->getContent();
        var_dump($content);
        die();
        return $page;
    }
}