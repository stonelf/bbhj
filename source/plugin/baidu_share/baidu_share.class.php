<?php

/**
 * A class of Baidu Share plugin for Discuz! X3
 * @author Dahao.Saerdna.Zhao
 */

class plugin_baidu_share {

	/**
	* The class constructor
	*/

    function plugin_baidu_share() {
	
		/**
		* Global constant defined by Discuz! X2
		*/

        global $_G;
		
		/**
		* Get config variables for baidu share plugin
		* script: javascript code of baidu share button  
		* @var string
		*/
        $this->script = $_G['cache']['plugin']['baidu_share']['baidu_share_script'];
		
		/**
		* position: position of baidu share button in Discuz! main page.
		* 1:header of the top post 2:footer of the top post 3:above the top post 4:behind the top post
		* @var number
		*/
		$this->position = $_G['cache']['plugin']['baidu_share']['baidu_share_position'];
		
		/**
		* position: position of baidu share button in Discuz! main page.
		* 1:header of the top post 2:footer of the top post 3:above the top post 4:behind the top post
		* @var number
		*/
		$this->content = $_G['cache']['plugin']['baidu_share']['baidu_share_content'];
    }
	
	
	/**
	* Get the version of ie browser
	* @returns number 
	* if the browser is ie,return its version
	* if not,return 0
	*/
	function is_ie() {
		$str=preg_match('/MSIE ([0-9]\.[0-9])/',$_SERVER['HTTP_USER_AGENT'],$matches);
		if ($str == 0){
			return 0;
		} else {
			return floatval($matches[1]);
		}
			
	}
	
	/**
	* Return "if the browser is firefox"
	* @returns boolean
	* if the browser is firefox,return true
	* else return false
	*/
	function is_ff() {
		$str=preg_match('/Firefox/',$_SERVER['HTTP_USER_AGENT'],$matches);
		if ($str == 0){
			return false;
		} else {
			return true;
		}
	}
}

class plugin_baidu_share_group extends plugin_baidu_share {
	function viewthread_postheader() {
		if ($this->position == 1) {
			$v = $this->is_ie();
			if ($v <= 6 && $v != 0) {
				return array('<div style="float:right;position:relative;top:-20px;">' . $this->script . '</div>');
			} else if ($v == 7) {
				return array('<div style="float:right;position:relative;top:-20px;">' . $this->script . '</div>');
			} else if ($this->is_ff()) {
				return array('<div style="float:right;">' . $this->script . '</div>');
			} else {
				return array('<div style="float:right;position:relative;top:-6px;">' . $this->script . '</div>');
			}
		} else {
			return array();
		}
	}
	
	function viewthread_postfooter(){
		if($this->position == 2) {
			$v = $this->is_ie();
			if ($v <= 6 && $v != 0) {
				return array('<div style="line-height:14px;margin-top:6px;float:left;">' . $this->script . '</div>');
			} else if ($v == 7) {
				return array('<div style="line-height:14px;margin-top:6px;float:left;">' . $this->script . '</div>');
			} else if ($this->is_ff()) {
				return array('<div style="line-height:14px;float:right;margin-top:6px;">' . $this->script . '</div>');
			} else {
				return array('<div style="line-height:14px;margin-top:6px;float:right;position:relative;">' . $this->script . '</div>');
			}
		}else {
			return array();
		}
	}
	
	function viewthread_posttop() {
		if ($this->position == 3) {
			return array('<div style="float:left;padding-top:5px;margin-bottom:25px;width:100%">' . $this->script . '</div>');
		} else {
			return array();
		}
	}
	
	function viewthread_postbottom() {
		if ($this->position == 4) {
			return array('<div style="margin-bottom:-10px; overflow:hidden;">' . $this->script . '</div>');
		} else {
			return array('');
		}
	}
	
	function viewthread_endline(){
		if($this->content == 2){
			$v = "<script type='text/javascript'>var arrAll=document.getElementsByTagName('*');for (var i=0;i<arrAll.length;i++){if(arrAll[i].id.substring(0,11)=='postmessage'){var data=arrAll[i].innerHTML.replace(/<[^>].*?>/g,\"\").replace(/\\n|\\r|\\t/g,\" \");var baidushare=document.getElementById('bdshare');baidushare.setAttribute('data','{\"text\":data}');break;}}</script>";
			return array('<div>' . $v  . '</div>');
		}
		else{
			return array();
		}
		
	}
	
	function viewthread_useraction() {
		return "";
	}
}

class plugin_baidu_share_forum extends plugin_baidu_share {
	function viewthread_postheader() {
		if ($this->position == 1) {
			$v = $this->is_ie();
			if ($v <= 6 && $v != 0) {
				return array('<div style="float:right;position:relative;top:-20px;">' . $this->script . '</div>');
			} else if ($v == 7) {
				return array('<div style="float:right;position:relative;top:-20px;">' . $this->script . '</div>');
			} else if ($this->is_ff()) {
				return array('<div style="float:right;">' . $this->script . '</div>');
			} else {
				return array('<div style="float:right;position:relative;top:-6px;">' . $this->script . '</div>');
			}
		} else {
			return array();
		}
	}
	
	function viewthread_postfooter(){
		if($this->position == 2) {
			$v = $this->is_ie();
			if ($v <= 6 && $v != 0) {
				return array('<div style="margin-top:6px;line-height:14px;float:left;">' . $this->script . '</div>');
			} else if ($v == 7) {
				return array('<div style="margin-top:6px;line-height:14px;float:left;">' . $this->script . '</div>');
			} else if ($v == 8) {
				return array('<div style="margin-top:6px;line-height:14px;float:right;margin-top:6px;">' . $this->script . '</div>');
			} else if ($this->is_ff()) {
				return array('<div style="margin-top:6px;line-height:14px;float:right;margin-top:6px;">' . $this->script . '</div>');
			} else {
				return array('<div style="margin-top:6px;line-height:14px;float:right;position:relative;">' . $this->script . '</div>');
			}
		}else {
			return array();
		}
	}
	
	function viewthread_posttop() {
		if ($this->position == 3) {
			return array('<div style="float:left;padding-top:5px;margin-bottom:25px;width:100%">' . $this->script . '</div>');
		} else {
			return array();
		}
	}
	
	function viewthread_postbottom() {
		if ($this->position == 4) {
			return array('<div style="margin-bottom:-10px; overflow:hidden;">' . $this->script . '</div>');
		} else {
			return array('');
		}
	}
	
	function viewthread_endline(){
		if($this->content == 2){
			$v = "<script type='text/javascript'>var arrAll=document.getElementsByTagName('*');for (var i=0;i<arrAll.length;i++){if(arrAll[i].id.substring(0,11)=='postmessage'){var data=arrAll[i].innerHTML.replace(/<[^>].*?>/g,\"\").replace(/\\n|\\r|\\t/g,\" \");var baidushare=document.getElementById('bdshare');baidushare.setAttribute('data','{\"text\":data}');break;}}</script>";
			return array('<div>' . $v  . '</div>');
		}
		else{
			return array();
		}
		
	}
	
	function viewthread_useraction() {
		return "";
	}
}

?>
