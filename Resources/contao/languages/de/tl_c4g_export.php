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
$GLOBALS['TL_LANG'][$strName]['exportheadlines']= array('Spaltennamen exportieren', 'Bitte wählen Sie, ob die Spaltenüberschriften in der ersten Spalte der Exportdatei stehen sollen.');
$GLOBALS['TL_LANG'][$strName]['usequeue']       = array('Abarbeitung über Warteschlange', 'Auftrag über Warteschlange abarbeiten.');
$GLOBALS['TL_LANG'][$strName]['useinterval']    = array('Intervallausführung', 'Bitte wählen Sie aus, ob der Auftrag in einem bestimmten Intervall wiederholt ausgeführt werden soll.');
$GLOBALS['TL_LANG'][$strName]['intervalkind']   = array('Intervall', 'Bitte legen Sie das Intervall fest, in dem der Auftrag wiederholt werden soll.');
$GLOBALS['TL_LANG'][$strName]['intervalcount']  = array('Maximale Anzahl der Ausführungen', 'Bitte legen Sie fest, ob der Auftrag nach einer bestimmten Anzahl von Ausführungen beendet sein soll. Für unendliche Ausführung bitte leer lassen.');


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
