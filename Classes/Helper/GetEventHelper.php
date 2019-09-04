<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    6
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */
namespace con4gis\ExportBundle\Classes\Helper;

use con4gis\ExportBundle\Classes\Events\ExportRunEvent;
use Contao\Config;
use Contao\FilesModel;
use Contao\InsertTags;
use Contao\System;

class GetEventHelper
{
    /**
     * GetEventHelper constructor.
     */
    public function __construct()
    {
        System::loadLanguageFile('default');
    }


    /**
     * @param $exportSettings
     * @return ExportRunEvent
     */
    public function getExportEvent($exportSettings)
    {
        $filename       = $this->parseFilename($exportSettings);
        $foldername     = $this->getPath($exportSettings);
        $event          = new ExportRunEvent();

        $this->getPath($exportSettings);
        $event->setFilename($filename);
        $event->setFolderName($foldername);
        $event->setSettings($exportSettings);
        $event->setLang($GLOBALS['TL_LANG']);
        $event->setWebsitetile(strval(Config::get('websiteTitle')));
        $event->setAdminmail(strval(Config::get('adminEmail')));
        $event->setCharset(strval(Config::get('characterSet')));

        return $event;
    }


    /**
     * Lädt die Einstellungen des Exports.
     * @param $id
     * @return mixed
     */
    protected function getSettings($id)
    {
        $respositoryName    = '\con4gis\ExportBundle\Entity\TlC4gExport';
        $respository        = $this->entityManager->getRepository($respositoryName);
        $exportSettings     = $respository->find($id);

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
        $modleFiles = FilesModel::findByUuid((string)$savefolder);
        $path       = $modleFiles->path;

        return TL_ROOT . '/' . $path . '/';
    }


    /**
     * Erstellt den Dateinamen für die Exportdatei.
     * @param $exportSettings
     * @return string
     */
    protected function parseFilename($exportSettings)
    {
        $pattern    = $GLOBALS['con4gis']['export']['filename'];
        $pattern    = str_replace('{{export::title}}', $exportSettings->getTitle(), $pattern);
        $pattern    = str_replace('{{time}}', date('H.i'), $pattern);
        // replace manual instead of inserttag, because it creates an esi tag into the filename
        $filename   = str_replace('{{date}}', date('d.m.Y'), $pattern);
        return $filename;
    }
}
