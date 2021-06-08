<?php
/*
 * This file is part of con4gis, the gis-kit for Contao CMS.
 * @package con4gis
 * @version 8
 * @author con4gis contributors (see "authors.txt")
 * @license LGPL-3.0-or-later
 * @copyright (c) 2010-2021, by Küstenschmiede GmbH Software & Design
 * @link https://www.con4gis.org
 */
namespace con4gis\ExportBundle\Classes\Listener;

use con4gis\CoreBundle\Classes\C4GUtils;
use con4gis\CoreBundle\Classes\Helper\ArrayHelper;
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
        $settings = $event->getSettings();
        $fieldlist = $event->getFieldlist();
        $table = $settings->getSrctable();
        $query = "SELECT $fieldlist FROM $table";
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
        $query = $event->getQuery();
        $settings = $event->getSettings();
        $where = html_entity_decode($settings->getFilterstring());

        if ($where) {
            $where = str_replace(';', '', $where); // rudimentäre SQL-Injection-Protection!
            $where = str_replace('WHERE', '', $where);
            $query .= " WHERE $where";
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
            if ($event->getSettings()->getCalculator() === '1') {
                if ($event->getSettings()->getCalculatorType() && $event->getSettings()->getCalculatorField()) {
                    $calculatorType = $event->getSettings()->getCalculatorType();
                    $fieldName = $event->getSettings()->getCalculatorField();
                    $tableName = $event->getSettings()->getSrctable();
                    switch ($calculatorType) {
                        case 'count':
                            foreach ($result as $key => $row) {
                                $count = 0;
                                foreach ($row as $k => $value) {
                                    if ($k == $fieldName) {
                                        $query = 'SELECT COUNT('.$fieldName.') AS count FROM '.$tableName.' WHERE '.$fieldName.'='.$value;
                                        $statement = $entityManager->getConnection()->prepare($query);
                                        $statement->execute();
                                        $countResult = $statement->fetch();
                                        if ($result) {
                                            $count = $countResult['count'];
                                        }
                                        break;
                                    }
                                }
                                $result[$key]['Count'] = $count;
                            }
                            break;
                        case 'sum':
                            foreach ($result as $key => $row) {
                                $sum = 0;
                                foreach ($row as $k => $value) {
                                    if ($k == $fieldName) {
                                        $query = 'SELECT SUM('.$fieldName.') AS sum FROM '.$tableName;
                                        $statement = $entityManager->getConnection()->prepare($query);
                                        $statement->execute();
                                        $countResult = $statement->fetch();
                                        if ($result) {
                                          $sum = $countResult['sum'];
                                        }
                                        break;
                                    }
                                }
                                $result[$key]['Sum'] = $sum;
                            }
                            break;
                    }
                }
            }

            if ($event->getSettings()->getSortRows() === '1') {
                $fieldName = $event->getSettings()->getSortField();
                if ($fieldName) {
                    $result = ArrayHelper::array_sort($result,$fieldName);
                }
            }

            if ($event->getSettings()->getConvertData() === '1') {
                foreach ($result as $key => $row) {
                    foreach ($row as $k => $value) {
                        if (strlen(strval(intval($value))) === 10) {
                            if (strpos(strtolower($k), 'time')) {
                                $result[$key][$k] = date($GLOBALS['TL_CONFIG']['timeFormat'], $value);
                            } elseif (strpos(strtolower($k), 'date')) {
                                $result[$key][$k] = date($GLOBALS['TL_CONFIG']['dateFormat'], $value);
                            } else {
                                $result[$key][$k] = date($GLOBALS['TL_CONFIG']['datimFormat'], $value);
                            }
                        } elseif (strlen(strval(intval($value))) === 5) {
                            if (strpos(strtolower($k), 'time')) {
                                $result[$key][$k] = date($GLOBALS['TL_CONFIG']['timeFormat'], $value);
                            }
                        } elseif (is_array(StringUtil::deserialize($value)) === true && !empty(StringUtil::deserialize($value))) {
                            $result[$key][$k] = implode(', ', array_filter($this->flattenArray(StringUtil::deserialize($value))));
                        }
                    }
                }
            }

            if ($event->getSettings()->getRemoveDuplicatedRows() === '1') {
                foreach ($result as $key => $row) {
                    $rowCount = 0;
                    foreach ($result as $key2 => $row2) {
                        if ($row == $row2) {
                            $rowCount++;
                        }
                    }
                    if ($rowCount > 1) {
                        unset($result[$key]);
                    }
                }
            }

            $event->setResult($result);
        }
    }

    private function recursivelyDeserializeArray($value)
    {
        $source = StringUtil::deserialize($value);
        $result = [];
        foreach ($source as $k => $v) {
            if (is_array($v)) {
                array_merge($result, $this->recursivelyDeserializeArray($v));
            } else {
                $result[] = $v;
            }
        }

        return $result;
    }

    private function flattenArray($arr)
    {
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($arr));

        return iterator_to_array($it, true);
    }

    private function filterEmptyArrayElements()
    {
    }
}
