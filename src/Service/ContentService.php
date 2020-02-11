<?php
namespace App\Service;

use App\Entity\Page;
use App\Repository\BlockRepository;

/**
 * Class ContentService
 *
 * @package App\Service
 */
class ContentService
{
    /**
     * @var BlockRepository
     */
    private $blockRepository;

    /**
     * ContentService constructor.
     *
     * @param $blockRepository
     */
    public function __construct($blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param Page $page
     * @return Page
     */
    public function wrap(Page $page)
    {
        $content = $page->getContent();

        preg_match_all("/\[[^\]]*\]/", $content, $matches);

        if(!count($matches)) {
            return $page;
        }

        $occurences = [];
        foreach($matches[0] as &$match) {
            $blockName = strtr($match, ['[' => '', ']' => '']);
            $block = $this->blockRepository->findByName($blockName);
            if($block) {
                $occurences[$match] = $block->getContent();
            }
        }

        $page->setContent(strtr($content, $occurences));

        return $page;
    }
}