<?php

namespace App\Models;

use App\Events\CustomerRegistered;
use App\Models\Traits\BsTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

/**
 * 客户表
 *
 * Class Customer
 * @package App\Models
 */
class Customer extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes, BsTableTrait;

    protected $fillable = [
        'unionid', 'openid', 'mp_openid', 'session_key', 'phone', 'nickname', 'avatar_url',
        'qrcode_url', 'mp_qrcode_url', 'subscribe_scene', 'qr_scene', 'qr_scene_str', 'parent_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     * bsTable 中不为null的检索字段
     *
     * @return string[]
     */
    public function bsWhereNotNull() : array
    {
        return ['phone'];
    }

    /**
     * 模型的事件映射
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CustomerRegistered::class
    ];

    /**
     * 邀请订单
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shareOrders()
    {
        return $this->hasMany('App\Models\ShareOrder');
    }

    /**
     * 收益
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function income()
    {
        return $this->hasOne('App\Models\CustomerIncome');
    }

    /**
     * 用户昵称
     *
     * @param $value
     * @return string
     */
    public function getNicknameAttribute($value)
    {
        return $value ?? '神秘人';
    }

    /**
     * 海报生成使用的二维码
     *    小程序码 或 公众号码
     *
     * @return string
     */
    public function getQrcodeUrlAttribute(): string
    {
        return $this->mp_qrcode_url;
    }

    /**
     * 是否绑定手机号码
     *
     * @return bool
     */
    public function hasBindPhone() : bool
    {
        return $this->phone ?? false;
    }

    /**
     * 是否关注公众号
     *
     * @return bool
     */
    public function hasSubscribeMp() : bool
    {
        return $this->mp_openid ?? false;
    }


    public function updateToken(string $name, array $abilities = ['*'])
    {
        $token = $this->tokens()->updateOrCreate(
            [
                'tokenable_type' => 'App\Models\Customer',
                'tokenable_id' => $this->id,
            ],
            [
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            ]
        );

        return new NewAccessToken($token, $token->id.'|'.$plainTextToken);
    }

    /**
     * 用户数据总计
     *
     * @return array
     */
    public function scopeTotalUser() : array
    {
        $totalPhone = $this->whereNotNull('phone')->count();
        $totalUser = $this->count();

        return compact('totalPhone', 'totalUser');
    }
}
