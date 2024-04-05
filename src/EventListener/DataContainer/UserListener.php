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
        foreach ($GLOBALS['TL_DCA'][$dc->table]['palettes'] as $palette => $fields) {
            if ('__selector__' === $palette) {
                continue;
            }

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
                ->applyToPalette($palette, $dc->table)
            ;
        }
    }
}
