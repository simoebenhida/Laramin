<?php

	$namespaceController = config('SLblog.namespaceControllers');

Route::get('/test',[
	'uses' => "{$namespaceController}\SLBlogHomeController@index"
]);