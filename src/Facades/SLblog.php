<?php
namespace Simoja\SLblog\Facades;

use Illuminate\Support\Facades\Facade;

class SLblog extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'slblog';
	}
}