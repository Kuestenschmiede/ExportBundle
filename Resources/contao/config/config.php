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