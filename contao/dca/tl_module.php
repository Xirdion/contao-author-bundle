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

$table = 'tl_module';

$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'authorArchiveType';
$GLOBALS['TL_DCA'][$table]['palettes']['author'] = '{title_legend},name,type,headline;{config_legend},authorArchiveType;{source_legend},imgSize;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA'][$table]['fields']['authorArchiveType'] = [
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
