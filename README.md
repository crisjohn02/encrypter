# Laravel Two-Way Column Encryption

##What this package is all about?
This package will automatically encrypt when storing and decrypt when retrieving eloquent using the laravel encryption method. This can be useful when someone illegally downloaded the database and will render the data useless. The salt is user specific so all data cannot be decrypted in just one salt value. __Please note that once you lose the salt values the encrypted data cannot be decrypted again, so be careful when using this package.__

## Installation
``` bash
composer require crisjohn02/encrypter
```


##### Usage

Create your user table with a `salt` column.

```php
Schema::create('users', function(Blueprint $table) {
    $table->string('salt');
});
```

To automatically create salt values, add trait ``HasSalt`` into your User model

```php
<?php

namespace App\YourNameSpace;

use Illuminate\Database\Eloquent\Model;
use Crisjohn02\Encrypter\Traits\HasSalt;

class User extends Model
{
    use HasSalt;
}
```

In your eloquent model, add trait ``Encryptable``
```php
<?php

namespace App\YourNameSpace;

use Illuminate\Database\Eloquent\Model;
use Crisjohn02\Encrypter\Traits\Encryptable;

class Post extends Model
{
    use Encryptable;
    
    //Specify the encryptable columns
    protected $encryptables = [
        'title',
        'user_id'
    ];
}
```

####Limitation
_Do not use `Encryptable` trait in your user model, this will cause an error when creating new user._

