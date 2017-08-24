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
 * @copyright Küstenschmiede GmbH Software & Design 2017
 * @link      https://www.kuestenschmiede.de
 */

/**
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['ExportConfirm'] = 'Wollen Sie den Export jetzt durchführen?';


/**
 * Export-Strings
 */
$GLOBALS['TL_LANG']['MSC']['export']['loadheadline']    = '<h3>Laden der Daten</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['loadresult']      = '<p>Es wurden %s Felder von %s Datensätze geladen.</p>';
$GLOBALS['TL_LANG']['MSC']['export']['convertheadline'] = '<h3>Konvertieren der Daten</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['convertresult']   = "<p>Es wurden %s Datensätze konvertiert. Der CSV-String ist %s Zeichen lang.</p>";
$GLOBALS['TL_LANG']['MSC']['export']['saveheadline']    = '<h3>Speichern der Daten</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['savenotused']     = '<p style="color: #bbb;">Der Export wird nicht gespeichert!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['saveresult']      = "<p>Der Export wurde erfolgreich in der Datei '%s' gespeichert. Es wurden %s Bytes geschrieben.</p>";
$GLOBALS['TL_LANG']['MSC']['export']['saveerror']       = '<p style="color: red;">Das Speichern des Exports ist fehlgeschlagen!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['mailheadline']    = '<h3>Versenden der Daten</h3>';
$GLOBALS['TL_LANG']['MSC']['export']['mailnotuesed']    = '<p style="color: #bbb;">Der Export wird nicht versendet!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['mailsubject']     = 'Export-Mail von %s';
$GLOBALS['TL_LANG']['MSC']['export']['mailtext']        = "Hallo,\n\n es wurde ein Export für Sie erstellt. Sie finden ihn im Anhang dieser Mail.\n\nViele Grüße,\nIhr Team von \"%s\"";
$GLOBALS['TL_LANG']['MSC']['export']['mailerror']       = '<p style="color: red;">Das Versenden des Exports ist fehlgeschlagen!</p>';
$GLOBALS['TL_LANG']['MSC']['export']['mailsuccess']     = '<p>Der Export wurde erfolgreich an die E-Mail-Adresse "%s" versendet.</p>';
