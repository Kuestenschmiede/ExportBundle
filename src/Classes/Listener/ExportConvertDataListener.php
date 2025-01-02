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
        $result = $event->getResult();
        $settings = $event->getSettings();
        $headlines = $settings->getSrcfields();

        if ($event->getSettings()->getCalculator() === '1') {
            if ($event->getSettings()->getCalculatorType() && $event->getSettings()->getCalculatorType() == 'count' && $event->getSettings()->getCalculatorField()) {
                $headlines[] = 'Count';
            }
            if ($event->getSettings()->getCalculatorType() && $event->getSettings()->getCalculatorType() == 'sum' && $event->getSettings()->getCalculatorField()) {
                $headlines[] = 'Sum';
            }
        }

        if ($settings->getLoadChildTableData()) {
            $tables = $settings->getChildTables();
            $formattedTables = [];
            foreach ($tables as $table) {
                $table = explode('.', $table);
                $formattedTables[$table[0]][] = $table[1];
            }
            $database = Database::getInstance();
            foreach ($formattedTables as $key => $columns) {
                $statement = $database->prepare("SELECT * FROM $key");
                $foreignRows = $statement->execute()->fetchAllAssoc();
                if (!empty($foreignRows)) {
                    $statement = $database->prepare(
                        "SELECT max(`count`) as `max` FROM (SELECT pid, count(*) as `count` FROM $key GROUP BY pid) target"
                    );
                    $max = $statement->execute()->fetchAssoc()['max'];
                    if ($max > 0) {
                        $counter = 1;
                        while ($counter <= $max) {
                            foreach ($columns as $column) {
                                $headlines[] = $key.'.'.$column.$counter;
                            }
                            $counter += 1;
                        }
                    }
                }
            }
        }

        if ($settings->getExportheadlines()) {
            $csv[] = '"' . implode('";"', $headlines) . '"';
        } else {
            $csv = [];
        }

        foreach ($result as $row) {
            $escapeQuotationMark = function ($value) {
                return str_replace('"', '""', $value);
            };
            $row = array_map($escapeQuotationMark, $row);
            $removeNewLines = function ($value) {
                return preg_replace('/\n+/', '', $value);
            };
            $row = array_map($removeNewLines, $row);

            $csv[] = '"' . implode('";"', $row) . '"';
        }

        $returnstring = implode(";\n", $csv) . ';';
        $event->setReturnstring($returnstring);
    }
}
