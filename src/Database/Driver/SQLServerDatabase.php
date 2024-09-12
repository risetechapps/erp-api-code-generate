<?php

namespace RiseTech\CodeGenerate\Database\Driver;

use Exception;
use Illuminate\Support\Facades\DB;
use Risetech\CodeGenerate\CodeGenerate;
use RiseTech\CodeGenerate\Contracts\Driver\DatabaseDriverInterface;

class SQLServerDatabase implements DatabaseDriverInterface
{
    /**
     * @throws Exception
     */
    public function getFieldType(string $table): array
    {
        $database = DB::connection()->getDatabaseName();
        $sql = 'SELECT column_name AS "column_name", data_type AS "data_type", character_maximum_length AS "column_length" FROM information_schema.columns ';
        $sql .= 'WHERE table_catalog = :database AND table_name = :table';

        $rows = DB::select($sql, ['database' => $database, 'table' => $table]);

        $fieldType = null;
        $fieldLength = 20;

        foreach ($rows as $col) {
            if (CodeGenerate::field == $col->column_name) {
                $fieldType = $col->data_type;
                if (!empty($col->column_length)) {
                    $fieldLength = $col->column_length;
                }
                break;
            }
        }

        if ($fieldType == null) {
            throw new Exception(CodeGenerate::field . " not found in $table table");
        }

        return ['type' => $fieldType, 'length' => $fieldLength];
    }
}