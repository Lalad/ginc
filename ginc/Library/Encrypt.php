<?php
defined('Ginc') or die('no direct script access allowed'); // no direct access
/**
 * Ginc
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package		Encrypt
 * @author		Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license		http://ginc-project.com/license.html
 * @link		http://ginc-project.com
 * @since		Version 1.6
 * @filesource
 */


class Encrypt
{


    /**
     * Encrypt a value
     * @param  mixed
     * @return string
     * */
    public static function crypt($strValue)
    {
        if (empty($strValue))
        {
            return;
        }

        // Loading Encrypt Configuration
        $resTd = mcrypt_module_open(Ginc::config('General.encryption_cipher'), '', Ginc::config('General.encryption_mode'), '');

        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($resTd), MCRYPT_RAND);
        mcrypt_generic_init($resTd, md5(Ginc::config('General.encryption_key')), $iv);

        $strEncrypted = mcrypt_generic($resTd, $strValue);
        $strEncrypted = base64_encode($iv . $strEncrypted);

        mcrypt_generic_deinit($resTd);

        return $strEncrypted;
    }


    /**
     * Decrypt a value
     * @param  mixed
     * @return string
     * */
    public static function decrypt($strValue)
    {
        if (empty($strValue))
        {
            return;
        }

        $resTd = mcrypt_module_open(Ginc::config('General.encryption_cipher'), '', Ginc::config('General.encryption_mode'), '');

        $strValue = base64_decode($strValue);

        $ivsize = mcrypt_enc_get_iv_size($resTd);
        $iv = substr($strValue, 0, $ivsize);
        $strValue = substr($strValue, $ivsize);

        if ($strValue == '')
        {
            return;
        }

        mcrypt_generic_init($resTd, md5(Ginc::config('General.encryption_key')), $iv);
        $strDecrypted = mdecrypt_generic($resTd, $strValue);

        mcrypt_generic_deinit($resTd);

        return $strDecrypted;
    }

}
