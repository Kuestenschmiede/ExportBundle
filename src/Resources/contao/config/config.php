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

$GLOBALS['BE_MOD']['con4gis'] = array_merge($GLOBALS['BE_MOD']['con4gis'], array(
    'c4g_export' => array(
        'brick'     => 'export',
        'tables'    => array('tl_c4g_export'),
        'runexport' => array('\con4gis\ExportBundle\Classes\Contao\Modules\ModulExport', 'runExport'),
        'icon'      => 'bundles/con4giscore/images/be-icons/edit.svg'
    )
));

/**
 * EXPORT-SETTINGS
 */
$GLOBALS['con4gis']['export']['filename'] = "{{date}}_{{time}}_{{export::title}}.csv";

/** Non-default databases (doctrine only)
 * To add: $GLOBALS['con4gis']['export']['databases'][$key] = $value;
 *  where $key is the connection name as defined in the config.yml and $value the browser output in the select field.
 */

$GLOBALS['con4gis']['export']['databases'] = [];
