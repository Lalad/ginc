<?php

defined ('Ginc') or die ('no direct script access allowed'); // no direct access
/**
 * - Ginc Framework
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package		Security
 * @author		Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license		http://ginc-project.com/license.html
 * @link		http://ginc-project.com
 * @since		Version 1.6
 * @filesource
 */


class Security
{

    /**
     * @var  string  key name used for token storage
     */
    public static $csrf_token_name  = 'scr_token';
    private static $csrf_cookie_name = 'coo_scr_kie';
    private static $csrf_expire      = 7200; // Two hours (in seconds)

    /**
     * Méthode qui retourne une chaine de caractères HTML en fonction du charset
     *
     * @param	str chaine de caractères
     * @return	string chaine de caractères tenant compte du charset
     * &lt;html&gt; return <html>
     * */


    public static function strRevCheck ($str)
    {
        if (is_array ($str))
        {
            return array_map ('self::strRevCheck', $str);
        }

        return html_entity_decode ($str, ENT_QUOTES, Ginc::config ('General.charset'));
    }


    /**
     * Generate and store a unique token which can be used to help prevent
     * [CSRF](http://wikipedia.org/wiki/Cross_site_Request_Forgery) attacks.
     *
     *     $token = Security::csrfToken();
     *
     * You can insert this token into your forms as a hidden field:
     *
     *     echo Form::hidden('csrf', Security::csrfToken());
     *
     * This provides a basic, but effective, method of preventing CSRF attacks.
     *
     * @param   boolean  force a new token to be generated?
     * @return  string
     */
    public static function csrfToken ($new = FALSE)
    {
        // Get the current token
        $token = Input::cookie (self::$csrf_cookie_name);

        if ($new === TRUE OR empty ($token))
        {
            // Generate a new unique token
            $token = uniqid ('security_token');

            $expire = time () + self::$csrf_expire;

            // Store the new token
            Input::setCookie (self::$csrf_cookie_name, $token, $expire);
        }

        return $token;
    }


    /**
     * Check that the given token matches the currently stored security token.
     *
     *     if (Security::csrfCheck($token))
     *     {
     *         // Pass
     *     }
     *
     * @param   string   token to check
     * @return  boolean
     */
    public static function csrfCheck ()
    {
        // If no POST data exists we will set the CSRF cookie
        if (count (Input::$data) == 0)
        {
            return;
        }

        // Do the tokens exist in both the Input::$data and _COOKIE arrays?
        if ( ! isset (Input::$data[self::$csrf_token_name]) OR ! Input::cookie (self::$csrf_cookie_name))
        {
            throw new Exception ('The action you have requested is not allowed.', 2);
        }

        // Do the tokens match?
        if (Input::$data[self::$csrf_token_name] != Input::cookie (self::$csrf_cookie_name))
        {
            throw new Exception ('The action you have requested is not allowed.', 3);
        }

        // We kill this since we're done and we don't want to polute the Input::$data array
        unset (Input::$data[self::$csrf_token_name]);

        // nothing should last forever
        // unset($_COOKIE[self::$csrf_cookie_name]);
        // Input::removeCookie(self::$csrf_cookie_name);
        // Set new Token
        // self::csrfToken(TRUE);
    }


    /**
     * remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @access	public
     * @param	string
     * @return	string
     */
    public static function rmInvisibleCharacters ($str, $url_encoded = TRUE)
    {
        if (is_array ($str))
        {
            return array_map ('self::rmInvisibleCharacters', $str);
        }

        $non_displayables = array ();

        // every control character except newline (dec 10)
        // carriage return (dec 13), and horizontal tab (dec 09)

        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';  // url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';   // url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';   // 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace ($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }


    /**
     * XSS Clean
     *
     * @access	public
     * @param	string
     * @return	string
     * */
    public static function xssClean ($str, $str_check = TRUE)
    {
        // If $str Is Array
        if (is_array ($str))
        {
            while (list($key) = each ($str))
            {
                $str[$key] = self::xScanner ($str[$key], $str_check);
            }

            return $str;
        }

        // remove_all NULL bytes
        $str = str_replace ("\0", '', $str);

        // Fix &entity\n;
        $str = str_replace (array ('&amp;', '&lt;', '&gt;'), array ('&amp;amp;', '&amp;lt;', '&amp;gt;'), $str);
        $str = preg_replace ('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $str);
        $str = preg_replace ('/(&#x*[0-9A-F]+);*/iu', '$1;', $str);

        // remove any attribute starting with "on" or xmlns
        $str = preg_replace ('#(?:on[a-z]+|xmlns)\s*=\s*[\'"\x00-\x20]?[^\'>"]*[\'"\x00-\x20]?\s?#iu', '', $str);

        // remove javascript: and vbscript: protocols
        $str = preg_replace ('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $str);
        $str = preg_replace ('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $str);
        $str = preg_replace ('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $str);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $str = preg_replace ('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#is', '$1>', $str);
        $str = preg_replace ('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#is', '$1>', $str);
        $str = preg_replace ('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#ius', '$1>', $str);

        // remove namespaced elements (we do not need them)
        $str = preg_replace ('#</*\w+:\w[^>]*+>#i', '', $str);

        /*
         *  Validate UTF16 two byte encoding (x00)
         * Just as above, adds a semicolon if missing.
         */
        $str = preg_replace ('#(&\#x?)([0-9A-F]+);?#i', "\\1\\2;", $str);

        // remove Invisible Characters Again!
        $str = self::rmInvisibleCharacters ($str);

        // convert code to string
        if ($str_check === TRUE)
        {
            $str = htmlspecialchars ($str, ENT_QUOTES, Ginc::config ('General.charset'));
        }

        return $str;
    }

}
