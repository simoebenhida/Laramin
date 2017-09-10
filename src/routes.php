<?php
    Route::group(['as' => 'laramin.'], function () {
        $namespaceController = '\\'.config('Laramin.namespaceControllers');

        Route::get('login', ['uses' => "{$namespaceController}\LaraminUserLoginController@showLoginForm", 'as' => 'login']);
        Route::post('login', [ 'uses' => "{$namespaceController}\LaraminUserLoginController@postLogin", 'as' => 'postlogin' ]);
        Route::get('logout', [ 'uses' => "{$namespaceController}\LaraminUserLoginController@logout", 'as' => 'logout' ]);

        Route::group(['middleware' => ['laramin.user']], function () use ($namespaceController) {
            Route::get('/', ['uses' => "{$namespaceController}\LaraminHomeController@index",'as' => 'index']);
            Route::get('/dashboard', ['uses' => "{$namespaceController}\LaraminHomeController@dashboard",'as' => 'dashboard']);

             //Database
            Route::group(['middleware' => ['laramin.permission'],'prefix' => 'database', 'as' => 'database.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\LaraminDatabaseController@browse",'as' => 'browse']);
                Route::get('/create', ['uses' => "{$namespaceController}\LaraminDatabaseController@create",'as' => 'add']);
                Route::post('/add', ['uses' => "{$namespaceController}\LaraminDatabaseController@store",'as' => 'store']);
            });

            //Permission
            Route::group(['middleware' => ['laramin.permission'],'prefix' => 'users', 'as' => 'users.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\LaraminPermissionController@users",'as' => 'users']);
            });
            Route::group(['middleware' => ['laramin.permission'],'prefix' => 'roles', 'as' => 'roles.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\LaraminPermissionController@roles",'as' => 'roles']);
            });

            //Models
             try {
            foreach (laramin_menu_slugs() as $key => $value)  {
                Route::resource($value,"{$namespaceController}\LaraminModelController");
            }
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
        } catch (\Exception $e) {
            // do nothing, might just be because table not yet migrated.
        }
            // foreach (laramin_menu_slugs() as $key => $value) {
            //         Route::group(['prefix' => 'models/'.$value,'middleware' => ['admin.permission'], 'as' => 'models.'], function () use ($namespaceController) {
            //         Route::get('/', ['uses' => "{$namespaceController}\LaraminCrudController@index",'as' => 'index']);
            //         Route::get('/create', ['uses' => "{$namespaceController}\LaraminCrudController@create",'as' => 'create']);
            //         Route::post('/add', ['uses' => "{$namespaceController}\LaraminCrudController@store",'as' => 'store']);
            //         Route::get('edit/{type}/{id}',['uses' => "{$namespaceController}\SLBlogCrudController@update",'as' => 'update']);
            //     });
            // }
        });

    });
