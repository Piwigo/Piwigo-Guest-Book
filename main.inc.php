<?php
/*
Plugin Name: GuestBook
Version: auto
Description: Add a guestbook to the gallery
Plugin URI: auto
Author: Mistic
Author URI: http://www.strangeplanet.fr
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

// TODO akismet
global $conf, $prefixeTable;

define('GUESTBOOK_ID',      basename(dirname(__FILE__)));
define('GUESTBOOK_PATH' ,   PHPWG_PLUGINS_PATH . GUESTBOOK_ID . '/');
define('GUESTBOOK_TABLE' ,  $prefixeTable . 'guestbook');
define('GUESTBOOK_ADMIN',   get_root_url().'admin.php?page=plugin-' . GUESTBOOK_ID);
define('GUESTBOOK_URL',     get_absolute_root_url() . make_index_url(array('section' => 'guestbook')));

$conf['guestbook'] = safe_unserialize($conf['guestbook']);

include_once(GUESTBOOK_PATH . 'include/events.inc.php');


add_event_handler('init', 'guestbook_init');

if (defined('IN_ADMIN'))
{
  add_event_handler('get_admin_plugin_menu_links', 'gb_admin_menu');
}
else
{
  add_event_handler('loc_end_section_init', 'gb_section_init');
  add_event_handler('loc_end_index', 'gb_index');
}

if ($conf['guestbook']['menu_link'])
{
  add_event_handler('blockmanager_apply', 'gb_menubar_apply', EVENT_HANDLER_PRIORITY_NEUTRAL+10);
}


function guestbook_init()
{
  load_language('plugin.lang', GUESTBOOK_PATH);
}
