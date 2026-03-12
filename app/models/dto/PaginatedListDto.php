<?php
namespace app\models\dto;

class PaginatedListDto
{
    public int $id;
    public string $first_name;
    public string $last_name;

    public static function fromDataProvider($dataProvider, $list): array
    {
       return [
            'status' => 'ok',
            'total' => $dataProvider->getTotalCount(),
            'page' => $dataProvider->pagination->getPage() + 1,
            'pageSize' => $dataProvider->pagination->getPageSize(),
            'data' => $list,
        ];  
    }
}