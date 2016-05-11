<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: callback.inc.php 31649 2013-05-01 16:06:16Z mpage $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'./source/plugin/mpage_weibo/config.php';
require_once DISCUZ_ROOT.'./source/plugin/mpage_weibo/saetv2.ex.class.php';

$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);

if(isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken('code', $keys) ;
	} catch (OAuthException $e) {
	}
}

if($token) {
	$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $token['access_token']);
	$user_message = $c->show_user_by_id($token['uid']);
	$token['username'] = $user_message['screen_name'];
	$token['username'] = diconv($token['username'], 'UTF-8', $_G['charset']);

	dsetcookie('weibo_token', addslashes(serialize($token)), 86400);
	dsetcookie('weibojs_'.$o->client_id, http_build_query($token), 86400);

	if($_G['uid']) {
		if($bind = C::t('#mpage_weibo#mpage_weibo')->fetch($_G['uid'])) {
			C::t('#mpage_weibo#mpage_weibo')->update($_G['uid'], array(
				'sina_uid' => $token['uid'],
				'sina_username' => $token['username'],
				'token' => $token['access_token'],
				'remind_in' => $token['remind_in'],
				'expires_in' => $token['expires_in'],
				'update' => $_G['timestamp'],
			));
		} else {
			C::t('#mpage_weibo#mpage_weibo')->insert(array(
				'uid' => $_G['uid'],
				'username' => $_G['username'],
				'sina_uid' => $token['uid'],
				'sina_username' => $token['username'],
				'token' => $token['access_token'],
				'remind_in' => $token['remind_in'],
				'expires_in' => $token['expires_in'],
				'thread' => 1,
				'reply' => 1,
				'follow' => 1,
				'blog' => 1,
				'doing' => 1,
				'share' => 1,
				'article' => 1,
				'dateline' => $_G['timestamp'],
				'update' => $_G['timestamp'],
			));
		}

		showmessage('mpage_weibo:bind_succeed', 'home.php?mod=spacecp&ac=plugin&id=mpage_weibo:bind');
	} else {
		$bind = C::t('#mpage_weibo#mpage_weibo')->fetch_by_sina_uid($token['uid']);
		$member = getuserbyuid($bind['uid'], 1);

		if($bind && $member) {
			if(isset($member['_inarchive'])) {
				C::t('common_member_archive')->move_to_master($member['uid']);
			}

			require_once libfile('function/member');
			$cookietime = 1296000;
			setloginstatus($member, $cookietime);

			loadcache('usergroups');
			$usergroups = $_G['cache']['usergroups'][$_G['groupid']]['grouptitle'];
			$param = array('username' => $_G['member']['username'], 'usergroup' => $_G['group']['grouptitle']);

			C::t('common_member_status')->update($bind['uid'], array('lastip'=>$_G['clientip'], 'lastvisit'=>TIMESTAMP, 'lastactivity' => TIMESTAMP));
			$ucsynlogin = '';
			if($_G['setting']['allowsynlogin']) {
				loaducenter();
				$ucsynlogin = uc_user_synlogin($_G['uid']);
			}

			showmessage('login_succeed', dreferer(), $param, array('extrajs' => $ucsynlogin));
		} else {
			$dreferer = rawurlencode(dreferer());
			showmessage('mpage_weibo:complete_or_bind', 'member.php?mod='.$_G['setting']['regname'].'&referer='.$dreferer);
		}
	}
} else {
	echo lang('plugin/mpage_weibo', 'reauth_fail');
}

?>