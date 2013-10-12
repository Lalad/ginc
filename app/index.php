<?php
/**
 * - Ginc Framework
 *
 * * An open source application development framework for PHP 5.2.x or newer
 *
 * @package     Ginc
 * @author      Ginc Dev Team
 * @copyright           Copyright (c) 2009 - 2011, Lelad, Inc.
 * @license     http://ginc-project.com/license.html
 * @link        http://ginc-project.com
 * @since       Version 1.6
 * @filesource
 */


/**
 *  Set flag that this is a parent file
 */
    define('Ginc', '2.5');


/**
 * Loadign system Files
 */
    require_once './Defines.php';

    require_once PATH_CORE . 'Ginc.php';

    // Runing application
    Ginc::run();


/**
 *  Load the GMVC and Run it
 */
    // Load the base controller class
    Ginc::load ('GMVC', 'Core');

    // Runing application
    GMVC::run();


/**
 * Set a mark point for end loading base class
 */
    // end Exection Base Time
    define('END_EXECUTION_TIME', microtime(TRUE));

    // end Exection Base Memory
    define('END_EXECUTION_MEMORY_USAGE', memory_get_usage());


// print_r(get_included_files ());

echo '<div id="speenfo">'
    // Total time in seconds
     . '<span class="time"><small>' . number_format(END_EXECUTION_TIME - START_EXECUTION_TIME, 5) . '</small></span>'
    // Amount of memory in bytes
     . '<br /><span class="mem"><small>' . number_format(END_EXECUTION_MEMORY_USAGE - START_EXECUTION_MEMORY_USAGE) . ' = ' . round((END_EXECUTION_MEMORY_USAGE - START_EXECUTION_MEMORY_USAGE)/1024/1024, 2).'MB' . '</small></span>'
. '</div>';
