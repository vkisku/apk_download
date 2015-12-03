<?PHP 
/*
DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 1, December 2015

 Copyright (C) 2015 Vikash Kumar Kisku <vikashkisku@gmail.com>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.

  You just need to supply the aptoide link of the android app you want to download and then you just need to wait for few seconds to get the link.
*/
include('simple_html_dom.php');
class apk{
	private $html;
	private $md;
	private $market;
	private $replace;
	private $link;
	private $pool="http://pool.apk.aptoide.com/";
function __construct($link){
		$this->link=$link;

	}
private function validate($link){ // validation of the aptoide link
		if (!filter_var($link, FILTER_VALIDATE_URL) === false) {
			if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)((m.apps)|[-a-z0-9]*)(.store.aptoide.com\/)([a-z]*\/)(market\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$link)) {
				return true;

			} 
		}
	}
private function get_md5(){// getting the md5 hash of the file
		$a[0]=$this->html->getElementByTagName("div.window_section")->nextsibling()->childNodes(1)->childNodes(0)->plaintext;
		$a[1]=$this->html->getElementByTagName("div.window_section")->nextsibling()->nextsibling()->childNodes(1)->childNodes(0)->plaintext;
		$this->md=trim(substr(strchr($a[0],"MD5:")?$a[0]:$a[1],4));
		
	}

private function get_market(){// getting the market from the store
		$p1=strpos($this->link,"aptoide.com")+11;
		$p2=strpos($this->link,"/market");
		$this->market=substr($this->link,$p1+1,$p2-$p1-1)."/";
	}

private function replace(){
		$p1=strpos($this->link,"market/")+7;
		$p2=strripos($this->link,"/");
		$p3=substr($this->link,$p1,$p2-$p1);
		$this->replace=str_replace("_","-",str_replace("/","-",str_replace(".","-",$p3)))."-";
	}
function get_apk(){
		if(self::validate($this->link)){//accessing the rest only if the link is valid.
			$this->html =file_get_html($this->link);
			self::get_market();
			self::get_md5();
			self::replace();
			return $this->pool.$this->market.$this->replace.$this->md.".apk";

		}
	}
}
?> 
