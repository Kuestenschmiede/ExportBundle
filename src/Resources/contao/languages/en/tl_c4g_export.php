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
$GLOBALS['TL_LANG'][$strName]['title']          = array('Title', 'Please enter the title.');
$GLOBALS['TL_LANG'][$strName]['srcdb']          = array('Database', 'Please choose the source database.');
$GLOBALS['TL_LANG'][$strName]['srctable']       = array('Table', 'Please choose the source table.');
$GLOBALS['TL_LANG'][$strName]['srcfields']      = array('Fields', 'Please choose the fields for export.');
$GLOBALS['TL_LANG'][$strName]['sendpermail']    = array('Send Export', 'Please choose whether to send the export via email.');
$GLOBALS['TL_LANG'][$strName]['mailaddress']    = array('Email Address', 'Please enter the email address.');
$GLOBALS['TL_LANG'][$strName]['sender']         = array('Sender', 'The sender given in the mail. Typically the domain.');
$GLOBALS['TL_LANG'][$strName]['saveexport']     = array('Save Export', 'Please choose whether to save the export.');
$GLOBALS['TL_LANG'][$strName]['savefolder']     = array('Save Location', '.Please choose the save location.');
$GLOBALS['TL_LANG'][$strName]['filterstring']   = array('Conditions', 'Enter additional conditions that will be attached to the WHERE-clause of the generated SQl statement.');
$GLOBALS['TL_LANG'][$strName]['convertData']   = ['Convert data', 'Certain data is converted into another format. However, a re-import is then no longer possible without loss.'];
$GLOBALS['TL_LANG'][$strName]['calculator'] = ['Calculate values', 'New contents in the CSV can be calculated from the field contents.'];
$GLOBALS['TL_LANG'][$strName]['calculatorType'] = ['Calculation type', 'Selection of calculation type.'];
$GLOBALS['TL_LANG'][$strName]['references']['sum'] = 'Make sum';
$GLOBALS['TL_LANG'][$strName]['references']['count'] = 'count entries';
$GLOBALS['TL_LANG'][$strName]['calculatorField'] = ['Field for calculation', 'Which field to calculate with.'];
$GLOBALS['TL_LANG'][$strName]['sortRows'] = ['Sort results', 'Should the results be sorted?'];
$GLOBALS['TL_LANG'][$strName]['sortField'] = ['Sort field', 'Which field should be sorted by?'];
$GLOBALS['TL_LANG'][$strName]['removeDuplicatedRows'] = ['Delete duplicate rows', 'Content identical rows will be deleted in the CSV.'];
$GLOBALS['TL_LANG'][$strName]['loadChildTableData'] = ['Load data from child tables', ''];
$GLOBALS['TL_LANG'][$strName]['childTables'] = ['Child data to load', ''];
$GLOBALS['TL_LANG'][$strName]['exportheadlines']= array('Export Column Names', 'Please choose whether to write the column names into the first column in the export file.');
$GLOBALS['TL_LANG'][$strName]['usequeue']       = array('Process via Queue', 'Process task via queue.');
$GLOBALS['TL_LANG'][$strName]['useinterval']    = array('Interval Execution', 'Please choose whether to repeat the task in a set interval.');
$GLOBALS['TL_LANG'][$strName]['intervalkind']   = array('Interval', 'Please choose the interval in which to repeat the task.');
$GLOBALS['TL_LANG'][$strName]['intervalcount']  = array('Maximum Number of Executions', 'Please choose whether the task should finish after a set number of executions. Leave empty for infinite executions.');


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$strName]['title_legend']           = 'Title';
$GLOBALS['TL_LANG'][$strName]['srcdb_legend']           = 'Database';
$GLOBALS['TL_LANG'][$strName]['srctable_legend']        = 'Table';
$GLOBALS['TL_LANG'][$strName]['srcfields_legend']       = 'Fields';
$GLOBALS['TL_LANG'][$strName]['mail_legend']            = 'Mail Settingsw';
$GLOBALS['TL_LANG'][$strName]['save_legend']            = 'Save Location';
$GLOBALS['TL_LANG'][$strName]['filterstring_legend']    = 'Expert Settings';
$GLOBALS['TL_LANG'][$strName]['usequeue_legend']        = 'Queue Settings';


/**
 * Reference
 */
$GLOBALS['TL_LANG'][$strName]['intervalkind_ref']       = array('hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly');


/**
 * Buttons
 */
$GLOBALS['TL_LANG'][$strName]['new']        = array('New ' . $strElement, 'New ' . $strElement . '');
$GLOBALS['TL_LANG'][$strName]['edit']       = array('Edit ' . $strElement, 'Edit ' . $strElement . ' with ID %s');
$GLOBALS['TL_LANG'][$strName]['copy']       = array('Copy ' . $strElement, 'Copy ' . $strElement . ' with ID %s');
$GLOBALS['TL_LANG'][$strName]['delete']     = array('Delete ' . $strElement, 'Delete ' . $strElement . ' with ID %s');
$GLOBALS['TL_LANG'][$strName]['show']       = array('Show ' . $strElement, 'Show details of the ' . $strElement . 'with ID %s');
$GLOBALS['TL_LANG'][$strName]['runexport']  = ["Run export", "Run the export with ID %s."];

/** Options */
$GLOBALS['TL_LANG'][$strName]['contaodb'] = 'Contao Database';

$GLOBALS['TL_LANG'][$strName]['exportConfirm'] = 'Would you like to export now?';