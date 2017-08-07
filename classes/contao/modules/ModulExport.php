<?php
/**
 * @version   2.0.0
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2016 - 2017.
 * @link      https://www.kuestenschmiede.de
 */

namespace con4gis\exportBundle\classes\contao\modules;

use con4gis\exportBundle\classes\events\ExportRunEvent;
use Contao\BackendTemplate;
use Contao\Config;
use Contao\FilesModel;
use Contao\System;

/**
 * Class ModulExport
 * @package con4gis\exportBundle\classes\contao\modules
 */
class ModulExport
{


    /**
     * Template
     * @var string
     */
    protected $templateName = 'be_mod_export';


    /**
     * @var \Contao\BackendTemplate|null
     */
    protected $template = null;

    /**
     * Instanz von doctrine.orm.default_entity_manager
     * @var null|object
     */
    protected $entityManager = null;


    /**
     * Instanz des Symfony EventDispatchers
     * @var null
     */
    protected $dispatcher = null;


    /**
     * Id der Exportkonfiguration
     * @var int
     */
    protected $exportId = 0;


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

        if ($dispatcher !== null) {
            $this->dispatcher = $dispatcher;
        } else {
            $this->dispatcher = System::getContainer()->get('event_dispatcher');
        }

        System::loadLanguageFile('default');
        $this->template = new BackendTemplate($this->templateName);
        $this->exportId = (isset($_GET ['id'])) ? $_GET['id'] : 0;
        // Contao funktioniert nicht: \Contao\Environment::get('id');
    }


    /**
     * @return int
     */
    public function getExportId(): int
    {
        return $this->exportId;
    }


    /**
     * @param int $exportId
     */
    public function setExportId(int $exportId)
    {
        $this->exportId = $exportId;
    }


    /**
     * Generate the module
     * @param bool $parseTemplate
     * @return string
     */
    public function runExport($parseTemplate = true)
    {
        $exportSettings = $this->getSettings();
        $filename       = $this->parseFilename($exportSettings);
        $foldername     = $this->getPath($exportSettings);
        $event          = new ExportRunEvent();

        $this->getPath($exportSettings);
        $event->setFilename($filename);
        $event->setFolderName($foldername);
        $event->setSettings($exportSettings);
        $event->setLang($GLOBALS['TL_LANG']);
        $event->setWebsitetile(Config::get('websiteTitle'));
        $event->setAdminmail(Config::get('adminEmail'));
        $event->setCharset(Config::get('characterSet'));
        $this->dispatcher->dispatch($event::NAME, $event);
        $content = $event->getData();

        if ($parseTemplate) {
            // Ausgabe Backend
            $this->template->exporttitle = $exportSettings->getTitle();
            $this->template->class       = 'exportoutput';
            $this->template->content     = $content;
            $output                      = $this->template->parse();
        } else {
            // Ausgabe für API-Call
            $output = array_map('strip_tags', $content);
        }

        return $output;
    }


    /**
     * @return mixed
     */
    protected function getSettings()
    {
        $respositoryName    = '\con4gis\exportBundle\Entity\TlCon4gisExport';
        $respository        = $this->entityManager->getRepository($respositoryName);
        $exportSettings     = $respository->find($this->exportId);
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
        $insertTag  = new \Contao\InsertTags();
        $pattern    = $GLOBALS['con4gis']['export']['filename'];
        $pattern    = str_replace('{{export::title}}', $exportSettings->getTitle(), $pattern);
        $pattern    = str_replace('{{time}}', date('H.i'), $pattern);
        $filename   = $insertTag->replace($pattern);
        return $filename;
    }
}
