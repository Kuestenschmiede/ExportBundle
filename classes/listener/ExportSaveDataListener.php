<?php
/**
 * con4gis
 * @version   2.0.0
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2016 - 2017.
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\exportBundle\classes\listener;

use con4gis\exportBundle\classes\events\ExportSaveDataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportSaveDataListener
 * @package con4gis\exportBundle\classes\listener
 */
class ExportSaveDataListener
{


    /**
     * Speichert den CSV-String auf dem Server.
     * @param ExportSaveDataEvent           $event
     * @param                               $eventName
     * @param EventDispatcherInterface      $dispatcher
     */
    public function onExportSaveData(
        ExportSaveDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $lang           = $event->getLang();
        $returnstring   = $event->getReturnstring();
        $filename       = $event->getFilename();
        $foldername     = $event->getFoldername();
        $savepath       = $foldername . $filename;
        $bytes          = file_put_contents($savepath, $returnstring);

        if ($bytes !== false) {
            $output = $lang['MSC']['export']['saveresult'];
            $output = sprintf($output, $filename, $bytes);
            $event->addData($output);
        } else {
            $event->addData($lang['MSC']['export']['saveerror']);
        }
    }
}
