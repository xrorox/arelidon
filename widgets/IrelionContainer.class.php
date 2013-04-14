<?php

class irelionContainer {

	private $html_generated = "";
   	

    // --- CONSTRUCTOR ---
	function __construct(){
		$num = func_num_args();
		
		switch($num){
			case 1 :
				$this->html_generated = generateHTML(func_get_arg(0));
			break;
		}
	}

	function getHTML($html="")
	{
		if($html_generated != "")
			return $html_generated;
		else
			return generateHTML($html);
		$returnHtml = ' <table>';
	}
	
	function generateHTML($html)
	{
		$returnHtml = '
			<table style="width: 200px;" cellpadding="0" cellspacing="0">
				<tr>
					<td class="top-left">
					</td>
					<td class="top-middle">
					</td>
					<td class="top-right">
					</td>
				</tr>
				
		
				<tr>
					<td class="middle-left">
					</td>
					<td class="middle">
						'.$html.'
					</td>
					<td class="middle-right">
					</td>
				</tr>
				
		
				<tr>
					<td class="bottom-left">
					</td>
					<td class="bottom-middle">
					</td>
					<td class="bottom-right">
					</td>
				</tr>
			</table>';
		
		return $returnHtml;
	}

	public static function echoBefore($class="")
	{
		echo IrelionContainer::getBefore($class);
	}
	
	public static function getBefore($class)
	{
		$str = '<table class="'.$class.'" style="width: 200px;" cellpadding="0" cellspacing="0">
				<tr>
					<td class="top-left">
					</td>
					<td class="top-middle">
					</td>
					<td class="top-right">
					</td>
				</tr>
				
		
				<tr>
					<td class="middle-left">
					</td>
					<td class="middle">';
					
		return $str;
	}
	
	public static function echoAfter()
	{
		echo IrelionContainer::getAfter();
	}
	
	
	public static function getAfter()
	{
		$str = '</td>
					<td class="middle-right">
					</td>
				</tr>
				
		
				<tr>
					<td class="bottom-left">
					</td>
					<td class="bottom-middle">
					</td>
					<td class="bottom-right">
					</td>
				</tr>
			</table>';
					
		return $str;
	}
}