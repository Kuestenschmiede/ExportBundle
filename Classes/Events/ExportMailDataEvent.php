<?php
/**
 * con4gis
 * @version   php 7
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2017
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\ExportBundle\Classes\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class ExportMailDataEvent
 * @package con4gis\ExportBundle\Classes\Events
 */
class ExportMailDataEvent extends Event
{


    /**
     * Name des Events
     */
    const NAME = 'con4gis.export.mail.data';


    /**
     * Entity mit den Einstellungen für den Export
     * @var null
     */
    protected $settings = null;


    /**
     * Language-Array
     * @var array
     */
    protected $lang = array();


    /**
     * Webseitentitel
     * @var string
     */
    protected $websitetile = '';


    /**
     * Absendemailadresse
     * @var string
     */
    protected $adminmail = '';


    /**
     * Charset fur die Mail.
     * @var string
     */
    protected $charset = 'utf8';


    /**
     * Ergebnis der Konvertierung.
     * @var string
     */
    protected $returnstring = '';


    /**
     * Name der Verzeichnisses, in dem der Export gespeichert werden soll.
     * @var string
     */
    protected $foldername = '';


    /**
     * Dateiname der Exportdatei
     * @var string
     */
    protected $filename = '';


    /**
     * Array mit den geladenen Daten.
     * @var array
     */
    protected $data = array();


    /**
     * @return null
     */
    public function getSettings()
    {
        return $this->settings;
    }


    /**
     * @param null $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }


    /**
     * @return array
     */
    public function getLang(): array
    {
        return $this->lang;
    }


    /**
     * @param array $lang
     */
    public function setLang(array $lang)
    {
        $this->lang = $lang;
    }


    /**
     * @return string
     */
    public function getWebsitetile(): string
    {
        return $this->websitetile;
    }


    /**
     * @param string $websitetile
     */
    public function setWebsitetile(string $websitetile)
    {
        $this->websitetile = $websitetile;
    }


    /**
     * @return string
     */
    public function getAdminmail(): string
    {
        return $this->adminmail;
    }


    /**
     * @param string $adminmail
     */
    public function setAdminmail(string $adminmail)
    {
        $this->adminmail = $adminmail;
    }


    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }


    /**
     * @param string $charset
     */
    public function setCharset(string $charset)
    {
        $this->charset = $charset;
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
     * @return string
     */
    public function getFoldername(): string
    {
        return $this->foldername;
    }


    /**
     * @param string $foldername
     */
    public function setFoldername(string $foldername)
    {
        $this->foldername = $foldername;
    }


    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }


    /**
     * @param string $filename
     */
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
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