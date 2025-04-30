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
namespace con4gis\ExportBundle\Classes\Listener;

use con4gis\ExportBundle\Classes\Events\ExportConvertDataEvent;
use Contao\Database;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportConvertDataListener
 * @package con4gis\ExportBundle\Classes\Listener
 */
class ExportConvertDataListener
{
    /**
     * Konvertiert die Daten vom Array in einen CSV-String.
     * @param ExportConvertDataEvent   $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportConvertGenCsv(
        ExportConvertDataEvent $event,
                               $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $result   = $event->getResult();
        $settings = $event->getSettings();
        $headlines = $settings->getSrcfields();

        // add calculator generated columns
        if ($settings->getCalculator() === '1') {
            if ($settings->getCalculatorType() === 'count' && $settings->getCalculatorField()) {
                $headlines[] = 'Count';
            }
            if ($settings->getCalculatorType() === 'sum' && $settings->getCalculatorField()) {
                $headlines[] = 'Sum';
            }
        }

        // add child‐table columns
        if ($settings->getLoadChildTableData()) {
            $tables = $settings->getChildTables();
            $formatted = [];
            foreach ($tables as $table) {
                list($tbl,$col) = explode('.', $table);
                $formatted[$tbl][] = $col;
            }
            $db = Database::getInstance();
            foreach ($formatted as $tbl => $cols) {
                $rows = $db->prepare("SELECT * FROM $tbl")->execute()->fetchAllAssoc();
                if (!empty($rows)) {
                    $max = $db
                        ->prepare("SELECT max(`count`) as `max` FROM (SELECT pid, count(*) as `count` FROM $tbl GROUP BY pid) t")
                        ->execute()
                        ->max
                    ;
                    for ($i=1; $i<=$max; $i++) {
                        foreach ($cols as $col) {
                            $headlines[] = "$tbl.$col$i";
                        }
                    }
                }
            }
        }

        // fetch custom fields and column label overrides
        $rawLabels    = $settings->getColumnLabels();
        $customFields = $settings->getCustomFields();
        $preLine      = $settings->getPreLine();

        // flatten raw array
        $columnLabels = [];
        if (!empty($rawLabels) && \is_array($rawLabels)) {
            foreach ($rawLabels as $row) {
                if (isset($row['field'], $row['label']) && $row['label'] !== '') {
                    $columnLabels[$row['field']] = $row['label'];
                }
            }
        }

        // override any headlines
        if (!empty($columnLabels)) {
            foreach ($headlines as $i => $field) {
                if (isset($columnLabels[$field]) && $columnLabels[$field] !== '') {
                    $headlines[$i] = $columnLabels[$field];
                }
            }
        }

        // append custom‐field labels to the header
        if (!empty($customFields)) {
            foreach ($customFields as $cf) {
                $headlines[] = $cf['name'];
            }
        }

        // optional preLine
        $csv = [];
        if ($preLine) {
            $csv[] = $preLine;
        }

        // building CSV array headlines
        if ($settings->getExportheadlines()) {
            $csv[] = '"' . implode('";"', $headlines) . '"';
        }

        // helper functions for escaping
        $escape = fn($v) => str_replace('"','""',$v);
        $stripNl = fn($v) => preg_replace('/\n+/', '', $v);

        // building CSV array rows
        foreach ($result as $row) {
            // escape and strip new‐lines
            $row = array_map($escape, $row);
            $row = array_map($stripNl, $row);

            // append each custom value
            if (!empty($customFields)) {
                foreach ($customFields as $cf) {
                    $val = $escape($cf['value']);
                    $val = $stripNl($val);
                    $row[] = $val;
                }
            }

            $csv[] = '"' . implode('";"', $row) . '"';
        }

        // return built CSV
        $returnstring = implode(";\n", $csv) . ';';
        $event->setReturnstring($returnstring);
    }
}
