<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo lang('items_generate_barcodes'); ?></title>
</head>
<body style="margin: 0;">
<table width='50%' align='center' cellpadding='20'>
<tr>
<?php 
for($k=0;$k<count($items);$k++)
{
	$item = $items[$k];
	$barcode = $item['id'];
	$text = $item['name'];
	
	$style = ($k == count($items) -1) ? 'text-align:center;font-size: 10pt;' : 'text-align:center;font-size: 10pt;page-break-after: always;';
	echo "<div style='$style'>".$this->Appconfig->get('company')."<br /><img src='".site_url('barcode')."?barcode=$barcode&text=$text&scale=$scale' /></div>";
}
?>
</tr>
</table>
</body>
</html>
