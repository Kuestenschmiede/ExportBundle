<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 *
 * con4gis
 * @version   php 7
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2011 - 2018
 * @link      https://www.kuestenschmiede.de
 */

/**
 * Set Tablename
 */
$strName = 'tl_c4g_export';


/**
 * Table tl_c4g_export
 */
$GLOBALS['TL_DCA'][$strName] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
            'panelLayout'             => 'sort,filter;search,limit',
			'flag'                    => 1
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
            'runexport' => array
            (
                'label'               => &$GLOBALS['TL_LANG'][$strName]['runexport'],
                'href'                => 'key=runexport',
                'icon'                => 'web/bundles/con4gisexport/export.png',
                'button_callback'     => array('\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport', 'cbGenerateButton'),
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['ExportConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            )
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('saveexport', 'sendpermail','useinterval'),
		'default'                     => '{title_legend},title;{save_legend},saveexport;{mail_legend},sendpermail;{srctable_legend},srctable,exportheadlines;{srcfields_legend},srcfields;{filterstring_legend:hide},filterstring;{usequeue_legend},usequeue,useinterval;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'sendpermail'                 => 'mailaddress',
        'saveexport'                  => 'savefolder',
        'useinterval'                 => 'intervalkind,intervalcount',
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['title'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'rgxp'=>'alnum', 'nospace'=>true, 'spaceToUnderscore'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'srctable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['srctable'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('\con4gis\CoreBundle\Classes\Helper\DcaHelper', 'cbGetTables'),
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'exportheadlines' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['exportheadlines'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'clr m12'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'srcfields' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['srcfields'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'checkboxWizard',
            'options_callback'        => array('\con4gis\CoreBundle\Classes\Helper\DcaHelper', 'cbGetFields'),
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'multiple'=>true),
            'sql'                     => "text NOT NULL"
        ),
        'sendpermail' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['sendpermail'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'clr m12', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'mailaddress' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['mailaddress'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'saveexport' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['saveexport'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'clr m12', 'submitOnChange'=>true),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'savefolder' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['savefolder'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr wizard'),
            'sql'                     => "blob NULL"
        ),
        'filterstring' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['filterstring'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'usequeue' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['usequeue'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'save_callback'           => array(array('\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport', 'cbAddToQueue')),
            'eval'                    => array('tl_class'=>'w50', 'submitOnChange'=>true)
        ),
        'useinterval' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['useinterval'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50', 'submitOnChange'=>true)
        ),
        'intervalkind' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['intervalkind'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array('hourly', 'daily', 'weekly', 'monthly', 'yearly'),
            'reference'               => $GLOBALS['TL_LANG'][$strName]['intervalkind_ref'],
            'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true, 'chosen'=>true)
        ),
        'intervalcount' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['intervalcount'],
            'default'                 => '',
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50', 'rgxp'=>'natural')
        )
	)
);
