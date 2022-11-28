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

namespace Xirdion\ContaoAuthorBundle\Tests\Controller\FrontendModule;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\ModuleModel;
use Contao\Template;
use PHPUnit\Framework\TestCase;
use Xirdion\ContaoAuthorBundle\Controller\FrontendModule\AuthorController;
use Symfony\Component\HttpFoundation\Request;

class AuthorControllerTest extends TestCase
{
    /**
     * @var ContaoFramework|\PHPUnit\Framework\MockObject\MockObject
     */
    private $framework;

    protected function setUp(): void
    {
        $this->framework = $this->createMock(ContaoFramework::class);
    }

    public function testAuthorModuleResponseWithInvalidParameters(): void
    {
        $request = new Request();
        $model = $this->getMockBuilder(ModuleModel::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $template = $this->createMock(Template::class);

        $controller = new AuthorController($this->framework);

        $response = $controller->getResponse($template, $model, $request);

        $this->assertSame(204, $response->getStatusCode());
    }
}
