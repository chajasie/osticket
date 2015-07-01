<?php
/*********************************************************************
    ostconfig.php

    Static osTicket configuration file. Mainly useful for mysql login info.
    Created during installation process and shouldn't change even on upgrades.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006,2007,2008 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
    $Id: $
**********************************************************************/
#Disable direct access.
define('ROOT_PATH', '/adunic/');
if(!strcasecmp(basename($_SERVER['SCRIPT_NAME']),basename(__FILE__)) || !defined('ROOT_PATH')) die('kwaheri rafiki!');

#Install flag
define('OSTINSTALLED',TRUE);
if(OSTINSTALLED!=TRUE){
    if(!file_exists(ROOT_PATH.'setup/install.php')) die('Error: Contact system admin.'); //Something is really wrong!
    //Invoke the installer.
    header('Location: '.ROOT_PATH.'setup/install.php');
    exit;
}

# Encrypt/Decrypt secret key - randomly generated during installation.
define('SECRET_SALT','f462707d288c85ae12eb3216e1496fa5');

#Default admin email. Used only on db connection issues and related alerts.
define('ADMIN_EMAIL','ticket@s-v-o.ch');

#Mysql Login info
define('DBTYPE','mysql');
define('DBHOST','localhost');
define('DBNAME','kmu365ch_osticket5');
define('DBUSER','kmu365ch_ostickt');
define('DBPASS','Standard15');
#Table prefix
define('TABLE_PREFIX','');
define('APS_UPGRADE','On');
error_reporting(1);
?>
