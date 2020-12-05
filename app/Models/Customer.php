<?php

namespace App\Models;

use App\Events\CustomerRegistered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'unionid', 'openid', 'mp_openid', 'session_key', 'phone', 'nickname', 'avatar_url',
        'qrcode_url', 'subscribe_scene', 'qr_scene', 'qr_scene_str'
    ];

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
}
