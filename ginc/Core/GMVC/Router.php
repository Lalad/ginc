<?php

defined ('Ginc') or die ('no direct script access allowed'); // no direct access
/**
 * - Ginc Framework
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package		Input
 * @author		Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license		http://ginc-project.com/license.html
 * @link		http://ginc-project.com
 * @filesource  CodeIgnter Framework ;)
 * @filesource
 */


class Router
{

    /**
     * List of routes
     *
     * @var array
     * @access public
     */
    private $routes = array ();

    /**
     * List of error routes
     *
     * @var array
     * @access public
     */
    private $error_routes = array ();

    /**
     * Current class name
     *
     * @var string
     * @access public
     */
    public $class = 'default';

    /**
     * Current method name
     *
     * @var string
     * @access public
     */
    public $method = 'index';

    /**
     * Sub-directory that contains the requested controller class
     *
     * @var string
     * @access public
     */
    public $directory = '';

    /**
     * Object
     *
     * @var string
     * @access public
     */
    private static $object = FALSE;


    public static function init ()
    {
        if (self::$object != FALSE)
        {
            return self::$object;
        }

        self::$object = new Router();

        return self::$object;
    }


    /**
     * Set the route mapping
     *
     * This function determines what should be served based on the URI request,
     * as well as any "routes" that have been set in the routing config file.
     *
     * @access	private
     * @return	void
     */
    public function _set_routing ()
    {
        // Are query strings enabled in the config file?  Normally CI doesn't utilize query strings
        // since URI segments are more search-engine friendly, but they can optionally be used.
        // If this feature is enabled, we will gather the directory/class/method a little differently
        $segments = array ();

        if (Ginc::config ('General.enable_query_strings') === TRUE AND isset (Input::$query[Ginc::config ('General.controller_trigger')]))
        {
            if (isset (Input::$query[Ginc::config ('General.directory_trigger')]))
            {
                $this->set_directory (trim (URI::init ()->_filter_uri (Input::$query[Ginc::config ('General.directory_trigger')])));
                $segments[] = $this->directory;
            }

            if (isset (Input::$query[Ginc::config ('General.controller_trigger')]))
            {
                $this->class = trim (URI::init ()->_filter_uri (Input::$query[Ginc::config ('General.controller_trigger')]));
                $segments[] = $this->class;
            }

            if (isset (Input::$query[Ginc::config ('General.function_trigger')]))
            {
                $this->method = trim (URI::init ()->_filter_uri (Input::$query[Ginc::config ('General.function_trigger')]));
                $segments[] = $this->method;
            }
        }

        $this->routes = Ginc::config ('Routes');

        // Set the default controller so we can display it in the event
        // the URI doesn't correlated to a valid controller.
        $this->default_controller = ( ! isset ($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower ($this->routes['default_controller']);

        // Were there any query string segments?  If so, we'll validate them and bail out since we're done.
        if (count ($segments) > 0)
        {
            return $this->_validate_request ($segments);
        }

        // Fetch the complete URI string
        URI::init ()->_fetch_uri_string ();

        // Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
        if (URI::init ()->uri_string == '')
        {
            return $this->_set_default_controller ();
        }

        // Do we need to remove the URL suffix?
        URI::init ()->_remove_url_suffix ();

        // Compile the segments into an array
        URI::init ()->_explode_segments ();

        // Parse any custom routing that may exist
        $this->_parse_routes ();

        // Re-index the segment array so that it starts with 1 rather than 0
        URI::init ()->_reindex_segments ();
    }


    /**
     * Set the default controller
     *
     * @access	private
     * @return	void
     */
    private function _set_default_controller ()
    {
        if ($this->class === FALSE)
        {
            throw new Exception ("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
        }

        $this->_set_request (array ($this->class, 'index'));

        // re-index the routed segments array so it starts with 1 rather than 0
        URI::init ()->_reindex_segments ();
    }


    /**
     * Set the Route
     *
     * This function takes an array of URI segments as
     * input, and sets the current class/method
     *
     * @access	private
     * @param	array
     * @param	bool
     * @return	void
     */
    private function _set_request ($segments = array ())
    {
        $segments = $this->_validate_request ($segments);

        if (count ($segments) == 0)
        {
            return $this->_set_default_controller ();
        }

        $this->class = $segments[0];

        if (isset ($segments[1]))
        {
            // A standard method request
            $this->method = $segments[1];
        }
        else
        {
            // This lets the "routed" segment array identify that the default
            // index method is being used.
            $segments[1] = 'index';
        }

        // Update our "routed" segment array to contain the segments.
        // Note: If there is no custom routing, this array will be
        // identical to URI::init()->segments
        URI::init ()->rsegments = $segments;
    }


    /**
     * Validates the supplied segments.  Attempts to determine the path to
     * the controller.
     *
     * @access	private
     * @param	array
     * @return	array
     */
    function _validate_request ($segments)
    {
        if (count ($segments) == 0)
        {
            return $segments;
        }

        $segments = array_map ('strtolower', $segments);

        // Does the requested controller exist in the root folder?
        if (file_exists (PATH_COMPONENT . Inflector::camelize ($segments[0]) . DS . 'controller.php'))
        {
            return $segments;
        }

        $controller_path = rtrim (PATH_COMPONENT, DS);

        // Is the controller in a sub-folder?
        for ($i = 0; isset ($segments[$i]) AND is_dir ($controller_path . DS . Inflector::camelize ($segments[$i])); $i ++ )
        {
            $controller_path .= DS . Inflector::camelize ($segments[$i]);
        }

        // Is the controller in a sub-folder?
        if ($i != 0)
        {
            // Set the directory and remove it from the segment array
            $directory = array_map ("Inflector::camelize", array_splice ($segments, 0, $i - 1));
            $this->set_directory ($directory);

            if (count ($segments) > 0)
            {
                // Does the requested controller exist in the sub-folder?
                if ( ! file_exists (PATH_COMPONENT . $this->directory . Inflector::camelize ($segments[0]) . DS . 'Controller.php'))
                {
                    if ( ! empty ($this->routes['404_override']))
                    {
                        $x = explode ('/', $this->routes['404_override']);

                        $this->directory = '';
                        $this->class = $x[0];
                        $this->method = isset ($x[1]) ? $x[1] : 'index';

                        return $x;
                    }
                    else
                    {
                        throw new Exception ('404 ahbibi ' . $this->directory . Inflector::camelize ($segments[0]), 345);
                    }
                }
            }
            else
            {

                $this->class = $this->class;
                $this->method = 'index';

                // Does the default controller exist in the sub-folder?
                if ( ! file_exists (PATH_COMPONENT . $this->directory . Inflector::camelize ($this->class) . DS . 'controller.php'))
                {
                    $this->directory = '';
                    return array ();
                }
            }

            return $segments;
        }

        // If we've gotten this far it means that the URI does not correlate to a valid
        // controller class.  We will now see if there is an override
        if ( ! empty ($this->routes['404_override']))
        {
            $x = explode ('/', $this->routes['404_override']);

            $this->class = $x[0];
            $this->method = isset ($x[1]) ? $x[1] : 'index';

            return $x;
        }


        // Nothing else to do at this point but show a 404
        throw new Exception ('404 ahbibi ' . $segments[0], 404);
    }


    /**
     *  Parse Routes
     *
     * This function matches any routes that may exist in
     * the config/routes.php file against the URI to
     * determine if the class/method need to be remapped.
     *
     * @access	private
     * @return	void
     */
    function _parse_routes ()
    {
        // Turn the segment array into a URI string
        $uri = implode ('/', URI::init ()->segments);

        // Is there a literal match?  If so we're done
        if (isset ($this->routes[$uri]))
        {
            return $this->_set_request (explode ('/', $this->routes[$uri]));
        }

        // Loop through the route array looking for wild-cards
        foreach ($this->routes as $key => $val)
        {
            // Convert wild-cards to RegEx
            $key = str_replace (':any', '.+', str_replace (':num', '[0-9]+', $key));

            // Does the RegEx match?
            if (preg_match ('#^' . $key . '$#', $uri))
            {
                // Do we have a back-reference?
                if (strpos ($val, '$') !== FALSE AND strpos ($key, '(') !== FALSE)
                {
                    $val = preg_replace ('#^' . $key . '$#', $val, $uri);
                }

                return $this->_set_request (explode ('/', $val));
            }
        }

        // If we got this far it means we didn't encounter a
        // matching route so we'll set the site default route
        $this->_set_request (URI::init ()->segments);
    }


    /**
     *  Set the directory name
     *
     * @access	public
     * @param	string
     * @return	void
     */
    function set_directory ($dir)
    {
        if (is_array ($dir))
        {
            return array_map ('self::set_directory', $dir);
        }
        $this->directory .= str_replace (array ('/', '.'), '', $dir) . '/';
    }


    /**
     *  Set the controller overrides
     *
     * @access	public
     * @param	array
     * @return	null
     */
    function _set_overrides ($routing)
    {
        if ( ! is_array ($routing))
        {
            return;
        }

        if (isset ($routing['directory']))
        {
            $this->set_directory ($routing['directory']);
        }

        if (isset ($routing['controller']) AND $routing['controller'] != '')
        {
            $this->class = $routing['controller'];
        }

        if (isset ($routing['function']))
        {
            $routing['function'] = ($routing['function'] == '') ? 'index' : $routing['function'];
            $this->method = $routing['function'];
        }
    }

}
