<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    7
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

$GLOBALS['con4gis']['export']['installed'] = true;

$GLOBALS['BE_MOD']['con4gis'] = array_merge($GLOBALS['BE_MOD']['con4gis'], array(
    'c4g_export' => array(
        'tables'        => array('tl_c4g_export'),
        'runexport'     => array('\con4gis\ExportBundle\Classes\Contao\Modules\ModulExport', 'runExport')
    )
));

//$GLOBALS['BE_MOD']['con4gis'] =
//    \con4gis\CoreBundle\Resources\contao\classes\C4GUtils::sortBackendModules($GLOBALS['BE_MOD']['con4gis']);
/**
 * EXPORT-SETTINGS
 */
$GLOBALS['con4gis']['export']['filename'] = "{{date}}_{{time}}_{{export::title}}.csv";

/** Non-default databases (doctrine only)
 * To add: $GLOBALS['con4gis']['export']['databases'][$key] = $value;
 *  where $key is the connection name as defined in the config.yml and $value the browser output in the select field.
 */

$GLOBALS['con4gis']['export']['databases'] = [];

if(TL_MODE == "BE") {
    $GLOBALS['TL_CSS'][] = '/bundles/con4gisexport/css/con4gis.css';
}