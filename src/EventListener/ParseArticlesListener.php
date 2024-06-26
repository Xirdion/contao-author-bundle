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

namespace Xirdion\ContaoAuthorBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;
use Contao\UserModel;

#[AsHook('parseArticles')]
class ParseArticlesListener
{
    private ContaoFramework $framework;

    /**
     * @param ContaoFramework $framework
     */
    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @param FrontendTemplate $template
     * @param array            $newsEntry
     * @param Module           $module
     */
    public function __invoke(FrontendTemplate $template, array $newsEntry, Module $module): void
    {
        // Try to load the author model
        $userModel = $this->framework->getAdapter(UserModel::class);

        /** @var UserModel $user */
        $user = $userModel->findById((int) $newsEntry['author']);
        if (null === $user) {
            return;
        }

        // Add the user model and the author links to the template
        $template->authorUser = $user;
        $template->authorLinks = StringUtil::deserialize($user->authorLinks, true);

        // Try to load the author image
        $imageModel = $this->framework->getAdapter(FilesModel::class);
        /** @var FilesModel $image */
        $image = $imageModel->findByUuid($user->authorPicture);
        if (null !== $image) {
            $imageTemplate = new \stdClass();

            $figureBuilder = System::getContainer()->get('contao.image.studio')->createFigureBuilder();

            $figure = $figureBuilder
                        ->fromFilesModel($image)
                        ->setSize(StringUtil::deserialize($newsEntry['authorImageSize'], true))
                        ->buildIfResourceExists()
            ;

            $figure->applyLegacyTemplateData($imageTemplate, null, null, false);

            $template->authorImage = $imageTemplate;
        }
    }
}
