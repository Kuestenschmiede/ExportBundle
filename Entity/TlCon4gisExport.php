<?php
/**
 * @version   2.0.0
 * @package   con4gis
 * @author    con4gis authors (see "authors.txt")
 * @copyright Küstenschmiede GmbH Software & Design 2016 - 2017.
 * @link      https://www.kuestenschmiede.de
 */
namespace con4gis\ExportBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class TlCon4gisExport
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_con4gis_export")
 * @package con4gis\ExportBundle\Entity
 */
class TlCon4gisExport extends BaseEntity
{


    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = 0;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $tstamp = 0;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $groupid = 0;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $memberid = 0;


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $uuid = '';


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $title = '';


    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $saveexport = '';


    /**
     * @var resource
     * @ORM\Column(type="blob")
     */
    protected $savefolder = null;


    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $sendpermail = '';


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $mailaddress = '';


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $srctable = '';


    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $exportheadlines = '';


    /**
     * @var string
     * @ORM\Column(type="array")
     */
    protected $srcfields = array();


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $filterstring = '';


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
     * @return int
     */
    public function getGroupid(): int
    {
        return $this->groupid;
    }


    /**
     * @param int $groupid
     */
    public function setGroupid(int $groupid)
    {
        $this->groupid = $groupid;
    }


    /**
     * @return int
     */
    public function getMemberid(): int
    {
        return $this->memberid;
    }


    /**
     * @param int $memberid
     */
    public function setMemberid(int $memberid)
    {
        $this->memberid = $memberid;
    }


    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }


    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
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
}
