<?php

defined ('Ginc') or die ('no direct script access allowed'); // no direct access
/**
 * - Ginc Framework
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package   Output
 * @author    Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license   http://ginc-project.com/license.html
 * @link    http://ginc-project.com
 * @since   Version 1.6
 * @filesource
 */


class Output
{

    private static $default_theme = "default";
    private static $current_theme = FALSE;
    private static $final_output  = NULL;
    public static $use_theme     = TRUE;


// public static $cache_expiration   = 2;

    public static function display ($output)
    {
        if (Input::is ('ajax') OR self::$use_theme == FALSE)
        {
            self::$final_output = $output;
        }
        else
        {
            $search       = '{featch::component}';
            $tmpl_content = file_get_contents (self::getTMPL ());
            self::$final_output = eval ("?>" . str_replace ($search, $output, $tmpl_content));
        }

        if (
                Ginc::config ('General.compress_output') == TRUE
                AND
                extension_loaded ('zlib')
                AND
                isset ($_SERVER['HTTP_ACCEPT_ENCODING'])
                AND
                strpos ($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE
        )
        {
            ob_start ('ob_gzhandler');

            echo self::$final_output;
        }
        else
        {
            echo self::$final_output;
        }
    }


    private static function getTMPL ()
    {
        if (self::$current_theme !== FALSE and is_dir (PATH_THEME . self::$current_theme . DS))
        {
            $current_theme = PATH_THEMES . self::$current_theme;
        }
        else
        {
            $current_theme = PATH_THEMES . Ginc::config ("General.theme");
        }

        $dir = array (Router::init ()->class, Router::init ()->method);
        $dir       = array_merge (explode ('/', Router::init ()->directory), $dir);
        $dir       = array_map ("Inflector::camelize", $dir);
        $path_tmpl = $current_theme;

        for ($i = 0; $i < count ($dir); $i ++ )
        {
            if (empty ($dir[$i]))
                continue;

            if (is_dir ($path_tmpl . DS . $dir[$i]))
            {
                $path_tmpl .= DS . $dir[$i];
            }
            else
            {
                $path_tmpl .= DS . $dir[$i];

                break;
            }
        }

        if (file_exists ($path_tmpl . '.php'))
        {
            $path_tmpl = $path_tmpl . '.php';
        }
        elseif (file_exists (str_replace (DS . $dir[$i], NULL, $path_tmpl . '.php')))
        {
            $path_tmpl = str_replace (DS . $dir[$i], NULL, $path_tmpl . '.php');
        }
        else
        {
            $path_tmpl = $current_theme . DS . self::$default_theme . '.php';
        }

        return $path_tmpl;
    }

    /*
      private static function _write_cache($output)
      {
      if ( ! is_dir(PATH_CACHE))
      {
      Log::_write('Cache Error', "Unable to write cache file: " . PATH_CACHE);

      return;
      }

      $uri = URI::getURL();

      $filepath = PATH_CACHE . md5($uri);

      if ( ! $fp = @fopen($filepath, 'wb'))
      {
      Log::_write('Cache Error', "Unable to write cache file: " . $filepath);

      return;
      }

      $expire = time() + (self::$cache_expiration * 60);

      if (flock($fp, LOCK_EX))
      {
      fwrite($fp, $expire . 'TS--->' . $output);

      flock($fp, LOCK_UN);
      }

      else
      {
      Log::_write('Cache Error', "Unable to secure a file lock for file at: " . $filepath);

      return;
      }

      fclose($fp);

      @chmod($filepath, 0666);
      }


      /**
     * update/serve a cached file
     *
     * @access  public
     * @return  void
     * /
      private static function _display_cache()
      {
      $uri = URI::getURL();

      $filepath = PATH_CACHE . md5($uri);

      if ( ! @file_exists($filepath))
      {
      return FALSE;
      }

      if ( ! $fp = @fopen($filepath, 'r'))
      {
      return FALSE;
      }

      flock($fp, LOCK_SH);

      $cache = '';

      if (filesize($filepath) > 0)
      {
      $cache = fread($fp, filesize($filepath));
      }

      flock($fp, LOCK_UN);

      fclose($fp);

      // Strip out the embedded timestamp
      if ( ! preg_match("/(\d+TS--->)/", $cache, $match))
      {
      return FALSE;
      }

      // Has the file expired? If so we'll delete it.
      if (time() >= trim(str_replace('TS--->', '', $match['1'])))
      {
      if (is_writable($filepath))
      {
      @unlink($filepath);

      return FALSE;
      }
      }

      // Display the cache
      echo str_replace($match['0'], '', $cache);

      return TRUE;
      }
     */

}
