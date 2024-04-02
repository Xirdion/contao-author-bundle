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

namespace Xirdion\ContaoAuthorBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

class UserListener
{
    /**
     * @param DataContainer $dc
     */
	#[AsCallback(table: 'tl_user', target: 'config.onload')]
    public function modifyPalette(DataContainer $dc): void
    {
        PaletteManipulator::create()
            ->addLegend('author_legend', 'backend_legend', PaletteManipulator::POSITION_BEFORE)
            ->addField(
                [
                    'authorPicture',
                    'authorDescription',
                    'authorLinks',
                    'authorPage',
                ],
                'author_legend',
                PaletteManipulator::POSITION_APPEND
            )
            ->applyToPalette('login', $dc->table)
            ->applyToPalette('admin', $dc->table)
            ->applyToPalette('default', $dc->table)
            ->applyToPalette('group', $dc->table)
            ->applyToPalette('extend', $dc->table)
            ->applyToPalette('custom', $dc->table)
        ;
    }
}
