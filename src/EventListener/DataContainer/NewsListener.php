<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c) 2022, Ideenwerkstatt Sowieso GmbH & Co. KG
 * @author     Sowieso GmbH & Co. KG <https://sowieso.team>
 * @link       https://github.com/sowieso-web/contao-author-bundle
 */

namespace Sowieso\ContaoAuthorBundle\EventListener\DataContainer;

use Contao\BackendUser;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Image\ImageSizes;
use Contao\DataContainer;

class NewsListener
{
    private ContaoFramework $framework;
    private ImageSizes $imageSizes;

    /**
     * @param ContaoFramework $framework
     * @param ImageSizes$imageSizes
     */
    public function __construct(ContaoFramework $framework, ImageSizes $imageSizes)
    {
        $this->framework = $framework;
        $this->imageSizes = $imageSizes;
    }

    /**
     * Add additional field to the palettes.
     *
     * @param DataContainer $dataContainer
     */
    public function modifyPalette(DataContainer $dataContainer): void
    {
        PaletteManipulator::create()
            ->addField(['authorImageSize'], 'author', PaletteManipulator::POSITION_AFTER)
            ->applyToPalette('default', $dataContainer->table)
            ->applyToPalette('internal', $dataContainer->table)
            ->applyToPalette('article', $dataContainer->table)
            ->applyToPalette('external', $dataContainer->table)
        ;
    }

    /**
     * Get the available image size options for this user.
     *
     * @return array
     */
    public function getImageSizeOptions(): array
    {
        $user = $this->framework->createInstance(BackendUser::class);

        return $this->imageSizes->getOptionsForUser($user);
    }
}
