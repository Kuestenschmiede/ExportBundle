<?php

namespace con4gis\ExportBundle\Migration;

use con4gis\PwaBundle\Entity\WebPushConfiguration;
use Contao\CoreBundle\Migration\MigrationInterface;
use Contao\CoreBundle\Migration\MigrationResult;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;

class UpdateArraysMigration implements MigrationInterface
{

    private array $exportConfigFields = [
        'srcfields',
        'customFields',
        'childTables',
        'columnLabels',
        'idMappings'
    ];

    public function __construct(
        private readonly Connection $connection,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function getName(): string
    {
        return "con4gis_export_update_arrays_migration";
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->createSchemaManager();

        if (
            !$schemaManager->tablesExist([
                'tl_c4g_export',
            ])
        ) {
            return false;
        }

        $columns = array_column($schemaManager->listTableColumns('tl_c4g_export'), 'name');
        $existingFields = array_intersect($this->exportConfigFields, $columns);
        if (empty($existingFields)) {
            return false;
        }

        $sql = "SELECT " . implode(',', $existingFields) . " FROM tl_c4g_export";
        $exportConfigs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        foreach ($exportConfigs as $config) {
            foreach ($existingFields as $field) {
                if (isset($config[$field]) && $this->checkForSerializedValue($config[$field])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function run(): MigrationResult
    {
        $schemaManager = $this->connection->createSchemaManager();
        $columns = array_column($schemaManager->listTableColumns('tl_c4g_export'), 'name');
        $existingFields = array_intersect($this->exportConfigFields, $columns);
        if (empty($existingFields)) {
            return new MigrationResult(true, "Keine Migration erforderlich.");
        }

        $sql = "SELECT id, " . implode(',', $existingFields) . " FROM tl_c4g_export";
        $exportConfigs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        $updatedExportConfigs = 0;
        $this->logger->info("Running migration...");

        foreach ($exportConfigs as $config) {
            $updates = [];
            $params = [];

            if (isset($config['srcfields']) && $this->checkForSerializedValue($config['srcfields'])) {
                $srcfields = StringUtil::deserialize($config['srcfields'], true);
                $updates[] = "srcfields = ?";
                $params[] = implode(",", $srcfields);
            }

            if (isset($config['childTables']) && $this->checkForSerializedValue($config['childTables'])) {
                $childTables = StringUtil::deserialize($config['childTables'], true);
                $updates[] = "childTables = ?";
                $params[] = implode(",", $childTables);
            }

            if (isset($config['customFields']) && $this->checkForSerializedValue($config['customFields'])) {
                $customFields = StringUtil::deserialize($config['customFields'], true);
                $updates[] = "customFields = ?";
                $params[] = json_encode($customFields);
            }

            if (isset($config['columnLabels']) && $this->checkForSerializedValue($config['columnLabels'])) {
                $columnLabels = StringUtil::deserialize($config['columnLabels'], true);
                $updates[] = "columnLabels = ?";
                $params[] = json_encode($columnLabels);
            }

            if (isset($config['idMappings']) && $this->checkForSerializedValue($config['idMappings'])) {
                $idMappings = StringUtil::deserialize($config['idMappings'], true);
                $updates[] = "idMappings = ?";
                $params[] = json_encode($idMappings);
            }

            if (!empty($updates)) {
                $params[] = $config['id'];
                $updateSql = "UPDATE tl_c4g_export SET " . implode(", ", $updates) . " WHERE id = ?";
                $this->connection->executeQuery($updateSql, $params);
                $updatedExportConfigs++;
            }
        }

        return new MigrationResult(
            true,
            sprintf(
                "Es wurden %d Export-Konfigurationen aktualisiert",
                $updatedExportConfigs
            )
        );
    }

    private function checkForSerializedValue($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        if (
            str_starts_with($value, "a:")
            || str_starts_with($value, "O:")
            || str_starts_with($value, "i:")
        ) {
            // serialized array, object or int
            return true;
        }

        return false;
    }
}