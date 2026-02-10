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
        'columnLabels'
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

        $sql = "SELECT srcfields,customFields,columnLabels FROM tl_c4g_export";
        $exportConfigs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        foreach ($exportConfigs as $config) {
            foreach ($this->exportConfigFields as $field) {
                if ($this->checkForSerializedValue($config[$field])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function run(): MigrationResult
    {
        $updatedExportConfigs = 0;

        $sql = "SELECT id,srcfields,customFields,columnLabels FROM tl_c4g_export";
        $exportConfigs = $this->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();

        if ($this->shouldRun()) {
            $this->logger->info("Running migration...");
            foreach ($exportConfigs as $config) {

                if ($this->checkForSerializedValue($config['srcfields'])) {
                    $srcfields = StringUtil::deserialize($config['srcfields'], true);
                    $srcfields = implode(",", $srcfields);
                }

                if ($this->checkForSerializedValue($config['customFields'])) {
                    $customFields = StringUtil::deserialize($config['customFields'], true);
                    $customFields = json_encode($customFields);
                }

                if ($this->checkForSerializedValue($config['columnLabels'])) {
                    $columnLabels = StringUtil::deserialize($config['columnLabels'], true);
                    $columnLabels = json_encode($columnLabels);
                }

                $sql = "UPDATE tl_c4g_export SET srcfields = ?, customFields = ?, columnLabels = ? WHERE id=?";
                $this->connection->executeQuery(
                    $sql,
                    [
                        $srcfields ?? $config['srcfields'],
                        $customFields ?? $config['customFields'],
                        $columnLabels ?? $config['columnLabels'],
                        $config['id']
                    ]
                );
                $updatedExportConfigs++;
            }

            return new MigrationResult(
                true,
                sprintf(
                    "Es wurden %d Export-Konfigurationen aktualisiert",
                    $updatedExportConfigs
                )
            );
        } else {

            return new MigrationResult(
                true,
                "Keine Migration erforderlich."
            );
        }

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