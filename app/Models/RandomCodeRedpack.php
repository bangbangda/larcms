<?php

namespace App\Models;

use App\Casts\Amount;
use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 随机码发放红包
 *
 * Class RandomCodeRedpack
 * @package App\Models
 */
class RandomCodeRedpack extends Model
{
    use HasFactory, SoftDeletes, BsTableTrait;

    protected $fillable = ['code'];

    protected $casts = [
//        'amount' => Amount::class
    ];

    /**
     * 获取红包金额
     *
     * @param  string  $code
     * @return int
     */
    public function getAmount(string $code): int
    {
        $result = $this->select('amount')
            ->where('code', $code)->where(function (Builder $query) {
            $query->whereNull('receive_status')
                ->orWhere('receive_status', 'error');
        })->firstOrFail();

        return $result['amount'];
    }
}
