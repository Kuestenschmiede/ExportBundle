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
namespace con4gis\ExportBundle\Classes\Events;

use Symfony\Contracts\EventDispatcher\Event;
use con4gis\ExportBundle\Entity\TlC4gExport;

/**
 * Class ExportLoadDataEvent
 * @package con4gis\ExportBundle\Classes\Events
 */
class ExportLoadDataEvent extends Event
{
    /**
     * Name des Events
     */
    const NAME = 'con4gis.export.load.data';

    /**
     * Entity mit den Einstellungen für den Export
     * @var null
     */
    protected $settings = null;

    /**
     * Kommagetrennte Liste der Felder
     * @var string
     */
    protected $fieldlist = '';

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var array
     */
    protected $result = [];

    /**
     * Array mit den geladenen Daten.
     * @var array
     */
    protected $data = [];

    /**
     * @return TlC4gExport
     */
    public function getSettings() : TlC4gExport
    {
        return $this->settings;
    }

    /**
     * @param TlC4gExport $settings
     */
    public function setSettings(TlC4gExport $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return string
     */
    public function getFieldlist(): string
    {
        return $this->fieldlist;
    }

    /**
     * @param string $fieldlist
     */
    public function setFieldlist(string $fieldlist)
    {
        $this->fieldlist = $fieldlist;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query)
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @param array $result
     */
    public function setResult(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Fügt der Ausgabe eine oder mehrere Zeilen hinzu.
     * @param $newdata
     */
    public function addData($newdata)
    {
        if ($newdata) {
            $data = $this->getData();

            if (is_array($newdata) && count($newdata)) {
                $data = array_merge($data, $newdata);
            } elseif (is_string($newdata)) {
                $data[] = $newdata;
            } else {
                $data[] = serialize($newdata);
            }

            $this->setData($data);
        }
    }
}
