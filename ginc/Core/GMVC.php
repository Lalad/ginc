<?php

defined ('Ginc') or die ('no direct script access allowed'); // no direct access
/**
 * - Ginc Framework
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package     Load
 * @author      Ginc Dev Team
 * @copyright   Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license     http://ginc-project.com/license.html
 * @link        http://ginc-project.com
 * @since       Version 1.6
 * @filesource
 */


class GMVC
{

    private static $object = array ();


    public static function run ()
    {
        // Loading URI class
        Ginc::load ('URI', 'Core/GMVC');

        // Loading Router class
        Ginc::load ('Router', 'Core/GMVC');

        // Loading Router class
        Ginc::load ('Output', 'Core');

        // Instantiate the routing class and set the routing
        Router::init ()->_set_routing ();

        // Set any routing overrides that may exist in the main index file
        // if (isset($routing))
        // {
        //     Router::init()->_set_overrides($routing);
        // }


        /*
         *  Load the app Controller and local Controller
         */

        // Load the base Controller class
        Ginc::load ('Controller', 'Core');

        echo Output::display (
                self::_set_request ('components', Router::init ()->directory, Router::init ()->class, Router::init ()->method, URI::init ()->rsegments)
        );

    }


    /**
     * Fonction initialize
     */
    public static function module ($name, $action = 'index', $params = array ())
    {
        $path = NULL;

        if (strpos ('/', $name) === FALSE)
        {
            $name = explode ('/', trim ($name, '/'));
            $path = array_map ("Inflector::camelize", array_splice ($name, 0, count ($name) - 1));
            $path = implode (DS, $path) . DS;
            $name = end ($name);
        }

        return self::_set_request ('module', $path, $name, $action, $params);

    }


    /**
     * Fonction _set_request
     */
    private static function _set_request ($type, $path, $name, $action = 'index', $params = array ())
    {

        $name            = Inflector::camelize ($name);
        $Controller_name = $name . 'Controller';


        if ( ! isset (self::$object[$Controller_name]))
        {
            $file_path = ($type == 'module' ? PATH_MODULE : PATH_COMPONENT) . $path . $name . DS;

            // Load the local application Controller
            // Note: The Router class automatically validates the Controller path using the router->_validate_request().
            // If this include fails it means that the default Controller in the Routes.php file is not resolving to something valid.
            if ( ! file_exists ($file_path . 'Controller.php'))
            {
                throw new Exception ("This Controller dont exists in path : <b>{$file_path}</b>", 7);
            }

            require_once $file_path . 'Controller.php';

            if ( ! class_exists ($Controller_name))
            {
                throw new Exception ("This Controller {$Controller_name} is not intilase in File : <b>{$file_path}Controller.php</b>", 8);
            }

            self::$object[$Controller_name] = new $Controller_name;
            self::$object[$Controller_name]->path = $file_path;
            self::$object[$Controller_name]->name = $name;

            if (self::$object[$Controller_name]->use_model !== FALSE)
            {
                if (count (self::$object[$Controller_name]->use_model) > 0)
                {
                    $model_name = Inflector::singularize ($name);

                    // Dont Load Model If Dont Exist
                    if (file_exists ($file_path))
                    {
                        self::model ($file_path, $Controller_name, $model_name);
                    }
                }
                else
                {
                    foreach (self::$object[$Controller_name]->use_model as $model_name)
                    {
                        self::model ($file_path, $Controller_name, $model_name);
                    }
                }
            }
        }

        /*
         *  Call the requested method
         */
        if (empty ($action))
        {
            $action = 'index';
        }

        if ( ! method_exists (self::$object[$Controller_name], $action))
        {
            throw new Exception ("this Method : {$action} Dont exists in Coontroller : {$file_path}", 8);
        }

        // set argument
        if (empty ($params) OR ! is_array ($params))
        {
            $params = URI::init ()->rsegments;
        }

        ob_start ();

        // Call the requested method.
        // Any URI segments present (besides the class/function) will be passed to the method for convenience
        call_user_func_array (array (self::$object[$Controller_name], strtolower ($action)), array_slice ($params, 2));

        if (self::$object[$Controller_name]->use_view !== FALSE)
        {
            self::view (($type == 'module' ? PATH_MODULE : PATH_COMPONENT) . $path . Inflector::camelize ($name), $action, $params, FALSE);
        }

        $content = ob_get_contents ();

        ob_end_clean ();

        return $content;

    }


    public static function model ($file_path, $Controller_name, $model_name)
    {
        $file_path = $file_path . DS . 'Model' . DS . $model_name . '.php';

        if ( ! file_exists ($file_path))
        {
            throw new Exception ("This Model dont exists in path : <b> {$file_path}</b>", 7);
        }

        require_once $file_path;

        if ( ! class_exists ($model_name))
        {
            throw new Exception ("This Model {$model_name} is not intilase in File : <b> {$file_path}</b>", 8);
        }

        self::$object[$Controller_name]->$model_name = new $model_name;
        self::$object[$Controller_name]->$model_name->_path = $file_path;
        self::$object[$Controller_name]->$model_name->_name = $model_name;

    }


    /**
     * Model
     */
    public static function view ($path, $view, $var = array (), $return = FALSE, $display_error = TRUE)
    {
        $view_file = $path . DS . 'View' . DS . $view . '.php';

        // Make Sure Module exists
        if ( ! file_exists ($view_file))
        {
            // Check If Display Error is Off
            if ($display_error === FALSE)
            {
                return FALSE;
            }

            throw new Exception ('This View ' . $view . ' Dont Exists in Path <b>' . $view_file . '</b>', 6);
        }
        else
        {
            if (is_array ($var))
            {
                extract ($var, EXTR_OVERWRITE);
            }

            extract (Ginc::_get (), EXTR_OVERWRITE);

            if ($return === TRUE)
            {
                ob_start ();

                // include view File
                require $view_file;

                $content = ob_get_contents ();

                ob_end_clean ();

                return $content;
            }
            else
            {
                // include view File
                require $view_file;
            }
        }

    }

}
