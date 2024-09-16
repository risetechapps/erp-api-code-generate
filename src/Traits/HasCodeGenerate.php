<?php

namespace RiseTech\CodeGenerate\Traits;

use RiseTech\CodeGenerate\CodeGenerate;
use Illuminate\Support\Facades\Schema;


trait HasCodeGenerate
{
    protected static function bootHasCodeGenerate(): void
    {
        static::creating(/**
         * @throws \Exception
         */ function ($model) {
            if (Schema::hasTable($model->getTable())) {
                $model->code = CodeGenerate::generate($model);
            }

        });

        static::updating(function ($model) {
            $model->code = $model->getOriginal('code');
        });
    }
}
