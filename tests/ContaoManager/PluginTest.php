<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c), Thomas Dirscherl
 * @author     Thomas Dirscherl <https://github.com/xirdion>
 * @link       https://github.com/xirdion/contao-author-bundle
 * @license    LGPL-3.0-or-later
 */

namespace Xirdion\ContaoAuthorBundle\Tests\ContaoManager;

use Contao\CalendarBundle\ContaoCalendarBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\FaqBundle\ContaoFaqBundle;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use PHPUnit\Framework\TestCase;
use Xirdion\ContaoAuthorBundle\ContaoManager\Plugin;
use Symfony\Component\Config\Loader\LoaderInterface;

class PluginTest extends TestCase
{

    public function testGetBundles(): void
    {
        $parser = $this->createMock(ParserInterface::class);

        $plugin = new Plugin();

        $bundles = $plugin->getBundles($parser);

        $this->assertInstanceOf(ConfigPluginInterface::class, $plugin);
        $this->assertCount(1, $bundles);
        $this->assertSame([
            ContaoCalendarBundle::class,
            ContaoCoreBundle::class,
            ContaoFaqBundle::class,
            ContaoNewsBundle::class,
        ], $bundles[0]->getLoadAfter());
    }
}
