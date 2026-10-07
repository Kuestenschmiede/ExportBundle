<?php

/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @author con4gis contributors (see "authors.md")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2026, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */

use con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport;
use Contao\DC_Table;
use Contao\StringUtil;

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
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
    		],

            'back' => [
                'href'                => 'key=back',
                'class'               => 'header_back',
                'button_callback'     => ['\con4gis\CoreBundle\Classes\Helper\DcaHelper','back'],
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
                'button_callback'     => ['\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport','cbGenerateButton'],
                'attributes'          => 'onclick="if(!confirm(\'' . key_exists($strName,$GLOBALS['TL_LANG']) && key_exists('exportConfirm',$GLOBALS['TL_LANG'][$strName]) ? $GLOBALS['TL_LANG'][$strName]['exportConfirm'] : '' . '\'))return false;Backend.getScrollOffset()"'
            ]
        ]
    ],
	'palettes' => [
		'__selector__'                => ['saveexport','sendpermail','useinterval','calculator','sortRows','loadChildTableData'],
		'default'                     => '{title_legend},title;' . '{save_legend},saveexport;' . '{mail_legend},sendpermail;' . '{srcdb_legend},srcdb;' . '{srctable_legend},srctable,exportheadlines;' . '{srcfields_legend},srcfields,customFields,columnLabels,idMappings,preLine;' . '{filterstring_legend:hide},filterstring,convertData,calculator,sortRows,removeDuplicatedRows,loadChildTableData;' . '{usequeue_legend},usequeue,useinterval'
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
            'eval'                    => ['mandatory'=>true,'maxlength'=>255,'tl_class'=>'w50','rgxp'=>'alnum','nospace'=>false,'spaceToUnderscore'=>true],
        ],
        'srcdb' => [
            'exclude'                 => true,
            'default'                 => 'default',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export','getDatabaseOptions'],
            'eval'                    => ['mandatory'=>true,'maxlength'=>255,'tl_class'=>'clr','submitOnChange'=>true,'includeBlankOption'=>false,'chosen'=>false],
        ],
        'srctable' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export','getTableOptions'],
            'eval'                    => ['mandatory'=>true,'maxlength'=>255,'tl_class'=>'clr','submitOnChange'=>true,'includeBlankOption'=>true,'chosen'=>true],
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
            'options_callback'        => ['tl_c4g_export','getTableFieldOptions'],
            'eval'                    => ['mandatory'=>true,'maxlength'=>255,'tl_class'=>'clr','multiple'=>true],
            'save_callback'           => [[TlCon4gisExport::class, 'saveSimpleArrayValue']],
            'load_callback'           => [[TlCon4gisExport::class, 'loadSimpleArrayValue']],
        ],
        'sendpermail' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr m12','submitOnChange'=>true],
        ],
        'mailaddress' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>true,'rgxp'=>'email','maxlength'=>255,'decodeEntities'=>true,'tl_class'=>'w50'],
        ],
        'sender' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['mandatory'=>true,'maxlength'=>255,'tl_class'=>'w50'],
        ],
        'saveexport' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr m12','submitOnChange'=>true],
        ],
        'savefolder' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'fileTree',
            'eval'                    => ['fieldType'=>'radio','tl_class'=>'clr wizard'],
        ],
        'filterstring' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['maxlength'=>1024],
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
            'eval'                    => ['tl_class'=>'clr','submitOnChange'=>true],
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
            'options_callback'        => ['tl_c4g_export','getTableFieldOptions'],
            'eval'                    => ['mandatory'=>true,'tl_class' => 'long clr','includeBlankOption'=>true,'multiple'=>false],
        ],
        'sortRows' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'clr','submitOnChange'=>true],
        ],
        'sortField' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options_callback'        => ['tl_c4g_export','getTableFieldOptions'],
            'eval'                    => ['mandatory'=>true,'tl_class' => 'long clr','includeBlankOption'=>true,'multiple'=>false],
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
            'eval'                    => ['tl_class' => 'clr','submitOnChange' => true],
        ],
        'childTables' => [
            'exclude' => true,
            'default' => '',
            'inputType' => 'checkboxWizard',
            'options_callback' => [\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport::class,'loadChildTableOptions'],
            'eval' => [
                'multiple' => true
            ],
            'save_callback' => [[TlCon4gisExport::class, 'saveSimpleArrayValue']],
            'load_callback' => [[TlCon4gisExport::class, 'loadSimpleArrayValue']],
        ],
        'usequeue' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'save_callback'           => [['\con4gis\ExportBundle\Classes\Contao\Callbacks\TlCon4gisExport','cbAddToQueue']],
            'eval'                    => ['tl_class'=>'w50','submitOnChange'=>true],
        ],
        'useinterval' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'checkbox',
            'eval'                    => ['tl_class'=>'w50','submitOnChange'=>true],
        ],
        'intervalkind' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'select',
            'options'                 => ['hourly','daily','weekly','monthly','yearly'],
            'reference'               => &$GLOBALS['TL_LANG'][$strName]['intervalkind_ref'],
            'eval'                    => ['tl_class'=>'w50','includeBlankOption'=>true,'chosen'=>true],
        ],
        'intervalcount' => [
            'exclude'                 => true,
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['tl_class'=>'w50','rgxp'=>'natural'],
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
                        'eval'      => ['maxlength'=>255,'tl_class'=>'w50'],
                    ],
                    'value' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['fieldValue'],
                        'inputType' => 'text',
                        'eval'      => ['maxlength'=>255,'tl_class'=>'w50'],
                    ],
                ],
            ],
            'save_callback' => [[TlCon4gisExport::class, 'saveJsonValue']],
            'load_callback' => [[TlCon4gisExport::class, 'loadJsonValue']],
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
                        'options_callback' => ['tl_c4g_export','getSrcFieldOptionsForLabels'],
                        'eval'             => ['mandatory'=>false,'tl_class'=>'w50','includeBlankOption'=>true],
                    ],
                    'label' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['newLabel'],
                        'inputType' => 'text',
                        'eval'      => ['maxlength'=>255,'tl_class'=>'w50'],
                    ],
                ],
            ],
            'save_callback' => [[TlCon4gisExport::class, 'saveJsonValue']],
            'load_callback' => [[TlCon4gisExport::class, 'loadJsonValue']],
            'sql'       => "blob NULL",
        ],
        'idMappings' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['idMappings'],
            'exclude'   => true,
            'inputType' => 'multiColumnWizard',
            'eval'      => [
                'tl_class'     => 'clr',
                'columnFields' => [
                    'srcField' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_c4g_export']['mappingSrcField'],
                        'inputType'        => 'select',
                        'options_callback' => ['tl_c4g_export', 'getSrcFieldOptionsForLabels'],
                        'eval'             => ['mandatory' => true, 'tl_class' => 'w25', 'includeBlankOption' => true],
                    ],
                    'targetTable' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_c4g_export']['mappingTargetTable'],
                        'inputType'        => 'select',
                        'options_callback' => ['tl_c4g_export', 'getTableOptions'],
                        'eval'             => ['mandatory' => true, 'tl_class' => 'w25', 'includeBlankOption' => true],
                    ],
                    'targetKey' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['mappingTargetKey'],
                        'inputType' => 'text',
                        'default'   => 'id',
                        'eval'      => ['maxlength' => 64, 'tl_class' => 'w25'],
                    ],
                    'targetField' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_c4g_export']['mappingTargetField'],
                        'inputType' => 'text',
                        'default'   => 'caption',
                        'eval'      => ['mandatory' => true, 'maxlength' => 64, 'tl_class' => 'w25'],
                    ],
                ],
            ],
            'save_callback' => [[TlCon4gisExport::class, 'saveJsonValue']],
            'load_callback' => [[TlCon4gisExport::class, 'loadJsonValue']],
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

    public function getTableOptions($dc = null) {
        $srcdb = 'default';
        if ($dc instanceof \Contao\DataContainer && isset($dc->activeRecord->srcdb) && $dc->activeRecord->srcdb !== '') {
            $srcdb = $dc->activeRecord->srcdb;
        } elseif (is_object($dc) && isset($dc->currentRecord)) {
            $row = \Contao\Database::getInstance()
                ->prepare("SELECT srcdb FROM tl_c4g_export WHERE id=?")
                ->execute($dc->currentRecord)
                ->fetchAssoc();
            if ($row && !empty($row['srcdb'])) {
                $srcdb = $row['srcdb'];
            }
        }

        try {
            $connection = $this->getContainer()->get('doctrine')->getManager($srcdb)->getConnection();
            $schemaManager = method_exists($connection, 'createSchemaManager')
                ? $connection->createSchemaManager()
                : $connection->getSchemaManager();
            $tables = $schemaManager->listTables();
            $tablesFormatted = [];
            foreach ($tables as $table) {
                $tablesFormatted[$table->getName()] = $table->getName();
            }
            natcasesort($tablesFormatted);
            return $tablesFormatted;
        } catch (\Throwable $e) {
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
                natcasesort($columnsFormatted);
                return $columnsFormatted;
            }
        } elseif ($dc->activeRecord->srcdb !== '') {
            if ($dc->activeRecord->srctable !== '' && $dc->activeRecord->srctable !== null) {
                $columns = $this->getContainer()->get('doctrine')->getManager($dc->activeRecord->srcdb)->getConnection()->getSchemaManager()->listTableColumns($dc->activeRecord->srctable);
                $columnsFormatted = [];
                foreach ($columns as $column) {
                    $columnsFormatted[$column->getName()] = $column->getName();
                }
                natcasesort($columnsFormatted);
                return $columnsFormatted;
            }
        } else {
            return [];
        }
        return [];
    }

    /**
     * Return the list of srcfields for populating the label-override selector and idMappings.
     *
     * @param \Contao\DataContainer|\MenAtWork\MultiColumnWizardBundle\Contao\Widgets\MultiColumnWizard|mixed $dcOrWidget
     * @return array
     */
    public function getSrcFieldOptionsForLabels($dcOrWidget)
    {
        $raw = null;
        if ($dcOrWidget instanceof \Contao\DataContainer && $dcOrWidget->activeRecord) {
            $raw = $dcOrWidget->activeRecord->srcfields;
        } elseif (is_object($dcOrWidget) && isset($dcOrWidget->currentRecord)) {
            $id = $dcOrWidget->currentRecord;
            $row = \Contao\Database::getInstance()
                ->prepare("SELECT srcfields FROM tl_c4g_export WHERE id=?")
                ->execute($id)
                ->fetchAssoc();
            $raw = $row ? $row['srcfields'] : null;
        }

        if (empty($raw)) {
            return [];
        }

        $fields = [];
        if (is_array($raw)) {
            $fields = $raw;
        } elseif (is_string($raw)) {
            if (str_starts_with($raw, 'a:') || str_starts_with($raw, 'O:') || str_starts_with($raw, 's:')) {
                $deserialized = StringUtil::deserialize($raw, true);
                $fields = is_array($deserialized) ? $deserialized : [];
            } elseif (str_starts_with($raw, '[') || str_starts_with($raw, '{')) {
                $decoded = json_decode($raw, true);
                $fields = is_array($decoded) ? $decoded : [];
            } elseif (str_contains($raw, ',')) {
                $fields = StringUtil::trimsplit(',', $raw);
            } else {
                $fields = [$raw];
            }
        }

        $opts = [];
        foreach ($fields as $f) {
            if (is_string($f) && $f !== '') {
                $opts[$f] = $f;
            }
        }

        return $opts;
    }
}
