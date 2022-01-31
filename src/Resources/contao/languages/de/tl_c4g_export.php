<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2022, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
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
$GLOBALS['TL_LANG'][$strName]['title']          = ['Titel', 'Bitte geben Sie den Titel ein.'];
$GLOBALS['TL_LANG'][$strName]['srcdb']          = ['Datenbank', 'Bitte wählen Sie die Quelldatenbank aus.'];
$GLOBALS['TL_LANG'][$strName]['srctable']       = ['Tabelle', 'Bitte wählen Sie die Quelltabelle aus.'];
$GLOBALS['TL_LANG'][$strName]['srcfields']      = ['Felder', 'Bitte wählen Sie sie Felder für den Export aus.'];
$GLOBALS['TL_LANG'][$strName]['sendpermail']    = ['Export versenden', 'Bitte wählen Sie, ob der Export per Mail versendet werden soll.'];
$GLOBALS['TL_LANG'][$strName]['mailaddress']    = ['E-Mail-Adresse', 'Bitte geben Sie die E-Mail-Adresse ein.'];
$GLOBALS['TL_LANG'][$strName]['sender']         = ['Absender', 'Der Absender, wie er in der Email angegeben wird. Typischerweise die Domain.'];
$GLOBALS['TL_LANG'][$strName]['saveexport']     = ['Export speichern', 'Bitte wählen Sie, ob der Export gespeichert werden soll.'];
$GLOBALS['TL_LANG'][$strName]['savefolder']     = ['Speicherort', 'Bitte wählen Sie den Speicherort aus.'];
$GLOBALS['TL_LANG'][$strName]['filterstring']   = ['Bedingungen', 'Geben Sie hier zusätzliche Bedingungen ein, die an die WHERE-Klausel des generierten SQL-Statements angehängt werden sollen.'];
$GLOBALS['TL_LANG'][$strName]['convertData']   = ['Daten umwandeln', 'Bestimmte Daten werden in ein anderes Format umgewandelt. Ein Wiederimport ist dann aber nicht mehr verlustfrei möglich.'];
$GLOBALS['TL_LANG'][$strName]['calculator'] = ['Werte berechnen', 'Aus den Feldinhalten können neue Inhalte in der CSV berechnet werden.'];
$GLOBALS['TL_LANG'][$strName]['calculatorType'] = ['Berechnungstyp', 'Auswahl des Berechnungstyps.'];
$GLOBALS['TL_LANG'][$strName]['references']['sum'] = 'Summe bilden';
$GLOBALS['TL_LANG'][$strName]['references']['count'] = 'Einträge zählen';
$GLOBALS['TL_LANG'][$strName]['calculatorField'] = ['Feld für die Berechnung', 'Mit welchem Feld soll gerechnet werden.'];
$GLOBALS['TL_LANG'][$strName]['sortRows'] = ['Ergebnisse sortieren', 'Sollen die Ergebnisse sortiert werden?'];
$GLOBALS['TL_LANG'][$strName]['sortField'] = ['Sortierfeld', 'Nach welchem Feld soll sortiert werden?'];
$GLOBALS['TL_LANG'][$strName]['removeDuplicatedRows'] = ['Doppelte Zeilen löschen', 'Inhaltlich identische Zeilen werden in der CSV gelöscht.'];
$GLOBALS['TL_LANG'][$strName]['exportheadlines']= ['Spaltennamen exportieren', 'Bitte wählen Sie, ob die Spaltenüberschriften in der ersten Spalte der Exportdatei stehen sollen.'];
$GLOBALS['TL_LANG'][$strName]['usequeue']       = ['Abarbeitung über Warteschlange', 'Auftrag über Warteschlange abarbeiten.'];
$GLOBALS['TL_LANG'][$strName]['useinterval']    = ['Intervallausführung', 'Bitte wählen Sie aus, ob der Auftrag in einem bestimmten Intervall wiederholt ausgeführt werden soll.'];
$GLOBALS['TL_LANG'][$strName]['intervalkind']   = ['Intervall', 'Bitte legen Sie das Intervall fest, in dem der Auftrag wiederholt werden soll.'];
$GLOBALS['TL_LANG'][$strName]['intervalcount']  = ['Maximale Anzahl der Ausführungen', 'Bitte legen Sie fest, ob der Auftrag nach einer bestimmten Anzahl von Ausführungen beendet sein soll. Für unendliche Ausführung bitte leer lassen.'];


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$strName]['title_legend']           = 'Titel';
$GLOBALS['TL_LANG'][$strName]['srcdb_legend']           = 'Datenbank';
$GLOBALS['TL_LANG'][$strName]['srctable_legend']        = 'Tabelle';
$GLOBALS['TL_LANG'][$strName]['srcfields_legend']       = 'Felder';
$GLOBALS['TL_LANG'][$strName]['mail_legend']            = 'Maileinstellungen';
$GLOBALS['TL_LANG'][$strName]['save_legend']            = 'Speicherort';
$GLOBALS['TL_LANG'][$strName]['filterstring_legend']    = 'Experteneinstellungen';
$GLOBALS['TL_LANG'][$strName]['usequeue_legend']        = 'Einstellungen für die Warteschlange';


/**
 * Reference
 */
$GLOBALS['TL_LANG'][$strName]['intervalkind_ref']       = ['hourly' => 'stündlich', 'daily' => 'täglich', 'weekly' => 'wöchentlich', 'monthly' => 'monatlich', 'yearly' => 'jährlich'];


/**
 * Buttons
 */
$GLOBALS['TL_LANG'][$strName]['new']        = ['Neuer ' . $strElement, 'Neuen ' . $strElement . ' anlegen'];
$GLOBALS['TL_LANG'][$strName]['edit']       = [$strElement . ' bearbeiten', $strElement . ' mit der ID %s bearbeiten'];
$GLOBALS['TL_LANG'][$strName]['copy']       = [$strElement . ' kopieren', $strElement . ' mit der ID %s kopieren'];
$GLOBALS['TL_LANG'][$strName]['delete']     = [$strElement . ' löschen', $strElement . ' mit der ID %s löschen'];
$GLOBALS['TL_LANG'][$strName]['show']       = [$strElement . ' anzeigen', 'Details des ' . $strElement . 's mit der ID %s anzeigen'];
$GLOBALS['TL_LANG'][$strName]['runexport']  = ["Export ausführen", "Den Export mit der ID %s ausführen."];

/** Options */
$GLOBALS['TL_LANG'][$strName]['contaodb'] = 'Contao Datenbank';
