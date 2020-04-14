<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle.
 * (c) Werbeagentur Dreibein GmbH
 */

namespace Dreibein\ContaoAuthorBundle\Controller\FrontendModule;

use Contao\CalendarEventsModel;
use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\FilesModel;
use Contao\Input;
use Contao\ModuleModel;
use Contao\NewsModel;
use Contao\StringUtil;
use Contao\Template;
use Contao\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends AbstractFrontendModuleController
{
    /**
     * @var ContaoFramework
     */
    private $framework;

    /**
     * AuthorController constructor.
     *
     * @param ContaoFramework $framework
     */
    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    public function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        $input = $this->framework->getAdapter(Input::class);
        $alias = $input->get('auto_item');

        $content = $this->getContent($alias, $model);

        if ($alias === null || $content === null || !$content->author) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $user = $this->framework->getAdapter(UserModel::class)->findByPk($content->author);
        $template->user = $user;

        if ($user) {
            $userImage = $this->framework->getAdapter(FilesModel::class)->findByUuid($user->authorPicture);
            [$size, $width, $height] = StringUtil::deserialize($model->imgSize);
            $template->size = [$size, $width, $height];
            $template->singleSRC = $userImage->path;
        }

        $template->links = $this->getLinks($user);

        return $template->getResponse();
    }

    /**
     * @param UserModel $user
     */
    private function getLinks($user)
    {
        $links = [];

        $authorLinks = StringUtil::deserialize($user->authorLinks);

        foreach ($authorLinks as $authorLink) {
            $links[] = [
                'name' => $authorLink['name'],
                'link' => $authorLink['link'],
                'class' => StringUtil::generateAlias($authorLink['name']),
            ];
        }

        return $links;
    }

    private function getContent(?string $alias, ModuleModel $model)
    {
        if ($alias === null) {
            return null;
        }

        switch ($model->authorArchiveType) {
            case 'author_news':
                $adapter = $this->framework->getAdapter(NewsModel::class);

                return $adapter->findPublishedByParentAndIdOrAlias($alias, (array) $model->authorArchive);
            case 'author_calendar':
                $adapter = $this->framework->getAdapter(CalendarEventsModel::class);

                return $adapter->findPublishedByParentAndIdOrAlias($alias, (array) $model->authorCalendar);
        }

        return null;
    }
}
