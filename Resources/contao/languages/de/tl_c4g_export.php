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
 * Set Elementname
 */
$strElement = 'Export';


/**
 * Fields
 */
$GLOBALS['TL_LANG'][$strName]['title']          = array('Titel', 'Bitte geben Sie den Titel ein.');
$GLOBALS['TL_LANG'][$strName]['srctable']       = array('Tabelle', 'Bitte wählen Sie die Quelltabelle aus.');
$GLOBALS['TL_LANG'][$strName]['srcfields']      = array('Felder', 'Bitte wählen Sie sie Felder für den Export aus.');
$GLOBALS['TL_LANG'][$strName]['sendpermail']    = array('Export versenden', 'Bitte wählen Sie, ob der Export per Mail versendet werden soll.');
$GLOBALS['TL_LANG'][$strName]['mailaddress']    = array('E-Mail-Adresse', 'Bitte geben Sie die E-Mail-Adresse ein.');
$GLOBALS['TL_LANG'][$strName]['saveexport']     = array('Export speichern', 'Bitte wählen Sie, ob der Export gespeichert werden soll.');
$GLOBALS['TL_LANG'][$strName]['savefolder']     = array('Speicherort', 'Bitte wählen Sie den Speicherort aus.');
$GLOBALS['TL_LANG'][$strName]['filterstring']   = array('Bedingungen', 'Geben Sie hier zusätzliche Bedingungen ein, die an die WHERE-Klausel des generierten SQL-Statements angehängt werden sollen.');
$GLOBALS['TL_LANG'][$strName]['exportheadlines']= array('Spaltennamen exportieren', 'Bitte wählen Sie, ob die Spaltenüberschrieften in der ersten Spalte der Exportdatei stehen sollen.');
$GLOBALS['TL_LANG'][$strName]['usequeue']       = array('Abarbeitung über Warteschlange', 'Auftrag über Warteschlange abarbeiten.');
$GLOBALS['TL_LANG'][$strName]['useinterval']    = array('Intervallausführung', 'Bitt wählen Sie aus, ober der Auftrag in einem bestimmten Intervall wiederholt ausgeführt werden soll.');
$GLOBALS['TL_LANG'][$strName]['intervalkind']   = array('Intervall', 'Bitt legen Sie das Intervall fest, in dem der Auftrag wiederholt werden soll.');
$GLOBALS['TL_LANG'][$strName]['intervalcount']  = array('Maximale Anzahl der Ausführungen', 'Bitt legen Sie fest, ob der Auftrag nach einer bestimmten Anzahl von Ausführungen beendet sein soll. Für unendliche Ausführung bitte leer lassen.');


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$strName]['title_legend']           = 'Titel';
$GLOBALS['TL_LANG'][$strName]['srctable_legend']        = 'Tabelle';
$GLOBALS['TL_LANG'][$strName]['srcfields_legend']       = 'Felder';
$GLOBALS['TL_LANG'][$strName]['mail_legend']            = 'Maileinstellungen';
$GLOBALS['TL_LANG'][$strName]['save_legend']            = 'Speicherort';
$GLOBALS['TL_LANG'][$strName]['filterstring_legend']    = 'Experteneinstellungen';
$GLOBALS['TL_LANG'][$strName]['usequeue_legend']        = 'Einstellungen für die Warteschlange';


/**
 * Reference
 */
$GLOBALS['TL_LANG'][$strName]['intervalkind_ref']       = array('hourly' => 'stündlich', 'daily' => 'täglich', 'weekly' => 'wöchentlich', 'monthly' => 'monatlich', 'yearly' => 'jährlich');


/**
 * Buttons
 */
$GLOBALS['TL_LANG'][$strName]['new']        = array('Neuer ' . $strElement, 'Neuen ' . $strElement . ' anlegen');
$GLOBALS['TL_LANG'][$strName]['edit']       = array($strElement . ' bearbeiten', $strElement . ' mit der ID %s bearbeiten');
$GLOBALS['TL_LANG'][$strName]['copy']       = array($strElement . ' kopieren', $strElement . ' mit der ID %s kopieren');
$GLOBALS['TL_LANG'][$strName]['delete']     = array($strElement . ' löschen', $strElement . ' mit der ID %s löschen');
$GLOBALS['TL_LANG'][$strName]['show']       = array($strElement . ' anzeigen', 'Details des ' . $strElement . 's mit der ID %s anzeigen');
