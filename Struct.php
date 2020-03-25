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


class Struct
{
	
	
	function __construct($arr = null)
	{
		if ($arr != null)
		{
			foreach ($arr as $key => $value) { $this->assignValue($key, $value); }
			$this->initData();
		}
	}
	
	
	
	/**
	 * Assign to struct
	 */
	protected function assignValue($key, $value)
	{
		$pkey = "__".$key;
		if (property_exists($this, $pkey)) $this->$pkey = $value;
	}
	
	
	
	/**
	 * Init data
	 */
	protected function initData()
	{
		
	}
	
	
	
	/**
	 * Get new value
	 */
	function __get($key)
	{
		$pkey = "__".$key;
		return isset($this->$pkey) ? $this->$pkey : null;
	}
	
	
	
	/**
	 * Set new value
	 */
	function __set($key, $value)
	{
		throw new \Exception('Set "' . $key . '" error');
	}
	
	
	
	/**
	 * Copy struct
	 */
	function copy($arr)
	{
		$obj = clone $this;
		foreach ($arr as $key => $value) { $obj->assignValue($key, $value); }
		$obj->initData();
		return $obj;
	}
	
	
	
	/**
	 * Create struct
	 */
	static function newInstance($params = null)
	{
		$class = static::class;
		$obj = new $class();
		if ($params != null)
		{
			foreach ($params as $key => $value) { $obj->assignValue($key, $value); }
		}
		$obj->initData();
		return $obj;
	}
	
}