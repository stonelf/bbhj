<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: map.inc.php 31649 2013-04-26 22:52:40Z mpage $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$map_center = $_G['cache']['plugin']['mpage_baidu_map']['map_center'];
$map_zoom = $_G['cache']['plugin']['mpage_baidu_map']['map_zoom'];
$map_height = $_G['cache']['plugin']['mpage_baidu_map']['map_height'];

$navtitle = $_G['cache']['plugin']['mpage_baidu_map']['seo_title'];
$metadescription = $_G['cache']['plugin']['mpage_baidu_map']['seo_description'];
$metakeywords = $_G['cache']['plugin']['mpage_baidu_map']['seo_keywords'];

include template('mpage_baidu_map:map');

?>