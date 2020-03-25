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

use Elberos\Core\CoreDriver;
use Elberos\Core\Struct;


class TwigDriver extends CoreDriver
{
	protected $twig_opt;
	protected $twig_loader;
	protected $twig_instance;
	
	
	/**
	 * Start driver
	 */
	function startDriver($ctx)
	{
		$twig_opt = array
		(
			'autoescape' => 'html',
			'charset' => 'utf-8',
			'optimizations' => -1,
		);
		$twig_opt['cache'] = $ctx->root_path . '/var/twig';
		$twig_opt['auto_reload'] = true;
		
		$twig_loader = new \Twig_Loader_Filesystem();
		$twig_instance = new \Twig_Environment($twig_loader, $twig_opt);
		
		/* Add path */
		$twig_loader->addPath($ctx->root_path . '/src/template');
		
		/* Register function */
		$twig_instance->addExtension( new \Twig_Extension_StringLoader() );		
		// $twig_instance->addExtension( new \Twig_Extension_Sandbox() );		
		// $twig_instance->addExtension( new \Twig_Extension_Optimizer() );		
		$twig_instance->registerUndefinedFunctionCallback
		(
			function ($name)
			{
				if (!function_exists($name))
				{
					return false;
				}
				return new \Twig\TwigFunction($name, $name);
			}
		);
		
		$twig_instance->registerUndefinedFilterCallback
		(
			function ($name)
			{
				if (!function_exists($name))
				{
					return false;
				}
				return new \Twig\TwigFunction($name, $name);
			}
		);
		
		$this->twig_opt = $twig_opt;
		$this->twig_loader = $twig_loader;
		$this->twig_instance = $twig_instance;
	}
	
	
	
	/**
	 * Render
	 */
	function render($template, $data = [])
	{
		$template = $this->twig_instance->loadTemplate($template);
		$result = $template->render($data);
		return $result;
	}
}