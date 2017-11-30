<?php
/**
 * @version   php 7
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2017
 * @link      https://www.kuestenschmiede.de
 */

namespace con4gis\ExportBundle\Classes\Contao\Modules;

use con4gis\ExportBundle\Classes\Events\ExportRunEvent;
use Contao\BackendTemplate;
use Contao\Config;
use Contao\FilesModel;
use Contao\InsertTags;
use Contao\System;
use con4gis\ExportBundle\Classes\Helper\GetEventHelper;

/**
 * Class ModulExport
 * @package con4gis\ExportBundle\Classes\Contao\Modules
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
        $eventHelper    = new GetEventHelper();
        $event          = $eventHelper->getExportEvent($this->exportId);
        $this->dispatcher->dispatch($event::NAME, $event);
        $content        = $event->getData();
        $exportSettings = $event->getSettings();

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
}
