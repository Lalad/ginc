<?php

//defined ('Ginc') or die ('no direct script access allowed'); // no direct access
/**
 * Ginc
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package		Defines
 * @author		Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license		http://ginc-project.com/license.html
 * @link		http://ginc-project.com
 * @since		Version 1.6
 * @filesource
 */
/**
 * Define the absolute paths for configured directories
 */
// Use the DS to separate the directories in other defines
define ('DS', DIRECTORY_SEPARATOR);

// The full server path to THIS file
define ('PATH_ROOT', realpath (dirname (__FILE__)) . DS . '..' . DS);

// The full server path to the "ginc" folder
define ('PATH_SYSTEM', PATH_ROOT . 'ginc' . DS);

// The full server path to the "application" folder
define ('PATH_APPLICATION', PATH_ROOT . 'app' . DS);

// The full server path to the "application" folder
define ('PATH_COMPONENT', PATH_APPLICATION . 'Component' . DS);

// The full server path to the "application" folder
define ('PATH_MODULE', PATH_APPLICATION . 'Module' . DS);

// The full server path to the "config" folder
define ('PATH_CONFIG', 'Config' . DS);

// The full server path to the "errors" folder
define ('PATH_ERROR', 'Error' . DS);

// The full server path to the "language" folder
define ('PATH_LOCALE', PATH_APPLICATION . 'Locale' . DS);

// The full server path to the "helpers" folder
define ('PATH_HELPER', 'Helper' . DS);

// The full server path to the "libraries" folder
define ('PATH_LIBRARY', 'Library' . DS);

// The full server path to the "database" folder
define ('PATH_DATABASE',   'DataBase' . DS);

// The full server path to the "core" folder
define ('PATH_CORE', PATH_SYSTEM . 'Core' . DS);

// The full server path to the "core" folder
define ('PATH_THEMES', PATH_APPLICATION . 'theme' . DS);

// The full server path to the "tmp" folder
define ('PATH_TMP', PATH_APPLICATION . 'tmp' . DS);

// The full server path to the "Logs" folder
define ('PATH_LOGS', PATH_TMP . 'logs' . DS);
