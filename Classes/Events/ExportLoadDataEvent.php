<?php
/**
 * con4gis
 * @version   php 7
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2011 - 2018
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\ExportBundle\Classes\Events;

use Symfony\Component\EventDispatcher\Event;

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
    protected $result = array();


    /**
     * Array mit den geladenen Daten.
     * @var array
     */
    protected $data = array();


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
