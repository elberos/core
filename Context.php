<?php

/*!
 *  Elberos Core
 *
 *  (c) Copyright 2019-2020 "Ildar Bikmamatov" <support@elberos.org>
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace Elberos\Core;

use Elberos\Core\Lib;


class Context extends Struct
{
	
	public $__root_path = "";
	public $__settings = [];
	public $__enviroments = [];
	public $__providers = [];
	public $__drivers = [];
	
	
	
	/**
	 * Root path
	 */
	static function setRootPath($ctx, $root_path)
	{
		return $ctx->copy([ "root_path" => $root_path ]);
	}
	
	
	
	/**
	 * Get settings
	 */
	static function getSettings($env)
	{
		return [];
	}
	
	
	
	/**
	 * Create context
	 */
	static function create($env)
	{
		$settings = static::getSettings($env);
		$class_name = static::class;
		
		$obj = [
			"settings" => $settings,
			"enviroments" => $env,
		];
		return new $class_name($obj);
	}
	
	
	
	/**
	 * Init context
	 */
	static function init($ctx)
	{
		return $ctx;
	}
	
	
	
	/**
	 * Start context
	 */
	static function start($ctx)
	{
		$drivers = $ctx->drivers;
		foreach ($drivers as $name => $item)
		{
			$item->startDriver($ctx);
		}
		return $ctx;
	}
	
	
	
	/**
	 * Returns provider
	 */
	static function createProvider($ctx, $provider_name, $settings_name = "default")
	{
		$providers = $ctx->providers;
		$settings = $ctx->settings;
		if (!isset($providers[$provider_name])) return null;
		
		$provider = $providers[$provider_name];
		$class_name = Lib::getClassName($provider->value);
		$obj = [];
		
		if (isset($settings["providers"]))
		{
			if (isset($settings["providers"][$provider_name]))
			{
				if (isset($settings["providers"][$provider_name][$settings_name]))
				{
					$obj = $settings["providers"][$provider_name][$settings_name];
				}
			}
		}
		
		return new $class_name($obj);
	}
	
	
	
	/**
	 * Get provider
	 */
	static function getProvider($ctx, $provider_name, $settings_name = "default")
	{
		return static::createProvider($ctx, $provider_name, $settings_name);
	}
	
	
	
	/**
	 * Returns driver
	 */
	static function getDriver($ctx, $driver_name)
	{
		$drivers = $ctx->drivers;
		if (!isset($drivers[$driver_name])) return null;
		return $drivers[$driver_name];
	}
	
	
	
}