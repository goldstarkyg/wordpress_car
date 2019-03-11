<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
	<?php    echo "<h2>" . __( 'DealerNetwork General Settings', 'dealernetwork_trdom' ) . "</h2>"; ?>
	
	<form name="dealernetwork_form" method="post" id="template" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="dealernetwork_hidden" value="Y">
		<?php
			if (isset($_POST['dealernetwork_hidden']) && $_POST['dealernetwork_hidden'] == 'Y') {
				$dealerid = intval(str_replace('\\', '', $_POST['dealernetwork_dealerid']));
				$locationid = intval(str_replace('\\', '', $_POST['dealernetwork_locationid']));
				$piwikid = intval(str_replace('\\', '', $_POST['dealernetwork_piwikid']));
				$listrpp = intval(str_replace('\\', '', $_POST['dealernetwork_listrpp']));
				
				$this->settings['DealerID'] = $dealerid;
				$this->settings['LocationID'] = $locationid;
				$this->settings['PiwikID'] = $piwikid;
				$this->settings['ListRPP'] = $listrpp;
				
				update_option( $this->settings_key, $this->settings );
				?>
				<div class="updated"><p><strong><?php _e(" Options saved." ); ?></strong></p></div>
				<?php
			} else {
				$dealerid = $this->settings['DealerID'];
				$locationid = $this->settings['LocationID'];
				$listrpp = $this->settings['ListRPP'];
				$piwikid = $this->settings['PiwikID'];
			}
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<?php _e("Dealer ID: " ); ?>
				</th>
				<td>
					<input type="number" name="dealernetwork_dealerid" value="<?php echo $dealerid; ?>" size="4" class="regular-text">
					<p class="description"><?php _e(" numeric" ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Location ID: " ); ?>
				</th>
				<td>
					<input type="number" name="dealernetwork_locationid" value="<?php echo $locationid; ?>" size="4" class="regular-text">
					<p class="description"><?php _e(" numeric" ); ?></p>
				</td>			
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Analytics ID: " ); ?>
				</th>
				<td>
					<input type="number" name="dealernetwork_piwikid" value="<?php echo $piwikid; ?>" size="4" class="regular-text">
					<p class="description"><?php _e(" numeric" ); ?></p>
				</td>			
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Default Vehicles Per Page: " ); ?>
				</th>
				<td>
					<input type="number" name="dealernetwork_listrpp" value="<?php echo $listrpp; ?>" size="4" class="regular-text">
					<p class="description"><?php _e(" numeric" ); ?></p>
				</td>
			</tr>
		</table>
		<p class="submit">
		<input type="submit" class="button button-primary" name="Submit" value="<?php _e('Update Options', 'dealernetwork_trdom' ) ?>" />
		</p>
	</form>
</div>