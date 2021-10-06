<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c) 2021, Digitalagentur Dreibein GmbH
 * @author     Digitalagentur Dreibein GmbH <https://www.agentur-dreibein.de>
 * @link       https://github.com/dreibein/contao-author-bundle
 */

namespace Dreibein\ContaoAuthorBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;

class UserListener
{
    /**
     * @param DataContainer $dc
     */
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
