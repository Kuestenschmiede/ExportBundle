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
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['ExportConfirm'] = 'Would you like to export now?';


/**
 * Export-Strings
 */
$GLOBALS['TL_LANG']['MSC']['export']['loadheadline']    = '<h3>Loading Data</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['loadresult']      = '<p>%s fields in %s data sets loaded.</p>';
$GLOBALS['TL_LANG']['MSC']['export']['convertheadline'] = '<h3>Converting Data</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['convertresult']   = "<p>%s data sets converted. The CSV-string is %s characters long.</p>";
$GLOBALS['TL_LANG']['MSC']['export']['saveheadline']    = '<h3>Saving Data</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['savenotused']     = '<p style="color: #bbb;">The export will not be saved!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['saveresult']      = "<p>The export was successfully saved in the file '%s'. %s bytes were written.</p>";
$GLOBALS['TL_LANG']['MSC']['export']['saveerror']       = '<p style="color: red;">Das Speichern des Exports ist fehlgeschlagen!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['mailheadline']    = '<h3>Sending Data</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['mailnotuesed']    = '<p style="color: #bbb;">The export will not be sent!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['mailsubject']     = 'Export-Mail of %s';
$GLOBALS['TL_LANG']['MSC']['export']['mailtext']        = "Hello,\n\n an export has been generated for you. You will find it attached to this email.\n\nBest Regards,\nYour \"%s\" team";
$GLOBALS['TL_LANG']['MSC']['export']['mailerror']       = '<p style="color: red;">Sending the export has failed.!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['mailsuccess']     = '<p>The export has successfully been sent to "%s".</p>';
