<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    7
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */
namespace con4gis\ExportBundle\Classes\Listener;

use con4gis\ExportBundle\Classes\Events\ExportConvertDataEvent;
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
