<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
    define('SITE_ROOT', 'C:'.DS.'wamp64'.DS.'www'.DS.'school_api');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

require_once(LIB_PATH.DS.'config.php');
require_once(LIB_PATH.DS.'functions.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'students.php');
require_once(LIB_PATH.DS.'user.php');
require_once(LIB_PATH.DS.'token.php');
require_once(LIB_PATH.DS.'grade.php');
require_once(LIB_PATH.DS.'marks.php');
require_once(LIB_PATH.DS.'subject.php');
require_once(LIB_PATH.DS.'teacher.php');
require_once(LIB_PATH.DS.'databaseObject.php');

