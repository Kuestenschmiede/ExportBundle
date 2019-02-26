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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExportLoadDataListener
 * @package con4gis\ExportBundle\Classes\Listener
 */
class ExportLoadDataListener
{


    /**
     * Instanz von \Contao\Database
     * @var \Contao\Database|null
     */
    protected $database = null;


    /**
     * ExportRunListener constructor.
     * @param null $database
     */
    public function __construct($database = null)
    {
        if ($database !== null) {
            $this->database = $database;
        } else {
            $this->database = Database::getInstance();
        }
    }


    /**
     * Führt den Export aus.
     * @param ExportLoadDataEvent      $event
     * @param                          $eventName
     * @param EventDispatcherInterface $dispatcher
     */
    public function onExportLoadGenFieldlist(
        ExportLoadDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $settings   = $event->getSettings();
        $table      = $settings->getSrctable();
        $srcFields  = $settings->getSrcfields();
        $fields     = deserialize($srcFields, true);

        if (count($fields)) {
            $saveFields = [];

            // Sicherstellen, dass noch alle ausgewählten Felder in der Tabelle existieren!
            foreach ($fields as $field) {
                if ($this->database->fieldExists($field, $table)) {
                    $saveFields[] = $field;
                }
            }

            $fieldlist = implode(',', $saveFields);
            $event->setFieldlist($fieldlist);

            // Ab jetzt nur noch die existierenden Felder verwenden!
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
        $query      = $event->getQuery();
        $result     = $this->database->execute($query);

        if ($result->numRows) {
            $event->setResult($result->fetchAllAssoc());
        }
    }
}
