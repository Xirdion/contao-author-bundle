<?php

namespace Dreibein\ContaoAuthorBundle\Controller\FrontendModule;

use Contao\Controller;
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
     * @param ContaoFramework $framework
     */
    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    protected function getResponse(Template $template, ModuleModel $model, Request $request): ?Response
    {
        $input = $this->framework->getAdapter(Input::class);
        $alias = $input->get('auto_item');

        $news = $this->framework->getAdapter(NewsModel::class);
        $row = $news->findOneBy('alias', $alias);

        if (null === $alias || !$row->author) {
            return new Response();
        }

        $user = $this->framework->getAdapter(UserModel::class)->findByPk($row->author);
        $userImage = $this->framework->getAdapter(FilesModel::class)->findByUuid($user->authorPicture);
        [$size, $width, $height] = \Contao\StringUtil::deserialize($model->imgSize);

        $template->size = [$size, $width, $height];
        $template->singleSRC = $userImage->path;
        $template->user = $user;
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
                'class' => StringUtil::generateAlias($authorLink['name'])
            ];
        }

        return $links;
    }
}
