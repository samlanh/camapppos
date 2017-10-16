<?php
function get_css_files()
{
	if(!defined("ENVIRONMENT") or ENVIRONMENT == 'development')
	{
		return array(
			array('path' =>'css/phppos.css', 'media' => 'all'),
			array('path' =>'css/menubar.css', 'media' => 'all'),
			array('path' =>'css/general.css', 'media' => 'all'),
			array('path' =>'css/popupbox.css', 'media' => 'all'),
			array('path' =>'css/register.css', 'media' => 'all'),
			array('path' =>'css/receipt.css', 'media' => 'all'),
			array('path' =>'css/reports.css', 'media' => 'all'),
			array('path' =>'css/tables.css', 'media' => 'all'),
			array('path' =>'css/thickbox.css', 'media' => 'all'),
			array('path' =>'css/datepicker.css', 'media' => 'all'),
			array('path' =>'css/editsale.css', 'media' => 'all'),
			array('path' =>'css/footer.css', 'media' => 'all'),
			array('path' =>'css/css3.css', 'media' => 'all'),
			array('path' =>'css/jquery-ui-1.8.14.custom.css', 'media' => 'all'),
			array('path' =>'css/jquery.loadmask.css', 'media' => 'all'),
			array('path' =>'css/phppos_print.css', 'media' => 'print'),			
		);
	}
	
	$config =& get_config();
	$_path = "css/all.css";
	if($config['language'] === "khmer"){
		$_path = "css/all_kh.css";
	}	
	return array(		
		array('path' =>$_path, 'media' => 'all'),	
		array('path' =>'css/suspended.css', 'media' => 'all'),
		array('path' =>'css/phppos_print.css', 'media' => 'print'),
	);
}

function get_js_files()
{
	if(!defined("ENVIRONMENT") or ENVIRONMENT == 'development')
	{
		return array(
			array('path' =>'js/jquery-1.3.2.min.js'),
			array('path' =>'js/jquery-ui-1.8.14.custom.min.js'),
			array('path' =>'js/jquery.color.js'),
			array('path' =>'js/jquery.form.js'),
			array('path' =>'js/jquery.tablesorter.min.js'),
			array('path' =>'js/jquery.validate.min.js'),
			array('path' =>'js/thickbox.js'),
			array('path' =>'js/common.js'),
			array('path' =>'js/manage_tables.js'),
			array('path' =>'js/date.js'),
			array('path' =>'js/datepicker.js'),
			array('path' =>'js/jquery.loadmask.min.js'),
		);
	}
	
	return array(
		array('path' =>'js/all.js'),
	);
}
?>