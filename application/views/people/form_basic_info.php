
<div class="field_row clearfix">	

<?php echo form_label(lang('common_first_name').':', 'first_name',array('class'=>'required')); ?>
	<div class='form_field'>

	<?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'class'=>'form-control',
		'value'=>$person_info->first_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_last_name').':', 'last_name',array('class'=>'required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'last_name',
		'class'=>'form-control',
		'value'=>$person_info->last_name)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_email').':', 'email'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control',
		'value'=>$person_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_phone_number').':', 'phone_number'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone_number',
		'class'=>'form-control',
		'id'=>'phone_number',
		'value'=>$person_info->phone_number));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_address_1').':', 'address_1'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_1',
		'class'=>'form-control',
		'id'=>'address_1',
		'value'=>$person_info->address_1));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_address_2').':', 'address_2'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'address_2',
		'class'=>'form-control',
		'id'=>'address_2',
		'value'=>$person_info->address_2));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_city').':', 'city'); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'city',
		'class'=>'form-control',
		'id'=>'city',
		'value'=>$person_info->city));?>
	</div>
</div>

<!--
<div class="field_row clearfix">	
<?php echo form_label(lang('common_state').':', 'state'); ?>
	<div class='form_field'> -->

	<?php $dataState = array(
		'type'  => 'hidden',
		'name'=>'state',
		'class'=>'form-control',
		'id'=>'state',
		'value'=>$person_info->state
        );

     echo form_input($dataState);?>

<!--	</div>
</div>

<div class="field_row clearfix">	
<?php  echo form_label(lang('common_zip').':', 'zip'); ?>
	<div class='form_field'>   -->
	<?php $dataZip = array(
		'type'  => 'hidden',
		'name'=>'zip',
		'class'=>'form-control',
		'id'=>'zip',
		'value'=>$person_info->zip
        );

	 echo form_input($dataZip); ?>
 <!-- 	</div>
</div>
  -->
<div class="field_row clearfix">	
<?php echo form_label(lang('common_country').':', 'country'); ?>
	<div class='form_field'> 
	<?php echo form_input(array(
		'name'=>'country',
		'class'=>'form-control',
		'id'=>'country',
		'value'=>$person_info->country));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label(lang('common_comments').':', 'comments'); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'class'=>'form-control',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'cols'=>'17')		
	);?>
	</div>
</div>

<?php
if ($this->config->item('mailchimp_api_key'))
{
?>
<div class="field_row clearfix">
	<div class="column">	
		<?php echo form_label(lang('common_mailing_lists').':', 'mailchimp_mailing_lists'); ?>
	</div>
	
    <div class="column">
		<ul style="list-style: none;">
	<?php 
	foreach(get_all_mailchimps_lists() as $list)
	{
		echo '<li>';
		echo form_checkbox(array('name'=> 'mailing_lists[]',
		'id' => $list['id'],
		'value' => $list['id'],
		'checked' => email_subscribed_to_list($person_info->email, $list['id']),
		'label'	=> $list['id']));
		echo form_label($list['name'], $list['id'], array('style' => 'float: none;'));
		echo '</li>';
	}
	?>
	</ul>
	</div>
	<div class="cleared"></div>
</div>
<?php
}
?>