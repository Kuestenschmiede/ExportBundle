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
namespace con4gis\ExportBundle\Classes\Contao\Modules;

use Contao\BackendTemplate;
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
     * ModulExport constructor
     */
    public function __construct()
    {
        $this->dispatcher = System::getContainer()->get('event_dispatcher');

        System::loadLanguageFile('default');
        $this->template = new BackendTemplate($this->templateName);
        $this->exportId = (isset($_GET['id'])) ? $_GET['id'] : 0;
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
        $respositoryName = '\con4gis\ExportBundle\Entity\TlC4gExport';
        $respository = System::getContainer()->get('doctrine')->getManager('default')->getRepository($respositoryName);
        $exportSettings = $respository->find($this->exportId);

        $eventHelper = new GetEventHelper();
        $event = $eventHelper->getExportEvent($exportSettings);
        $this->dispatcher->dispatch($event, $event::NAME);
        $content = $event->getData();

        if ($parseTemplate) {
            // Ausgabe Backend
            $this->template->exporttitle = $exportSettings->getTitle();
            $this->template->class = 'exportoutput';
            $this->template->content = $content;
            $output = $this->template->parse();
        } else {
            // Ausgabe für API-Call
            $output = array_map('strip_tags', $content);
        }

        return $output;
    }
}
