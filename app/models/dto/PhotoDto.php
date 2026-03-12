<?php
namespace app\models\dto;

class PhotoDto
{
    public int $id;
    public string $title;
    public string $url;

    public static function fromModel($model): self
    {
        $dto = new static();
        $dto->id = $model->id;
        $dto->title = $model->title;
        $dto->url = $model->getUrl();
        return $dto;
    }
}