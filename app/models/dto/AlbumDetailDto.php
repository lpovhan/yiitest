<?php

namespace app\models\dto;

class AlbumDetailDto extends AlbumDto
{
    public string $first_name;
    public string $last_name;
    public array $photos;

    public static function fromModel($model): self
    {
        $dto = parent::fromModel($model);
        $dto->first_name = $model->user->first_name ?? '';
        $dto->last_name = $model->user->last_name ?? '';
        $dto->photos = array_map(
            fn($p) => PhotoDto::fromModel($p), 
            $model->photos ?? []
        );
        return $dto;
    }
}