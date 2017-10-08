<?php
    Route::group(['as' => 'laramin.'], function () {
        $namespaceController = '\\'.config('Laramin.namespaceControllers');

        Route::post('addRole', "{$namespaceController}\LaraminRoleController@store");
        Route::put('editRole', "{$namespaceController}\LaraminRoleController@update");
        Route::delete('deleteRole/{auth}/{id}', "{$namespaceController}\LaraminRoleController@destroy");

        Route::put('editPermissionRole',"{$namespaceController}\LaraminRoleController@assignPermission");
        Route::get('getPermissionRole',"{$namespaceController}\LaraminRoleController@getAssignPermission");

        Route::post('addUser', "{$namespaceController}\LaraminUserController@store");
        Route::put('editUser',"{$namespaceController}\LaraminUserController@update");
        Route::delete('deleteUser/{auth}/{id}',"{$namespaceController}\LaraminUserController@destroy");

    });
