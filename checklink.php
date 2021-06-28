<?php
	ob_start();
	header('Content-Type: application/json');
	function url_test($url) {
		$timeout = 10;
		$ch = curl_init();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
		$http_respond = curl_exec($ch);
		$http_respond = trim( strip_tags( $http_respond ) );
		$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
			return "true";
		}else{
			return "false";
		}
		curl_close( $ch );
	}
	function get_host($url){
		try{
			$parse = parse_url($url);
			return $parse['host'];	
		} catch (Exception $e) {
			return "false";
		}
	}
	function get_title($url){
		try{
			$str = file_get_contents($url);
			if(strlen($str)>0){
				$str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
				preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
				return $title[1];
			}else{
				return "false";
			}
		} catch (Exception $e) {
			return "false";
		}
	}
	function get_img($url , $host){
		try{
			$str = file_get_contents($url);
			if(strlen($str)>0){
				$str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
				preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $str, $image);
				if( (strpos($image['src'], '.png') !== false) or (strpos($image['src'], '.jpg') !== false) or (strpos($image['src'], '.jpeg') !== false) or (strpos($image['src'], '.gif') !== false) ){ 
					return $image['src'];
				}else{
					return "false";
				}
			}else{
				return "false";
			}
		} catch (Exception $e) {
			return "false";
		}
	}
	if (isset($_POST['link'])){
		$aResult = array();
		$url_test=url_test($_POST['link']);
		$host=get_host($_POST['link']);
		if ($url_test=="true"){
			try{
				$sites_html = file_get_contents($_POST['link']);
				$html = new DOMDocument();
				@$html->loadHTML($sites_html);
				$meta_og_img = null;
				$meta_og_title = null;
				$meta_og_desc = null;
				foreach($html->getElementsByTagName('meta') as $meta) {
					if($meta->getAttribute('property')=='og:image'){ 
						$meta_og_img = $meta->getAttribute('content');
					}
					if($meta->getAttribute('property')=='og:title'){ 
						$meta_og_title = $meta->getAttribute('content');
					}
					if($meta->getAttribute('property')=='og:description'){ 
						$meta_og_desc = $meta->getAttribute('content');
					}
				}
				if ($meta_og_img==null){$meta_og_img=get_img($_POST['link'],$host); }				
				if ($meta_og_title==null){$meta_og_title=get_title($_POST['link']); }				
				if ($meta_og_desc==null){$meta_og_desc="false"; }
				//$meta_og_title=utf8_decode($meta_og_title);
				//$meta_og_desc=utf8_decode($meta_og_desc);
				array_push($aResult,$url_test,$meta_og_img,$meta_og_title,$meta_og_desc,$host);
			} catch (Exception $e) {
				array_push($aResult,"false","false","false","false","false");
			}
		}else{			
			array_push($aResult,$url_test,"false","false","false","false");
		}
		ob_end_clean();
		echo json_encode($aResult);
	}

?>