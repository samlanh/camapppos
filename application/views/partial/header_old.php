<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
   <!-- Google Khmer web fontss -->
	<link href='http://fonts.googleapis.com/css?family=Hanuman:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/font-icon/css/font-awesome.css?<?php echo APPLICATION_VERSION; ?>" />


	<?php		
	foreach(get_css_files() as $css_file)
	{
	?>
		<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url().$css_file['path'].'?'.APPLICATION_VERSION;?>" media="<?php echo $css_file['media'];?>" />
	<?php
	}
	?>	
    
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>assets/css/non-responsive.css" />

	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>assets/css/mystyle.css" />

	<script type="text/javascript">
	var SITE_URL= "<?php echo site_url(); ?>";
	</script>
	<?php
	foreach(get_js_files() as $js_file)
	{
	?>
		<script src="<?php echo base_url().$js_file['path'].'?'.APPLICATION_VERSION;?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<?php
	}
	?>	
	<script type="text/javascript" src="<?= base_url('assets/js/script.js'); ?>"></script>
	<script type="text/javascript">
	Date.format = '<?php echo get_js_date_format(); ?>';
	$.ajaxSetup ({
    	cache: false
	});
	</script>
<style type="text/css">
html {
    overflow: auto;
}
.companylogo img{height:60px;padding-top: 8px;}

<?php 
	$config =& get_config();	
	if($config['language'] === "khmer"){
		?>
		.container {
		min-height: 515px;
	    margin-top: 0px;
	    width: 100%;
	    max-width: none !important;    
         }

		<?php
	}else{
		?>
        .container {
        min-height: 515px;
	    margin-top: 0px;
	    width: 100%;
	    max-width: none !important;    
         }
		<?php
	}	

?>


</style>
</head>
<body>
<div id="menubar">

	<table id="menubar_container">
		<tr id="menubar_navigation">
			<td class="menu_item_home">			
				<a class='companylogo' href="<?php echo site_url(); ?>"><img src="<?= $this->Appconfig->get_logo_image(); ?>">
				</a>
			</td>
			<?php
			$arr_icone = array(
			'customers'=>'<i class="fa fa-users fa-2x" aria-hidden="true"></i><br/> ',

			'items'=>'<i class="fa fa-university fa-2x" aria-hidden="true"></i><br/> ',

			'item_kits'=>'<i class="fa fa-object-group fa-2x" aria-hidden="true"></i><br/>',

			'suppliers'=>'<i class="fa fa-life-ring fa-2x" aria-hidden="true"></i><br>',


			'reports'=>'<i class="fa fa-book  fa-2x" aria-hidden="true"></i><br>',

			'receivings'=>'<i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i><br>',

			'sales'=>'<i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i><br>',

			'employees'=>'<i class="fa fa-user-circle-o fa-2x" aria-hidden="true"></i><br>',

			'giftcards'=>'<i class="fa fa-bell fa-2x" aria-hidden="true"></i><br>',

			'config'=>'<i class="fa fa-cog fa-2x" aria-hidden="true"></i><br>'
			);
			foreach($allowed_modules->result() as $module)
			{
			?>
			<td class="menu_item menu_item_<?php echo $module->module_id;?>" >
				<a href="<?php echo site_url("$module->module_id");?>" style="padding-top:10px;"><?php echo $arr_icone[$module->module_id]; ?><?php echo lang("module_".$module->module_id) ?></a>
			</td>
			<?php
			}
			?>
		</tr>

	</table>
</div>

<!--
<div id="content_area_wrapper">
<div id="content_area">

-->