<?php

/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 10
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2025, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

use Contao\DC_Table;

$strName = 'tl_c4g_export';

$GLOBALS['TL_DCA'][$strName] = [
	'config' => [
		'dataContainer'               => DC_Table::class,
		'enableVersioning'            => true
    ],
	'list' => [
		'sorting' => [
			'mode'                    => 1,
			'fields'                  => ['title'],
            'panelLayout'             => 'sort,filter;search,limit',
			'flag'                    => 1,
            'icon'                    => 'bundles/con4giscore/images/be-icons/con4gis_blue.svg',
        ],
		'label' => [
			'fields'                  => ['title'],
			'format'                  => '%s'
        ],
		'global_operations' => [
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
            ]
        ],
		'operations' => [
			'edit' => [
				'label'               => &$GLOBALS['TL_LANG'][$strName]['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.svg',
            ],
			'copy' => [
				'label'               => &$GLOBALS['TL_LANG'][$strName]['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.svg'
            ],
			'delete' => [
				'label'               => &$GLOBALS['TL_LANG'][$strName]['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.svg',
				'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ],
			'show' => [
				'label'               => &$GLOBALS['TL_LANG'][$strName]['show'],
				'href'                => 'act=show',
				'icon'                => 'show.svg'
            ],
            'runexport' => [
                'label'               => &$GLOBALS['TL_LANG'][$strName]['runexport'],
                'href'                => 'key=runexport',
                'icon'                => 'bundles/con4gisexport/images/be-icons/export.svg',
                'button_callback'     => ['\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport', 'cbGenerateButton'],
                'attributes'          => 'onclick="if(!confirm(\'' . key_exists($strName,$GLOBALS['TL_LANG']) && key_exists('exportConfirm',$GLOBALS['TL_LANG'][$strName]) ? $GLOBALS['TL_LANG'][$strName]['exportConfirm'] : '' . '\'))return false;Backend.getScrollOffset()"'
            ]
        ]
    ],
	'palettes' => [
		'__selector__'                => ['saveexport', 'sendpermail','useinterval','calculator','sortRows','loadChildTableData'],
		'default'                     => '{title_legend},title;'.
            '{save_legend},saveexport;'.
            '{mail_legend},sendpermail;'.
            '{srcdb_legend},srcdb;'.
            '{srctable_legend},srctable,exportheadlines;'.
            '{srcfields_legend},srcfields,customFields,columnLabels,preLine;'.
            '{filterstring_legend:hide},filterstring,convertData,calculator,sortRows,removeDuplicatedRows,loadChildTableData;'.
            '{usequeue_legend},usequeue,useinterval;'
    ],
	'subpalettes' => [
		'sendpermail'                 => 'mailaddress,sender',
        'saveexport'                  => 'savefolder',
        'useinterval'                 => 'intervalkind,intervalcount',
        'calculator'                  => 'calculatorType,calculatorField',
        'sortRows'                    => 'sortField',
        'loadChildTableData'          => 'childTables'
    ],
	'fields' => [
        'title' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'rgxp'=>'alnum', 'nospace'=>false, 'spaceToUnderscore'=>true],
        ],
        'srcdb' => [
            'exclude'                 => true,
            'default'                 => 'default',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export', 'getDatabaseOptions'],
            'eval'                    => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'submitOnChange'=>true, 'includeBlankOption'=>false, 'chosen'=>false],
        ],
        'srctable' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export', 'getTableOptions'],
            'eval'                    => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'submitOnChange'=>true, 'includeBlankOption'=>true, 'chosen'=>true],
        ],
        'exportheadlines' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr m12'],
        ],
        'srcfields' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkboxWizard',
            'options_callback'        => ['tl_c4g_export', 'getTableFieldOptions'],
            'eval'                    => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr', 'multiple'=>true],
        ],
        'sendpermail' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr m12', 'submitOnChange'=>true],
        ],
        'mailaddress' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>true, 'rgxp'=>'email', 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'],
        ],
        'sender' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'],
        ],
        'saveexport' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr m12', 'submitOnChange'=>true],
        ],
        'savefolder' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'fileTree',
            'eval'                    => ['fieldType'=>'radio', 'tl_class'=>'clr wizard'],
        ],
        'filterstring' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['maxlength'=>255],
        ],
        'convertData' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr'],
        ],
        'calculator' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr', 'submitOnChange'=>true],
        ],
        'calculatorType' => [
            'exclude'           => true,
            'inputType'         => 'select',
            'default'           => 'sum',
            'options'           => ['sum','count'],
            'reference'         => &$GLOBALS['TL_LANG'][$strName]['references'],
            'sql'               => "varchar(25) NOT NULL default 'sum'"
        ],
        'calculatorField' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export', 'getTableFieldOptions'],
            'eval'                    => ['mandatory'=>true, 'tl_class' => 'long clr', 'includeBlankOption'=>true, 'multiple'=>false],
        ],
        'sortRows' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr', 'submitOnChange'=>true],
        ],
        'sortField' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export', 'getTableFieldOptions'],
            'eval'                    => ['mandatory'=>true, 'tl_class' => 'long clr', 'includeBlankOption'=>true, 'multiple'=>false],
        ],
        'removeDuplicatedRows' => [
            'exclude'                 => true,
            'default'                 => '1',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr'],
        ],
        'loadChildTableData' => [
            'exclude'                 => true,
            'default'                 => '0',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class' => 'clr', 'submitOnChange' => true],
        ],
        'childTables' => [
            'exclude' => true,
            'default' => '',
            'inputType' => 'checkboxWizard',
            'options_callback' => [\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport::class, 'loadChildTableOptions'],
            'eval' => [
                'multiple' => true
            ]
        ],
        'usequeue' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'save_callback'           => [['\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport', 'cbAddToQueue']],
            'eval'                    => ['tl_class'=>'w50', 'submitOnChange'=>true],
        ],
        'useinterval' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'w50', 'submitOnChange'=>true],
        ],
        'intervalkind' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options'                 => ['hourly', 'daily', 'weekly', 'monthly', 'yearly'],
            'reference'               => &$GLOBALS['TL_LANG'][$strName]['intervalkind_ref'],
            'eval'                    => ['tl_class'=>'w50', 'includeBlankOption'=>true, 'chosen'=>true],
        ],
        'intervalcount' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['tl_class'=>'w50', 'rgxp'=>'natural'],
        ],
        'customFields' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['customFields'],
            'exclude'   => true,
            'inputType' => 'multiColumnWizard',
            'eval'      => [
                'tl_class'     => 'clr',
                'columnFields' => [
                    'name' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['fieldName'],
                        'inputType' => 'text',
                        'eval'      => ['maxlength'=>255, 'tl_class'=>'w50'],
                    ],
                    'value' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['fieldValue'],
                        'inputType' => 'text',
                        'eval'      => ['maxlength'=>255, 'tl_class'=>'w50'],
                    ],
                ],
            ],
            'sql'       => "blob NULL",
        ],
        'columnLabels' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['columnLabels'],
            'exclude'   => true,
            'inputType' => 'multiColumnWizard',
            'eval'      => [
                'tl_class'     => 'clr',
                'columnFields' => [
                    'field' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_c4g_export']['origField'],
                        'exclude'          => true,
                        'inputType'        => 'select',
                        'options_callback' => ['tl_c4g_export', 'getSrcFieldOptionsForLabels'],
                        'eval'             => ['mandatory'=>false, 'tl_class'=>'w50', 'includeBlankOption'=>true],
                    ],
                    'label' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['newLabel'],
                        'inputType' => 'text',
                        'eval'      => ['maxlength'=>255, 'tl_class'=>'w50'],
                    ],
                ],
            ],
            'sql'       => "blob NULL",
        ],
        'preLine' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['preLine'],
            'exclude'   => true,
            'inputType' => 'textarea',
            'eval'      => [
                'tl_class' => 'clr',
                'rows'     => 3,
                'allowHtml'=> false,
            ],
            'sql'       => "text NULL",
        ],
    ]
];

class tl_c4g_export extends \Contao\Backend
{
    public function getDatabaseOptions(\Contao\DataContainer $dc) {
        $options = ['default' => &$GLOBALS['TL_LANG']['tl_c4g_export']['contaodb']];
        foreach ($GLOBALS['con4gis']['export']['databases'] as $key => $value) {
            $options[$key] = $value;
        }
        return $options;
    }

    public function getTableOptions(\Contao\DataContainer $dc) {
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

    public function getTableFieldOptions(\Contao\DataContainer $dc) {
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

    /**
     * Return the list of srcfields for populating the label-override selector.
     *
     * @param \Contao\DataContainer|\MenAtWork\MultiColumnWizardBundle\Contao\Widgets\MultiColumnWizard $dcOrWidget
     * @return array
     */
    public function getSrcFieldOptionsForLabels($dcOrWidget)
    {
        if ($dcOrWidget instanceof \Contao\DataContainer) {
            $raw = $dcOrWidget->activeRecord->srcfields;
        } else {
            $id  = $dcOrWidget->currentRecord;
            $raw = \Contao\Database::getInstance()
                ->prepare("SELECT srcfields FROM tl_c4g_export WHERE id=?")
                ->execute($id)
                ->srcfields;
        }

        $fields = \Contao\System::importStatic('Contao\StringUtil')
            ->deserialize($raw, true);

        $opts = [];
        foreach ($fields as $f) {
            $opts[$f] = $f;
        }

        return $opts;
    }
}
