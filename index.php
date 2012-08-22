<?php

require "config/defines.php";
require "config/startup.php";

$front = new Front();
$front->setLocales( array('fr', 'en', 'es', 'it') );
$front->setPath(APP_DIR . DS . 'modules');
$front->run();
