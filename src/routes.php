<?php
    Route::group(['as' => 'laramin.'], function () {
        $namespaceController = '\\'.config('laramin.namespaceControllers');

        Route::get('login', ['uses' => "{$namespaceController}\LaraminUserLoginController@showLoginForm", 'as' => 'login']);
        Route::post('login', [ 'uses' => "{$namespaceController}\LaraminUserLoginController@postLogin", 'as' => 'postlogin' ]);
        Route::post('logout', [ 'uses' => "{$namespaceController}\LaraminUserLoginController@logout", 'as' => 'logout' ]);

        Route::group(['middleware' => ['laramin.user']], function () use ($namespaceController) {
            Route::get('/', ['uses' => "{$namespaceController}\LaraminHomeController@index",'as' => 'index']);
            Route::get('/dashboard', ['uses' => "{$namespaceController}\LaraminHomeController@dashboard",'as' => 'dashboard']);
            Route::get('/profile', ['uses' => "{$namespaceController}\LaraminHomeController@profile",'as' => 'profile']);
            Route::get('/profile/edit', ['uses' => "{$namespaceController}\LaraminUserController@Profileedit",'as' => 'profile_edit']);
            Route::put('/profile/editing',['uses' => "{$namespaceController}\LaraminUserController@Profileupdate",'as' => 'profile_editing']);
             //Database
            Route::group(['middleware' => ['laramin.permission'],'prefix' => 'database', 'as' => 'database.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\LaraminDatabaseController@browse",'as' => 'browse']);
                Route::get('/create', ['uses' => "{$namespaceController}\LaraminDatabaseController@create",'as' => 'add']);
                Route::get('/edit/{id}', ['uses' => "{$namespaceController}\LaraminDatabaseController@edit",'as' => 'edit']);
                Route::post('/update/{id}', ['uses' => "{$namespaceController}\LaraminDatabaseController@update",'as' => 'update']);
                Route::get('/destroy/{id}', ['uses' => "{$namespaceController}\LaraminDatabaseController@destroy",'as' => 'destroy']);
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


        });

    });
