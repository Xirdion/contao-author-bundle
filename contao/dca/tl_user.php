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

$table = 'tl_user';

$GLOBALS['TL_DCA'][$table]['fields']['authorPicture'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorPicture'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => [
        'filesOnly' => true,
        'fieldType' => 'radio',
        'tl_class' => 'w50',
        'extensions' => 'jpg,jpeg,png,gif',
    ],
    'sql' => ['type' => 'binary', 'notnull' => false],
];

$GLOBALS['TL_DCA'][$table]['fields']['authorDescription'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorDescription'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['tl_class' => 'long clr'],
    'sql' => ['type' => 'text', 'notnull' => false],
];

$GLOBALS['TL_DCA'][$table]['fields']['authorLinks'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorLinks'],
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'name' => [
                'label' => &$GLOBALS['TL_LANG'][$table]['authorLinkName'],
                'inputType' => 'text',
            ],
            'link' => [
                'label' => &$GLOBALS['TL_LANG'][$table]['authorLink'],
                'inputType' => 'text',
                'eval' => [
                    'rgxp' => 'url',
                ],
            ],
        ],
    ],
    'sql' => ['type' => 'blob', 'notnull' => false],
];

$GLOBALS['TL_DCA'][$table]['fields']['authorPage'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorPage'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'fieldType' => 'radio',
        'tl_class' => 'w50',
        'dcaPicker' => [
            'do' => 'page',
            'providers' => [
                'pagePicker',
                'newsPicker',
            ],
        ],
    ],

    'sql' => ['type' => 'string', 'length' => 255, 'notnull' => true, 'default' => ''],
];
