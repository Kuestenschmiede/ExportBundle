<?php
/**
 * @package     con4gis
 * @filesource  GetEventHelper.php
 * @version     1.0.0
 * @since       29.09.17 - 12:20
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2017
 * @license     EULA
 */
namespace con4gis\ExportBundle\Classes\Helper;

use Contao\Config;
use Contao\FilesModel;
use Contao\InsertTags;
use Contao\System;

class GetEventHelper
{
    /**
     * Instanz von doctrine.orm.default_entity_manager
     * @var null|object
     */
    protected $entityManager = null;


    /**
     * ModulExport constructor.
     * @param null $em
     * @param null $dispatcher
     */
    public function __construct($em = null, $dispatcher = null)
    {
        if (($em !== null)) {
            $this->entityManager = $em;
        } else {
            $this->entityManager = System::getContainer()->get('doctrine.orm.default_entity_manager');
        }

        System::loadLanguageFile('default');
    }


    /**
     * Erzeugt das Event für den Export.
     * @param $exportId
     * @return ExportRunEvent
     */
    public function getExportEvent($exportId)
    {
        $exportSettings = $this->getSettings($exportId);
        $filename       = $this->parseFilename($exportSettings);
        $foldername     = $this->getPath($exportSettings);
        $event          = new \con4gis\ExportBundle\Classes\Events\ExportRunEvent();

        $this->getPath($exportSettings);
        $event->setFilename($filename);
        $event->setFolderName($foldername);
        $event->setSettings($exportSettings);
        $event->setLang($GLOBALS['TL_LANG']);
        $event->setWebsitetile(Config::get('websiteTitle'));
        $event->setAdminmail(Config::get('adminEmail'));
        $event->setCharset(Config::get('characterSet'));

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
