<?php
/**
 * @version   php 7
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2011 - 2018
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\ExportBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class TlC4gExport
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_export")
 * @package con4gis\ExportBundle\Entity
 */
class TlC4gExport extends BaseEntity
{


    /**
     * Id
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = 0;


    /**
     * Timestamp
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $tstamp = 0;


    /**
     * Titel der Exportkonfiguration
     * @var string
     * @ORM\Column(type="string")
     */
    protected $title = '';


    /**
     * Exportdatei speichern
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $saveexport = '';


    /**
     * Speicherort für die Exportdatei
     * @var resource
     * @ORM\Column(type="blob")
     */
    protected $savefolder = null;


    /**
     * Export per Mail versenden
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $sendpermail = '';


    /**
     * Empfängeradressen, für die Exportdatei
     * @var string
     * @ORM\Column(type="string")
     */
    protected $mailaddress = '';


    /**
     * Tabelle, derem Datensätze exportiert werden sollen.
     * @var string
     * @ORM\Column(type="string")
     */
    protected $srctable = '';


    /**
     * Kopfzeile mit Feldnamen exportieren.
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $exportheadlines = '';


    /**
     * Felder, die exportiert werden sollen.
     * @var string
     * @ORM\Column(type="array")
     */
    protected $srcfields = array();


    /**
     * String um nur bestimmte Datensätze zu exportieren
     * @var string
     * @ORM\Column(type="string")
     */
    protected $filterstring = '';


    /**
     * Abarbeitung über die Warteschlange
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $usequeue = '';


    /**
     * Verarbeitungsintervall in der Queue benutzen
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $useinterval = '';


    /**
     * Verarbeitungsintervall in der Queue
     * @var string
     * @ORM\Column(type="string")
     */
    protected $intervalkind = '';


    /**
     * Verarbeitungsanzahl in der Queue
     * @var string
     * @ORM\Column(type="string")
     */
    protected $intervalcount = '';


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }


    /**
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }


    /**
     * @param int $tstamp
     */
    public function setTstamp(int $tstamp)
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }


    /**
     * @return string
     */
    public function getSaveexport(): string
    {
        return $this->saveexport;
    }


    /**
     * @param string $saveexport
     */
    public function setSaveexport(string $saveexport)
    {
        $this->saveexport = $saveexport;
    }


    /**
     * @return Object
     */
    public function getSavefolder()
    {
        return stream_get_contents($this->savefolder);
    }


    /**
     * @param resource $savefolder
     */
    public function setSavefolder($savefolder)
    {
        $this->savefolder = $savefolder;
    }


    /**
     * @return string
     */
    public function getSendpermail(): string
    {
        return $this->sendpermail;
    }


    /**
     * @param string $sendpermail
     */
    public function setSendpermail(string $sendpermail)
    {
        $this->sendpermail = $sendpermail;
    }


    /**
     * @return string
     */
    public function getMailaddress(): string
    {
        return $this->mailaddress;
    }


    /**
     * @param string $mailaddress
     */
    public function setMailaddress(string $mailaddress)
    {
        $this->mailaddress = $mailaddress;
    }


    /**
     * @return string
     */
    public function getSrctable(): string
    {
        return $this->srctable;
    }


    /**
     * @param string $srctable
     */
    public function setSrctable(string $srctable)
    {
        $this->srctable = $srctable;
    }


    /**
     * @return string
     */
    public function getExportheadlines(): string
    {
        return $this->exportheadlines;
    }


    /**
     * @param string $exportheadlines
     */
    public function setExportheadlines(string $exportheadlines)
    {
        $this->exportheadlines = $exportheadlines;
    }


    /**
     * @return array
     */
    public function getSrcfields(): array
    {
        if ($this->srcfields) {
            return deserialize($this->srcfields, true);
        }

        return [];
    }


    /**
     * @param array $srcfields
     */
    public function setSrcfields(array $srcfields)
    {
        $this->srcfields = serialize($srcfields);
    }


    /**
     * @return string
     */
    public function getFilterstring(): string
    {
        return $this->filterstring;
    }


    /**
     * @param string $filterstring
     */
    public function setFilterstring(string $filterstring)
    {
        $this->filterstring = $filterstring;
    }


    /**
     * @return string
     */
    public function getUsequeue(): string
    {
        return $this->usequeue;
    }


    /**
     * @param string $usequeue
     */
    public function setUsequeue(string $usequeue)
    {
        $this->usequeue = $usequeue;
    }


    /**
     * @return string
     */
    public function getUseinterval(): string
    {
        return $this->useinterval;
    }


    /**
     * @param string $useinterval
     */
    public function setUseinterval(string $useinterval)
    {
        $this->useinterval = $useinterval;
    }


    /**
     * @return string
     */
    public function getIntervalkind(): string
    {
        return $this->intervalkind;
    }


    /**
     * @param string $intervalkind
     */
    public function setIntervalkind(string $intervalkind)
    {
        $this->intervalkind = $intervalkind;
    }


    /**
     * @return string
     */
    public function getIntervalcount(): string
    {
        return $this->intervalcount;
    }


    /**
     * @param string $intervalcount
     */
    public function setIntervalcount(string $intervalcount)
    {
        $this->intervalcount = $intervalcount;
    }
}
