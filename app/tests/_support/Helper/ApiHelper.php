<?php

declare(strict_types=1);

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

trait ApiHelper
{
    public function invalidIds(): array
    {
        return [
            'user_not_found' => ['id' => 999999, 'code' => 404],
            'string_id' => ['id' => 'abc', 'code' => 404],
            'negative_id' => ['id' => -1, 'code' => 404],
            'zero_id' => ['id' => 0, 'code' => 404],
            'float_id' => ['id' => 1.5, 'code' => 404],
        ];
    }


    public function invalidPage(): array
    {
        return [
            'string_page' => ['value' => 'abc', 'code' => 400],
            'negative_page' => ['value' => -1, 'code' => 400],
            'zero_page' => ['value' => 0, 'code' => 400],
            'float_page' => ['value' => 1.5, 'code' => 400],
        ];
    }

     public function invalidPageSize(): array
    {
        return [
            'string_pagesize' => ['value' => 'abc', 'code' => 400],
            'negative_pagesize' => ['value' => -1, 'code' => 400],
            'zero_pagesize' => ['value' => 0, 'code' => 400],
            'float_pagesize' => ['value' => 1.5, 'code' => 400],
        ];
    }
}
