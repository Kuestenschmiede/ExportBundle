<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @author con4gis contributors (see "authors.md")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2026, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\ExportBundle\Classes\Listener;

use con4gis\ExportBundle\Classes\Events\ExportSaveDataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportSaveDataListener
 * @package con4gis\ExportBundle\Classes\Listener
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
        $lang = $event->getLang();
        $returnstring = $event->getReturnstring();
        $filename = $event->getFilename();
        $foldername = $event->getFoldername();
        $savepath = $foldername . $filename;
        $bytes = file_put_contents($savepath, $returnstring);

        if ($bytes !== false) {
            $output = $lang['MSC']['export']['saveresult'];
            $output = sprintf($output, $filename, $bytes);
            $event->addData($output);
        } else {
            $event->addData($lang['MSC']['export']['saveerror']);
        }
    }
}
