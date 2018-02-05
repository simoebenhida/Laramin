<?php
Route::group(['as' => 'laramin.'], function () {
    $namespaceController = '\\' . config('laramin.namespaceControllers');

    Route::post('addRole', "{$namespaceController}\LaraminRoleController@store");
    Route::put('editRole', "{$namespaceController}\LaraminRoleController@update");
    Route::delete('deleteRole/{auth}/{id}', "{$namespaceController}\LaraminRoleController@destroy");

    Route::put('editPermissionRole', "{$namespaceController}\LaraminRoleController@assignPermission");
    Route::get('getPermissionRole', "{$namespaceController}\LaraminRoleController@assignedPermission");

    Route::post('addUser', "{$namespaceController}\LaraminUserController@store");
    Route::put('editUser', "{$namespaceController}\LaraminUserController@update");
    Route::put('editOwnPassword', "{$namespaceController}\LaraminUserController@editOwnPassword");

    Route::delete('deleteUser/{auth}/{id}', "{$namespaceController}\LaraminUserController@destroy");


    Route::post('database/add', "{$namespaceController}\LaraminDatabaseController@store");
    Route::delete('database/destroy/{auth}/{id}', "{$namespaceController}\LaraminDatabaseController@destroy");

});
