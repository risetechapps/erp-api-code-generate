<?php

namespace RiseTech\CodeGenerate\Contracts\Driver;

interface DatabaseDriverInterface
{
    public function getFieldType(string $table): array;
}
