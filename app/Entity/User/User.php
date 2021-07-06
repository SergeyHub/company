<?php

namespace App\Entity\User;

use App\Entity\Agency\Agency;
use App\Entity\Clients\Client;
use App\Entity\FavouriteGirl\FavouriteGirl;
use App\Entity\Girl\Girl;
use App\Events\Users\UserDeleted;
use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, Notifiable, SoftDeletes;

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';

    public const TYPE_AGENCY = 'agency';
    public const TYPE_GIRL = 'girl';
    public const TYPE_CLIENT = 'client';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    public static function rolesList(): array
    {
        return [
            self::ROLE_USER => 'User',
            self::ROLE_MODERATOR => 'Moderator',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public static function typesList(): array
    {
        return [
            self::TYPE_GIRL => 'Independent',
            self::TYPE_CLIENT => 'Client',
            /*self::TYPE_AGENCY => 'Agency',*/
        ];
    }

    public function ownGirls() {
        return $this->hasMany(Girl::class, 'user_id');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'role', 'status', 'type', 'last_seen_at', 'online'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => UserDeleted::class,
    ];

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isGirl(): bool
    {
        return $this->type === self::TYPE_GIRL;
    }

    public function isAgency(): bool
    {
        return $this->type === self::TYPE_AGENCY;
    }

    public function isClient(): bool
    {
        return $this->type === self::TYPE_CLIENT;
    }

    public function canReceiveNotifications(): bool
    {
        return !!$this->receive_notifications;
    }

    public function girl()
    {
        return $this->hasOne(Girl::class, 'user_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function agency()
    {
        return $this->hasOne(Agency::class, 'user_id');
    }

    public function favourites()
    {
        return $this->belongsToMany(Girl::class, 'favourite_girls')
            ->using(FavouriteGirl::class);
    }

    /**
     * Девушки, к которым есть доступ к этого пользователя
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function girls()
    {
        return $this->hasMany(UserGirlAccess::class, 'user_id');
    }

    /**
     * Предложения, к которым есть доступ к этого пользователя
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany(UserOfferAccess::class, 'user_id');
    }

    /**
     * @param $girl_id
     * @return bool
     */
    public function hasAccessToGirl($girl_id): bool
    {
        $girl_access = $this->girls()->where('girl_id', $girl_id)->first();
        return !is_null($girl_access);
    }

    /**
     * @param $offer_id
     * @return bool
     */
    public function hasAccessToOffer($offer_id): bool
    {
        $offer_access = $this->offers()->where('offer_id', $offer_id)->first();
        return !is_null($offer_access);
    }

    /**
     * Краткая информация о юзере
     */
    public function getMetaInfo()
    {
        return Cache::tags('user_'.$this->id)
            ->rememberForever('user_meta_'.$this->id, function() {
                $meta = ['type' => $this->type, 'id' => $this->id];
                if($this->isGirl()) {
                    $meta['name'] = $this->girl && $this->girl->name ? $this->girl->name : 'Noname';
                    $meta['avatar'] = $this->girl && $this->girl->avatar ? $this->girl->avatar->getUrl('thumbs') : null;
                    $meta['girl_id'] = $this->girl ? $this->girl->id : null;
                } else {
                    $meta['name'] = $this->client && $this->client->name ? $this->client->name : 'Noname';
                    $meta['avatar'] = null;
                }
                return $meta;
            });
    }

    /**
     * Имя пользователя из анкеты
     * @return string
     */
    public function getName(): string
    {
        if($this->isGirl() && $this->girl && $this->girl->name)
            return $this->girl->name;

        if($this->client && $this->client->name)
            return $this->client->name;

        return 'Noname';
    }

    /**
     * Получение хэша пользователя для поддержки интерком
     * @return string
     * @throws \Throwable
     */
    public function getIntercomHash(): string
    {
        if($this->intercom_hash)
            return $this->intercom_hash;

        $intercom_hash = hash_hmac(
            'sha256',
            $this->id,
            config('intercom.secret_key')
        );

        $this->intercom_hash = $intercom_hash;
        $this->saveOrFail();

        return $intercom_hash;
    }

    /**
     * @param Builder $builder
     * @param BaseFilter $filter
     * @return Builder
     */
    public function scopeFilter(Builder $builder, BaseFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function sendEmailVerificationNotification()
    {

    }

    public function setOnline(): void
    {
        $this->online = true;
        $this->last_seen_at = now();
        $this->save();
    }

    public function setOffline($date): void
    {
        $this->online = false;
        $this->last_seen_at = $date;
        $this->save();
    }

    public function hiddenGirls() {
        return $this->belongsToMany(Girl::class, 'hidden_girls', 'user_id', 'girl_id');
    }
}
