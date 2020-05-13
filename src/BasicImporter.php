<?php

namespace Sparclex\NovaImportCard;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BasicImporter implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;

    protected $attributes;

    protected $rules;

    protected $modelClass;

    protected $isUpdate;

    public function __construct($resource, $attributes, $rules, $modelClass, $isUpdate = false)
    {
        $this->resource = $resource;
        $this->attributes = $attributes;
        $this->rules = $rules;
        $this->modelClass = $modelClass;
        $this->isUpdate = $isUpdate;
    }

    public function model(array $row)
    {
        [$model, $callbacks] = $this->resource::fill(
            new ImportNovaRequest($row), $this->resource::newModel()
        );

        return $model;
    }

    public function rules(): array
    {
        return $this->rules;
    }
}
