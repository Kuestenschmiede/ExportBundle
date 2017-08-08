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
use con4gis\ExportBundle\Classes\Events\ExportLoadDataEvent;
use con4gis\ExportBundle\Classes\Events\ExportMailDataEvent;
use con4gis\ExportBundle\Classes\Events\ExportRunEvent;
use con4gis\ExportBundle\Classes\Events\ExportSaveDataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportRunListener
 * @package con4gis\ExportBundle\Classes\Listener
 */
class ExportRunListener
{


    /**
     * Führt den Export aus.
     * @param ExportRunEvent            $event
     * @param                           $eventName
     * @param EventDispatcherInterface  $dispatcher
     */
    public function onExportRunLoadData(ExportRunEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $settings   = $event->getSettings();
        $lang       = $event->getLang();
        $event->addData($lang['MSC']['export']['loadheadline']);
        $loadEvent  = new ExportLoadDataEvent();
        $loadEvent->setSettings($settings);
        $dispatcher->dispatch($loadEvent::NAME, $loadEvent);
        $result     = $loadEvent->getResult();
        $fields     = $settings->getSrcfields();
        $resulttext = $lang['MSC']['export']['loadresult'];
        $resulttext = sprintf($resulttext, count($fields), count($result));
        $event->addData($resulttext);
        $event->setResult($result);
    }


    /**
     * Ruft das Konvertieren der Daten vom Array in einen CSV-String auf.
     * @param ExportRunEvent            $event
     * @param                           $eventName
     * @param EventDispatcherInterface  $dispatcher
     */
    public function onExportRunConvertData(ExportRunEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $settings   = $event->getSettings();
        $result     = $event->getResult();
        $lang       = $event->getLang();
        $event->addData($lang['MSC']['export']['convertheadline']);
        $convertEvent = new ExportConvertDataEvent();
        $convertEvent->setSettings($settings);
        $convertEvent->setResult($result);
        $dispatcher->dispatch($convertEvent::NAME, $convertEvent);
        $csvstring  = $convertEvent->getReturnstring();
        $resulttext = $lang['MSC']['export']['convertresult'];
        $resulttext = sprintf($resulttext, count($result), strlen($csvstring));
        $event->addData($resulttext);
        $event->setReturnstring($csvstring);
    }


    /**
     * Führt den Export aus.
     * @param ExportRunEvent            $event
     * @param                           $eventName
     * @param EventDispatcherInterface  $dispatcher
     */
    public function onExportRunSaveData(ExportRunEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $settings   = $event->getSettings();
        $lang       = $event->getLang();
        $event->addData($lang['MSC']['export']['saveheadline']);

        if ($settings->getSaveexport()) {
            $retrunstring   = $event->getReturnstring();
            $filname        = $event->getFilename();
            $foldername     = $event->getFoldername();
            $lang           = $event->getLang();
            $saveEvent      = new ExportSaveDataEvent();
            $saveEvent->setSettings($settings);
            $saveEvent->setLang($lang);
            $saveEvent->setReturnstring($retrunstring);
            $saveEvent->setFilename($filname);
            $saveEvent->setFoldername($foldername);
            $dispatcher->dispatch($saveEvent::NAME, $saveEvent);
            $output = $saveEvent->getData();
            $event->addData($output);
        } else {
            $event->addData($lang['MSC']['export']['savenotused']);
        }
    }


    /**
     * Führt den Export aus.
     * @param ExportRunEvent            $event
     * @param                           $eventName
     * @param EventDispatcherInterface  $dispatcher
     */
    public function onExportRunMailData(ExportRunEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $settings   = $event->getSettings();
        $lang       = $event->getLang();
        $event->addData($lang['MSC']['export']['mailheadline']);

        if ($settings->getSendpermail()) {
            $retrunstring   = $event->getReturnstring();
            $filname        = $event->getFilename();
            $foldername     = $event->getFoldername();
            $lang           = $event->getLang();
            $websiteTitle   = $event->getWebsitetile();
            $adminEmail     = $event->getAdminmail();
            $characterSet   = $event->getCharset();
            $mailEvent      = new ExportMailDataEvent();
            $mailEvent->setSettings($settings);
            $mailEvent->setLang($lang);
            $mailEvent->setReturnstring($retrunstring);
            $mailEvent->setFilename($filname);
            $mailEvent->setFoldername($foldername);
            $mailEvent->setWebsitetile($websiteTitle);
            $mailEvent->setAdminmail($adminEmail);
            $mailEvent->setCharset($characterSet);
            $dispatcher->dispatch($mailEvent::NAME, $mailEvent);
            $output = $mailEvent->getData();
            $event->addData($output);
        } else {
            $event->addData($lang['MSC']['export']['mailnotuesed']);
        }
    }
}
