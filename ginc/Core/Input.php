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
 * @since		Version 1.6
 * @filesource
 */


class Input
{

    private static $user_agent            = FALSE;
    private static $_enable_xss           = TRUE;
    private static $ip_address            = FALSE;
    private static $headers               = FALSE;
    private static $_allow_get_array      = TRUE;
    private static $_standardize_newlines = TRUE;
    private static $cookie_params         = array (
        'expire' => 0,
        'domain' => NULL,
        'path'   => '/',
        'secure' => FALSE,
        'crypt'  => TRUE,
    );

    /**
     * Array of parameters parsed from the url.
     *
     * @var array
     */
    public static $params = array (
        'controller' => null,
        'action'     => null,
        'named'      => array (),
        'pass' => array (),
    );

    /**
     * Array of querystring arguments
     *
     * @var array
     */
    public static $query = array ();

    /**
     * The built in detectors used with `is()` can be modified with `addDetector()`.
     *
     * There are several ways to specify a detector, see CakeRequest::addDetector() for the
     * various formats and ways to define detectors.
     *
     * @var array
     */
    private static $_detectors = array (
        'get' => array ('env'   => 'REQUEST_METHOD', 'value' => 'GET'),
        'post'  => array ('env'   => 'REQUEST_METHOD', 'value' => 'POST'),
        'put'   => array ('env'    => 'REQUEST_METHOD', 'value'  => 'PUT'),
        'delete' => array ('env'   => 'REQUEST_METHOD', 'value' => 'DELETE'),
        'head'  => array ('env'     => 'REQUEST_METHOD', 'value'   => 'HEAD'),
        'options' => array ('env'   => 'REQUEST_METHOD', 'value' => 'OPTIONS'),
        'ssl'   => array ('env'   => 'HTTPS', 'value' => 1),
        'ajax'  => array ('env'   => 'HTTP_X_REQUESTED_WITH', 'value' => 'XMLHttpRequest'),
        'flash' => array ('env'     => 'HTTP_USER_AGENT', 'pattern' => '/^(Shockwave|Adobe) Flash/'),
        'mobile'  => array ('env'     => 'HTTP_USER_AGENT', 'options' => array (
                'Android', 'AvantGo', 'BlackBerry', 'DoCoMo', 'Fennec', 'iPod', 'iPhone', 'iPad',
                'J2ME', 'MIDP', 'NetFront', 'Nokia', 'Opera Mini', 'Opera Mobi', 'PalmOS', 'PalmSource',
                'portalmmm', 'Plucker', 'ReqwirelessWeb', 'SonyEricsson', 'Symbian', 'UP\\.Browser',
                'webOS', 'Windows CE', 'Windows Phone OS', 'Xiino'
        )),
        'requested' => array ('param' => 'requested', 'value' => 1)
    );

    /**
     * Array of POST data.  Will contain form data as well as uploaded files.
     * Inputs prefixed with 'data' will have the data prefix removed.  If there is
     * overlap between an input prefixed with data and one without, the 'data' prefixed
     * value will take precedence.
     *
     * @var array
     */
    public static $data = array ();


    private static function fromArray (&$array, $index, $xss_clean)
    {
        if ( ! array_key_exists ($index, $array))
        {
            return FALSE;
        }

        if ($xss_clean === TRUE)
        {
            return Security::xssClean ($array[$index]);
        }

        return $array[$index];
    }


    /**
     * Fetch an item from the COOKIE array
     * 
     * @param string $index
     * @param bool $xss_clean
     * @return string 
     */
    public static function cookie ($index, $xss_clean = TRUE)
    {
        $value = self::fromArray ($_COOKIE, $index, $xss_clean);

        $value = (self::$cookie_params['crypt'] === TRUE && $value !== FALSE ? Encrypt::decrypt ($value) : $value);

        return $value;
    }


    /**
     * Deletes a cookie - uses default parameters set by the other set methods of this class
     *
     * @param  string  $name    The cookie name to delete
     * @param  string  $path    The path of the cookie to delete
     * @param  string  $domain  The domain of the cookie to delete
     * @param  boolean $secure  If the cookie is a secure-only cookie
     * @return void
     */
    public static function removeCookie ($name)
    {
        self::setCookie ($name, FALSE, time () - 31500000);
    }


    /**
     * Deletes all cookie
     */
    public static function destroyCookie ()
    {
        foreach ($_COOKIE as $key => $value)
        {
            self::setCookie ($key, FALSE, time () - 31500000);
        }
    }


    /**
     * Set cookie
     *
     * Accepts six parameter, or you can submit an associative
     * array in the first parameter containing all the values.
     *
     * @access	public
     * @param	mixed
     * @param	string	the value of the cookie
     * @param	string	the number of seconds until expiration
     * @param	string	the cookie domain.  Usually:  .yourdomain.com
     * @param	string	the cookie path
     * @param	string	the cookie prefix
     * @return	void
     */
    public static function setCookie ($name, $value, $expire = FALSE, $domain = FALSE, $path = FALSE)
    {
        if (is_array ($name))
        {
            foreach (array ('value', 'expire', 'domain', 'path', 'prefix', 'name') as $item)
            {
                if (isset ($name[$item]))
                {
                    $$item = $name[$item];
                }
            }
        }

        if ($domain == NULL AND self::$cookie_params['domain'] != NULL)
        {
            $domain = self::$cookie_params['domain'];
        }

        if ($path === FALSE AND self::$cookie_params['path'] != NULL)
        {
            $path = self::$cookie_params['path'];
        }

        if ($expire === FALSE)
        {
            $expire = (self::$cookie_params['expire'] > 0) ? time () + self::$cookie_params['expire'] : 0;
        }
        else
        {
            $expire = ($expire > 0) ? time () + $expire : 0;
        }

        $value = (self::$cookie_params['crypt'] === TRUE ? Encrypt::crypt ($value) : $value);

        setcookie ($name, $value, $expire, $path, $domain, self::$cookie_params['secure']);
    }


    /** user Agent * */
    public static function userAgent ()
    {
        if (self::$user_agent !== FALSE)
        {
            return self::$user_agent;
        }

        self::$user_agent = preg_replace ('/javascript|vbscri?pt|script|applet|alert|document|write|cookie/i', '', self::env ('HTTP_USER_AGENT'));

        return self::$user_agent;
    }


    /**
     * Gets an environment variable from available sources, and provides emulation
     * for unsupported or inconsistent environment variables (i.e. DOCUMENT_ROOT on
     * IIS, or SCRIPT_NAME in CGI mode).  Also exposes some additional custom
     * environment information.
     *
     * @param  string $key Environment variable name.
     * @return string Environment variable setting.
     * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#env
     */
    public static function env ($key)
    {
        if ($key === 'HTTPS')
        {
            if (isset ($_SERVER['HTTPS']))
            {
                return ( ! empty ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            }
            return (strpos (self::env ('SCRIPT_URI'), 'https://') === 0);
        }

        if ($key === 'SCRIPT_NAME')
        {
            if (self::env ('CGI_MODE') && isset ($_ENV['SCRIPT_URL']))
            {
                $key = 'SCRIPT_URL';
            }
        }

        $val = null;
        if (isset ($_SERVER[$key]))
        {
            $val = $_SERVER[$key];
        }
        elseif (isset ($_ENV[$key]))
        {
            $val = $_ENV[$key];
        }
        elseif (getenv ($key) !== false)
        {
            $val = getenv ($key);
        }

        if ($key === 'REMOTE_ADDR' && $val === self::env ('SERVER_ADDR'))
        {
            $addr = self::env ('HTTP_PC_REMOTE_ADDR');
            if ($addr !== null)
            {
                $val = $addr;
            }
        }

        if ($val !== null)
        {
            return $val;
        }

        switch ($key)
        {
            case 'SCRIPT_FILENAME':

                if (defined ('SERVER_IIS') && SERVER_IIS === true)
                {
                    return str_replace ('\\\\', '\\', self::env ('PATH_TRANSLATED'));
                }

                break;

            case 'DOCUMENT_ROOT':

                $name     = self::env ('SCRIPT_NAME');
                $filename = self::env ('SCRIPT_FILENAME');
                $offset   = 0;

                if ( ! strpos ($name, '.php'))
                {
                    $offset = 4;
                }

                return substr ($filename, 0, strlen ($filename) - (strlen ($name) + $offset));

                break;

            case 'PHP_SELF':

                return str_replace (self::env ('DOCUMENT_ROOT'), '', self::env ('SCRIPT_FILENAME'));

                break;

            case 'CGI_MODE':

                return (PHP_SAPI === 'cgi');

                break;

            case 'HTTP_BASE':

                $host  = self::env ('HTTP_HOST');
                $parts = explode ('.', $host);
                $count = count ($parts);

                if ($count === 1)
                {
                    return '.' . $host;
                }
                elseif ($count === 2)
                {
                    return '.' . $host;
                }
                elseif ($count === 3)
                {
                    $gTLD = array (
                        'aero',
                        'asia',
                        'biz',
                        'cat',
                        'com',
                        'coop',
                        'edu',
                        'gov',
                        'info',
                        'int',
                        'jobs',
                        'mil',
                        'mobi',
                        'museum',
                        'name',
                        'net',
                        'org',
                        'pro',
                        'tel',
                        'travel',
                        'xxx'
                    );

                    if (in_array ($parts[1], $gTLD))
                    {
                        return '.' . $host;
                    }
                }

                array_shift ($parts);

                return '.' . implode ('.', $parts);

                break;
        }
        return null;
    }


    /**
     * Get the IP the client is using, or says they are using.
     *
     * @param boolean $safe Use safe = false when you think the user might manipulate their HTTP_CLIENT_IP
     *   header.  Setting $safe = false will will also look at HTTP_X_FORWARDED_FOR
     * @return string The client IP.
     */
    public static function IP ($safe = true)
    {
        if ( ! $safe && env ('HTTP_X_FORWARDED_FOR') != null)
        {
            $ipaddr = preg_replace ('/(?:,.*)/', '', self::env ('HTTP_X_FORWARDED_FOR'));
        }
        else
        {
            if (self::env ('HTTP_CLIENT_IP') != null)
            {
                $ipaddr = self::env ('HTTP_CLIENT_IP');
            }
            else
            {
                $ipaddr = self::env ('REMOTE_ADDR');
            }
        }

        if (self::env ('HTTP_CLIENTADDRESS') != null)
        {
            $tmpipaddr = self::env ('HTTP_CLIENTADDRESS');

            if ( ! empty ($tmpipaddr))
            {
                $ipaddr = preg_replace ('/(?:,.*)/', '', $tmpipaddr);
            }
        }
        return trim ($ipaddr);
    }


    /**
     * Check whether or not a Request is a certain type.  Uses the built in detection rules
     * as well as additional rules defined with CakeRequest::addDetector().  Any detector can be called
     * as `is($type)` or `is$Type()`.
     *
     * @param string $type The type of request you want to check.
     * @return boolean Whether or not the request is the type you are checking.
     */
    public static function is ($type)
    {
        $type = strtolower ($type);
        if ( ! isset (self::$_detectors[$type]))
        {
            return false;
        }
        $detect = self::$_detectors[$type];
        if (isset ($detect['env']))
        {
            if (isset ($detect['value']))
            {
                return Input::env ($detect['env']) == $detect['value'];
            }
            if (isset ($detect['pattern']))
            {
                return (bool) preg_match ($detect['pattern'], Input::env ($detect['env']));
            }
            if (isset ($detect['options']))
            {
                $pattern = '/' . implode ('|', $detect['options']) . '/i';
                return (bool) preg_match ($pattern, Input::env ($detect['env']));
            }
        }
        if (isset ($detect['param']))
        {
            $key   = $detect['param'];
            $value = $detect['value'];
            return isset ($this->params[$key]) ? $this->params[$key] == $value : false;
        }

        return false;
    }


    /**
     * Request Headers
     *
     * In Apache, you can simply call apache_request_headers(), however for
     * people running other webservers the function is undefined.
     *
     * @param   bool XSS cleaning
     *
     * @return array
     */
    public static function requestHeaders ()
    {
        // Look at Apache go!
        if (function_exists ('apache_request_headers'))
        {
            $headers = apache_request_headers ();
        }
        else
        {
            $headers['Content-Type'] = (self::env ('CONTENT_TYPE') ? self::env ('CONTENT_TYPE') : @getenv ('CONTENT_TYPE'));

            foreach ($_SERVER as $key => $val)
            {
                if (strncmp ($key, 'HTTP_', 5) === 0)
                {
                    $headers[substr ($key, 5)] = self::env ($key);
                }
            }
        }

        // take SOME_HEADER and turn it into Some-Header
        foreach ($headers as $key => $val)
        {
            $key = str_replace ('_', ' ', strtolower ($key));
            $key = str_replace (' ', '-', ucwords ($key));

            self::$headers[$key] = $val;
        }

        return self::$headers;
    }


    /**
     * Get Request Header
     *
     * Returns the value of a single member of the headers class member
     *
     * @param   string      array key for $this->headers
     * @param   boolean     XSS Clean or not
     * @return  mixed       FALSE on failure, string on success
     */
    public static function get_request_header ($index)
    {
        if (empty (self::$headers))
        {
            self::requestHeaders ();
        }

        if ( ! isset (self::$headers[$index]))
        {
            return FALSE;
        }

        return self::$headers[$index];
    }


    /**
     * Clean Keys
     *
     * This is a helper function. To prevent malicious users
     * from trying to exploit keys we make sure that keys are
     * only named with alpha-numeric text and a few other items.
     *
     * @param	string
     * @return	string
     */
    public static function cleanKeys ($str)
    {
        if ( ! preg_match ("/^[$-z0-9:_\/-]+$/i", $str))
        {
            throw new Exception ('Disallowed Key Characters.');
        }

        return $str;
    }


    /**
     * Sanitize Globals
     *
     * This function does the following:
     *
     * Unsets $_GET data (if query strings are not enabled)
     *
     * Unsets all globals if register_globals is enabled
     *
     * Standardizes newline characters to \n
     *
     * @return	void
     */
    public static function _sanitize_globals ()
    {
        // Sanitize Globals Variables For Securty
        if (Ginc::config ('General.XSS_FILTERING') == FALSE)
        {
            return;
        }

        // It would be "wrong" to unset any of these GLOBALS.
        $protected = array ('_SERVER', '_GET', '_POST', '_FILES', '_REQUEST',
            '_SESSION', '_ENV', 'GLOBALS', 'HTTP_RAW_POST_DATA',
            'system_folder', 'application_folder', 'BM', 'EXT',
            'CFG', 'URI', 'RTR', 'OUT', 'IN');

        // Unset globals for securiy.
        // This is effectively the same as register_globals = off
        foreach (array ($_GET, $_POST, $_COOKIE) as $global)
        {
            if ( ! is_array ($global))
            {
                if ( ! in_array ($global, $protected))
                {
                    global $$global;

                    $$global = NULL;
                }
            }
            else
            {
                foreach ($global as $key => $val)
                {
                    if ( ! in_array ($key, $protected))
                    {
                        global $$key;

                        $$key = NULL;
                    }
                }
            }
        }

        // Process Environment
        self::$data = $_POST;

        self::$query = $_GET;

        unset ($_POST, $_GET);

        if (self::env ('HTTP_X_HTTP_METHOD_OVERRIDE'))
        {
            self::$data['_method'] = self::env ('HTTP_X_HTTP_METHOD_OVERRIDE');
        }

        if (isset (self::$data['_method']))
        {
            if ( ! empty ($_SERVER))
            {
                $_SERVER['REQUEST_METHOD'] = self::$data['_method'];
            }
            else
            {
                $_ENV['REQUEST_METHOD'] = self::$data['_method'];
            }
            unset (self::$data['_method']);
        }

        // Is $_GET data allowed? If not we'll set the $_GET to an empty array
        if (is_array (self::$query) AND count (self::$query) > 0)
        {
            foreach (self::$query as $key => $val)
            {
                self::$query[self::cleanKeys ($key)] = self::cleanData ($val);
            }
        }

        // Clean $_POST Data
        if (is_array (self::$data) AND count (self::$data) > 0)
        {
            foreach (self::$data as $key => $val)
            {
                self::$data[self::cleanKeys ($key)] = self::cleanData ($val);
            }
        }

        // Clean $_COOKIE Data
        if (is_array ($_COOKIE) AND count ($_COOKIE) > 0)
        {
            // Also get rid of specially treated cookies that might be set by a server
            // or silly application, that are of no use to a CI application anyway
            // but that when present will trip our 'Disallowed Key Characters' alarm
            // http://www.ietf.org/rfc/rfc2109.txt
            // note that the key names below are single quoted strings, and are not PHP variables
            unset ($_COOKIE['$Version']);
            unset ($_COOKIE['$Path']);
            unset ($_COOKIE['$Domain']);

            foreach ($_COOKIE as $key => $val)
            {
                $_COOKIE[self::cleanKeys ($key)] = self::cleanData ($val);
            }
        }

        // Sanitize PHP_SELF
        $_SERVER['PHP_SELF'] = strip_tags ($_SERVER['PHP_SELF']);

        // CSRF Protection check
        if (Ginc::config ('General.enable_csrf') == TRUE)
        {
            Security::csrfCheck ();
        }
    }


    /**
     * Clean Input Data
     *
     * This is a helper function. It escapes data and
     * standardizes newline characters to \n
     *
     * @param	string
     * @return	string
     */
    private static function cleanData ($str)
    {
        if (is_array ($str))
        {
            $new_array = array ();

            foreach ($str as $key => $val)
            {
                $new_array[self::cleanKeys ($key)] = self::cleanData ($val);
            }

            return $new_array;
        }

        // We strip slashes if magic quotes is on to keep things consistent
        if (function_exists ('get_magic_quotes_gpc') AND get_magic_quotes_gpc ())
        {
            $str = stripslashes ($str);
        }

        // Should we filter the input data?
        if (self::$_enable_xss === TRUE)
        {
            $str = Security::xssClean ($str);
        }

        // Standardize newlines if needed
        if (self::$_standardize_newlines === TRUE)
        {
            if (strpos ($str, "\r") !== FALSE)
            {
                $str = str_replace (array ("\r\n", "\r"), PHP_EOL, $str);
            }
        }

        return $str;
    }

}
