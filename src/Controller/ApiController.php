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
namespace con4gis\ExportBundle\Controller;

use con4gis\ExportBundle\Classes\Contao\Modules\ModulExport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiController
 * @package con4gis\ExportBundle\Controller
 */
class ApiController extends AbstractController
{


    /**
     * initialize contao
     */
    protected function initialize()
    {
        $this->container->get('contao.framework')->initialize();
    }


    /**
     * Ruft das Event für den Export auf.
     * @param $id
     * @return JsonResponse
     */
    public function runExportAction($id)
    {
        $this->initialize();
        $export = new ModulExport();
        $export->setExportId($id);
        $output = $export->runExport(false);
        return $this->sendResponse($output);
    }


    /**
     * Erstellt das Response.
     * @param       $output
     * @param int   $status
     * @param array $header
     * @return JsonResponse
     */
    protected function sendResponse($output, $status = 200, $header = array())
    {
        $status = ($status == 200 && (!is_array($output)) || !count($output)) ? 204 : $status;
        $data   = json_encode(['output' => $output]);
        return new JsonResponse($data, $status, $header);
    }
}
