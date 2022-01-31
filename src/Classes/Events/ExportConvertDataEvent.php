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
namespace con4gis\ExportBundle\Classes\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ExportConvertDataEvent
 * @package con4gis\ExportBundle\Classes\Events
 */
class ExportConvertDataEvent extends Event
{
    /**
     * Name des Events
     */
    const NAME = 'con4gis.export.convert.data';

    /**
     * Entity mit den Einstellungen für den Export
     * @var null
     */
    protected $settings = null;

    /**
     * Ergebniss der Db-Abfrage
     * @var array
     */
    protected $result = [];

    /**
     * Ergebnis der Konvertierung.
     * @var string
     */
    protected $returnstring = '';

    /**
     * Array mit den geladenen Daten.
     * @var array
     */
    protected $data = [];

    /**
     * @return object
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param object $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
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
     * @return string
     */
    public function getReturnstring(): string
    {
        return $this->returnstring;
    }

    /**
     * @param string $returnstring
     */
    public function setReturnstring(string $returnstring)
    {
        $this->returnstring = $returnstring;
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
