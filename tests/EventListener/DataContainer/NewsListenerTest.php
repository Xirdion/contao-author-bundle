<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c) 2021, Digitalagentur Dreibein GmbH
 * @author     Digitalagentur Dreibein GmbH <https://www.agentur-dreibein.de>
 * @link       https://github.com/dreibein/contao-author-bundle
 */

namespace Dreibein\ContaoAuthorBundle\Tests\EventListener\DataContainer;

use Contao\CoreBundle\Image\ImageSizes;
use Contao\DataContainer;
use Contao\TestCase\ContaoTestCase;
use Dreibein\ContaoAuthorBundle\EventListener\DataContainer\NewsListener;

class NewsListenerTest extends ContaoTestCase
{
    private NewsListener $listener;

    protected function setUp(): void
    {
        $framework = $this->mockContaoFramework();
        $imageSizes = $this->createMock(ImageSizes::class);
        $this->listener = new NewsListener($framework, $imageSizes);
    }

    public function testModifyPalette(): void
    {
        $palettes = ['default', 'internal', 'article', 'external'];
        $dc = $this->mockClassWithProperties(DataContainer::class);
        $dc->table = 'tl_news';

        include_once __DIR__ . '/../../../src/Resources/contao/dca/tl_news.php';

        // Prepare the palette
        foreach ($palettes as $palette) {
            $GLOBALS['TL_DCA']['tl_news']['palettes'][$palette] = '{title_legend},headline,alias,author;{date_legend},date,time;';
        }

        $this->listener->modifyPalette($dc);

        foreach ($palettes as $palette) {
            $haystack = $GLOBALS['TL_DCA']['tl_news']['palettes'][$palette];

            $this->assertStringContainsString('author,authorImageSize', $haystack);
        }
    }
}
