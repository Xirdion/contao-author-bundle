<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Author Bundle
 *
 * @copyright  Copyright (c) 2021, Digitalagentur Dreibein GmbH
 * @author     Digitalagentur Dreibein GmbH <https://www.agentur-dreibein.de>
 * @link       https://github.com/dreibein/project-interliving
 */

$table = 'tl_module';

$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'authorArchiveType';
$GLOBALS['TL_DCA'][$table]['palettes']['author'] = '{title_legend},name,type,headline;{config_legend},authorArchiveType;{source_legend},imgSize;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA'][$table]['fields']['authorArchiveType'] = [
    'label' => &$GLOBALS['TL_LANG'][$table]['authorArchiveType'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => [
        'author_news' => &$GLOBALS['TL_LANG'][$table]['authorArchiveTypeNews'],
        'author_calendar' => &$GLOBALS['TL_LANG'][$table]['authorArchiveTypeCalendar'],
        'author_faq' => &$GLOBALS['TL_LANG'][$table]['authorArchiveTypeFAQ'],
    ],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50',
        'submitOnChange' => true,
    ],
    'sql' => ['type' => 'string', 'length' => 255, 'notnull' => true, 'default' => ''],
];
