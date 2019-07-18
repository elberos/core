<?php

/*!
 *  Elberos Core
 *
 *  (c) Copyright 2019 "Ildar Bikmamatov" <support@elberos.org>
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
	
	protected $__data = [];
	
	
	
	function __construct($arr = null)
	{
		if ($arr != null)
		{
			$this->__data = $arr;
			$this->initData();
		}
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
		return isset($this->__data[$key]) ? $this->__data[$key] : null;
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
		$class = static::class;
		$obj = new $class();
		$obj->__data = $this->__data;
		foreach ($arr as $key => $value) $obj->__data[$key] = $value;
		$obj->initData();
		return $obj;
	}
	
	
	
	/**
	 * Create struct
	 */
	static function create($arr)
	{
		$class = static::class;
		$obj = new $class();
		foreach ($arr as $key => $value) $obj->__data[$key] = $value;
		$obj->initData();
		return $obj;
	}
	
}