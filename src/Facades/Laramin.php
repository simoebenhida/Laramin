<?php
namespace Simoja\Laramin\Facades;

use Illuminate\Support\Facades\Facade;

class Laramin extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'laramin';
	}
}
