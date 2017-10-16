</div>
</div>
	
	<table id="footer_info">
		<tr>
			<td id="menubar_footer">
			<?php echo lang('common_welcome')." <b> $user_info->first_name $user_info->last_name! | </b>"; ?>
			<?php
			if ($this->config->item('track_cash') && $this->Sale->is_register_log_open()) {
				echo anchor("sales/closeregister?continue=logout",lang("common_logout"));
			} else {
				echo anchor("home/logout",lang("common_logout"));
			}
			?>
			</td>
	
			<td id="menubar_date_time" class="menu_date">
				<?php
				if($this->config->item('time_format') == '24_hour')
				{
					echo date('H:i');					
				}
				else
				{
					echo date('h:i');
				}
				?>
			</td>
			<td id="menubar_date_day" class="menu_date mini_date">
				<?php echo date('D') ?>	
				<br />
				<?php
				if($this->config->item('time_format') != '24_hour')
				{
					echo date('a');
				}
				?>
			</td>
			<td id="menubar_date_spacer" class="menu_date">
				|
			</td>
			<td id="menubar_date_date" class="menu_date">
				<?php echo date('d') ?>
			</td>
			<td id="menubar_date_monthyr" class="menu_date mini_date">
				<?php echo date('F') ?>
				<br />
				<?php echo date('Y') ?>
			</td>
		</tr>
	</table>
	
	<div id="footer_spacer"></div>

	<table id="footer">
		<tr>
			<td id="footer_cred">
				<?php echo lang('common_please_visit_my'); ?> 
					<a href="http://www.vssservice.com.com" target="_blank">
						<?php echo lang('common_website'); ?>
					</a> 
				<?php echo lang('common_learn_about_project'); ?>.
			</td>
			<td id="footer_version">
				<?php echo lang('common_you_are_using_phppos')?> <?php echo APPLICATION_VERSION; ?>.
			</td>
		</tr>
	</table>
</body>
</html>