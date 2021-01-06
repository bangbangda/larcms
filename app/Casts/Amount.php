<?php
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * 金额类型转换
 *    数据库单位为分，显示单位为元。
 *
 * Class Amount
 * @package App\Casts
 */
class Amount implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return ($value / 100) . ' 元';
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return intval($value * 100);
    }
}