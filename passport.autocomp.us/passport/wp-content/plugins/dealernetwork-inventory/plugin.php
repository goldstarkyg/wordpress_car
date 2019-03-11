<?php
/*
Plugin Name: DealerNetwork
Plugin URI: http://www.dealernetwork.com/
Description: This plugin allows wordpress to work with your DealerNetwork account
Version: 0.8
Author: Nasser Oloumi
Author Email: nasser@dealerclick.com
License:

  Copyright 2013 Nasser Oloumi (nasser@dealerclick.com)
  
*/
if (strpos(ABSPATH, 'dealerpress') !== false) {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}
include('lib/car.class.php');
include('lib/dealer.class.php');
include('lib/lead.class.php');
include('lib/zipcode.class.php');
include('lib/Mobile_Detect.class.php');
include('functions.php');

// TODO: Debug only, remove after
include('lib/kint/Kint.class.php');

class DealerNetworkInventory {

	public $settings;
	public $current_url;
	public $car_list;
	public $dealer;
	public $location;
	public $dpl;
	public $zipcodes;
	public $records_per_page;
	public $random_array = array(
		'http://i.imgur.com/kvPjBWz.gif', 
		'http://i.imgur.com/ou1ZP.gif', 
		'http://25.media.tumblr.com/55113e8efe11c3470d7a3b7a0f0b8f91/tumblr_mjwux1v7OC1ru2fjro1_400.gif',
		'http://25.media.tumblr.com/tumblr_lqbeq1ctYd1qlu51io1_500.gif',
		'http://cdn.fd.uproxx.com/wp-content/uploads/2013/02/Drop-the-Bass.gif',
		'http://gifmesmile.com/data/published/03_2012/b328f72cc08454eb3349717912eaa4eb_pub.gif',
		'http://img37.imageshack.us/img37/7044/oprahbees.gif'
	);
			
	public $pages_array = array(
		'Inventory' => '[dealernetwork-inventory]',
		'Financing' => '[dealernetwork-creditapplication]',
		'Trade Appraisal' => '[dealernetwork-valuetrade]',
		'Site Map' => '[dealernetwork-sitemap]',
		'Contact Us' => '[dealernetwork-contactus]'
	);
	
	public $filter_keys = array(
		'search' => 'q',
		'year' => 'yr',
		'make' => 'mk',
		'model' => 'md',
		'bodystyle' => 'bstyle',
		'transmission' => 'tran',
		'color' => 'color',
		'condition' => 'cond',
        'category' => 'cat'
	);
	public $filter_values;
	public $filter_relations;
	
	public $filter_range_keys = array(
		'pricerange' => array('min_price', 'max_price'),
		'internetpricerange' => array('min_iprice', 'max_iprice'),
		'citympgrange' => array('min_citympg', 'max_citympg'),
		'hwympgrange' => array('min_hwympg', 'max_hwympg')
	);
	public $filter_range_values;
	public $filter_range_relations;
	
	public $sort_key = 'sort_by';
	public $sort_relations = array (
		'make' => 'Make',
		'year' => 'Year', 
		'mileage' => 'Mileage', 
		'price' => 'Price'
	);
	public $sort_values = array (
		'make' => 'Make/Model',
		'year' => 'Year',
		'mileage' => 'Mileage',
		'price' => 'Price'
	);
	public $sort_by = 'make';
	public $sort_descending = false;
	
	public $rpp_key = 'rpp';
	public $rpp_values = array (
		25 => '25',
		50 => '50',
		100 => '100'
	);
	
	public $special_characters = array ( '#', '$', '/', '\\'	);
	
	public $settings_default = array (
		'DealerID' => 0,
		'LocationID' => 0,
		'PiwikID' => 0,
		'ListRPP' => 20,
                'DaysToShowSold' => 0,
		'MetaDescription' => ' ',
		'MetaKeywords' => ' ',
		'DetailMetaDescription' => ' ',
		'DetailMetaKeywords' => ' ',
		'ListTemplate' => 'default/default-list.txt',
		'ListTemplateCSS' => 'default/default-list-css.txt',
		'DetailTemplate' => 'default/default-detail.txt',
		'DetailTemplateCSS' => 'default/default-detail-css.txt',
		'FeaturedTemplate' => 'default/default-featured.txt',
		'FeaturedTemplateCSS' => 'default/default-featured-css.txt',
		'PopularTemplate' => 'default/default-popular.txt',
		'PopularTemplateCSS' => 'default/default-popular-css.txt',
		'NewAdditionTemplate' => 'default/default-newaddition.txt',
		'NewAdditionTemplateCSS' => 'default/default-newaddition-css.txt',
		'BestPriceTemplate' => 'default/default-bestprice.txt',
		'BestPriceTemplateCSS' => 'default/default-bestprice-css.txt',
		'SingleOfferTemplate' => 'default/default-singleoffer.txt',
		'SingleOfferTemplateCSS' => 'default/default-singleoffer-css.txt',
		'ListTemplateMobile' => 'mobile/mobile-list.txt',
		'ListTemplateCSSMobile' => 'mobile/mobile-list-css.txt',
		'DetailTemplateMobile' => 'mobile/mobile-detail.txt',
		'DetailTemplateCSSMobile' => 'mobile/mobile-detail-css.txt',
		'FeaturedTemplateMobile' => 'mobile/mobile-featured.txt',
		'FeaturedTemplateCSSMobile' => 'mobile/mobile-featured-css.txt',
		'PopularTemplateMobile' => 'mobile/mobile-popular.txt',
		'PopularTemplateCSSMobile' => 'mobile/mobile-popular-css.txt',
		'NewAdditionTemplateMobile' => 'mobile/mobile-newaddition.txt',
		'NewAdditionTemplateCSSMobile' => 'mobile/mobile-newaddition-css.txt',
		'BestPriceTemplateMobile' => 'mobile/mobile-bestprice.txt',
		'BestPriceTemplateCSSMobile' => 'mobile/mobile-bestprice-css.txt',
		'SingleOfferTemplateMobile' => 'mobile/mobile-singleoffer.txt',
		'SingleOfferTemplateCSSMobile' => 'mobile/mobile-singleoffer-css.txt',
		'EmailSubjectTemplate' => 'email/email-subject.txt',
		'EmailBodyTemplate' => 'email/email-body.txt'
                
	);
		
	
	public $mobile_detect;
	
	private $settings_key = 'dealernetwork';
	private $session_car_list_key = 'dn-inv-list';
	private $session_dealer_key = 'dn-dealer';
	private $session_location_key = 'dn-location';
	private $session_dpl_key = 'dn-dpl';
	private $session_zipcodes_key = 'dn-zipcodes';
	private $session_rpp_key = 'dn-inv-rpp';
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		add_shortcode('dealernetwork-inventory', array($this, 'shortcode_inventory'));
		add_shortcode('dealernetwork-inventory-slideshow', array($this, 'shortcode_inventory_slideshow'));
		add_shortcode('dealernetwork-inventory-featured', array($this, 'shortcode_featured'));
		add_shortcode('dealernetwork-inventory-featured-slideshow', array($this, 'shortcode_inventory_featured_slideshow'));
		add_shortcode('dealernetwork-inventory-similar', array($this, 'shortcode_inventory_similar'));
		add_shortcode('dealernetwork-inventory-popular', array($this, 'shortcode_popular'));
		add_shortcode('dealernetwork-inventory-newaddition', array($this, 'shortcode_newaddition'));
		add_shortcode('dealernetwork-inventory-bestprice', array($this, 'shortcode_bestprice'));
		add_shortcode('dealernetwork-inventory-singleoffer', array($this, 'shortcode_singleoffer'));
		add_shortcode('dealernetwork-inventory-search', array($this, 'shortcode_search'));
		add_shortcode('dealernetwork-inventory-search-dropdowns', array($this, 'shortcode_search_dropdowns'));
		add_shortcode('dealernetwork-inventory-search-autocomplete', array($this, 'shortcode_inventory_search_autocomplete'));
		add_shortcode('dealernetwork-valuetrade', array($this, 'shortcode_valuetrade'));
		add_shortcode('dealernetwork-contactus', array($this, 'shortcode_contactus'));
        add_shortcode('dealernetwork-contactg', array($this, 'shortcode_contactg'));
                add_shortcode('dealernetwork-galleryp', array($this, 'shortcode_galleryp'));
                add_shortcode('dealernetwork-videop', array($this, 'shortcode_videop'));
                add_shortcode('dealernetwork-brochurep', array($this, 'shortcode_brochurep'));
                add_shortcode('dealernetwork-emailfrindsp', array($this, 'shortcode_emailfrindsp'));
        add_shortcode('dealernetwork-makeoffer', array($this, 'shortcode_makeoffer'));
		add_shortcode('dealernetwork-creditapplication', array($this, 'shortcode_creditapplication'));
		add_shortcode('dealernetwork-sitemap', array($this, 'shortcode_sitemap'));
		add_shortcode('dealernetwork-inventory-chained-dropdowns', array($this, 'shortcode_chained_dropdowns'));
		add_shortcode('dealernetwork-form-calc', array($this, 'shortcode_form_calc'));
        add_shortcode('dealernetwork-makes-grid', array($this, 'shortcode_makes_grid'));
        add_shortcode('dealernetwork-inventory-carousel', array($this, 'shortcode_carousel'));
        add_shortcode('dealernetwork-test', array($this, 'shortcode_test'));
        add_shortcode('dealernetwork-inventory-customer', array($this, 'shortcode_inventory_customer'));
		
		// Load plugin text domain
		add_action( 'init', array( $this, 'plugin_textdomain' ) );
		
		add_action( 'init', array( $this, 'load_settings' ) );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
		wp_enqueue_script('jquery');
		
		add_action('wp_head', array( $this, 'add_meta_tags' ), 0);
		add_action('wp_footer', array( $this, 'add_footer' ));
	
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );
		
	    /*
	     * TODO:
	     * Define the custom functionality for your plugin. The first parameter of the
	     * add_action/add_filter calls are the hooks into which your code should fire.
	     *
	     * The second parameter is the function name located within this class. See the stubs
	     * later in the file.
	     *
	     * For more information: 
	     * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
	     */
		add_action( 'admin_menu', array( $this, 'action_show_admin') );
	    add_action( 'wp_loaded', array( $this, 'action_flush_rules' ) );
		add_action( 'init', array( $this, 'action_start_session' ), 0 );
	    add_filter( 'rewrite_rules_array', array( $this, 'filter_insert_rewrite_rules' ) );
	    add_filter( 'query_vars', array( $this, 'filter_insert_query_vars' ) );
		add_filter('widget_text', 'do_shortcode');
		add_filter( 'wp_title', array( $this, 'alter_title' ), 10, 2 );
		
		$this->current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		// filters
		$this->filter_values = array(
			$this->filter_keys['search'] => 'Search',
			$this->filter_keys['year'] => 'Year',
			$this->filter_keys['make'] => 'Make',
			$this->filter_keys['model'] => 'Model',
			$this->filter_keys['bodystyle'] => 'Body Style',
			$this->filter_keys['transmission'] => 'Transmission',
			$this->filter_keys['color'] => 'Color',
			$this->filter_keys['condition'] => 'Condition',
                    $this->filter_keys['category'] => 'Category'
		);		
		$this->filter_relations = array(
			$this->filter_keys['year'] => 'Year',
			$this->filter_keys['make'] => 'Make',
			$this->filter_keys['model'] => 'Model',
			$this->filter_keys['bodystyle'] => 'BodyStyle',
			$this->filter_keys['transmission'] => 'Transmission',
			$this->filter_keys['color'] => 'ExteriorColor',
			$this->filter_keys['condition'] => 'Condition',
                    $this->filter_keys['category'] => 'Category'
		);
		
		// range filters
		$this->filter_range_values = array(
			'pricerange' => 'Price',
			'internetpricerange' => 'Internet Price',
			'citympgrange' => 'City MPG',
			'hwympgrange' => 'Highway MPG'
		);
		$this->filter_range_relations = array(
			'pricerange' => 'Price',
			'internetpricerange' => 'InternetPrice',
			'citympgrange' => 'CityMPG',
			'hwympgrange' => 'HwyMPG'
		);
		
		if (isset($_GET[$this->sort_key])) {
			if (strpos($_GET[$this->sort_key], 'asc') !== false) {
				$sort_me_by = explode('asc', $_GET[$this->sort_key])[0];
				$this->sort_descending = false;
			} else if (strpos($_GET[$this->sort_key], 'desc') !== false) {
				$sort_me_by = explode('desc', $_GET[$this->sort_key])[0];
				$this->sort_descending = true;
			}
			if (isset($sort_me_by) && array_key_exists($sort_me_by, $this->sort_relations))
				$this->sort_by = $sort_me_by;
		}		
		
		// initialize mobile detection
		$this->mobile_detect = new Mobile_Detect();
		if ($this->mobile_detect->isMobile())
			wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-jquerymobile', 'http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css' );
	} // end constructor
	
	public function check_user_role( $capability, $user_id = null ) {	 
		if ( is_numeric( $user_id ) )
		$user = get_userdata( $user_id );
		else
			$user = wp_get_current_user();
		if ( empty( $user ) )
		return false;
		
		foreach ($user->roles as $role_name) {
			$role = get_role($role_name);
			if ($role->capabilities != null && array_key_exists($capability, $role->capabilities) && $role->capabilities[$capability])
				return true;
		}
		return false;
	}
	
	public function add_footer() {
		if ($this->settings['PiwikID'] > 0) {
			echo "<!-- Piwik -->
				<script type=\"text/javascript\"> 
				  var _paq = _paq || [];
				  _paq.push(['trackPageView']);
				  _paq.push(['enableLinkTracking']);
				  (function() {
					var u=((\"https:\" == document.location.protocol) ? \"https\" : \"http\") + \"://analytics.dealernetwork.com//\";
					_paq.push(['setTrackerUrl', u+'piwik.php']);
					_paq.push(['setSiteId', 1]);
					var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
					g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
				  })();

				</script>
				<noscript><p><img src=\"http://analytics.dealernetwork.com/piwik.php?idsite=" . $this->settings['PiwikID'] . "\" style=\"border:0\" alt=\"\" /></p></noscript>
				<!-- End Piwik Code -->";
		}
	}
	
	public function add_meta_tags() {
		$keywords = $this->generate_keywords();
		$car = $this->get_detail_car();
        //(Richard H) - ADDED EMPTY/WHITESPACE CHECKs AND TO NOT ECHO IF TRUE
        //  ALSO MERGED ECHOES TO SINGLE LINES FOR THE ELSE AS WELL AS CREATED 
        //  NEW VARS FOR ACCESSING META SETTINGS/VALUES
		if ($car == null) {
            $md = $this->settings['MetaDescription'];
            if ($md != "" && $md != " ")
			    echo '<meta name="description" content="' . $md . '" />';
            $mk = $keywords . ',' . $this->settings['MetaKeywords'];
			if (strlen($mk) > 2)
                echo '<meta name="keywords" content="' . $mk . '" />';
		} else {
            $dmd = $this->parse_detail_template($this->settings['DetailMetaDescription'], $car);
            if ($dmd != "" && $dmd != " ")
			    echo '<meta name="description" content="' . $dmd . '" />';
			//echo $this->parse_detail_template($this->settings['DetailMetaDescription'], $car);
			//echo '" />';
            $dmk = $keywords . ',' . $this->parse_detail_template($this->settings['DetailMetaKeywords'], $car);
            if (strlen($dmk) > 2)
			    echo '<meta name="keywords" content="' . $dmk . '" />';
			//echo $this->parse_detail_template($this->settings['DetailMetaKeywords'], $car);
			//echo '" />';
		}
	}
	
	public function get_detail_car() {
		$query_string = get_query_var('friendly');
		if (strlen($query_string) > 0)  {
			if (strpos($query_string, '/')) {
				$split = explode('/', $query_string);
				$inventory_id = $split[0];
				if (is_numeric($inventory_id)) {
					foreach ($this->car_list as $single_car) {
						if ($single_car->InventoryID == (int) $inventory_id)
							$car = $single_car;
					}
				}
			}
		}
		return isset($car) ? $car : null;
	}
	
	public function parse_list_template($template, $list, $additional_shortcode = array(), $sort = true) {	
        
//        $dbg = isset($_GET['roh-dbg']) ? TRUE : FALSE;
        
		// sort
		if ($sort) {
			$this->quick_sort($list, $this->sort_relations[$this->sort_by]);
			if ($this->sort_descending) $list = array_reverse($list);
		}
		$replace_array = array(
			'[carlist-count]' => count($list),
			'[carlist-search]' => $this->get_search(),
			'[carlist-filters]' => $this->get_filters(),
			'[carlist-sort]' => $this->get_sort(),
			'[carlist-rpp]' => $this->get_rpp(),
            '[carlist-makes-grid]'=>$this->get_makes_grid(),
			'[carlist-recordsperpage]' => $this->records_per_page
		);
        //            '[carlist-contactrequest]' => $this->get_contactrequest(),
        //            '[carlist-finicialrequest]' => $this->get_finicialrequest(),
        
		$replace_array = array_merge($replace_array, $additional_shortcode, $this->get_common_array($list[0]));

		foreach ($replace_array as $key=>$value) {
			$template = str_replace($key, $value, $template);
		}

		// refine
		preg_match_all('/\[carlist-refine-(.+?)\]/', $template, $refine_matches);
		for ($x = 0; $x < count($refine_matches[0]); $x++) {
			$template = str_replace($refine_matches[0][$x], $this->get_refine($refine_matches[1][$x], $list), $template);
		}
		
		if (strpos($template, '[carlist-loop]') !== false) {
			$explode_bottom = explode('[/carlist-loop]', $template);
			$explode_top = explode('[carlist-loop]', $explode_bottom[0]);
			$formatted_ret = $this->parse_conditional($explode_top[0]);
			foreach ($list as $car) {
				$this->parse_detail_template($explode_top[1], $car, array('[car-index]' => array_search($car, $list)));
			}
			return $formatted_ret . $this->parse_conditional($explode_bottom[1]);
		}
		return 'Missing [carlist-loop]';
	}
	
	public function parse_detail_template($template, $car, $additional_shortcode = array()) {
		$location_id = $car->Location->LocationID;
		$dealer_id = $car->Location->DealerID;
		$car_image = "http://www.dealernetwork.com/getImage.asp?ImageName=$car->VIN-0.jpg&amp;DealerID=$dealer_id&amp;LocationID=$location_id";
		$detail_url = $this->generate_detail_url($car);
		$appraisal_url = home_url("/trade-appraisal/?id=$car->InventoryID");
        $contactus_url = home_url("/contact/?id=$car->InventoryID");
        $videop_url = home_url("/playvideo/?id=$car->InventoryID");
        $makeoffer_url = home_url("/make-offer/?id=$car->InventoryID");
        $financing_url = home_url("/financing/?id=$car->InventoryID");
        $loan_url = home_url("/calculater/?id=$car->InventoryID");
		$replace_array = array(
			'[car-id]' => $car->InventoryID,
			'[car-views]' => $car->Views,
			'[car-category]' => $car->Category,
			'[car-condition]' => $car->Condition,
			'[car-stocknumber]' => $car->StockNumber,
			'[car-year]' => $car->Year,
			'[car-make]' => $car->Make,
			'[car-model]' => $car->Model,
			'[car-trim]' => $car->Trim,
			'[car-vin]' => $car->VIN,
			'[car-engine]' => $car->Engine,
			'[car-transmission]' => $car->Transmission,
			'[car-exterior]' => $car->ExteriorColor,
			'[car-exteriorhex]' => $car->ExteriorHex,
			'[car-interior]' => $car->InteriorColor,
			'[car-interiorhex]' => $car->InteriorHex,
			'[car-mileage]' => $car->Mileage,
			'[car-mileage-formatted]' => number_format($car->Mileage),
			'[car-fueltype]' => $car->FuelType,
			'[car-doors]' => $car->Doors,
			'[car-cylinders]' => $car->Cylinders,
			'[car-drivetype]' => $car->DriveType,
			'[car-description]' => $this->remove_conditional($car->Description),
			'[car-bodystyle]' => $car->BodyStyle,
			'[car-wholesaleprice]' => $car->WholesalePrice,
			'[car-internetprice]' => $car->InternetPrice,
			'[car-price]' => $car->Price,
			'[car-wholesaleprice-formatted]' => number_format($car->WholesalePrice),
			'[car-internetprice-formatted]' => number_format($car->InternetPrice),
			'[car-price-formatted]' => number_format($car->Price),
			'[car-status]' => $car->Status,
			'[car-lotdate]' => date('m/d/Y', $car->LotDate),
			'[car-cover-url]' => $car_image,
			'[car-url]' => $detail_url,
			'[car-citympg]' => $car->CityMPG,
			'[car-hwympg]' => $car->HwyMPG,
			'[car-images-count]' => count($car->ImageUrls),
			'[car-specifications-count]' => count($car->Specifications),
			'[car-equipment-count]' => count($car->Equipment),
			'[car-optionalequipment-count]' => count($car->OptionalEquipment),
			'[car-gallery]' => $this->get_car_gallery($car),
			'[car-appraisal-url]' => $appraisal_url,
            '[car-contactus-url]' => $contactus_url,
            '[car-videop-url]' => $videop_url,
            '[car-makeoffer-url]' => $makeoffer_url,
            '[car-financing-url]' => $financing_url,
            '[car-loan-url]' => $loan_url,
			'[car-carfax-hasreport]' => ($car->HasCarfax && !empty($this->dpl->CarfaxUser) ? 'true' : 'false'),
			'[car-carfax-oneowner]' => ($car->CarfaxOneOwner ? 'true' : 'false'),
			'[car-carfax-url]' => (!$car->HasCarfax || empty($this->dpl->CarfaxUser) ? '' : 'http://www.carfaxonline.com/cfm/Display_Dealer_Report.cfm?partner=DRC_0&UID=' . $this->dpl->CarfaxUser . '&VIN=' . $car->VIN),
			'[car-autocheck-hasreport]' => ($car->HasAutoCheck ? 'true' : 'false'),
			'[car-autocheck-url]' => (!$car->HasAutoCheck ? '' : 'http://www.dealernetwork.com/Autocheckreport.aspx?InventoryID=' . $car->InventoryID . '&DealerID=' . $this->dealer->DealerID),
            '[LocationID]' => $location_id,
            '[DealerID]' => $dealer_id,
            '[key]' => (($location_id + $dealer_id) * 1000) + 2
		);
		$replace_array = array_merge($replace_array, $additional_shortcode, $this->get_common_array($car));
		foreach ($replace_array as $key=>$value) {
			$template = str_replace($key, $value, $template);
		}
		// images 
		if (strpos($template, '[car-images-loop]') !== false) {
			$split = explode('[/car-images-loop]', $template);
			$split_top = explode('[car-images-loop]', $split[0]);
			$ret_temp = $split_top[0];
			foreach($car->ImageUrls as $image) {
				$ret_temp .= str_replace('[car-image-url]', $image, $split_top[1]);
			}
			$ret_temp .= $split[1];
			$template = $ret_temp;
		}
		// specs
		if (strpos($template, '[car-specifications-loop]') !== false) {
			$split = explode('[/car-specifications-loop]', $template);
			$split_top = explode('[car-specifications-loop]', $split[0]);
			$ret_temp = $split_top[0];
			foreach($car->Specifications as $specification) {
				$ret_temp .= str_replace('[car-specification]', $specification, $split_top[1]);
			}
			$ret_temp .= $split[1];
			$template = $ret_temp;
		}
		// equip
		if (strpos($template, '[car-equipment-loop]') !== false) {
			$split = explode('[/car-equipment-loop]', $template);
			$split_top = explode('[car-equipment-loop]', $split[0]);
			$ret_temp = $split_top[0];
			foreach($car->Equipment as $equipment) {
				$ret_temp .= str_replace('[car-equipment]', $equipment, $split_top[1]);
			}
			$ret_temp .= $split[1];
			$template = $ret_temp;
		}
		// optional equip
		if (strpos($template, '[car-optionalequipment-loop]') !== false) {
			$split = explode('[/car-optionalequipment-loop]', $template);
			$split_top = explode('[car-optionalequipment-loop]', $split[0]);
			$ret_temp = $split_top[0];
			foreach($car->OptionalEquipment as $optionalequipment) {
				$ret_temp .= str_replace('[car-optionalequipment]', $optionalequipment, $split_top[1]);
			}
			$ret_temp .= $split[1];
			$template = $ret_temp;
		}
		// forms
		preg_match_all('/\[car-form-(.+?)\]/', $template, $form_matches);
		for ($x = 0; $x < count($form_matches[0]); $x++) {
			$template = str_replace($form_matches[0][$x], $this->get_form($form_matches[1][$x], $car), $template);
		}
		return $this->parse_conditional($template);
	}
	
	private function generate_sitemap() {
		if (!file_exists('sitemap.xml') || (time() - filemtime('sitemap.xml')) > 86400) {
			// generate sitemap
			$xml = new SimpleXMLElement('<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
			$node = $xml->addChild('sitemap');
			$node->addChild('loc', home_url());
			$node->addChild('lastmod', date('Y-m-d', time()));
			foreach (get_pages(array()) as $page) {
				$node = $xml->addChild('sitemap');
				$node->addChild('loc', get_permalink($page->ID));
				$node->addChild('lastmod', date('Y-m-d', strtotime($page->post_modified)));
			}
			foreach ($this->car_list as $car) {
				$node = $xml->addChild('sitemap');
				$node->addChild('loc', $this->generate_detail_url($car));
				$node->addChild('lastmod', date('Y-m-d', $car->UpdatedOn));
			}
			//file_put_contents('sitemap.xml', $xml->asXML());
			if (!file_exists('robots.txt')) {
				//file_put_contents('robots.txt', 'Sitemap: ' . home_url('/sitemap.xml'));
			}
		}
	}
	
	private function generate_detail_url($car) {
		$str = "$car->Year $car->Make $car->Model";
		foreach ($this->special_characters as $character) {
			$str = str_replace($character, '', $str);
		}
		$url = str_replace(' ', '-', home_url("/inventory/$car->InventoryID/$str"));
		return $url;
	}
	
	private function remove_conditional($input) {
		$input = str_replace('[else]', '', $input);
		$input = str_replace('[/if]', '', $input);
		$input = preg_replace('/\[if (.+?)\]/i', '', $input);
		return $input;
	}
	
	private function parse_conditional($input) {
		$input = str_replace('[else]', '<?php } else { ?>', $input);
		$input = str_replace('[/if]', '<?php } ?>', $input);
		$input = preg_replace('/\[if (.+?)\]/i', '<?php if($1) { ?>', $input);
		//Kint::dump($input);
		return eval('?>' . $input . '<?php ');
	}
	
	public function add_query_var($key, $value, $url = null) {
		$url = ($url == null) ? $this->current_url : $url;
		$parsed_url = parse_url($url, PHP_URL_QUERY);
		if ($parsed_url != null) {
			$query_strings = array();
			foreach (explode('&', $parsed_url) as $val) {
				$query = explode('=', $val);
				if (count($query) == 2) {
					$query_strings[$query[0]] = $query[1];
				}
			}
			if (array_key_exists($key, $query_strings)) {
				$url = $this->remove_query_var($key, $url);
			}
		}
		$separator = ($parsed_url == null) ? '?' : '&';
		if (substr($url, strlen($url) - 1, strlen($url)) == '?') $separator = '';
		return $url . $separator . $key . '=' . str_replace(' ', '+', $value);
	}
	
	public function remove_query_var($varname, $url = null) {
		$url = ($url == null) ? $this->current_url : $url;
		$new_url = preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
		$last_char = substr($new_url, strlen($new_url) - 1, strlen($new_url));
		return $new_url; //($last_char == '?' || $last_char == '&') ? substr($new_url, 0, strlen($new_url) - 1) : $new_url;
	}
	
	public function quick_sort(&$array, $key) {
		if (count($array) > 0) {
			$cur = 1;
			$stack[1]['l'] = 0;
			$stack[1]['r'] = count($array)-1;

			do {
				$l = $stack[$cur]['l'];
				$r = $stack[$cur]['r'];
				$cur--;

				do {
					$i = $l;
					$j = $r;
					$tmp = $array[(int)( ($l+$r)/2 )];

					// partion the array in two parts.
					// left from $tmp are with smaller values,
					// right from $tmp are with bigger ones
					do {
						while( $array[$i]->$key < $tmp->$key )
							$i++;
						while( $tmp->$key < $array[$j]->$key )
							$j--;
						// swap elements from the two sides
						if( $i <= $j) {
							$w = $array[$i];
							$array[$i] = $array[$j];
							$array[$j] = $w;

							$i++;
							$j--;
						}
					} while( $i <= $j );
					if( $i < $r ) {
						$cur++;
						$stack[$cur]['l'] = $i;
						$stack[$cur]['r'] = $r;
					}
					$r = $j;
				} while( $l < $r );
			} while( $cur != 0 );
		}
	}
	
	private function generate_keywords() {
		$keywords = array(
			$this->dealer->Company,
			$this->location->LocationName,
			$this->location->Address,
			$this->location->City,
			$this->location->State,
			$this->location->Zip
		);
		foreach ($this->zipcodes as $zip) {
			if (!in_array($zip->Zipcode, $keywords))
				array_push($keywords, $zip->Zipcode);
			if (!in_array($zip->City, $keywords))
				array_push($keywords, $zip->City);
		}
		$ret = "";
		foreach ($keywords as $keyword) {
			$ret .= $keyword . ',';
		}
		if (strlen($ret) > 0)
			$ret = substr($ret, 0, strlen($ret) - 1);
		return $ret;
	}
	
	private function get_form($type, $car) {
		ob_start();
		include( "views/forms/car-form.view.php" );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function get_search() {
		ob_start();
		include( 'views/carlist-search.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	private function get_car_gallery($car) {
		ob_start();
		include( "views/car-gallery.view.php" );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	private function get_refine($type, $car_list) {
		ob_start();
		include( "views/carlist-refine.view.php" );
		$output = ob_get_contents();
		ob_end_clean();
		unset($type);
		return $output;
	}
	
	private function get_filters() {
		ob_start();
		include( "views/carlist-filters.view.php" );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	private function get_sort() {
		ob_start();
		include( "views/carlist-sort.view.php" );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	private function get_rpp() {
		ob_start();
		include( "views/carlist-rpp.view.php" );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
    
    public function get_makes_grid() {
		ob_start();
		include( 'views/carlist-makes-grid.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
    
	public function is_set($input) {
		return isset($input) && strlen($input) > 0;
	}
	
	public function truncate($str, $limit) {
		if (strlen($str) <= $limit) return $str;
		return substr($str, 0, $limit - 3) . '...';
	}
	
	private function get_common_array($car) {
		$random = $this->random_array[array_rand($this->random_array, 1)];
		$random_img = "<img src='$random' alt='Easteregg' />";
		return array(
			'[easter-egg]' => $random_img,
			'[dealership-name]' => $this->dealer->Company,
			'[dealership-website]' => $this->dealer->Website,
			'[dealership-address]' => $car->Location->Address,
			'[dealership-address2]' => $car->Location->Address2,
			'[dealership-city]' => $car->Location->City,
			'[dealership-state]' => $car->Location->State,
			'[dealership-zip]' => $car->Location->Zip,
			'[dealership-phone]' => $car->Location->Phone,
			'[dealership-email]' => $car->Location->Email,
			'[dealership-hours-monday]' => $this->dealer->Settings->MondayHours,
			'[dealership-hours-tuesday]' => $this->dealer->Settings->TuesdayHours,
			'[dealership-hours-wednesday]' => $this->dealer->Settings->WednesdayHours,
			'[dealership-hours-thursday]' => $this->dealer->Settings->ThursdayHours,
			'[dealership-hours-friday]' => $this->dealer->Settings->FridayHours,
			'[dealership-hours-saturday]' => $this->dealer->Settings->SaturdayHours,
			'[dealership-hours-sunday]' => $this->dealer->Settings->SundayHours,
			'[dealership-nopricetext]' => $this->dealer->Settings->NoPriceText,
			'[user-wholesale]' => ($this->check_user_role('view_wholesale') ? 'true' : 'false')
		);
	}
	
	public function shortcode_inventory_customer() {
		ob_start();
		include( 'views/inventory-customer.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_sitemap() {
		ob_start();
		include( 'views/sitemap.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_creditapplication($attributes) {
		ob_start();
		include( 'views/creditapplication.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_contactus() {
		ob_start();
		include( 'views/contactus.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
    
    public function shortcode_contactg() {
		ob_start();
		include( 'views/contactg.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
    
    public function shortcode_galleryp() {
		ob_start();
		include( 'views/galleryp.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
    
    public function shortcode_videop() {
		ob_start();
		include( 'views/videop.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
    
     public function shortcode_brochurep() {
		ob_start();
		include( 'views/brochurep.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	} 
    
    public function shortcode_emailfrindsp() {
		ob_start();
		include( 'views/emailfrindsp.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
        
        public function shortcode_makeoffer() {
		ob_start();
		include( 'views/makeoffer.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_valuetrade() {
		ob_start();
		include( 'views/valuetrade.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_search_dropdowns() {
		ob_start();
		include( 'views/inventory-search-dropdowns.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_search() {
		ob_start();
		include( 'views/inventory-search.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_singleoffer($attributes) {
		ob_start();
		include( 'views/inventory-singleoffer.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_bestprice($attributes) {
		ob_start();
		include( 'views/inventory-bestprice.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_newaddition($attributes) {
		ob_start();
		include( 'views/inventory-newaddition.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_popular($attributes) {
		ob_start();
		include( 'views/inventory-popular.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_featured($attributes) {
		ob_start();
		include( 'views/inventory-featured.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_inventory() {
		ob_start();
		include( 'views/inventory.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function shortcode_inventory_featured_slideshow() {
		ob_start();
		include( 'views/inventory-featured-slideshow.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
		
		public function shortcode_inventory_slideshow() {
		ob_start();
		include( 'views/inventory-slideshow.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}	
		public function shortcode_inventory_search_autocomplete() {
		ob_start();
		include( 'views/inventory-search-autocomplete.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}	
		public function shortcode_chained_dropdowns() {
		ob_start();
		include( 'views/inventory-chained-dropdowns.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}	
		public function shortcode_form_email() {
		ob_start();
		include( 'views/form-email.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}	
		public function shortcode_inventory_similar() {
		ob_start();
		include( 'views/similar-inventory.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}	
		public function shortcode_form_calc() {
		ob_start();
		include( 'views/form-calc.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
        
        	
		public function shortcode_test() {
		ob_start();
		include( 'views/test.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
        
        	
		public function shortcode_makes_grid() {
		ob_start();
		include( 'views/makes-link-grid.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
        
        
        	
		public function shortcode_carousel() {
		ob_start();
		include( 'views/inventory-carousel.view.php' );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
		if (get_role('wholesale_user') == null)
			add_role('wholesale_user', 'Wholesale User', array('read' => true, 'view_wholesale' => true));
			
		// create pages		
		foreach ($this->pages_array as $key=>$value) {
			$post = array(
				'post_title' => $key,
				'post_content' => $value,
				'post_type' => 'page',
				'post_status' => 'publish'
			);
			$page = get_page_by_title($key);
			if ($page != null) $post['ID'] = $page->ID;
			wp_insert_post($post);
			$page = get_page_by_title($key);
			update_post_meta( $page->ID, '_wp_page_template', 'page-templates/full-width.php' );
		}
		
		// set permalink option
		update_option( 'permalink_structure', '/%postname%/' );
		
	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		if (get_role('wholesale_user') != null)
			remove_role('wholesale_user');
		
		foreach ($this->pages_array as $key=>$value) {
			$page = get_page_by_title($key);
			if ($page != null) wp_delete_post($page->ID);
		}
	} // end deactivate
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function uninstall( $network_wide ) {
		// TODO:	Define uninstall functionality here		
	} // end uninstall

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
	
		// TODO: replace "dealernetwork-inventory-locale" with a unique value for your plugin
		$domain = 'dealernetwork-inventory-locale';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		// TODO:	Change 'dealernetwork-inventory' to the name of your plugin
		wp_enqueue_style( 'dealernetwork-inventory-admin-styles', plugins_url( 'dealernetwork-inventory/css/admin.css' ) );
		//wp_enqueue_style( 'dealernetwork-inventory-admin-styles-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css' ) );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts($hook) {
		if (strpos($hook, 'dn_settings') === false) return;
		// TODO:	Change 'dealernetwork-inventory' to the name of your plugin
		wp_enqueue_script( 'dealernetwork-inventory-admin-script', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js' );
		wp_enqueue_script( 'dealernetwork-inventory-admin-script-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js' );
		wp_enqueue_script( 'dealernetwork-inventory-admin-script-tabs', plugins_url( 'dealernetwork-inventory/js/admin.js' ) );
	
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		// TODO:	Change 'dealernetwork-inventory' to the name of your plugin
		wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css' );
		wp_enqueue_style( 'dealernetwork-inventory-plugin-styles', plugins_url( 'dealernetwork-inventory/css/display.css' ) );
        wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-owlcarousel', plugins_url( 'dealernetwork-inventory/css/owl.carousel.css' ) );
        wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-owltheme', plugins_url( 'dealernetwork-inventory/css/owl.theme.css' ) );
		wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-fancybox', plugins_url( 'dealernetwork-inventory/css/jquery.fancybox.css' ) );
		wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-chosen', plugins_url( 'dealernetwork-inventory/css/chosen.min.css' ) );
		wp_enqueue_style( 'dealernetwork-inventory-plugin-styles-bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');

	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
		// TODO:	Change 'dealernetwork-inventory' to the name of your plugin
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script', plugins_url( 'dealernetwork-inventory/js/display.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-gallerific', plugins_url( 'dealernetwork-inventory/js/jquery.galleriffic.js' ) );
        wp_enqueue_script( 'dealernetwork-inventory-plugin-script-owlcarousel', plugins_url( 'dealernetwork-inventory/js/owl.carousel.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-mousewheel', plugins_url( 'dealernetwork-inventory/js/jquery.mousewheel.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-chosen', plugins_url( 'dealernetwork-inventory/js/chosen.jquery.min.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-fancybox', plugins_url( 'dealernetwork-inventory/js/jquery.fancybox.pack.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-vaidate', plugins_url( 'dealernetwork-inventory/js/jquery.validate.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-maskedinput', plugins_url( 'dealernetwork-inventory/js/jquery.maskedinput.min.js' ) );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-pager', plugins_url( 'dealernetwork-inventory/js/pager.js' ), false, '1.0', true );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js' );
		wp_enqueue_script( 'dealernetwork-inventory-plugin-script-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' );
	} // end register_plugin_scripts
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/
	
	/**
 	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *		  WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *		  Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 */
	 
	function action_start_session() {
		if (!session_id()) {
			session_start();
		}
	}
	 
	function action_flush_rules() {
    	$rules = get_option('rewrite_rules');
		if (!isset($rules['(inventory)/(.+)$'])) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
	} // end action_method_name
	
	public function load_settings() {
		$this->settings = (array) get_option( $this->settings_key );
		foreach ($this->settings_default as $key => $value) {
			if (!isset($this->settings[$key]) || empty($this->settings[$key]))
				$this->settings[$key] = (strpos($value, '.txt') !== false ? file_get_contents(ABSPATH . 'wp-content/plugins/dealernetwork-inventory/views/admin/default-templates/' . $value) : $value);
		}
		update_option( $this->settings_key, $this->settings );
		
		// customize session keys
		$this->session_car_list_key .= '-' . $this->settings['LocationID'];
		$this->session_dealer_key .= '-' . $this->settings['LocationID'];
		$this->session_location_key .= '-' . $this->settings['LocationID'];
		$this->session_zipcodes_key .= '-' . $this->settings['LocationID'];
		$this->session_rpp_key .= '-' . $this->settings['LocationID'];
		
		// records per page
		if (isset($_COOKIE[$this->session_rpp_key]))
			$this->records_per_page = intval($_COOKIE[$this->session_rpp_key]);
		if (!isset($_COOKIE[$this->session_rpp_key])) {
			setcookie($this->session_rpp_key, intval($this->settings['ListRPP']), time() + (3600 * 24 * 30), "/");
			$this->records_per_page = intval($this->settings['ListRPP']);
		}
		if (isset($_GET[$this->rpp_key]) && is_numeric($_GET[$this->rpp_key])) {
			if (intval($_GET[$this->rpp_key]) != intval($_COOKIE[$this->session_rpp_key])) {
				setcookie($this->session_rpp_key, null, time() + (3600 * 24 * 30), "/");
				setcookie($this->session_rpp_key, intval($_GET[$this->rpp_key]), time() + (3600 * 24 * 30), "/");
				$this->records_per_page = intval($_GET[$this->rpp_key]);
			}
		}
		
		// car list
		$location_id = $this->settings['LocationID'];
		$dealer_id = $this->settings['DealerID'];
		if (isset($_SESSION[$this->session_car_list_key])) {
			$this->car_list = $_SESSION[$this->session_car_list_key];
		} else {
			$_SESSION[$this->session_car_list_key] = $this->car_list = Car::GetListByLocationID($location_id);
		}
		
                //-------------------------------------------
		//adding sold inventory to car_list
		//TODO: have dealernetwork send sold vehicles, then delete this work-around.
                
                 if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME))
                 {
                    $sql = 'create table if not exists `sold_inventory`(id INT, previous_inv MEDIUMBLOB NULL, sold_inv MEDIUMBLOB NULL)';
                    $mysqli->query($sql);
                    
                    $one = 1;
                    $sql = "select `id` from `sold_inventory` where `id` = ?";
                    if ($stmt = $mysqli->prepare($sql))
                    {
                        $stmt->bind_param('i', $one);
                        if ($stmt->execute())
                        {
                            $stmt->store_result();
                            if ($stmt->num_rows < 1)
                            {
                                $sql = 'insert into `sold_inventory`(id, previous_inv, sold_inv) values(1, NULL, NULL)';
                                $mysqli->query($sql);
                            }
                            $stmt->free_result();
                        }
                        $stmt->close();
                    }
                         
                    //functions
                        function car_in_array($car, $array)
                        {
                                $flag = false;
                                foreach($array as $x)
                                {
                                        if($x->VIN == $car->VIN)
                                        {
                                            $flag = true;
                                        }
                                }
                                return $flag;
                        }

                        function delete_car_from_array(&$array, $car)
                        {
                            foreach($array as $key => $x)
                            {
                                if($x->VIN == $car->VIN)
                                {
                                    unset($array[$key]);
                                }
                            }
                        }

                        function getPrevAndSold($conn)
                        {
                              $one = 1;
                              $sql = "select `previous_inv`, `sold_inv` from `sold_inventory` where `id` = ?";

                              if ($stmt = $conn->prepare($sql))
                              {
                                  $stmt->bind_param('i', $one);
                                  if ($stmt->execute())
                                  {
                                      $stmt->store_result();
                                      if ($stmt->num_rows > 0)
                                      {
                                          $stmt->bind_result($prev, $sold);
                                          $stmt->fetch();
                                          $stmt->free_result();
                                          $stmt->close();
                                          return array(unserialize($prev), unserialize($sold));
                                      }
                                      $stmt->free_result();
                                  }
                                  $stmt->close();
                              }
                              return false;
                        }

                        function setPrevAndSold($conn, $prev, $sold)
                        {
                            $sql = "update `sold_inventory` set `previous_inv` = ?, `sold_inv` = ? where `id` = ?";
                            
                            if ($stmt = $conn->prepare($sql))
                            {
                                $one = 1;
                                $stmt->bind_param('ssi', serialize($prev), serialize($sold), $one);
                                if ($stmt->execute())
                                {
                                    $stmt->close();
                                    return true;
                                }else
                                {
                                    echo $conn->error;
                                }
                                $stmt->close();
                            }
                            return false;
                        }
                        //end functions

                        $inventory = getPrevAndSold($mysqli); //$inventory[0] = previous, [1] = sold
                      
                        if($inventory[0])
                        {
                            $prevInv = $inventory[0];
                            $soldInv = $inventory[1];
                            
                            //check for re-added inventory, remove from soldInv
                            foreach($this->car_list as $car)
                            {
                                if(car_in_array($car, $soldInv))
                                {
                                    delete_car_from_array($soldInv, $car);
                                }
                            }
                            
                            //check for cars that are no longer being sent by dealernetwork, add them to soldInv
                            foreach($prevInv as $key => $car)
                                {
                                        if(!car_in_array($car, $this->car_list))
                                        {
                                                //add to soldInv with datekey, and remove from prevInv
                                                if(!car_in_array($car, $soldInv))
                                                {
                                                        $car->Status = 'Sold';
                                                        $soldInv[date('z').' '.$car->VIN] = $car;
                                                        unset($prevInv[$key]); 
                                                }
                                        }
                                }

                                //filter cars older than X days from $soldInv
                                foreach($soldInv as $key => $car)
                                {
                                        $x = $this->settings['DaysToShowSold'];
                                        $exploded = explode(' ', $key);
                                        if( (int) $exploded[0] + $x <= (date('z')) || (int) $exploded[0] > date('z'))
                                        {
                                            unset($soldInv[$key]);
                                        }
                                }

                                //add current Inventory to $prevInv
                                foreach($this->car_list as $car)
                                {
                                        if(!car_in_array($car, $prevInv))
                                        {
                                            array_push($prevInv, $car);
                                        }
                                }

                                //add $soldInv to current inv
                                foreach($soldInv as $car)
                                {
                                        if(!car_in_array($car, $this->car_list))
                                        {
                                                array_push($this->car_list, $car);
                                        }
                                }
                                
                                setPrevAndSold($mysqli, $prevInv, $soldInv);
                        }else
                        {
                            $prevInv = $this->car_list;
                            $soldInv = [];

                            setPrevAndSold($mysqli, $prevInv, $soldInv);
                        }
                        $mysqli->close();
                 }
                 
                        
                //end sold-inventory temp solution
		//------------------------------------------
                
		// dealer info
		if (isset($_SESSION[$this->session_dealer_key])) {
			$this->dealer = $_SESSION[$this->session_dealer_key];
		} else {
			$_SESSION[$this->session_dealer_key] = $this->dealer = Dealer::GetByDealerID($dealer_id);
		}
		
		// location info
		if (isset($_SESSION[$this->session_location_key])) {
			$this->location = $_SESSION[$this->session_location_key];
		} else {
			$_SESSION[$this->session_location_key] = $this->location = Location::GetByLocationID($location_id);
		}
		
		// dpl info
		if (isset($_SESSION[$this->session_dpl_key])) {
			$this->dpl = $_SESSION[$this->session_dpl_key];
		} else {
			$_SESSION[$this->session_dpl_key] = $this->dpl = DealerPartnerLink::GetByLocationID($location_id);
		}
		
		// zipcodes
		if (isset($_SESSION[$this->session_zipcodes_key])) {
			$this->zipcodes = $_SESSION[$this->session_zipcodes_key];
		} else {
			$_SESSION[$this->session_zipcodes_key] = $this->zipcodes = ZipCode::ListByZipRadius($this->location->Zip, 5);
		}
		
		// sitemap
		$this->generate_sitemap();
		
		// add extra shortcodes
		
		add_shortcode('dealernetwork-dealership-name', array($this, 'shortcode_dealership_name'));
		add_shortcode('dealernetwork-dealership-website',  array($this, 'shortcode_dealership_website'));
		add_shortcode('dealernetwork-dealership-address',  array($this, 'shortcode_dealership_address'));
		add_shortcode('dealernetwork-dealership-address2',  array($this, 'shortcode_dealership_address2'));
		add_shortcode('dealernetwork-dealership-city',  array($this, 'shortcode_dealership_city'));
		add_shortcode('dealernetwork-dealership-state',  array($this, 'shortcode_dealership_state'));
		add_shortcode('dealernetwork-dealership-zip',  array($this, 'shortcode_dealership_zip'));
		add_shortcode('dealernetwork-dealership-phone',  array($this, 'shortcode_dealership_phone'));
		add_shortcode('dealernetwork-dealership-email',  array($this, 'shortcode_dealership_email'));
		add_shortcode('dealernetwork-dealership-hours-monday',  array($this, 'shortcode_dealership_hours_monday'));
		add_shortcode('dealernetwork-dealership-hours-tuesday',  array($this, 'shortcode_dealership_hours_tuesday'));
		add_shortcode('dealernetwork-dealership-hours-wednesday',  array($this, 'shortcode_dealership_hours_wednesday'));
		add_shortcode('dealernetwork-dealership-hours-thursday',  array($this, 'shortcode_dealership_hours_thursday'));
		add_shortcode('dealernetwork-dealership-hours-friday',  array($this, 'shortcode_dealership_hours_friday'));
		add_shortcode('dealernetwork-dealership-hours-saturday',  array($this, 'shortcode_dealership_hours_saturday'));
		add_shortcode('dealernetwork-dealership-hours-sunday',  array($this, 'shortcode_dealership_hours_sunday'));
	}
	
	public function shortcode_dealership_name() {
		return $this->dealer->Company;
	}

	public function shortcode_dealership_website() {
		return $this->dealer->Website;
	}

	public function shortcode_dealership_address() {
		return $this->location->Address;
	}

	public function shortcode_dealership_address2() {
		return $this->location->Address2;
	}

	public function shortcode_dealership_city() {
		return $this->location->City;
	}

	public function shortcode_dealership_state() {
		return $this->location->State;
	}

	public function shortcode_dealership_zip() {
		return $this->location->Zip;
	}

	public function shortcode_dealership_phone() {
		return $this->location->Phone;
	}

	public function shortcode_dealership_email() {
		return $this->location->Email;
	}

	public function shortcode_dealership_hours_monday() {
		return $this->dealer->Settings->MondayHours;
	}

	public function shortcode_dealership_hours_tuesday() {
		return $this->dealer->Settings->TuesdayHours;
	}

	public function shortcode_dealership_hours_wednesday() {
		return $this->dealer->Settings->WednesdayHours;
	}

	public function shortcode_dealership_hours_thursday() {
		return $this->dealer->Settings->ThursdayHours;
	}

	public function shortcode_dealership_hours_friday() {
		return $this->dealer->Settings->FridayHours;
	}

	public function shortcode_dealership_hours_saturday() {
		return $this->dealer->Settings->SaturdayHours;
	}

	public function shortcode_dealership_hours_sunday() {
		return $this->dealer->Settings->SundayHours;
	}
	
	public function action_show_admin() {
		//add_options_page('DealerNetwork', 'DealerNetwork', 1, 'DealerNetwork', function() {include('views/admin.view.php');});
		add_menu_page('DealerNetwork General Settings', 'DealerNetwork', 'nosuchcapability', 'dn_settings');
		add_submenu_page('dn_settings', 'DealerNetwork General Settings', 'General', 'administrator', 'dn_settings_general', function() {include('views/admin/general.view.php');});
		add_submenu_page('dn_settings', 'DealerNetwork SEO Settings', 'SEO Settings', 'administrator', 'dn_settings_seo', function() {include('views/admin/seo.view.php');});
		add_submenu_page('dn_settings', 'DealerNetwork Templates', 'Templates', 'administrator', 'dn_settings_templates', function() {include('views/admin/templates.view.php');});
	}
	
	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *		  WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *		  Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 */
	function filter_insert_rewrite_rules($rules) {
	    $newrules = array();
		$newrules['(inventory)/(.+)$'] = 'index.php?pagename=$matches[1]&friendly=$matches[2]';
		$newrules['(trade-appraisal)/(.+)$'] = 'index.php?pagename=$matches[1]&friendly=$matches[2]';
		
		return $newrules + $rules;
	} // end filter_method_name
	
	function filter_insert_query_vars($vars) {
		array_push($vars, 'friendly');
		return $vars;
	}
	
	function alter_title($title, $sep) {
		// check to see if this is a detail page
		$car = $this->get_detail_car();
		if ($car != null) $title = "$car->Year $car->Make $car->Model $sep ";
		return $title;
	}
  
} // end class

// TODO:	Update the instantiation call of your plugin to the name given at the class definition
$dealernetwork_inventory = new DealerNetworkInventory();
