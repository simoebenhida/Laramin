<?php
    Route::group(['as' => 'slblog.'], function () {
        $namespaceController = '\\'.config('SLblog.namespaceControllers');
        // Route::get('/test',['uses' => "{$namespaceController}\SLBlogHomeController@index"]);

        Route::get('login', ['uses' => "{$namespaceController}\SLBlogUserLoginController@showLoginForm", 'as' => 'login']);
        Route::post('login', [ 'uses' => "{$namespaceController}\SLBlogUserLoginController@postLogin", 'as' => 'postlogin' ]);

        Route::group(['middleware' => 'admin.user'], function () use ($namespaceController) {
            Route::get('/', ['uses' => "{$namespaceController}\SLBlogHomeController@index",'as' => 'index']);
            Route::get('/dashboard', ['uses' => "{$namespaceController}\SLBlogHomeController@dashboard",'as' => 'dashboard']);
            // Route::get('/test',function(){
            // 	return view('slblog::database.add-edit');
            // });
            /**

                TODO:
                - For the crud add en event to detect the type Post , Tag, Category and change the name to type name
                - click link target the type and change the config to current type ?
                Make Slug ?
             */
                //Database
            Route::group(['prefix' => 'database', 'as' => 'database.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\SLBlogDatabaseController@browse",'as' => 'browse']);
                Route::get('/create', ['uses' => "{$namespaceController}\SLBlogDatabaseController@create",'as' => 'add']);
                Route::post('/add', ['uses' => "{$namespaceController}\SLBlogDatabaseController@store",'as' => 'store']);
            });
            //Permission
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\SLblogPermissionController@users",'as' => 'users']);
                // Route::get('/create', ['uses' => "{$namespaceController}\SLblogPermissionController@create",'as' => 'add']);
                // Route::post('/add', ['uses' => "{$namespaceController}\SLblogPermissionController@store",'as' => 'store']);
            });
            Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () use ($namespaceController) {
                Route::get('/', ['uses' => "{$namespaceController}\SLblogPermissionController@roles",'as' => 'roles']);
                // Route::get('/create', ['uses' => "{$namespaceController}\SLblogPermissionController@create",'as' => 'add']);
                // Route::post('/add', ['uses' => "{$namespaceController}\SLblogPermissionController@store",'as' => 'store']);
            });
            foreach (slblog_menu_slugs() as $key => $value) {
                Route::group(['prefix' => $value, 'as' => $value.'.'], function () use ($namespaceController) {
                    Route::get('/', ['uses' => "{$namespaceController}\SLBlogCrudController@browse",'as' => 'browse']);
                    Route::get('/create', ['uses' => "{$namespaceController}\SLBlogCrudController@create",'as' => 'add']);
                    Route::post('/add', ['uses' => "{$namespaceController}\SLBlogCrudController@store",'as' => 'store']);
                    // Route::get('/edit',['uses' => "{$namespaceController}\SLBlogCrudController@editPost",'as' => 'edit']);
                });
            }
            // Route::group(['prefix' => 'tag', 'as' => 'tag.'],function() use($namespaceController) {
        // 	Route::get('/',['uses' => "{$namespaceController}\SLBlogCrudController@browse",'as' => 'browse']);
        // 	Route::get('/create',['uses' => "{$namespaceController}\SLBlogCrudController@create",'as' => 'add']);
        // 	Route::post('/add',['uses' => "{$namespaceController}\SLBlogCrudController@store",'as' => 'store']);
        // 	// Route::get('/edit',['uses' => "{$namespaceController}\SLBlogCrudController@editTag",'as' => 'edit']);
        // });

        // Route::group(['prefix' => 'category', 'as' => 'category.'],function() use($namespaceController) {
        // 	Route::get('/',['uses' => "{$namespaceController}\SLBlogCrudController@browse",'as' => 'browse']);
        // 	Route::get('/create',['uses' => "{$namespaceController}\SLBlogCrudController@create",'as' => 'add']);
        // 	Route::post('/add',['uses' => "{$namespaceController}\SLBlogCrudController@store",'as' => 'store']);
        // 	// Route::get('/edit',['uses' => "{$namespaceController}\SLBlogCrudController@editCategory",'as' => 'edit']);
        // });
        });
    });
