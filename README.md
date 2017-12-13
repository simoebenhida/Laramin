<p align="center"><a href="https://github.com/simoebenhida/Laramin" target="_blank"><img width="400" src="https://i.imgur.com/XQ57dWg.png"></a></p>



# **L**aramin - Small Laravel Admin

<p align="center">
Laramin Screenshot
</p>
<p align="center">
<img width="400" src="https://i.imgur.com/33ikwWg.png">
</p>
<hr>

### Demo
<a href="http://devma.net/package/Laramin" target="_blank">Demo Here</a>

### Getting Started

After creating your new Laravel application you can include the Laramin package with the following command:

```bash
composer require simoja/laramin
```

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### Laravel 5.5 and up

You don't have to do anything else, this package uses the Package Auto-Discovery feature, and should be available as soon as you install it via Composer.

### Laravel 5.4 or 5.3

Add the Laramin service provider to the `config/app.php` file in the `providers` array:

```php
'providers' => [
    // Laravel Framework Service Providers...
    //...

    // Package Service Providers
    Simoja\Laramin\LaraminServiceProvider::class,

    // ...

    // Application Service Providers
    // ...
],
```

Lastly, we can install laramin with simply run It Will Add Some Dummy Data

```bash
php artisan Laramin:install
```

### Seed
Then you need to seed the permissions roles dummy users
Dont forget to launch First
```
composer dump-autoload
```

by adding this lines on `database/seeds/DatabaseSeeder.php
```
$this->call(LaraminDataSeeder::class);
$this->call(LaratrustSeeder::class);
```
and launch
```
php artisan db:seed
```

You will Have Three Config Files Where you can update the Data As You Wish :

`config/laramin.php`</br>

`config/laratrust.php`</br>

`config/laratrust_seeder.php`</br>



And we're all good to go!

To connected There is some dummy data added you can check on Database
Now Launch your website with prefix name by default /admin and enter this dummy credentials and all works fine
>**email:** `superadministrator@app.com`
></br>
>**password:** `password`

### How It Works

When you create a database it creates a migration file and model File also you will dont need to anything on the server side.

If you Created the Database you have to go to Roles and and assign the permissions of the new Database then refresh the page(it will change later) then you can see your new Model on Menu

### Inspired By :

<a href="https://github.com/santigarcor/laratrust">Laratrust</a> For The User Permissions
</br>
<a href="https://github.com/the-control-group/voyager">Voyager</a> The Idea of making a simple Admin Panel



### Contributing

You are more than welcome to contribute to this repo with anything you think is useful. fixes are more than welcome.


