<?php
namespace Crisjohn02\Encrypter\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    protected static function bootHasUuid()
    {
        static::creating(function($model) {
            $model->{$model->getRouteKeyName()} = Uuid::uuid4();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}