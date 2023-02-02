<?php

namespace App\Repositories;

use App\Interfaces\ImportLog as ImportLogInterface;
use App\Models\ImportLog as ImportLogModel;

class ImportLog implements ImportLogInterface
{
    private ImportLogModel $model;

    public function __construct(ImportLogModel $model)
    {
        $this->model =  $model;
    }
    public function create(array $insertableData): void
    {
        $this->model->create($insertableData);
    }
}