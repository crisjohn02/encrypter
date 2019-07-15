<?php
namespace Crisjohn02\Encrypter\Traits;

use Illuminate\Support\Facades\Schema;

trait HasSalt
{

    protected static function bootHasSalt()
    {
        static::creating(function($model) {
            if (!Schema::hasColumn($model->getTable(), config('encrypter.salt_column'))) {
                throw new \RuntimeException('User salt field does not exist!');
            }
            $model->{config('encrypter.salt_column')} = static::salt();
        });
    }

    protected static function salt()
    {
        return 'base64:' . base64_encode(random_bytes(config('app.cipher') == 'AES-128-CBC' ? 16 : 32));
    }


}