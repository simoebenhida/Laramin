<?php
    Route::group(['as' => 'slblog.'], function () {
        $namespaceController = '\\'.config('SLblog.namespaceControllers');
                            Route::post('addRoles',['uses' => "{$namespaceController}\SLblogRoleController@store",'as' => 'store']);

                            Route::post('editUser',['uses' => "{$namespaceController}\SLblogUserController@update",'as' => 'update']);
});
