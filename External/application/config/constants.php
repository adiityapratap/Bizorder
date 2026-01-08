<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/


$arrofFloatCoins = array(
                                                                               array(
                                                                          "coinNameLabel" => '0.05',
                                                                           "inputId1" => '5c',
                                                                            "inputName" => '5c',
                                                                            "inputId2" => 't6',
                                                                            "managerInputName" => '5c1',
                                                                            "managerinputId2" => 't61',
                                                                             "floatBuildAmount" => '2.00',
                                                                             "FBamountPerItem" => '10',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '0.10',
                                                                           "inputId1" => '10c',
                                                                            "inputName" => '10c',
                                                                            "inputId2" => 't5',
                                                                            "managerInputName" => '10c1',
                                                                            "managerinputId2" => 't51',
                                                                            "floatBuildAmount" => '4.00',
                                                                             "FBamountPerItem" => '15',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '0.20',
                                                                           "inputId1" => '20c',
                                                                            "inputName" => '20c',
                                                                            "inputId2" => 't4',
                                                                             "managerInputName" => '20c1',
                                                                            "managerinputId2" => 't41',
                                                                            "floatBuildAmount" => '4.00',
                                                                             "FBamountPerItem" => '15',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '0.50',
                                                                           "inputId1" => '050c',
                                                                            "inputName" => '050c',
                                                                            "inputId2" => 't3',
                                                                             "managerInputName" => '050c1',
                                                                            "managerinputId2" => 't31',
                                                                            "floatBuildAmount" => '10.00',
                                                                             "FBamountPerItem" => '10',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '1.00',
                                                                           "inputId1" => '1d',
                                                                            "inputName" => '1d',
                                                                            "inputId2" => 't2',
                                                                             "managerInputName" => '1d1',
                                                                            "managerinputId2" => 't21',
                                                                            "floatBuildAmount" => '20.00',
                                                                             "FBamountPerItem" => '15',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '2.00',
                                                                           "inputId1" => '2d',
                                                                            "inputName" => '2d',
                                                                            "inputId2" => 't1',
                                                                             "managerInputName" => '2d1',
                                                                            "managerinputId2" => 't112',
                                                                            "floatBuildAmount" => '50.00',
                                                                             "FBamountPerItem" => '8',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '5.00',
                                                                           "inputId1" => '5d',
                                                                            "inputName" => '5d',
                                                                            "inputId2" => 't11',
                                                                             "managerInputName" => '5d1',
                                                                            "managerinputId2" => 't13',
                                                                            "floatBuildAmount" => '5.00',
                                                                             "FBamountPerItem" => '100',
                                                                                ),
                                                                                
                                                                                 array(
                                                                          "coinNameLabel" => '10.00',
                                                                           "inputId1" => '10d',
                                                                            "inputName" => '10d',
                                                                            "inputId2" => 't10',
                                                                             "managerInputName" => '10d1',
                                                                            "managerinputId2" => 't101',
                                                                            "floatBuildAmount" => '10.00',
                                                                             "FBamountPerItem" => '56',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '20.00',
                                                                           "inputId1" => '20d',
                                                                            "inputName" => '20d',
                                                                            "inputId2" => 't9',
                                                                             "managerInputName" => '20d1',
                                                                            "managerinputId2" => 't91',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '50.00',
                                                                           "inputId1" => '50d',
                                                                            "inputName" => '50d',
                                                                            "inputId2" => 't8',
                                                                             "managerInputName" => '50d1',
                                                                            "managerinputId2" => 't81',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '100.00',
                                                                           "inputId1" => '100d',
                                                                            "inputName" => '100d',
                                                                            "inputId2" => 't7',
                                                                             "managerInputName" => '100d1',
                                                                            "managerinputId2" => 't71',
                                                                                ),
                                                                                      );
$arrofCoins = array(
                                                                               array(
                                                                          "coinNameLabel" => '0.05',
                                                                           "inputId1" => '5c',
                                                                            "inputName" => '5c',
                                                                            "inputId2" => 't6',
                                                                            "managerInputName" => '5c1',
                                                                            "managerinputId2" => 't61',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '0.10',
                                                                           "inputId1" => '10c',
                                                                            "inputName" => '10c',
                                                                            "inputId2" => 't5',
                                                                            "managerInputName" => '10c1',
                                                                            "managerinputId2" => 't51',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '0.20',
                                                                           "inputId1" => '20c',
                                                                            "inputName" => '20c',
                                                                            "inputId2" => 't4',
                                                                             "managerInputName" => '20c1',
                                                                            "managerinputId2" => 't41',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '0.50',
                                                                           "inputId1" => '050c',
                                                                            "inputName" => '050c',
                                                                            "inputId2" => 't3',
                                                                             "managerInputName" => '050c1',
                                                                            "managerinputId2" => 't31',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '1.00',
                                                                           "inputId1" => '1d',
                                                                            "inputName" => '1d',
                                                                            "inputId2" => 't2',
                                                                             "managerInputName" => '1d1',
                                                                            "managerinputId2" => 't21',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '2.00',
                                                                           "inputId1" => '2d',
                                                                            "inputName" => '2d',
                                                                            "inputId2" => 't1',
                                                                             "managerInputName" => '2d1',
                                                                            "managerinputId2" => 't112',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '5.00',
                                                                           "inputId1" => '5d',
                                                                            "inputName" => '5d',
                                                                            "inputId2" => 't11',
                                                                             "managerInputName" => '5d1',
                                                                            "managerinputId2" => 't13',
                                                                                ),
                                                                                 array(
                                                                          "coinNameLabel" => '10.00',
                                                                           "inputId1" => '10d',
                                                                            "inputName" => '10d',
                                                                            "inputId2" => 't10',
                                                                             "managerInputName" => '10d1',
                                                                            "managerinputId2" => 't101',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '20.00',
                                                                           "inputId1" => '20d',
                                                                            "inputName" => '20d',
                                                                            "inputId2" => 't9',
                                                                             "managerInputName" => '20d1',
                                                                            "managerinputId2" => 't91',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '50.00',
                                                                           "inputId1" => '50d',
                                                                            "inputName" => '50d',
                                                                            "inputId2" => 't8',
                                                                             "managerInputName" => '50d1',
                                                                            "managerinputId2" => 't81',
                                                                                ),
                                                                                array(
                                                                          "coinNameLabel" => '100.00',
                                                                           "inputId1" => '100d',
                                                                            "inputName" => '100d',
                                                                            "inputId2" => 't7',
                                                                             "managerInputName" => '100d1',
                                                                            "managerinputId2" => 't71',
                                                                                ),
                                                                                      );
                                                                                      
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);
defined('COINS') OR define('COINS', $arrofCoins);
defined('FLOATCOINS') OR define('FLOATCOINS', $arrofFloatCoins);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
