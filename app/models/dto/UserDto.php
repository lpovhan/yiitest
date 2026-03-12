<?php
namespace app\models\dto;

class UserDto
{
    public int $id;
    public string $first_name;
    public string $last_name;

    public static function fromModel($model): self
    {
        $dto = new static();
        $dto->id = $model->id;
        $dto->first_name = $model->first_name;
        $dto->last_name = $model->last_name;
        return $dto;
    }
}