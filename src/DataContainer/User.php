<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Dreibein\ContaoAuthorBundle\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;

class User
{
    /**
     * @param DataContainer $dc
     */
    public function modifyPalette($dc): void
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
            ->applyToPalette('admin', $dc->table)
            ->applyToPalette('default', $dc->table)
            ->applyToPalette('group', $dc->table)
            ->applyToPalette('extend', $dc->table)
            ->applyToPalette('custom', $dc->table)
        ;
    }
}
