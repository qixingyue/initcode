<?php
class Util{
	/**
	 * 根据文件名获得图标
	 * @param  string $filename
	 * @return string
	 */
	static public function getFileIcon($filename){
		return self::extToIcon(self::getFileExt($filename, true));
	}

	/**
	 * 获取文件后缀
	 * @param  string  $filename
	 * @param  boolean $lower    是否转换为小写
	 * @return string
	 */
	static public function getFileExt($filename, $lower = false)
	{
		$dot_pos = strrpos($filename, '.');
		if(false === $dot_pos){
			return '';
		}
		else{
			$ext = substr($filename, $dot_pos + 1);
			$lower && $ext = strtolower($ext);
			return $ext;
		}
	}

	/**
	 * 根据文件后缀得到图标
	 * @param  string $ext
	 * @return string
	 */
	static public function extToIcon($ext){
		static $icons = array(
				//'图标class' => array(扩展名列表)
				'pic' => array('ai','bmp','gif','jpeg','jpg','png','psd','mpeg','raw'),
				'apk' => array('apk'),
				'ipa' => array('ipa'),
				'csv' => array('csv'),
				'epub' => array('epub'),
				'txt' => array('txt'),
				'wps' => array('wps'),
				'doc' => array('doc','docx'),
				'pdf' => array('pdf'),
				'ppt' => array('pps','ppsx','ppt','pptx'),
				'xls' => array('xlsx','xls'),
				'music' => array('mp3','wma','aac','ape','flac'),
				'video' => array('ai','mov','mpeg','wav','raw','mp4','rmvb'),
				'exe' => array('exe'),
				'swf' => array('swf'),
				'xap' => array('xap'),
				'html' => array('html'),
				'rar' => array('rar','zip'),
				);

		if($ext){
			foreach ($icons as $icon => $extensions) {
				if(in_array($ext, $extensions)){
					return $icon;
				}
			}
		}

		return 'other';
	}

	/*
	 * 字符串截断
	 * 如果长度大于len按照len-1截断，之后加...格式
	 */
	static public function substr_cut($str, $len) {
		$mbchars = array();
		$chars = array();
		for( $i=0, $I=strlen($str), $L=0; $L<$len && $i<$I;) {
			$char = substr($str, $i, 1);
			switch ( true ) {
				default :
					$chars[] = substr($str, $i, 1); $L++; $i++; break;
				case ( ord($char) >= 252 ) :
					$chars[] = substr($str, $i, 6); $L++; $i += 6; break;
				case ( ord($char) >= 248 ) :
					$chars[] = substr($str, $i, 5); $L++; $i += 5; break;
				case ( ord($char) >= 240 ) :
					$chars[] = substr($str, $i, 4); $L++; $i += 4; break;
				case ( ord($char) >= 224 ) :
					$chars[] = substr($str, $i, 3); $L++; $i += 3; break;
				case ( ord($char) >= 192 ) :
					$chars[] = substr($str, $i, 2); $L++; $i += 2; break;
			}
		}
		if($L>0&&$I>$i)
			$chars[$L-1]='...';
		return implode('', $chars);
	}

	/*
	 * 文件名类型字符串截断
	 * 如果除开后缀长度大于截断长度按(len-后缀-4)+...+后两个字+后缀处理
	 *
	 */
	static public function substr_cut_files($str, $len) {
		//规则len必须大于4
		if( $len<=4 )
			return $str;
		//获取后缀
		$tmp_profix = self::getFileIcon($str);
		$has_profix = 0;
		if( isset($tmp_profix) && 'other'!= $tmp_profix )
		{
			$dot_pos = strrpos($str, '.');
			$t_profix = substr($str, $dot_pos + 1);
			$str = substr($str, 0,strlen($str)-strlen($t_profix)-1);
			$has_profix = 1; 
		}
		$chars = array();
		$mbchars = array();
		for( $i=0, $I=strlen($str); $i<$I;) {
			$char = substr($str, $i, 1);
			switch ( true ) {
				default :
					$chars[] = substr($str, $i, 1);  $i++; break;
				case ( ord($char) >= 252 ) :
					$chars[] = substr($str, $i, 6);  $i += 6; break;
				case ( ord($char) >= 248 ) :
					$chars[] = substr($str, $i, 5);  $i += 5; break;
				case ( ord($char) >= 240 ) :
					$chars[] = substr($str, $i, 4);  $i += 4; break;
				case ( ord($char) >= 224 ) :
					$chars[] = substr($str, $i, 3);  $i += 3; break;
				case ( ord($char) >= 192 ) :
					$chars[] = substr($str, $i, 2);  $i += 2; break;
			}
		}
		$L = count($chars);
		if($L > $len){
			$k =0 ;
			foreach($chars as $k=>$v ){
				if( $k >= $len-4 )
					break;
				$charsnew[$k] = $v;
			}
			$charsnew[$k+1] = '...';
			$charsnew[$k+2] = $chars[$L-2];
			$charsnew[$k+3] = $chars[$L-1];
			if($has_profix)
				$charsnew[$k+4] = '.'.$t_profix;
			return implode('', $charsnew);
			$ext = substr($filename, $dot_pos + 1);
		}
		if($has_profix)
			$chars[$L] = '.'.$t_profix;
		return implode('', $chars);
	}
	/*
	 * 防止xss攻击
	 *
	 */
	static public function safe($value)
	{
		htmlentities($value, ENT_QUOTES, 'utf-8');
		// other processing
		return $value;
	}

	/*
	 * 创建目录
	 * 若存在返回revision若不存在先创建再返回
	 *
	 */
	static public function get_folderid($uid,$foldername)
	{
			$m_res = Comm_Vdisk::get_metadata($foldername,$uid);
			if(isset($m_res['revision']))
			{
					$folderid_vdisk = $m_res['revision'];
			}
			else
			{
					$res = Comm_Vdisk::create_folder($uid,$foldername);
					if(isset($res['revision']))
					{
							$folderid_vdisk = $res['revision'];
					}
					else
					{
							return false;
					}
			}
			return $folderid_vdisk;
	}

}
