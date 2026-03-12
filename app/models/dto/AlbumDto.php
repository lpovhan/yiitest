<?php

namespace app\models\dto;

class AlbumDto
{
    public int $id;
    public string $title;

    public static function fromModel($model): self
    {
        $dto = new static();
        $dto->id = $model->id;
        $dto->title = $model->title;
        return $dto;
    }
}