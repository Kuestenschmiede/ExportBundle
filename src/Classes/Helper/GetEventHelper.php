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
namespace con4gis\ExportBundle\Classes\Helper;

use con4gis\ExportBundle\Classes\Events\ExportRunEvent;
use Contao\Config;
use Contao\FilesModel;
use Contao\System;
use Doctrine\ORM\EntityManager;

class GetEventHelper
{
    /**
     * @var EntityManager
     */
    private $entityManager = null;

    /**
     * GetEventHelper constructor.
     */
    public function __construct()
    {
        System::loadLanguageFile('default');
        $this->entityManager = System::getContainer()->get('doctrine.orm.default_entity_manager');
    }

    /**
     * @param $exportSettings
     * @return ExportRunEvent
     */
    public function getExportEvent($exportSettings)
    {
        $exportSettings = $this->getSettings($exportSettings);
        $filename = $this->parseFilename($exportSettings);
        $foldername = $this->getPath($exportSettings);
        $event = new ExportRunEvent();

        $this->getPath($exportSettings);
        $event->setFilename($filename);
        $event->setFolderName($foldername);
        $event->setSettings($exportSettings);
        $event->setLang($GLOBALS['TL_LANG']);
        $event->setWebsitetile(strval(Config::get('websiteTitle')));
        $event->setAdminmail(strval(Config::get('adminEmail')));
        $event->setCharset(strval(Config::get('characterSet')));
        $event->setCustomFields($exportSettings->getCustomFields());
        $event->setColumnLabels($exportSettings->getColumnLabels());
        $event->setPreLine($exportSettings->getPreLine());

        return $event;
    }

    /**
     * Lädt die Einstellungen des Exports.
     * @param $id
     * @return mixed
     */
    protected function getSettings($id)
    {
        $respositoryName = '\con4gis\ExportBundle\Entity\TlC4gExport';
        $respository = $this->entityManager->getRepository($respositoryName);
        $exportSettings = $respository->find($id);

        return $exportSettings;
    }

    /**
     * Setzt den Pfad für das Speichern des Exports.
     * @param $exportSettings
     * @return string
     */
    protected function getPath($exportSettings)
    {
        $savefolder = $exportSettings->getSavefolder();
        $modleFiles = FilesModel::findByUuid((string) $savefolder);
        $path = $modleFiles->path;
        $rootDir = System::getContainer()->getParameter("kernel.project_dir");

        return $rootDir . '/' . $path . '/';
    }

    /**
     * Erstellt den Dateinamen für die Exportdatei.
     * @param $exportSettings
     * @return string
     */
    protected function parseFilename($exportSettings)
    {
        $pattern = $GLOBALS['con4gis']['export']['filename'];
        $pattern = str_replace('{{export::title}}', $exportSettings->getTitle(), $pattern);
        $pattern = str_replace('{{time}}', date('H.i'), $pattern);
        // replace manual instead of inserttag, because it creates an esi tag into the filename
        $filename = str_replace('{{date}}', date('d.m.Y'), $pattern);

        return $filename;
    }
}
