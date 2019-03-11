<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
	<?php    echo "<h2>" . __( 'DealerNetwork SEO Settings', 'dealernetwork_trdom' ) . "</h2>"; ?>
	
	<form name="dealernetwork_form" method="post" id="template" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="dealernetwork_hidden" value="Y">
		<?php
			if (isset($_POST['dealernetwork_hidden']) && $_POST['dealernetwork_hidden'] == 'Y') {
				$metadescription = str_replace('\\', '', $_POST['dealernetwork_metadescription']);
				$metakeywords = str_replace('\\', '', $_POST['dealernetwork_metakeywords']);
				$detailmetadescription = str_replace('\\', '', $_POST['dealernetwork_detailmetadescription']);
				$detailmetakeywords = str_replace('\\', '', $_POST['dealernetwork_detailmetakeywords']);
				
				$this->settings['MetaDescription'] = $metadescription;
				$this->settings['MetaKeywords'] = $metakeywords;
				$this->settings['DetailMetaDescription'] = $detailmetadescription;
				$this->settings['DetailMetaKeywords'] = $detailmetakeywords;
				
				update_option( $this->settings_key, $this->settings );
				?>
				<div class="updated"><p><strong><?php _e(" Options saved." ); ?></strong></p></div>
				<?php
			} else {
				$metadescription = $this->settings['MetaDescription'];
				$metakeywords = $this->settings['MetaKeywords'];
				$detailmetadescription = $this->settings['DetailMetaDescription'];
				$detailmetakeywords = $this->settings['DetailMetaKeywords'];
			}
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<?php _e("Meta Description: " ); ?>
				</th>
				<td>
					<textarea rows="5" cols="70" name="dealernetwork_metadescription"><?php echo $metadescription; ?></textarea>
					<p class="description"><?php _e(" " ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Meta Keywords: " ); ?>
				</th>
				<td>
					<textarea rows="5" cols="70" name="dealernetwork_metakeywords"><?php echo $metakeywords; ?></textarea>
					<p class="description"><?php _e(" " ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Detail Meta Description: " ); ?>
				</th>
				<td>
					<textarea rows="5" cols="70" name="dealernetwork_detailmetadescription"><?php echo $detailmetadescription; ?></textarea>
					<p class="description"><?php _e(" " ); ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<?php _e("Detail Meta Keywords: " ); ?>
				</th>
				<td>
					<textarea rows="5" cols="70" name="dealernetwork_detailmetakeywords"><?php echo $detailmetakeywords; ?></textarea>
					<p class="description"><?php _e(" " ); ?></p>
				</td>
			</tr>
		</table>
		<p class="submit">
		<input type="submit" class="button button-primary" name="Submit" value="<?php _e('Update Options', 'dealernetwork_trdom' ) ?>" />
		</p>
	</form>
</div>