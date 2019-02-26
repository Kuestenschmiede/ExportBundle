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

$GLOBALS['con4gis']['export']['installed'] = true;

$GLOBALS['BE_MOD']['con4gis'] = array_merge($GLOBALS['BE_MOD']['con4gis'], array(
    'export' => array(
        'tables'        => array('tl_c4g_export'),
        'runexport'     => array('\con4gis\ExportBundle\Classes\Contao\Modules\ModulExport', 'runExport')
    )
));


/**
 * EXPORT-SETTINGS
 */
$GLOBALS['con4gis']['export']['filename'] = "{{date}}_{{time}}_{{export::title}}.csv";