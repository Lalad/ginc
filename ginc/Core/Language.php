<?php

/**
 * Localization
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.I18n
 * @since         CakePHP(tm) v 1.2.0.4116
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


/**
 * Localization
 *
 * @package       Cake.I18n
 */
class Language
{

    /**
     * The language for current locale
     *
     * @var string
     */
    public static $language = 'English (United States)';

    /**
     * Locale
     *
     * @var string
     */
    public static $locale = 'en_us';

    /**
     * Encoding used for current locale
     *
     * @var string
     */
    public static $charset = 'utf-8';

    /**
     * Text direction for current locale
     *
     * @var string
     */
    public static $direction = 'ltr';

    /**
     * Set to true if a locale is found
     *
     * @var string
     */
    public static $found = false;


    /**
     * Gets the settings for $language.
     * If $language is null it attempt to get settings from Language::_autoLanguage(); if this fails
     * the method will get the settings from Language::_setLanguage();
     *
     * @param string $language Language (if null will use DEFAULT_LANGUAGE if defined)
     * @return mixed
     */
    public static function get ($language = null)
    {
        if ($language !== null)
        {
            return self::_setLanguage ($language);
        }

        if ( ! self::_autoLanguage ())
        {
            self::_setLanguage ();
        }

        return self::$lang;
    }


    /**
     * Sets the class vars to correct values for $language.
     * If $language is null it will use the DEFAULT_LANGUAGE if defined
     *
     * @param string $language Language (if null will use DEFAULT_LANGUAGE if defined)
     * @return mixed
     */
    protected static function _setLanguage ($language = null)
    {
        $langKey = null;
        if ($language !== null && isset (self::$_LanguageMap[$language]) && isset (self::$_LanguageCatalog[self::$_LanguageMap[$language]]))
        {
            $langKey = self::$_LanguageMap[$language];
        }
        elseif ($language !== null && isset (self::$_LanguageCatalog[$language]))
        {
            $langKey = $language;
        }
        else
        {
            $langKey  = $language = Ginc::config ('General.language');
        }

        if ($langKey !== null && isset (self::$_LanguageCatalog[$langKey]))
        {
            self::$language = self::$_LanguageCatalog[$langKey]['language'];
            self::$languagePath = array (
                self::$_LanguageCatalog[$langKey]['locale'],
                self::$_LanguageCatalog[$langKey]['localeFallback']
            );
            self::$lang = $language;
            self::$locale = self::$_LanguageCatalog[$langKey]['locale'];
            self::$charset = self::$_LanguageCatalog[$langKey]['charset'];
            self::$direction = self::$_LanguageCatalog[$langKey]['direction'];
        }
        else
        {
            self::$lang = $language;
            self::$languagePath = array ($language);
        }

        if (self::$default)
        {
            if (isset (self::$_LanguageMap[self::$default]) && isset (self::$_LanguageCatalog[self::$_LanguageMap[self::$default]]))
            {
                self::$languagePath[] = self::$_LanguageCatalog[self::$_LanguageMap[self::$default]]['localeFallback'];
            }
            elseif (isset (self::$_LanguageCatalog[self::$default]))
            {
                self::$languagePath[] = self::$_LanguageCatalog[self::$default]['localeFallback'];
            }
        }
        self::$found = true;

        if ($language)
        {
            return $language;
        }
    }


    /**
     * Attempts to find the locale settings based on the HTTP_ACCEPT_LANGUAGE variable
     *
     * @return boolean Success
     */
    protected static function _autoLanguage ()
    {
        $_detectableLanguages = Ginc::acceptLanguage ();
        foreach ($_detectableLanguages as $key => $langKey)
        {
            if (isset (self::$_LanguageCatalog[$langKey]))
            {
                self::_setLanguage ($langKey);
                return true;
            }
            elseif (strpos ($langKey, '-') !== false)
            {
                $langKey = substr ($langKey, 0, 2);
                if (isset (self::$_LanguageCatalog[$langKey]))
                {
                    self::_setLanguage ($langKey);
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * Attempts to find locale for language, or language for locale
     *
     * @param mixed $mixed 2/3 char string (language/locale), array of those strings, or null
     * @return mixed string language/locale, array of those values, whole map as an array,
     *    or false when language/locale doesn't exist
     */
    public function map ($mixed = null)
    {
        if (is_array ($mixed))
        {
            $result = array ();
            foreach ($mixed as $_mixed)
            {
                if ($_result = self::$map ($_mixed))
                {
                    $result[$_mixed] = $_result;
                }
            }
            return $result;
        }
        elseif (is_string ($mixed))
        {
            if (strlen ($mixed) === 2 && in_array ($mixed, self::$_LanguageMap))
            {
                return array_search ($mixed, self::$_LanguageMap);
            }
            elseif (isset (self::$_LanguageMap[$mixed]))
            {
                return self::$_LanguageMap[$mixed];
            }
            return false;
        }
        return self::$_LanguageMap;
    }


    /**
     * Attempts to find catalog record for requested language
     *
     * @param mixed $language string requested language, array of requested languages, or null for whole catalog
     * @return mixed array catalog record for requested language, array of catalog records, whole catalog,
     *    or false when language doesn't exist
     */
    public function catalog ($language = null)
    {
        if (is_array ($language))
        {
            $result = array ();
            foreach ($language as $_language)
            {
                if ($_result = self::catalog ($_language))
                {
                    $result[$_language] = $_result;
                }
            }
            return $result;
        }
        elseif (is_string ($language))
        {
            if (isset (self::$_LanguageCatalog[$language]))
            {
                return self::$_LanguageCatalog[$language];
            }
            elseif (isset (self::$_LanguageMap[$language]) && isset (self::$_LanguageCatalog[self::$_LanguageMap[$language]]))
            {
                return self::$_LanguageCatalog[self::$_LanguageMap[$language]];
            }
            return false;
        }
        return $this->_LanguageCatalog;
    }

}
