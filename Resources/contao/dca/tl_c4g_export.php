<?php

/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    6
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

/**
 * Set Tablename
 */

use con4gis\CoreBundle\Classes\Helper\DcaHelper;

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
		'enableVersioning'            => true/*,

        'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)*/
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
			'all' => [
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			],
            'back' => [
                'href'                => 'key=back',
                'class'               => 'header_back',
                'button_callback'     => ['\con4gis\CoreBundle\Classes\Helper\DcaHelper', 'back'],
                'icon'                => 'back.svg',
                'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
            ],
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG'][$strName]['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
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
		'default'                     => '{title_legend},title;'.
            '{save_legend},saveexport;'.
            '{mail_legend},sendpermail;'.
            '{srcdb_legend},srcdb;'.
            '{srctable_legend},srctable,exportheadlines;'.
            '{srcfields_legend},srcfields;'.
            '{filterstring_legend:hide},filterstring;'.
            '{usequeue_legend},usequeue,useinterval;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'sendpermail'                 => 'mailaddress,sender',
        'saveexport'                  => 'savefolder',
        'useinterval'                 => 'intervalkind,intervalcount',
	),

	// Fields
	'fields' => array
	(
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['title'],
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'rgxp'=>'alnum', 'nospace'=>false, 'spaceToUnderscore'=>true),
        ),
        'srcdb' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['srcdb'],
            'default'                 => 'default',
            'inputType'               => 'select',
            'options_callback'        => array('tl_c4g_export', 'getDatabaseOptions'),
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'submitOnChange'=>true, 'includeBlankOption'=>false, 'chosen'=>false),
        ),
        'srctable' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['srctable'],
            'default'                 => '',
            'inputType'               => 'select',
            'options_callback'        => array('tl_c4g_export', 'getTableOptions'),
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true),
        ),
        'exportheadlines' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['exportheadlines'],
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'clr m12'),
        ),
        'srcfields' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['srcfields'],
            'default'                 => '',
            'inputType'               => 'checkboxWizard',
            'options_callback'        => array('tl_c4g_export', 'getTableFieldOptions'),
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'multiple'=>true),
        ),
        'sendpermail' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['sendpermail'],
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'clr m12', 'submitOnChange'=>true),
        ),
        'mailaddress' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['mailaddress'],
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
        ),
        'sender' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['sender'],
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
        ),
        'saveexport' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['saveexport'],
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'clr m12', 'submitOnChange'=>true),
        ),
        'savefolder' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['savefolder'],
            'default'                 => '',
            'inputType'               => 'fileTree',
            'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr wizard'),
        ),
        'filterstring' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['filterstring'],
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255),
        ),
        'usequeue' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['usequeue'],
            'default'                 => '',
            'inputType'               => 'checkbox',
            'save_callback'           => array(array('\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport', 'cbAddToQueue')),
            'eval'                    => array('tl_class'=>'w50', 'submitOnChange'=>true),
        ),
        'useinterval' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['useinterval'],
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => array('tl_class'=>'w50', 'submitOnChange'=>true),
        ),
        'intervalkind' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['intervalkind'],
            'default'                 => '',
            'inputType'               => 'select',
            'options'                 => array('hourly', 'daily', 'weekly', 'monthly', 'yearly'),
            'reference'               => $GLOBALS['TL_LANG'][$strName]['intervalkind_ref'],
            'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true, 'chosen'=>true),
        ),
        'intervalcount' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['intervalcount'],
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => array('tl_class'=>'w50', 'rgxp'=>'natural'),
        )
	)
);

class tl_c4g_export extends \Backend
{
    public function getDatabaseOptions(DataContainer $dc) {
        $options = ['default' => $GLOBALS['TL_LANG']['tl_c4g_export']['contaodb']];
        foreach ($GLOBALS['con4gis']['export']['databases'] as $key => $value) {
            $options[$key] = $value;
        }
        return $options;
    }

    public function getTableOptions(DataContainer $dc) {
        if ($dc->activeRecord->srcdb === 'default') {
            $tables = $this->getContainer()->get('doctrine')->getManager('default')->getConnection()->getSchemaManager()->listTables();
            $tablesFormatted = [];
            foreach ($tables as $table) {
                $tablesFormatted[$table->getName()] = $table->getName();
            }
            return $tablesFormatted;

        } elseif ($dc->activeRecord->srcdb !== '') {
            $tables = $this->getContainer()->get('doctrine')->getManager($dc->activeRecord->srcdb)->getConnection()->getSchemaManager()->listTables();
            $tablesFormatted = [];
            foreach ($tables as $table) {
                $tablesFormatted[$table->getName()] = $table->getName();
            }
            return $tablesFormatted;
        } else {
            return [];
        }
    }

    public function getTableFieldOptions(DataContainer $dc) {
        if ($dc->activeRecord->srcdb === 'default') {
            if ($dc->activeRecord->srctable !== '' && $dc->activeRecord->srctable !== null) {
                $columns = $this->getContainer()->get('doctrine')->getManager('default')->getConnection()->getSchemaManager()->listTableColumns($dc->activeRecord->srctable);
                $columnsFormatted = [];
                foreach ($columns as $column) {
                    $columnsFormatted[$column->getName()] = $column->getName();
                }
                return $columnsFormatted;
            }
        } elseif ($dc->activeRecord->srcdb !== '') {
            if ($dc->activeRecord->srctable !== '' && $dc->activeRecord->srctable !== null) {
                $columns = $this->getContainer()->get('doctrine')->getManager($dc->activeRecord->srcdb)->getConnection()->getSchemaManager()->listTableColumns($dc->activeRecord->srctable);
                $columnsFormatted = [];
                foreach ($columns as $column) {
                    $columnsFormatted[$column->getName()] = $column->getName();
                }
                return $columnsFormatted;
            }
        } else {
            return [];
        }
        return [];
    }
}
