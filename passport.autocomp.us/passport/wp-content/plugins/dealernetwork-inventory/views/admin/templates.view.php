<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
	<?php    echo "<h2>" . __( 'DealerNetwork Templates', 'dealernetwork_trdom' ) . "</h2>"; ?>
	
	<form name="dealernetwork_form" method="post" id="template" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="dealernetwork_hidden" value="Y">
		<?php
			if (isset($_POST['dealernetwork_hidden']) && $_POST['dealernetwork_hidden'] == 'Y') {
				$listtemplate = str_replace('\\', '', $_POST['dealernetwork_listtemplate']);
				$listtemplatecss = str_replace('\\', '', $_POST['dealernetwork_listtemplatecss']);
				$detailtemplate = str_replace('\\', '', $_POST['dealernetwork_detailtemplate']);
				$detailtemplatecss = str_replace('\\', '', $_POST['dealernetwork_detailtemplatecss']);
				$featuredtemplate = str_replace('\\', '', $_POST['dealernetwork_featuredtemplate']);
				$featuredtemplatecss = str_replace('\\', '', $_POST['dealernetwork_featuredtemplatecss']);
				$populartemplate = str_replace('\\', '', $_POST['dealernetwork_populartemplate']);
				$populartemplatecss = str_replace('\\', '', $_POST['dealernetwork_populartemplatecss']);
				$newadditiontemplate = str_replace('\\', '', $_POST['dealernetwork_newadditiontemplate']);
				$newadditiontemplatecss = str_replace('\\', '', $_POST['dealernetwork_newadditiontemplatecss']);
				$bestpricetemplate = str_replace('\\', '', $_POST['dealernetwork_bestpricetemplate']);
				$bestpricetemplatecss = str_replace('\\', '', $_POST['dealernetwork_bestpricetemplatecss']);
				$singleoffertemplate = str_replace('\\', '', $_POST['dealernetwork_singleoffertemplate']);
				$singleoffertemplatecss = str_replace('\\', '', $_POST['dealernetwork_singleoffertemplatecss']);
				$listtemplatemobile = str_replace('\\', '', $_POST['dealernetwork_listtemplate_mobile']);
				$listtemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_listtemplatecss_mobile']);
				$detailtemplatemobile = str_replace('\\', '', $_POST['dealernetwork_detailtemplate_mobile']);
				$detailtemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_detailtemplatecss_mobile']);
				$featuredtemplatemobile = str_replace('\\', '', $_POST['dealernetwork_featuredtemplate_mobile']);
				$featuredtemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_featuredtemplatecss_mobile']);
				$populartemplatemobile = str_replace('\\', '', $_POST['dealernetwork_populartemplate_mobile']);
				$populartemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_populartemplatecss_mobile']);
				$newadditiontemplatemobile = str_replace('\\', '', $_POST['dealernetwork_newadditiontemplate_mobile']);
				$newadditiontemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_newadditiontemplatecss_mobile']);
				$bestpricetemplatemobile = str_replace('\\', '', $_POST['dealernetwork_bestpricetemplate_mobile']);
				$bestpricetemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_bestpricetemplatecss_mobile']);
				$singleoffertemplatemobile = str_replace('\\', '', $_POST['dealernetwork_singleoffertemplate_mobile']);
				$singleoffertemplatecssmobile = str_replace('\\', '', $_POST['dealernetwork_singleoffertemplatecss_mobile']);
				$emailsubjecttemplate = str_replace('\\', '', $_POST['dealernetwork_emailsubjecttemplate']);
				$emailbodytemplate = str_replace('\\', '', $_POST['dealernetwork_emailbodytemplate']);
				
				$this->settings['ListTemplate'] = $listtemplate; 
				$this->settings['ListTemplateCSS'] = $listtemplatecss;
				$this->settings['DetailTemplate'] = $detailtemplate;
				$this->settings['DetailTemplateCSS'] = $detailtemplatecss;
				$this->settings['FeaturedTemplate'] = $featuredtemplate;
				$this->settings['FeaturedTemplateCSS'] = $featuredtemplatecss; 
				$this->settings['PopularTemplate'] = $populartemplate;
				$this->settings['PopularTemplateCSS'] = $populartemplatecss; 
				$this->settings['NewAdditionTemplate'] = $newadditiontemplate;
				$this->settings['NewAdditionTemplateCSS'] = $newadditiontemplatecss; 
				$this->settings['BestPriceTemplate'] = $bestpricetemplate;
				$this->settings['BestPriceTemplateCSS'] = $bestpricetemplatecss; 
				$this->settings['SingleOfferTemplate'] = $singleoffertemplate;
				$this->settings['SingleOfferTemplateCSS'] = $singleoffertemplatecss; 
				$this->settings['ListTemplateMobile'] = $listtemplatemobile; 
				$this->settings['ListTemplateCSSMobile'] = $listtemplatecssmobile;
				$this->settings['DetailTemplateMobile'] = $detailtemplatemobile;
				$this->settings['DetailTemplateCSSMobile'] = $detailtemplatecssmobile;
				$this->settings['FeaturedTemplateMobile'] = $featuredtemplatemobile;
				$this->settings['FeaturedTemplateCSSMobile'] = $featuredtemplatecssmobile;
				$this->settings['PopularTemplateMobile'] = $populartemplatemobile;
				$this->settings['PopularTemplateCSSMobile'] = $populartemplatecssmobile;
				$this->settings['NewAdditionTemplateMobile'] = $newadditiontemplatemobile;
				$this->settings['NewAdditionTemplateCSSMobile'] = $newadditiontemplatecssmobile;
				$this->settings['BestPriceTemplateMobile'] = $bestpricetemplatemobile;
				$this->settings['BestPriceTemplateCSSMobile'] = $bestpricetemplatecssmobile;
				$this->settings['SingleOfferTemplateMobile'] = $singleoffertemplatemobile;
				$this->settings['SingleOfferTemplateCSSMobile'] = $singleoffertemplatecssmobile;
				$this->settings['EmailSubjectTemplate'] = $emailsubjecttemplate;
				$this->settings['EmailBodyTemplate'] = $emailbodytemplate;
				
				update_option( $this->settings_key, $this->settings );
				?>
				<div class="updated"><p><strong><?php _e(" Options saved." ); ?></strong></p></div>
				<?php
			} else {
				$listtemplate = $this->settings['ListTemplate'];
				$listtemplatecss = $this->settings['ListTemplateCSS'];
				$detailtemplate = $this->settings['DetailTemplate'];
				$detailtemplatecss = $this->settings['DetailTemplateCSS'];
				$featuredtemplate = $this->settings['FeaturedTemplate'];
				$featuredtemplatecss = $this->settings['FeaturedTemplateCSS'];
				$populartemplate = $this->settings['PopularTemplate'];
				$populartemplatecss = $this->settings['PopularTemplateCSS'];
				$newadditiontemplate = $this->settings['NewAdditionTemplate'];
				$newadditiontemplatecss = $this->settings['NewAdditionTemplateCSS'];
				$bestpricetemplate = $this->settings['BestPriceTemplate'];
				$bestpricetemplatecss = $this->settings['BestPriceTemplateCSS'];
				$singleoffertemplate = $this->settings['SingleOfferTemplate'];
				$singleoffertemplatecss = $this->settings['SingleOfferTemplateCSS'];
				$listtemplatemobile = $this->settings['ListTemplateMobile'];
				$listtemplatecssmobile = $this->settings['ListTemplateCSSMobile'];
				$detailtemplatemobile = $this->settings['DetailTemplateMobile'];
				$detailtemplatecssmobile = $this->settings['DetailTemplateCSSMobile'];
				$featuredtemplatemobile = $this->settings['FeaturedTemplateMobile'];
				$featuredtemplatecssmobile = $this->settings['FeaturedTemplateCSSMobile'];
				$populartemplatemobile = $this->settings['PopularTemplateMobile'];
				$populartemplatecssmobile = $this->settings['PopularTemplateCSSMobile'];
				$newadditiontemplatemobile = $this->settings['NewAdditionTemplateMobile'];
				$newadditiontemplatecssmobile = $this->settings['NewAdditionTemplateCSSMobile'];
				$bestpricetemplatemobile = $this->settings['BestPriceTemplateMobile'];
				$bestpricetemplatecssmobile = $this->settings['BestPriceTemplateCSSMobile'];
				$singleoffertemplatemobile = $this->settings['SingleOfferTemplateMobile'];
				$singleoffertemplatecssmobile = $this->settings['SingleOfferTemplateCSSMobile'];
				$emailsubjecttemplate = $this->settings['EmailSubjectTemplate'];
				$emailbodytemplate = $this->settings['EmailBodyTemplate'];
			}
		?>
		<div class="tabs">
			<ul>
				<li><a href="#default">Default</a></li>
				<li><a href="#mobile">Mobile</a></li>
				<li><a href="#email">Email</a></li>
			</ul>
			<div class="tabs" id="default">
				<ul>
					<li><a href="#tabs-1">List Template</a></li>
					<li><a href="#tabs-2">Detail Template</a></li>
					<li><a href="#tabs-3">Featured Template</a></li>
					<li><a href="#tabs-4">Popular Template</a></li>
					<li><a href="#tabs-5">New Additions Template</a></li>
					<li><a href="#tabs-6">Best Price Template</a></li>
					<li><a href="#tabs-7">Single Offer Template</a></li>
				</ul>
				<table class="form-table" id="tabs-1">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory] List Page " ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("List Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_listtemplate', '<?php echo $this->settings_default['ListTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_listtemplate" name="dealernetwork_listtemplate"><?php echo $listtemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("List Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_listtemplatecss', '<?php echo $this->settings_default['ListTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_listtemplatecss" name="dealernetwork_listtemplatecss"><?php echo $listtemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-2">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory] Detail Page " ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Detail Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_detailtemplate', '<?php echo $this->settings_default['DetailTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_detailtemplate" name="dealernetwork_detailtemplate"><?php echo $detailtemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Detail Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_detailtemplatecss', '<?php echo $this->settings_default['DetailTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_detailtemplatecss" name="dealernetwork_detailtemplatecss"><?php echo $detailtemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-3">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-featured]" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Featured Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_featuredtemplate', '<?php echo $this->settings_default['FeaturedTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_featuredtemplate" name="dealernetwork_featuredtemplate"><?php echo $featuredtemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Featured Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_featuredtemplatecss', '<?php echo $this->settings_default['FeaturedTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_featuredtemplatecss" name="dealernetwork_featuredtemplatecss"><?php echo $featuredtemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-4">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-popular]" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Popular Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_populartemplate', '<?php echo $this->settings_default['PopularTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_populartemplate" name="dealernetwork_populartemplate"><?php echo $populartemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Popular Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_populartemplatecss', '<?php echo $this->settings_default['PopularTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_populartemplatecss" name="dealernetwork_populartemplatecss"><?php echo $populartemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-5">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-newaddition]" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("New Additions Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_newadditiontemplate', '<?php echo $this->settings_default['NewAdditionTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_newadditiontemplate" name="dealernetwork_newadditiontemplate"><?php echo $newadditiontemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("New Additions Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_newadditiontemplatecss', '<?php echo $this->settings_default['NewAdditionTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_newadditiontemplatecss" name="dealernetwork_newadditiontemplatecss"><?php echo $newadditiontemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-6">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-bestprice]" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Best Price Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_bestpricetemplate', '<?php echo $this->settings_default['BestPriceTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_bestpricetemplate" name="dealernetwork_bestpricetemplate"><?php echo $bestpricetemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Best Price Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_bestpricetemplatecss', '<?php echo $this->settings_default['BestPriceTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_bestpricetemplatecss" name="dealernetwork_bestpricetemplatecss"><?php echo $bestpricetemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-7">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-singleoffer]" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Single Offer Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_singleoffertemplate', '<?php echo $this->settings_default['SingleOfferTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_singleoffertemplate" name="dealernetwork_singleoffertemplate"><?php echo $singleoffertemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Single Offer Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_singleoffertemplatecss', '<?php echo $this->settings_default['SingleOfferTemplateCSS']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_singleoffertemplatecss" name="dealernetwork_singleoffertemplatecss"><?php echo $singleoffertemplatecss; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
			</div>
			<div class="tabs" id="mobile">
				<ul>
					<li><a href="#tabs-m1">List Template</a></li>
					<li><a href="#tabs-m2">Detail Template</a></li>
					<li><a href="#tabs-m3">Featured Template</a></li>
					<li><a href="#tabs-m4">Popular Template</a></li>
					<li><a href="#tabs-m5">New Additions Template</a></li>
					<li><a href="#tabs-m6">Best Price Template</a></li>
					<li><a href="#tabs-m7">Single Offer Template</a></li>
				</ul>
				<table class="form-table" id="tabs-m1">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory] List Page Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("List Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_listtemplate_mobile', '<?php echo $this->settings_default['ListTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_listtemplate_mobile" name="dealernetwork_listtemplate_mobile"><?php echo $listtemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("List Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_listtemplatecss_mobile', '<?php echo $this->settings_default['ListTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_listtemplatecss_mobile" name="dealernetwork_listtemplatecss_mobile"><?php echo $listtemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-m2">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory] Detail Page Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Detail Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_detailtemplate_mobile', '<?php echo $this->settings_default['DetailTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_detailtemplate_mobile" name="dealernetwork_detailtemplate_mobile"><?php echo $detailtemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Detail Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_detailtemplatecss_mobile', '<?php echo $this->settings_default['DetailTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_detailtemplatecss_mobile" name="dealernetwork_detailtemplatecss_mobile"><?php echo $detailtemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-m3">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-featured] Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Featured Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_featuredtemplate_mobile', '<?php echo $this->settings_default['FeaturedTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_featuredtemplate_mobile" name="dealernetwork_featuredtemplate_mobile"><?php echo $featuredtemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Featured Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_featuredtemplatess_mobile', '<?php echo $this->settings_default['FeaturedTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_featuredtemplatecss_mobile" name="dealernetwork_featuredtemplatecss_mobile"><?php echo $featuredtemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-m4">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-popular] Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Popular Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_populartemplate_mobile', '<?php echo $this->settings_default['PopularTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_populartemplate_mobile" name="dealernetwork_populartemplate_mobile"><?php echo $populartemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Popular Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_populartemplatecss_mobile', '<?php echo $this->settings_default['PopularTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_populartemplatecss_mobile" name="dealernetwork_populartemplatecss_mobile"><?php echo $populartemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-m5">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-newaddition] Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("New Additions Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_newadditiontemplate_mobile', '<?php echo $this->settings_default['NewAdditionTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_newadditiontemplate_mobile" name="dealernetwork_newadditiontemplate_mobile"><?php echo $newadditiontemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("New Additions CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_newadditiontemplatecss_mobile', '<?php echo $this->settings_default['NewAdditionTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_newadditiontemplatecss_mobile" name="dealernetwork_newadditiontemplatecss_mobile"><?php echo $newadditiontemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-m6">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-bestprice] Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Best Price Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_bestpricetemplate_mobile', '<?php echo $this->settings_default['BestPriceTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_bestpricetemplate_mobile" name="dealernetwork_bestpricetemplate_mobile"><?php echo $bestpricetemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Best Price Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_bestpricetemplatecss_mobile', '<?php echo $this->settings_default['BestPriceTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_bestpricetemplatecss_mobile" name="dealernetwork_bestpricetemplatecss_mobile"><?php echo $bestpricetemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
				<table class="form-table" id="tabs-m7">
					<tr valign="top">
						<th scope="row" colspan="2">
							<?php _e("[dealernetwork-inventory-singleoffer] Mobile" ); ?>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Single Offer Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_singleoffertemplate_mobile', '<?php echo $this->settings_default['SingleOfferTemplateMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_singleoffertemplate_mobile" name="dealernetwork_singleoffertemplate_mobile"><?php echo $singleoffertemplatemobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Single Offer Template CSS: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_singleoffertemplatecss_mobile', '<?php echo $this->settings_default['SingleOfferTemplateCSSMobile']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="30" cols="70" id="dealernetwork_singleoffertemplatecss_mobile" name="dealernetwork_singleoffertemplatecss_mobile"><?php echo $singleoffertemplatecssmobile; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
			</div>
			<div class="tabs" id="email">
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e("Email Subject Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_emailsubjecttemplate', '<?php echo $this->settings_default['EmailSubjectTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<input type="text" id="dealernetwork_emailsubjecttemplate" name="dealernetwork_emailsubjecttemplate" value="<?php echo $emailsubjecttemplate; ?>" size="4" class="regular-text">
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e("Email Body Template: " ); ?>
							<p class="submit">
								<input type="submit" class="button button-primary" onClick="restoreDefault('dealernetwork_emailbodytemplate', '<?php echo $this->settings_default['EmailBodyTemplate']; ?>');return false;" name="Submit" value="<?php _e('Restore Default', 'dealernetwork_trdom' ) ?>" />
							</p>
						</th>
						<td>
							<textarea rows="5" cols="70" id="dealernetwork_emailbodytemplate" name="dealernetwork_emailbodytemplate"><?php echo $emailbodytemplate; ?></textarea>
							<p class="description"><?php _e(" " ); ?></p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<p class="submit">
		<input type="submit" class="button button-primary" name="Submit" value="<?php _e('Update Options', 'dealernetwork_trdom' ) ?>" />
		</p>
	</form>
</div>