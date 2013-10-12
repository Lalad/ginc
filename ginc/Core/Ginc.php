<?php

defined ('Ginc') or die ('no direct script access allowed'); // no direct access
/**
 * - Engine
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package		Ginc
 * @author		Ginc Dev Team
 * @copyright   Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license		http://ginc-project.com/license.html
 * @link		http://ginc-project.com
 * @since		Version 1.6
 * @filesource
 */
// start Exection Time
define ('START_EXECUTION_TIME', microtime (TRUE));

// start Exection Memory
define ('START_EXECUTION_MEMORY_USAGE', memory_get_usage (TRUE));


class Ginc
{

    private static $object = array ();
    private static $config = array ();
    private static $var = array ();
    private static $base    = '';
    private static $webroot = '';
    private static $here    = '';
    private static $query   = '';


    public static function run ()
    {
        /**
         * - sets the error_reporting directive at runtime.
         *
         * PHP has many levels of errors,
         * using this function sets that level
         * for the duration (runtime) of your script.
         * If the optional level is not set, error_reporting()
         * will just return the current error reporting level.
         * http://www.php.net/manual/en/function.error-reporting.php
         */
        error_reporting (E_ALL | E_STRICT);


        /**
         * - Sets the default timezone
         *
         * used by all date/time functions in a script
         *
         * note:
         * Since PHP 5.1.0 (when the date/time functions were rewritten),
         * every call to a date/time function will generate a E_NOTICE
         * if the timezone isn't valid, and/or a E_WARNING message
         * if using the system settings or the TZ environment variable.
         *
         * @see  http://php.net/timezones
         */
        date_default_timezone_set ('Africa/Casablanca');


        /**
         * Security
         */
        /**
         * - Set a liberal script execution time limit
         *
         * Set the number of seconds a script is allowed to run.
         * If this is reached, the script returns a fatal error.
         * The default limit is 30 seconds or, if it exists,
         * the max_execution_time value defined in the php.ini.
         */
        if (function_exists ("set_time_limit") == TRUE AND @ini_get ("safe_mode") == 0)
        {
            @set_time_limit (300);
        }


        // Set the current active configuration setting of magic_quotes_runtime
        if (version_compare (PHP_VERSION, '5.3', '>='))
        {
            @set_magic_quotes_runtime (0); // Kill magic quotes
        }


        /**
         * - AutoLoad
         *
         * Register a function with the spl provided __autoload stack.
         * If the stack is not yet activated it will be activated.
         *
         * http://www.php.net/manual/en/function.spl-autoload-register.php
         */
        spl_autoload_register ('Ginc::autoLoad');

        // Loading Input class
        self::load ('Input', 'Core');

        // Loading Inflector class
        self::load ('Inflector', 'Library');

        // Check If gettext is Installed
        if (function_exists ("gettext"))
        {
            $locale     = 'el';
            $locale_dir = PATH_LOCALE; // relative path
            putenv ("LC_ALL=");
            putenv ("LANG=en_US.UTF-8");
            putenv ("LANGUAGE=$locale");
            setlocale (LC_ALL, "");
            // initial gettext domain settings
            bindtextdomain ("messages", $locale_dir);
            textdomain ("messages");
        }
        else
        {
            // Loading I18n class
            self::load ('I18n', 'Core');
            // Loading I18n Helper
            self::load ('MBString', 'Helper');
        }

        // The full URL to the "datas" folder
        define ('FULL_BASE_URL', isset ($_SERVER['HTTPS']) && strtolower ($_SERVER['HTTPS']) !== 'off' ?
                        'https' : 'http'
                        . '://' . $_SERVER['HTTP_HOST']
                        . str_replace (basename ($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']));


        /* ====== Main App ====== */
        print nl2br ('<br /><br /><br /><div style="margin: 0 auto 0 auto; padding: 30px; width:550px; text-align:left; background-color:lightgreen; font-family:sans-serif; font-weight:bold"><p>');

        print nl2br ("PHP Gettext " . _ ("Demonstration") . PHP_EOL . PHP_EOL);
        print nl2br (_ ("If you change your browser language setting to a different first language you can then view this page in different languages.") . ' ' . _ ("Spanish, French and German translations are provided.") . ' ' . _ ("Try adding a new gettext language translation.") . PHP_EOL . PHP_EOL);
        print nl2br (_ ("In Firefox go to ") . _ ("Edit") . " | " . _ ("Preferences") . " | " . _ ("Content") . " | " . _ ("Languages") . PHP_EOL . PHP_EOL);
        print nl2br (_ ("In IE go to ") . _ ("Tools") . " | " . _ ("Internet Options") . " | " . _ ("General") . " | " . _ ("Languages") . PHP_EOL . PHP_EOL);
        print nl2br (_ ("If you look at the php source file you will see that we are using gettext to translate both single words and full sentences.") . PHP_EOL . PHP_EOL);
        print nl2br (_ ("In Main App") . PHP_EOL . PHP_EOL);
        print nl2br (_ ("Now using the Main App translation file.") . PHP_EOL);

        print nl2br ('</p></div>' . PHP_EOL);

        // Loading Security class
        self::load ('Security', 'Core');

        // Sanitize Globals Variables For Securty
        Input::_sanitize_globals ();
    }


    /**
     * Fonction spéciale de loading Libraries and helpers and core File System
     */
    public static function load ($apps, $location, $show_error = TRUE)
    {
        if (is_array ($apps))
        {
            foreach ($apps as $app)
            {
                self::load ($app, $location, $show_error);
            }
        }

        $location = str_replace ('/', DS, $location);

        if (file_exists (PATH_APPLICATION . $location . DS . $apps . '.php'))
        {
            return require_once (PATH_APPLICATION . $location . DS . $apps . '.php');
        }
        elseif (file_exists (PATH_SYSTEM . $location . DS . $apps . '.php'))
        {
            return require_once (PATH_SYSTEM . $location . DS . $apps . '.php');
        }
        elseif ($show_error == TRUE)
        {
            // Show Error
            throw new Exception ("This File " . $location . DS . $apps . ".php Dont Exists in {$location}", 1);
        }

        return FALSE;
    }


    /**
     * Fonction spéciale de loading config
     */
    public static function config ($config_and_offset)
    {
        $Config = array ();

        if (strpos ('.', $config_and_offset) === FALSE)
        {
            $config_array = explode ('.', $config_and_offset);
            $config_name  = $config_array[0];
            $config_kyes  = array_splice ($config_array, 1);
        }

        if (array_key_exists (strtoupper ($config_name), self::$config))
        {
            $Config = array_merge ($Config, self::$config[strtoupper ($config_name)]);
        }
        else
        {
            self::$config[strtoupper ($config_name)] = self::load ($config_name, 'Config');

            $Config = array_merge ($Config, self::$config[strtoupper ($config_name)]);
        }

        if (strpos ('.', $config_and_offset) === FALSE)
        {
            if (isset ($config_kyes[0]))
            {
                return $Config[$config_kyes[0]];
            }
        }

        return $Config;
    }


    /**
     * Fonction Auto de loading
     */
    public static function autoLoad ($object_name)
    {
        // Loading From Core
        if (self::load ($object_name, 'Core', FALSE))
        {
            return FALSE;
        }

        // Loading From Libraries
        elseif (self::load ($object_name, 'Library', FALSE))
        {
            return FALSE;
        }
    }


    /**
     * Get the request uri.  Looks in PATH_INFO first, as this is the exact value we need prepared
     * by PHP.  Following that, REQUEST_URI, PHP_SELF, HTTP_X_REWRITE_URL and argv are checked in that order.
     * Each of these server variables have the base path, and query strings stripped off
     *
     * @return string URI The CakePHP request path that is being accessed.
     */
    public static function url ()
    {
        if ( ! empty ($_SERVER['PATH_INFO']))
        {
            return $_SERVER['PATH_INFO'];
        }
        elseif (isset ($_SERVER['REQUEST_URI']))
        {
            $uri = $_SERVER['REQUEST_URI'];
        }
        elseif (isset ($_SERVER['PHP_SELF']) && isset ($_SERVER['SCRIPT_NAME']))
        {
            $uri = str_replace ($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']);
        }
        elseif (isset ($_SERVER['HTTP_X_REWRITE_URL']))
        {
            $uri = $_SERVER['HTTP_X_REWRITE_URL'];
        }
        elseif ($var = env ('argv'))
        {
            $uri = $var[0];
        }

        $base = self::$base;

        if (strlen ($base) > 0 && strpos ($uri, $base) === 0)
        {
            $uri = substr ($uri, strlen ($base));
        }

        if (strpos ($uri, '?') !== false)
        {
            list($uri) = explode ('?', $uri, 2);
        }

        if (empty ($uri) || $uri == '/' || $uri == '//')
        {
            return '/';
        }

        return $uri;
    }


    /**
     * Returns the referer that referred this request.
     *
     * @param boolean $local Attempt to return a local address. Local addresses do not contain hostnames.
     * @return string The referring address for this request.
     */
    public static function referer ($local = false)
    {
        $ref       = Input::env ('HTTP_REFERER');
        $forwarded = Input::env ('HTTP_X_FORWARDED_HOST');

        if ($forwarded)
        {
            $ref = $forwarded;
        }

        $base = '';

        if (defined ('FULL_BASE_URL'))
        {
            $base = FULL_BASE_URL . self::$webroot;
        }

        if ( ! empty ($ref) && ! empty ($base))
        {
            if ($local && strpos ($ref, $base) === 0)
            {
                $ref = substr ($ref, strlen ($base));
                if ($ref[0] != '/')
                {
                    $ref = '/' . $ref;
                }
                return $ref;
            }
            elseif ( ! $local)
            {
                return $ref;
            }
        }
        return '/';
    }


    /**
     * Get the domain name and include $tldLength segments of the tld.
     *
     * @param integer $tldLength Number of segments your tld contains. For example: `example.com` contains 1 tld.
     *   While `example.co.uk` contains 2.
     * @return string Domain name without subdomains.
     */
    public static function domain ($tldLength = 1)
    {
        $segments = explode ('.', Input::env ('HTTP_HOST'));
        $domain   = array_slice ($segments, -1 * ($tldLength + 1));
        return implode ('.', $domain);
    }


    /**
     * Get the subdomains for a host.
     *
     * @param integer $tldLength Number of segments your tld contains. For example: `example.com` contains 1 tld.
     *   While `example.co.uk` contains 2.
     * @return array of subdomains.
     */
    public static function subdomains ($tldLength = 1)
    {
        $segments = explode ('.', Input::env ('HTTP_HOST'));
        return array_slice ($segments, 0, -1 * ($tldLength + 1));
    }


    public static function _set ($offset, $value)
    {
        self::$var[$offset] = $value;
    }


    public static function _get ($offset = FALSE)
    {
        if ($offset === FALSE)
        {
            return self::$var;
        }

        return array_key_exists ($offset, self::$var) ? self::$var[$offset] : FALSE;
    }


    public static function _remove ($offset)
    {
        if (array_key_exists ($offset, self::$var))
        {
            unset (self::$var[$offset]);
        }
    }


    public static function _count ($offset = null)
    {
        if ($offset != NULL)
        {
            count (self::$var[$offset]);
        }
        else
        {
            count (self::$var);
        }
    }


    /**
     * Get the languages accepted by the client, or check if a specific language is accepted.
     *
     * Get the list of accepted languages:
     *
     * {{{ CakeRequest::acceptLanguage(); }}}
     *
     * Check if a specific language is accepted:
     *
     * {{{ CakeRequest::acceptLanguage('es-es'); }}}
     *
     * @param string $language The language to test.
     * @return If a $language is provided, a boolean. Otherwise the array of accepted languages.
     */
    public static function acceptLanguage ($language = null)
    {
        $accepts = preg_split ('/[;,]/', Input::env ('HTTP_Accept-Language'));
        foreach ($accepts as &$accept)
        {
            $accept = strtolower ($accept);
            if (strpos ($accept, '_') !== false)
            {
                $accept = str_replace ('_', '-', $accept);
            }
        }
        if ($language === null)
        {
            return $accepts;
        }
        return in_array ($language, $accepts);
    }


    /**
     * Write Log File
     */
    public static function logWrite ($msg, $type = 'Error')
    {
        // string  timestamp format for log entries
        static $time = 'Y-m-d H:i:s';

        // If WRITE_LOG_MESSAGE if is True
        if (Ginc::config ('General.WRITE_LOG_MESSAGE') == FALSE)
        {
            return;
        }

        $file_path = PATH_LOGS . $type . '.php';

        $log_message = NULL;

        if ( ! file_exists ($file_path) or filesize ($file_path) < 50)
        {
            $log_message = '<?php' . "\n"
                    . '// This file is part of Ginc.' . "\n"
                    . '// no direct access' . "\n"
                    . 'defined(\'Ginc\') or die(\'no direct script access allowed\');' . "\n?>\n\n";
        }

        $log_message .= 'Time  : ' . date ('Y-m-d H:i:s') . "\n" . $msg
                . "\n" . '#------------------------------------------------------------------' . "\n\n";

        // writle
        if ( ! ($f = fopen ($file_path, 'ab')))
            throw new Exception ('this file' . ' <b>' . $file_path . '</b> ' . 'is not writable', 1);

        // On écrit
        fwrite ($f, $log_message);

        // On ferme
        fclose ($f);
    }

}

/**
 * Set a mark point for end loading base class
 */
// end Exection Base Time
define ('END_BASE_EXECUTION_TIME', microtime (TRUE));

// end Exection Base Memory
define ('END_BASE_EXECUTION_MEMORY_USAGE', memory_get_usage (TRUE));