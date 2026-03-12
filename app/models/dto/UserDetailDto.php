<?php
namespace app\models\dto;

class UserDetailDto extends UserDto
{
    public array $albums;

    public static function fromModel($model): self
    {
        $dto = parent::fromModel($model);
        $dto->albums = array_map(
            fn($a) => AlbumDto::fromModel($a), 
            $model->albums ?? []
        );
        return $dto;
    }
}