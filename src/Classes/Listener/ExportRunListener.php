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
namespace con4gis\ExportBundle\Classes\Listener;

use con4gis\ExportBundle\Classes\Events\ExportConvertDataEvent;
use con4gis\ExportBundle\Classes\Events\ExportLoadDataEvent;
use con4gis\ExportBundle\Classes\Events\ExportMailDataEvent;
use con4gis\ExportBundle\Classes\Events\ExportRunEvent;
use con4gis\ExportBundle\Classes\Events\ExportSaveDataEvent;
use Contao\Input;
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
        $settings = $event->getSettings();

        $where = Input::get('where');
        if ($where) {
            $settings->setFilterstring(html_entity_decode($where));
        }

        $lang = $event->getLang();
        $event->addData($lang['MSC']['export']['loadheadline']);
        $loadEvent = new ExportLoadDataEvent();
        $loadEvent->setSettings($settings);
        $dispatcher->dispatch($loadEvent, $loadEvent::NAME);
        $result = $loadEvent->getResult();
        $fields = $settings->getSrcfields();
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
        $settings = $event->getSettings();
        $result = $event->getResult();
        $lang = $event->getLang();
        $event->addData($lang['MSC']['export']['convertheadline']);
        $convertEvent = new ExportConvertDataEvent();
        $convertEvent->setSettings($settings);
        $convertEvent->setResult($result);
        $dispatcher->dispatch($convertEvent, $convertEvent::NAME);
        $csvstring = $convertEvent->getReturnstring();
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
        $settings = $event->getSettings();
        $lang = $event->getLang();
        $event->addData($lang['MSC']['export']['saveheadline']);

        if ($settings->getSaveexport()) {
            $retrunstring = $event->getReturnstring();
            $filname = $event->getFilename();
            $foldername = $event->getFoldername();
            $lang = $event->getLang();
            $saveEvent = new ExportSaveDataEvent();
            $saveEvent->setSettings($settings);
            $saveEvent->setLang($lang);
            $saveEvent->setReturnstring($retrunstring);
            $saveEvent->setFilename($filname);
            $saveEvent->setFoldername($foldername);
            $dispatcher->dispatch($saveEvent, $saveEvent::NAME);
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
        $settings = $event->getSettings();
        $lang = $event->getLang();
        $event->addData($lang['MSC']['export']['mailheadline']);

        if ($settings->getSendpermail()) {
            $retrunstring = $event->getReturnstring();
            $filname = $event->getFilename();
            $foldername = $event->getFoldername();
            $lang = $event->getLang();
            $websiteTitle = $event->getWebsitetile();
            $adminEmail = $event->getAdminmail();
            $characterSet = $event->getCharset();
            $mailEvent = new ExportMailDataEvent();
            $mailEvent->setSettings($settings);
            $mailEvent->setLang($lang);
            $mailEvent->setReturnstring($retrunstring);
            $mailEvent->setFilename($filname);
            $mailEvent->setFoldername($foldername);
            $mailEvent->setWebsitetile($websiteTitle);
            $mailEvent->setAdminmail($adminEmail);
            $mailEvent->setCharset($characterSet);
            $dispatcher->dispatch($mailEvent, $mailEvent::NAME);
            $output = $mailEvent->getData();
            $event->addData($output);
        } else {
            $event->addData($lang['MSC']['export']['mailnotuesed']);
        }
    }
}
