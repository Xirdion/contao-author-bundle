<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c) 2022, Ideenwerkstatt Sowieso GmbH & Co. KG
 * @author     Sowieso GmbH & Co. KG <https://sowieso.team>
 * @link       https://github.com/sowieso-web/contao-author-bundle
 */

namespace Sowieso\ContaoAuthorBundle\Tests\EventListener\DataContainer;

use Contao\DataContainer;
use PHPUnit\Framework\TestCase;
use Sowieso\ContaoAuthorBundle\EventListener\DataContainer\UserListener;

class UserListenerTest extends TestCase
{
    public function testModifyPalette(): void
    {
        $palettes = ['login', 'admin', 'default', 'group', 'extend', 'custom'];
        $dc = $this->createMock(DataContainer::class);
        $dc
            ->method('__get')
            ->with('table')
            ->willReturn('tl_user')
        ;

        include_once __DIR__ . '/../../../src/Resources/contao/dca/tl_user.php';

        // prepare
        foreach ($palettes as $palette) {
            $GLOBALS['TL_DCA']['tl_user']['palettes'][$palette] = '{name_legend},name;';
        }

        $callback = new UserListener();

        $callback->modifyPalette($dc);

        foreach ($palettes as $palette) {
            $haystack = $GLOBALS['TL_DCA']['tl_user']['palettes'][$palette];

            $this->assertStringContainsString('{author_legend}', $haystack);
            $this->assertStringContainsString('authorPicture', $haystack);
            $this->assertStringContainsString('authorDescription', $haystack);
            $this->assertStringContainsString('authorLinks', $haystack);
            $this->assertStringContainsString('authorPage', $haystack);
        }
    }
}
