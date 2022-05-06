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
namespace con4gis\ExportBundle\Classes\Listener;

use con4gis\CoreBundle\Classes\Helper\ArrayHelper;
use con4gis\CoreBundle\Resources\contao\models\C4gLogModel;
use con4gis\ExportBundle\Classes\Events\ExportLoadDataEvent;
use Contao\Controller;
use Contao\Database;
use Contao\StringUtil;
use Contao\System;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Exception;
use Throwable;

/**
 * Class ExportLoadDataListener
 * @package con4gis\ExportBundle\Classes\Listener
 */
class ExportLoadDataListener
{
    private EntityManagerInterface $entityManager;
    private array $foreignKeyValues = [];

    /**
     * @param ExportLoadDataEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @return void
     * @throws \Doctrine\DBAL\Exception
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

        $this->entityManager = System::getContainer()->get('doctrine')->getManager($settings->getSrcdb());
        $connection = $this->entityManager->getConnection();
        if (method_exists($connection, 'createSchemaManager')) {
            $columns = $connection->createSchemaManager()->listTableColumns($table);
        } else {
            $columns = $connection->getSchemaManager()->listTableColumns($table);
        }

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
     * @param ExportLoadDataEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @return void
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
     * @param ExportLoadDataEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @return void
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
     * @param $string
     * @param $chunk
     * @return mixed|string
     */
    public function prepend($string, $chunk)
    {
        if (!empty($chunk) && isset($chunk)) {
            return $string . $chunk;
        }

        return $string;
    }

    /**
     * @param ExportLoadDataEvent $event
     * @param $eventName
     * @param EventDispatcherInterface $dispatcher
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function onExportLoadExecuteQuery(
        ExportLoadDataEvent $event,
        $eventName,
        EventDispatcherInterface $dispatcher
    ) {
        $query = $event->getQuery();
        $settings = $event->getSettings();
        $this->entityManager = System::getContainer()->get('doctrine')->getManager($settings->getSrcdb());
        $statement = $this->entityManager->getConnection()->prepare($query);
        $result = $statement->executeQuery()->fetchAllAssociative();

        if (count($result) >= 1) {
            if ($settings->getCalculator() === '1') {
                if ($settings->getCalculatorType() && $settings->getCalculatorField()) {
                    $calculatorType = $settings->getCalculatorType();
                    $fieldName = $settings->getCalculatorField();
                    $tableName = $settings->getSrctable();
                    switch ($calculatorType) {
                        case 'count':
                            foreach ($result as $key => $row) {
                                $count = 0;
                                foreach ($row as $k => $value) {
                                    if ($k == $fieldName) {
                                        $query = 'SELECT COUNT(' . $fieldName . ') AS count FROM ' . $tableName . ' WHERE ' . $fieldName . '=' . $value;
                                        $statement = $this->entityManager->getConnection()->prepare($query);
                                        $countResult = $statement->executeQuery()->fetchOne();
                                        if ($countResult) {
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
                                        $query = 'SELECT SUM(' . $fieldName . ') AS sum FROM ' . $tableName;
                                        $statement = $this->entityManager->getConnection()->prepare($query);
                                        $countResult = $statement->executeQuery()->fetchOne();
                                        if ($countResult) {
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

            if ($settings->getSortRows() === '1') {
                $fieldName = $settings->getSortField();
                if ($fieldName) {
                    $result = ArrayHelper::array_sort($result, $fieldName);
                }
            }

            if ($settings->getConvertData() === '1') {
                $table = $settings->getSrctable();
                System::loadLanguageFile($table);
                Controller::loadDataContainer($table);
                $dcaFields = $GLOBALS['TL_DCA'][$table]['fields'];
                $hasValidDcaFields = is_array($dcaFields) && !empty($dcaFields);
                foreach ($result as $key => $row) {
                    foreach ($row as $k => $value) {
                        if ($hasValidDcaFields && isset($dcaFields[$k]['foreignKey'])) {
                            $foreignKey = $dcaFields[$k]['foreignKey'];
                            $foreignKey = explode('.', $foreignKey);
                            if (count($foreignKey) === 2) {
                                if (!is_array($this->foreignKeyValues[$foreignKey[0]][$foreignKey[1]])) {
                                    try {
                                        $this->fillForeignKeyValues($foreignKey[0], $foreignKey[1]);
                                    } catch (Exception $exception) {
                                        continue;
                                    }
                                }
                                if (
                                    isset($dcaFields[$k]['inputType']) &&
                                    (
                                        $dcaFields[$k]['inputType'] === 'select' ||
                                        $dcaFields[$k]['inputType'] === 'radio'
                                    )
                                ) {
                                    if (
                                        !isset($dcaFields[$k]['eval']) ||
                                        !isset($dcaFields[$k]['eval']['multiple']) ||
                                        $dcaFields[$k]['eval']['multiple'] !== true
                                    ) {
                                        if (
                                            array_key_exists(
                                                $value,
                                                $this->foreignKeyValues[$foreignKey[0]][$foreignKey[1]]
                                            )
                                        ) {
                                            $result[$key][$k] = $this->foreignKeyValues[$foreignKey[0]][$foreignKey[1]][$value];
                                        }
                                    }
                                }
                            }
                        } elseif ($hasValidDcaFields && isset($dcaFields[$k]['reference'])) {
                            if (
                                isset($dcaFields[$k]['inputType']) &&
                                (
                                    $dcaFields[$k]['inputType'] === 'select' ||
                                    $dcaFields[$k]['inputType'] === 'radio'
                                )
                            ) {
                                if (
                                    !isset($dcaFields[$k]['eval']) ||
                                    !isset($dcaFields[$k]['eval']['multiple']) ||
                                    $dcaFields[$k]['eval']['multiple'] !== true
                                ) {
                                    if (array_key_exists($value, $dcaFields[$k]['reference'])
                                    ) {
                                        if (is_array($dcaFields[$k]['reference'][$value])) {
                                            $result[$key][$k] = $dcaFields[$k]['reference'][$value][0];
                                        } else {
                                            $result[$key][$k] = $dcaFields[$k]['reference'][$value];
                                        }
                                    }
                                }
                            }
                        } elseif (
                            $hasValidDcaFields &&
                            isset($dcaFields[$k]['options_callback']) &&
                            is_array($dcaFields[$k]['options_callback'])
                        ) {
                            if (
                                isset($dcaFields[$k]['inputType']) &&
                                (
                                    $dcaFields[$k]['inputType'] === 'select' ||
                                    $dcaFields[$k]['inputType'] === 'radio'
                                )
                            ) {
                                if (
                                    !isset($dcaFields[$k]['eval']) ||
                                    !isset($dcaFields[$k]['eval']['multiple']) ||
                                    $dcaFields[$k]['eval']['multiple'] !== true
                                ) {
                                    try {
                                        $optionsCallback = $dcaFields[$k]['options_callback'];
                                        $callbackClass = $optionsCallback[0];
                                        $object = new $callbackClass();
                                        $method = $optionsCallback[1];
                                        $options = $object->$method($row);
                                    } catch (Throwable $throwable) {
                                        C4gLogModel::addLogEntry('export', $throwable->getMessage());
                                        continue;
                                    }
                                    if (array_key_exists($value, $options)
                                    ) {
                                        $result[$key][$k] = $options[$value];
                                    }
                                }
                            }
                        } elseif (intval($value) && (strpos(strtolower($k), 'time') !== false)) {
                            $result[$key][$k] = date($GLOBALS['TL_CONFIG']['timeFormat'], $value);
                        } elseif (intval($value) && (strpos(strtolower($k), 'date')) !== false) {
                            $result[$key][$k] = date($GLOBALS['TL_CONFIG']['dateFormat'], $value);
                        } elseif (strpos(strtolower($k), 'file') !== false) {
                            try {
                                $file = \FilesModel::findByUuid(StringUtil::binToUuid($value));

                                if ($file && $file->path) {
                                    $result[$key][$k] = $file->path;
                                }
                            } catch (Throwable $throwable) {}
                        } elseif (is_array(StringUtil::deserialize($value)) === true && !empty(StringUtil::deserialize($value))) {
                            $result[$key][$k] = implode(', ', array_filter($this->flattenArray(StringUtil::deserialize($value))));
                        }
                    }
                }
            }

            if ($settings->getRemoveDuplicatedRows() === '1') {
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

    private function flattenArray($arr)
    {
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($arr));

        return iterator_to_array($it, true);
    }

    /**
     * @param string $table
     * @param string $field
     * @return void
     * @throws Exception
     */
    private function fillForeignKeyValues(string $table, string $field)
    {
        $database = Database::getInstance();

        $tables = $database->listTables();
        if (!in_array($table, $tables)) {
            throw new Exception("Unknown table $table.");
        }
        $fields = array_column($database->listFields($table), 'name');
        if (!in_array($field, $fields)) {
            throw new Exception("Unknown column $field in table $table.");
        }

        $statement = $database->prepare("SELECT id, $field FROM $table");
        $result = $statement->execute()->fetchAllAssoc();
        if (!empty($result)) {
            foreach ($result as $row) {
                $this->foreignKeyValues[$table][$field][$row['id']] = $row[$field];
            }
        } else {
            $this->foreignKeyValues[$table][$field] = [];
        }
    }
}
