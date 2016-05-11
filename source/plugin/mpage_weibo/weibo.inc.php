<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: weibo.inc.php 29364 2013-07-02 14:47:58Z mpage $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$lang = array_merge($lang, $scriptlang['mpage_weibo']);

if(empty($_GET['ac'])) {

	if(!submitcheck('listsubmit')) {

		$perpage = 20;
		$start = ($page - 1) * $perpage;
		$mpurl = ADMINSCRIPT."?action=plugins&operation=config&identifier=mpage_weibo&pmod=weibo";

		showformheader('plugins&operation=config&identifier=mpage_weibo&pmod=weibo');
		showtableheader();
		showsubtitle(array('del', 'username', 'sina_username', 'bind', 'expires', 'update'));
		$count = C::t('#mpage_weibo#mpage_weibo')->count_by_search($_GET['username']);
		if($count) {
			$query = C::t('#mpage_weibo#mpage_weibo')->fetch_all_by_search($_GET['username'], $start, $perpage);
			foreach($query as $value) {
				showtablerow('', array('class="td25"'), array(
					'<input type="checkbox" class="checkbox" name="delete[]" value="'.$value['uid'].'" />',
					'<a href="home.php?mod=space&uid='.$value['uid'].'" target="_blank">'.$value['username'].'</a>',
					'<a href="http://weibo.com/u/'.$value['sina_uid'].'" target="_blank">'.$value['sina_username'].'</a>',
					dgmdate($value['dateline']),
					dgmdate($value['dateline'] + $value['expires_in']),
					dgmdate($value['update']),
				));
			}
			$multipage = multi($count, $perpage, $page, $mpurl);
		}
		showsubmit('listsubmit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();

	} else {

		if(is_array($_GET['delete'])) {
			C::t('#mpage_weibo#mpage_weibo')->delete($_GET['delete']);
		}

		cpmsg('bind_update_succeed', 'action=plugins&operation=config&identifier=mpage_weibo&pmod=weibo', 'succeed');

	}

}

?>