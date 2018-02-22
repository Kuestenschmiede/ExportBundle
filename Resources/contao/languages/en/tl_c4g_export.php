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
$GLOBALS['TL_LANG'][$strName]['title']          = array('Title', 'Please enter the title.');
$GLOBALS['TL_LANG'][$strName]['srctable']       = array('Table', 'Please choose the source table.');
$GLOBALS['TL_LANG'][$strName]['srcfields']      = array('Fields', 'Please choose the fields for export.');
$GLOBALS['TL_LANG'][$strName]['sendpermail']    = array('Send Export', 'Please choose whether to send the export via email.');
$GLOBALS['TL_LANG'][$strName]['mailaddress']    = array('Email Address', 'Please enter the email address.');
$GLOBALS['TL_LANG'][$strName]['saveexport']     = array('Save Export', 'Please choose whether to save the export.');
$GLOBALS['TL_LANG'][$strName]['savefolder']     = array('Save Location', '.Please choose the save location.');
$GLOBALS['TL_LANG'][$strName]['filterstring']   = array('Conditions', 'Enter additional conditions that will be attached to the WHERE-clause of the generated SQl statement.');
$GLOBALS['TL_LANG'][$strName]['exportheadlines']= array('Export Column Names', 'Please choose whether to write the column names into the first column in the export file.');
$GLOBALS['TL_LANG'][$strName]['usequeue']       = array('Process via Queue', 'Process task via queue.');
$GLOBALS['TL_LANG'][$strName]['useinterval']    = array('Interval Execution', 'Please choose whether to repeat the task in a set interval.');
$GLOBALS['TL_LANG'][$strName]['intervalkind']   = array('Interval', 'Please choose the interval in which to repeat the task.');
$GLOBALS['TL_LANG'][$strName]['intervalcount']  = array('Maximum Number of Executions', 'Please choose whether the task should finish after a set number of executions. Leave empty for infinite executions.');


/**
 * Legends
 */
$GLOBALS['TL_LANG'][$strName]['title_legend']           = 'Title';
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
