<?php
defined('Ginc') or die('no direct script access allowed'); // no direct access
/**
 * - Ginc Framework
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package		Base Controller
 * @author		Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license		http://ginc-project.com/license.html
 * @link		http://ginc-project.com
 * @since		Version 1.6
 * @filesource
 */


class Controller
{
	public $use_model = TRUE;
	public $use_view = TRUE;
	public $path;
	public $name;


    protected function view($view = NULL, $var = array(), $return = FALSE)
    {	
    	$this->use_view = $view;

        return GMVC::view($this->path, $view, $var, $return);
    }

}
