<?php
/**
 * @package ServiceLoader
*/

namespace App;

final class Init
{
/*
==========================================================================================================
	get the classes
===========================================================================================================
*/
	public function getServices()
	{
		require_once "config/config.php";

		return [
			//Controller\Table::class,
			Controller\Database::class,
			Controller\User::class,
		];
	}

/*
==========================================================================================================
	loop through all the registered the service
===========================================================================================================
*/
	public static function registerServices()
	{
		foreach ( self::getServices() as $class ) {
			$services = self::instantiates( $class );

			if( method_exists( $services, "register" ) )
			{
				$services->register();
			}
		}
	}

/*
==========================================================================================================
	Instantiate all the registered class
===========================================================================================================
*/
	public static function instantiates( $class )
	{
		$services = new $class();
		return $services;
	}
}