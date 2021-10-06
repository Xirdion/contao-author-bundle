<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c) 2021, Digitalagentur Dreibein GmbH
 * @author     Digitalagentur Dreibein GmbH <https://www.agentur-dreibein.de>
 * @link       https://github.com/dreibein/contao-author-bundle
 */

namespace Dreibein\ContaoAuthorBundle\Controller\FrontendModule;

use Contao\CalendarEventsModel;
use Contao\Controller;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FaqModel;
use Contao\FilesModel;
use Contao\Input;
use Contao\Model;
use Contao\ModuleModel;
use Contao\NewsModel;
use Contao\StringUtil;
use Contao\Template;
use Contao\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends AbstractFrontendModuleController
{
    private ContaoFramework $framework;

    /**
     * AuthorController constructor.
     *
     * @param ContaoFramework $framework
     */
    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @param Template    $template
     * @param ModuleModel $model
     * @param Request     $request
     *
     * @return Response|null
     */
    public function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        // Get the auto_item value
        $input = $this->framework->getAdapter(Input::class);
        $alias = $input->get('auto_item');

        // Get the correct entry model
        $content = $this->getContent($alias, $model);

        if (null === $alias || null === $content || !$content->author) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        // Load the author-user-model
        /** @var UserModel $user */
        $user = $this->framework->getAdapter(UserModel::class)->findByPk($content->author);
        $template->user = $user;
        $template->links = $this->getLinks($user);

        // Check if a user/author has been found
        if (null === $user) {
            return $template->getResponse();
        }

        // Load the image of the author
        /** @var FilesModel $userImage */
        $userImage = $this->framework->getAdapter(FilesModel::class)->findByUuid($user->authorPicture);

        // Check if the user/author has an image
        if (null === $userImage) {
            return $template->getResponse();
        }

        [$size, $width, $height] = StringUtil::deserialize($model->imgSize);
        $template->size = [$size, $width, $height];
        $template->singleSRC = $userImage->path;

        $this->framework->getAdapter(Controller::class)->addImageToTemplate($template, $template->getData(), null, null, $userImage);

        // overwrite alt text if it does not exist
        if (!$template->picture['alt']) {
            $picture = $template->picture;
            $picture['alt'] = $user->name;
            $template->picture = $picture;
        }

        return $template->getResponse();
    }

    /**
     * @param UserModel|null $user
     *
     * @return array
     */
    private function getLinks(?UserModel $user): array
    {
        if (null === $user) {
            return [];
        }

        $links = [];
        $authorLinks = StringUtil::deserialize($user->authorLinks, true);

        foreach ($authorLinks as $authorLink) {
            if (!$authorLink['link']) {
                continue;
            }

            $links[] = [
                'name' => $authorLink['name'],
                'link' => $authorLink['link'],
                'class' => StringUtil::generateAlias($authorLink['name']),
            ];
        }

        return $links;
    }

    /**
     * @param string|null $alias
     * @param ModuleModel $model
     *
     * @return NewsModel|CalendarEventsModel|FaqModel|null
     */
    private function getContent(?string $alias, ModuleModel $model): ?Model
    {
        if (null === $alias) {
            return null;
        }

        switch ($model->authorArchiveType) {
            case 'author_news':
                $adapter = $this->framework->getAdapter(NewsModel::class);

                return $adapter->findOneByAlias($alias);
            case 'author_calendar':
                $adapter = $this->framework->getAdapter(CalendarEventsModel::class);

                return $adapter->findOneByAlias($alias);
            case 'author_faq':
                $adapter = $this->framework->getAdapter(FaqModel::class);

                return $adapter->findOneByAlias($alias);
        }

        return null;
    }
}
