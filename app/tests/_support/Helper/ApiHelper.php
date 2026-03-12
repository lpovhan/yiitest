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
}
