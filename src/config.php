<?php
 return array (
  'siteVersionName' => 'site-beta-1',
  'siteVersionCode' => '0.1.1',
  'apiPageIndex' => './index.php?action=page.index',
  'apiPageLogin' => './index.php?action=page.login',
  'apiPageLogout' => './index.php?action=page.logout',
  'apiPageJump' => './index.php?action=page.jump',
  'loginPluginId' => '102',
  'apiPageWidget' => './index.php?action=page.widget',
  'apiPageSiteInit' => './index.php?action=installDB',
  'session_verify_101' => 'http://open.akaxin.com:5208/index.php?action=api.session.verify&body_format=base64pb',
  'session_verify_102' => './index.php?action=api.session.verify&body_format=base64pb',
  'siteAddress' => 'http://127.0.0.1:5207',
  'passport_cookie_name' => 'duckchat_passport_cookie',
  'mail' => 
  array (
    'host' => 'smtp.126.com',
    'SMTPAuth' => true,
    'emailAddress' => 'xxxx@126.com',
    'password' => '',
    'SMTPSecure' => '',
    'port' => 25,
  ),
  'dbType' => 'sqlite',
  'dbVersion' => '2',
  'sqlite' => 
  array (
    'sqliteDBPath' => '.',
    'sqliteDBName' => 'db.471f4d7a9b76ba26e997d3d0ee979f80.sqlite3',
  ),
  'mysql' => 
  array (
    'dbName' => 'duckchat_site',
    'dbHost' => '127.0.0.1',
    'dbPort' => '3306',
    'dbUserName' => 'duckchat',
    'dbPassword' => '1234567890',
  ),
  'mysqlSlave' => 
  array (
  ),
  'logPath' => '.',
  'debugMode' => false,
  'msectime' => 1537619085135.0,
);
 