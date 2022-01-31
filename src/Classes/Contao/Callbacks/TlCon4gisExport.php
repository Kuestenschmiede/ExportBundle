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
namespace con4gis\ExportBundle\Classes\Contao\Callbacks;

use con4gis\QueueBundle\Classes\Queue\QueueManager;
use Contao\Controller;
use Contao\Image;
use con4gis\ExportBundle\Classes\Helper\GetEventHelper;
use Contao\Input;

/**
 * Class TlCon4gisExport
 * @package con4gis\ExportBundle\Classes\Contao\Callbacks
 */
class TlCon4gisExport
{
    /**
     * button_callback: Prüft, ob ein Import ausgeführt werden kann.
     * @param $arrRow
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     * @param $strTable
     * @param $arrRootIds
     * @param $arrChildRecordIds
     * @param $blnCircularReference
     * @param $strPrevious
     * @param $strNext
     * @return string
     */
    public function cbGenerateButton($arrRow,
                                     $href,
                                     $label,
                                     $title,
                                     $icon,
                                     $attributes,
                                     $strTable,
                                     $arrRootIds,
                                     $arrChildRecordIds,
                                     $blnCircularReference,
                                     $strPrevious,
                                     $strNext
    ) {
        if ($this->testExport($arrRow)) {
            $link = '<a href="' . Controller::addToUrl($href) . '&id=' . $arrRow['id'];
            $link .= '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label);
            $link .= '</a> ';
        } else {
            $link = '<span style="opacity: 0.4;">' . Image::getHtml($icon, $label) . '</span>';
        }

        return $link;
    }

    /**
     * Prüft, ob die Mindestangaben für einen Import vorliegen.
     * @param $row
     * @return bool
     */
    protected function testExport($row)
    {
        if (!isset($row['srctable']) ||
            !isset($row['srcfields']) ||
            !isset($row['saveexport']) ||
            !isset($row['savefolder']) ||
            !isset($row['sendpermail']) ||
            !isset($row['mailaddress'])
        ) {
            return false;
        }

        if ($row['srctable'] == '') {
            return false;
        }

        if (!$row['saveexport'] && !$row['sendpermail']) {
            return false;
        }

        if ($row['saveexport']) {
            $dir = \FilesModel::findByUuid($row['savefolder']);
            if (!$dir || !is_dir(TL_ROOT . '/' . $dir->path)) {
                return false;
            }
        }

        if ($row['sendpermail'] && $row['mailaddress'] == '') {
            return false;
        }

        $fields = deserialize($row['srcfields'], true);

        if (!count($fields)) {
            return false;
        }

        return true;
    }

    /**
     * submit_callback: Speichert den Import in der Queue.
     * @param $value
     * @param $dc
     * @return mixed
     */
    public function cbAddToQueue($value, $dc)
    {
        if ($value) {
            $eventHelper = new GetEventHelper();
            $event = $eventHelper->getExportEvent($dc->id);
            $qm = new QueueManager();
            $interval = '';
            $intervalcount = '';

            if (Input::post('useinterval')) {
                $interval = Input::post('intervalkind');
                $intervalcount = Input::post('intervalcount');
            }

            $metaData = [
                'srcmodule' => 'export',
                'srctable' => 'tl_c4g_export',
                'srcid' => $dc->id,
                'intervalkind' => $interval,
                'intervalcount' => $intervalcount,
            ];

            if ($intervalcount) {
                $metaData['intervaltorun'] = $intervalcount;
            }

            $qm->addToQueue($event, 1024, $metaData);
        }

        return $value;
    }
}
