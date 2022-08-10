<?php

namespace App\Traits\Arabic;

/**
 * Trait ArabicNumbers
 * @package App\Traits\Arabic
 */
trait ArabicNumbers {

	/**
	 * @param $str
	 *
	 * @return string
	 */
	public function en2ar($str)
	{
		$number = '';
		$strParse = str_split($str, 1);
		$arabic = array( 0 => '٠', 1 =>  '١', 2 => '٢', 3 => '٣', 4 => '٤', 5 => '٥', 6 => '٦', 7 =>'٧', 8 => '٨', 9 => '٩');
		foreach($strParse as $num){
			if(array_key_exists($num, $arabic)){
				$number .= $arabic[$num];
			}
		}
		return $number;
	}
}