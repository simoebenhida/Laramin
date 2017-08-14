<?php
    Route::group(['as' => 'slblog.'], function () {
        $namespaceController = '\\'.config('SLblog.namespaceControllers');

        Route::post('addRoles', ['uses' => "{$namespaceController}\SLblogRoleController@store",'as' => 'store']);
        Route::put('editPermissionRoles', ['uses' => "{$namespaceController}\SLblogRoleController@assignPermission",'as' => 'assignPermission']);

        Route::put('editUser', ['uses' => "{$namespaceController}\SLblogUserController@update",'as' => 'update']);
    });
