<?php
/**
 * con4gis
 * @version   2.0.0
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2016 - 2017.
 * @link      https://www.kuestenschmiede.de
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
        $result     = $event->getResult();
        $settings   = $event->getSettings();
        $headlines  = $settings->getSrcfields();

        if ($settings->getExportheadlines()) {
            $csv[] = '"' . implode('";"', $headlines) . '"';
        } else {
            $csv = array();
        }

        foreach ($result as $row) {
            $replaceQuotationMark   = function ($value) {
                return str_replace('"', '\"', $value);
            };
            $temp                   = array_map($replaceQuotationMark, $row);
            $csv[]                  = '"' . implode('";"', $row) . '"';
        }

        $returnstring = implode(";\n", $csv) . ';';
        $event->setReturnstring($returnstring);
    }
}
