<?php
/**
 * @package     con4gis
 * @filesource  TlCon4gisExport.php
 * @version     1.0.0
 * @since       27.04.17 - 17:53
 * @author      Patrick Froch <info@easySolutionsIT.de>
 * @link        http://easySolutionsIT.de
 * @copyright   e@sy Solutions IT 2017
 * @license     EULA
 */
namespace con4gis\ExportBundle\Classes\Contao\Callbacks;

use Contao\Controller;
use Contao\Image;

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
            $link   = '<a href="' . Controller::addToUrl($href) . '&id=' . $arrRow['id'];
            $link  .= '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label);
            $link  .= '</a> ';
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

        if ($row['sendpermail'] && $row['mailaddress'] == '')
        {
            return false;
        }

        $fields = deserialize($row['srcfields'], true);

        if (!count($fields)) {
            return false;
        }

        return true;
    }
}
