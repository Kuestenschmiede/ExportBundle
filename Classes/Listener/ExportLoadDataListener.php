<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    6
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */
namespace con4gis\ExportBundle\Classes\Listener;

use Contao\Database;
use con4gis\ExportBundle\Classes\Events\ExportLoadDataEvent;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportLoadDataListener
 * @package con4gis\ExportBundle\Classes\Listener
 */
class ExportLoadDataListener
{
    /**
     * @param ExportLoadDataEvent      $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportLoadGenFieldlist(
        ExportLoadDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $settings = $event->getSettings();
        $table = $settings->getSrctable();
        $srcFields = $settings->getSrcfields();
        $fields = StringUtil::deserialize($srcFields, true);

        $entityManager = System::getContainer()->get('doctrine')->getManager($settings->getSrcdb());
        $columns = $entityManager->getConnection()->getSchemaManager()->listTableColumns($table);

        if (count($fields) >= 1) {
            $saveFields = [];

            // Make sure the fields still exist in the table
            foreach ($fields as $field) {
                foreach ($columns as $column) {
                    if ($field === $column->getName()) {
                        $saveFields[] = $field;
                    }
                }
            }

            $fieldlist = implode(',', $saveFields);
            $event->setFieldlist($fieldlist);

            // Save the changed field list in the settings
            $settings->setSrcfields($saveFields);
            $event->setSettings($settings);
        }
    }


    /**
     * Erstellt die Db-Abfrage zum laden der Daten.
     * @param ExportLoadDataEvent           $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportLoadGenQuery(
        ExportLoadDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $settings   = $event->getSettings();
        $fieldlist  = $event->getFieldlist();
        $table      = $settings->getSrctable();
        $query      = "SELECT $fieldlist FROM $table";
        $event->setQuery($query);
    }


    /**
     * Erstellt die Db-Abfrage zum laden der Daten.
     * @param ExportLoadDataEvent           $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportLoadAddWhere(
        ExportLoadDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $query      = $event->getQuery();
        $settings   = $event->getSettings();
        $where      = $settings->getFilterstring();

        if ($where) {
            $where  = str_replace(';', '', $where); // rudimentäre SQL-Injection-Protection!
            $query .= "WHERE $where";
            $event->setQuery($query);
        }
    }


    /**
     * Führt die Abfrage aus.
     * @param ExportLoadDataEvent           $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportLoadExecuteQuery(
        ExportLoadDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $query = $event->getQuery();
        $entityManager = System::getContainer()->get('doctrine')->getManager($event->getSettings()->getSrcdb());
        $statement = $entityManager->getConnection()->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();

        if (count($result) >= 1) {
            $event->setResult($result);
        }
    }
}
