<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle.
 * (c) Werbeagentur Dreibein GmbH
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
    'sql' => 'binary(16) NULL',
];

$GLOBALS['TL_DCA'][$table]['fields']['authorDescription'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorDescription'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['tl_class' => 'long clr'],
    'sql' => "varchar(255) NOT NULL default ''",
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
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA'][$table]['fields']['authorPage'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorPage'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'fieldType' => 'radio',
        'tl_class' => 'w50',
        'dcaPicker' => [['providers' => ['pagePicker']]],
    ],
    'sql' => 'blob NULL',
];
