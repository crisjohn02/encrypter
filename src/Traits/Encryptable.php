<?php
namespace Crisjohn02\Encrypter\Traits;

use Crisjohn02\Encrypter\Encrypter;
use Illuminate\Support\Facades\Auth;

trait Encryptable
{

    private $encrypter;

    protected static function bootEncryptable()
    {
        //if (Auth::check()) {
            static::creating(function($model) {
                $model->encrypter = new Encrypter(Auth::user()->{config('encrypter.salt_column')});
            });
        //}

    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (in_array($key, $this->encryptables) && $value !== '') {
            $value = $this->crypt()->decrypt($value);
        }
        return parent::setAttribute($key, $value);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->encryptables as $key)
        {
            if (isset($attributes[$key]))
                $attributes[$key] = $this->crypt()->decrypt($attributes[$key]);
        }
        return $attributes;
    }

    protected function getSalt()
    {
        return Auth::user()->{config('encypter.salt_column')};
    }

    protected function crypt()
    {
        $crypt = new Encrypter($this->getSalt(), config('app.cipher'));
        return $this->encrypter ?? $crypt;
    }

    public function setEncrypterAttribute(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }
}