<?php
    Route::group(['as' => 'laramin.'], function () {
        $namespaceController = '\\'.config('Laramin.namespaceControllers');

        Route::post('addRole', "{$namespaceController}\LaraminRoleController@store");
        Route::put('editRole', "{$namespaceController}\LaraminRoleController@update");
        Route::delete('deleteRole/{id}', "{$namespaceController}\LaraminRoleController@destroy");
        Route::put('editPermissionRole',"{$namespaceController}\LaraminRoleController@assignPermission");
        Route::get('getPermissionRole',"{$namespaceController}\LaraminRoleController@getAssignPermission");

        Route::put('editUser',"{$namespaceController}\LaraminUserController@update");
        Route::delete('deleteUser/{id}',"{$namespaceController}\LaraminUserController@destroy");

    });
