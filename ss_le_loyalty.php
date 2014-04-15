<?php
/**
 * Plugin Name: SS Loyalty Easy
 * Plugin URI: http://stickystreet.com/
 * Description: StickyStreet Loyalty Integration plugin.  Requires PHP5.
 * Version: 2.0
 * Author: Russell Benzing
 * Author URI: http://russellbenzing.com/
 */
 
 error_reporting(E_ERROR);
 ini_set('display_errors', '1');
 
 //if($_SERVER['SCRIPT_FILENAME'] == __FILE__) die("Access denied.");
 if(!class_exists('ss_LoyaltyEasy')){
 class ss_LoyaltyEasy{
 
 	static $instance = false;
 	private $_settings;
 	private $_campaigns;
    private $_optionsGroup = 'ss_le_options';
    private $_optionsName = 'ss_le_';
    public $_countries = array('AF'=>'Afghanistan','AL'=>'Albania','DZ'=>'Algeria','AS'=>'American Samoa','AD'=>'Andorra','AO'=>'Angola','AI'=>'Anguilla','AQ'=>'Antarctica','AG'=>'Antigua And Barbuda','AR'=>'Argentina','AM'=>'Armenia','AW'=>'Aruba','AU'=>'Australia','AT'=>'Austria','AZ'=>'Azerbaijan','BS'=>'Bahamas','BH'=>'Bahrain','BD'=>'Bangladesh','BB'=>'Barbados','BY'=>'Belarus','BE'=>'Belgium','BZ'=>'Belize','BJ'=>'Benin','BM'=>'Bermuda','BT'=>'Bhutan','BO'=>'Bolivia','BA'=>'Bosnia And Herzegovina','BW'=>'Botswana','BV'=>'Bouvet Island','BR'=>'Brazil','IO'=>'British Indian Ocean Territory','BN'=>'Brunei','BG'=>'Bulgaria','BF'=>'Burkina Faso','BI'=>'Burundi','KH'=>'Cambodia','CM'=>'Cameroon','CA'=>'Canada','CV'=>'Cape Verde','KY'=>'Cayman Islands','CF'=>'Central African Republic','TD'=>'Chad','CL'=>'Chile','CN'=>'China','CX'=>'Christmas Island','CC'=>'Cocos (Keeling) Islands','CO'=>'Columbia','KM'=>'Comoros','CG'=>'Congo','CK'=>'Cook Islands','CR'=>'Costa Rica','CI'=>'Cote D\'Ivorie (Ivory Coast)','HR'=>'Croatia (Hrvatska)','CU'=>'Cuba','CY'=>'Cyprus','CZ'=>'Czech Republic','CD'=>'Democratic Republic Of Congo (Zaire)','DK'=>'Denmark','DJ'=>'Djibouti','DM'=>'Dominica','DO'=>'Dominican Republic','TP'=>'East Timor','EC'=>'Ecuador','EG'=>'Egypt','SV'=>'El Salvador','GQ'=>'Equatorial Guinea','ER'=>'Eritrea','EE'=>'Estonia','ET'=>'Ethiopia','FK'=>'Falkland Islands (Malvinas)','FO'=>'Faroe Islands','FJ'=>'Fiji','FI'=>'Finland','FR'=>'France','FX'=>'France, Metropolitan','GF'=>'French Guinea','PF'=>'French Polynesia','TF'=>'French Southern Territories','GA'=>'Gabon','GM'=>'Gambia','GE'=>'Georgia','DE'=>'Germany','GH'=>'Ghana','GI'=>'Gibraltar','GR'=>'Greece','GL'=>'Greenland','GD'=>'Grenada','GP'=>'Guadeloupe','GU'=>'Guam','GT'=>'Guatemala','GN'=>'Guinea','GW'=>'Guinea-Bissau','GY'=>'Guyana','HT'=>'Haiti','HM'=>'Heard And McDonald Islands','HN'=>'Honduras','HK'=>'Hong Kong','HU'=>'Hungary','IS'=>'Iceland','IN'=>'India','ID'=>'Indonesia','IR'=>'Iran','IQ'=>'Iraq','IE'=>'Ireland','IL'=>'Israel','IT'=>'Italy','JM'=>'Jamaica','JP'=>'Japan','JO'=>'Jordan','KZ'=>'Kazakhstan','KE'=>'Kenya','KI'=>'Kiribati','KW'=>'Kuwait','KG'=>'Kyrgyzstan','LA'=>'Laos','LV'=>'Latvia','LB'=>'Lebanon','LS'=>'Lesotho','LR'=>'Liberia','LY'=>'Libya','LI'=>'Liechtenstein','LT'=>'Lithuania','LU'=>'Luxembourg','MO'=>'Macau','MK'=>'Macedonia','MG'=>'Madagascar','MW'=>'Malawi','MY'=>'Malaysia','MV'=>'Maldives','ML'=>'Mali','MT'=>'Malta','MH'=>'Marshall Islands','MQ'=>'Martinique','MR'=>'Mauritania','MU'=>'Mauritius','YT'=>'Mayotte','MX'=>'Mexico','FM'=>'Micronesia','MD'=>'Moldova','MC'=>'Monaco','MN'=>'Mongolia','MS'=>'Montserrat','MA'=>'Morocco','MZ'=>'Mozambique','MM'=>'Myanmar (Burma)','NA'=>'Namibia','NR'=>'Nauru','NP'=>'Nepal','NL'=>'Netherlands','AN'=>'Netherlands Antilles','NC'=>'New Caledonia','NZ'=>'New Zealand','NI'=>'Nicaragua','NE'=>'Niger','NG'=>'Nigeria','NU'=>'Niue','NF'=>'Norfolk Island','KP'=>'North Korea','MP'=>'Northern Mariana Islands','NO'=>'Norway','OM'=>'Oman','PK'=>'Pakistan','PW'=>'Palau','PA'=>'Panama','PG'=>'Papua New Guinea','PY'=>'Paraguay','PE'=>'Peru','PH'=>'Philippines','PN'=>'Pitcairn','PL'=>'Poland','PT'=>'Portugal','PR'=>'Puerto Rico','QA'=>'Qatar','RE'=>'Reunion','RO'=>'Romania','RU'=>'Russia','RW'=>'Rwanda','SH'=>'Saint Helena','KN'=>'Saint Kitts And Nevis','LC'=>'Saint Lucia','PM'=>'Saint Pierre And Miquelon','VC'=>'Saint Vincent And The Grenadines','SM'=>'San Marino','ST'=>'Sao Tome And Principe','SA'=>'Saudi Arabia','SN'=>'Senegal','SC'=>'Seychelles','SL'=>'Sierra Leone','SG'=>'Singapore','SK'=>'Slovak Republic','SI'=>'Slovenia','SB'=>'Solomon Islands','SO'=>'Somalia','ZA'=>'South Africa','GS'=>'South Georgia And South Sandwich Islands','KR'=>'South Korea','ES'=>'Spain','LK'=>'Sri Lanka','SD'=>'Sudan','SR'=>'Suriname','SJ'=>'Svalbard And Jan Mayen','SZ'=>'Swaziland','SE'=>'Sweden','CH'=>'Switzerland','SY'=>'Syria','TW'=>'Taiwan','TJ'=>'Tajikistan','TZ'=>'Tanzania','TH'=>'Thailand','TG'=>'Togo','TK'=>'Tokelau','TO'=>'Tonga','TT'=>'Trinidad And Tobago','TN'=>'Tunisia','TR'=>'Turkey','TM'=>'Turkmenistan','TC'=>'Turks And Caicos Islands','TV'=>'Tuvalu','UG'=>'Uganda','UA'=>'Ukraine','AE'=>'United Arab Emirates','UK'=>'United Kingdom','US'=>'United States','UM'=>'United States Minor Outlying Islands','UY'=>'Uruguay','UZ'=>'Uzbekistan','VU'=>'Vanuatu','VA'=>'Vatican City (Holy See)','VE'=>'Venezuela','VN'=>'Vietnam','VG'=>'Virgin Islands (British)','VI'=>'Virgin Islands (US)','WF'=>'Wallis And Futuna Islands','EH'=>'Western Sahara','WS'=>'Western Samoa','YE'=>'Yemen','YU'=>'Yugoslavia','ZM'=>'Zambia','ZW'=>'Zimbabwe');
    public $_states = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois",'IN'=>"Indiana",'IA'=>"Iowa",'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland",'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma",'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");
    public $_months = array('January','February','March','April','May','June','July','August','September','October','November','December');
 	
 	public function __construct() {
 		$this->ss_le_set_settings(); 		
 		$this->_getCampaigns();
 		
 		add_action('admin_init',array($this,'ss_le_register_options'));
 		add_action('admin_menu',array($this,'ss_le_admin_menu'));
 		add_action('plugins_loaded',array($this,'loadFB'));
 		add_action('wp_enqueue_scripts', array($this,'ss_le_resources'));
 		add_action('wp_ajax_ss_le_logout',array($this,'ss_le_fb_logout'));
 		 		
 		register_activation_hook( __FILE__,array($this,'activatePlugin'));
        register_uninstall_hook(__FILE__, array($this,'uninstallPlugin'));
        
        add_action('wp_ajax_ss_le_balance', array($this,'ss_le_balancecheck'));
	 	add_action('wp_ajax_nopriv_ss_le_balance', array($this,'ss_le_balancecheck'));
        
 		add_shortcode('le_balancecheck', array(__CLASS__,'ss_le_form'));
 		add_shortcode('le_register', array(__CLASS__,'ss_le_register_form'));
 	}
 	
 	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new self;
		}      
		return self::$instance;
    }
    
    public function loadFB(){
    	require('includes/facebook.php');
    }
 	
 	private function activatePlugin(){
		update_option($this->_optionsName,$this->_settings);
    }
    
    private function uninstallPlugin(){
    	delete_option($this->_optionsName.'api_url');
		delete_option($this->_optionsName.'user_id');
		delete_option($this->_optionsName.'password');
		delete_option($this->_optionsName.'account_id');
		//delete_option($this->_optionsName.'campaign_id');
		delete_option($this->_optionsName.'app_id');
        delete_option($this->_optionsName.'app_secret');
     	delete_option($this->_optionsName.'fb_redirect');
    	delete_option($this->_optionsName.'show_campaign');
     	delete_option($this->_optionsName.'show_phone');
     	delete_option($this->_optionsName.'show_address');
     	delete_option($this->_optionsName.'show_birthday');
      	delete_option($this->_optionsName.'show_country');
       	delete_option($this->_optionsName.'show_password');
     	delete_option($this->_optionsName.'default_campaign');
        delete_option($this->_optionsName.'balance_campaign');
        delete_option($this->_optionsName.'success_url');
		delete_option($this->_optionsName.'require_password');
		delete_option($this->_optionsName.'auto_add_points');
		delete_option($this->_optionsName.'free_enroll');
		delete_option($this->_optionsName.'default_campaign_name');
    }
 	
 	public function ss_le_resources() {
 		wp_enqueue_style('ss_le_style', plugins_url('ss_le_style.css', __FILE__), '', '1.0');
		wp_enqueue_script('ss_le_ajax', plugins_url('js/ajax.js', __FILE__), array('jquery'));
 		wp_enqueue_script('ss_le_validation', plugins_url('js/jquery.validateField.js', __FILE__), array('jquery'));
        wp_enqueue_script('ss_le_runtime', plugins_url('js/runtime.js', __FILE__), array('jquery'));
		wp_localize_script( 
        	'ss_le_ajax', 
        	'wp_ajax', 
        	array( 
            	'ajaxurl'	=> admin_url('admin-ajax.php'), 
            	'ajaxnonce' => wp_create_nonce('ss_le_validation'),
            	'pluginimg'  => plugins_url('images/ajax-loading.gif',__FILE__)
        	)
        );
 	}
	
	private function ss_le_set_settings(){
		if(empty($this->_settings)){
			$this->_settings = get_option($this->_optionsName);
		}
		if(!is_array($this->_settings)){
			$this->_settings = array();
		}
		$defaults = array(
			'api_url'				=> 'https://api.clienttoolbox.com/api.php',
			'user_id'				=> '',
			'password'				=> '',
			'account_id'			=> '',
			//'campaign_id'			=> '',
			'app_id'				=> '',
        	'app_secret'            => '',
          	'fb_redirect'           => '',
			'show_campaign'         => '',
         	'show_phone'            => '',
          	'show_address'          => '',
         	'show_birthday'         => '',
          	'show_country'          => '',
          	'default_campaign'      => '',
           	'balance_campaign'      => '',
          	'success_url'           => '',
          	'show_password'         => '',
			'require_password'		=> '',
			'auto_add_points'		=> '',
			'free_enroll'			=> '',
			'default_campaign_name' => 'Default Campaign'
		);
		$this->_settings = wp_parse_args($this->_settings, $defaults);
	}
	
	public function ss_le_get_setting($settingName){
		if(isset($this->_settings[$settingName])){
			return $this->_settings[$settingName];
		} else {
			return false;
		}
	}
    
	public function ss_le_register_options(){
		register_setting( $this->_optionsGroup, $this->_optionsName );
	}
       
	public function ss_le_admin_menu(){
		add_options_page('Loyalty Easy Settings','Loyalty Easy','manage_options','ss_le_options',array($this,'ss_le_options'));
    }
    
    public function ss_le_options(){
    	?>
    	<div class="wrap">
		<?php screen_icon('options-general'); ?>
		<h2>Loyalty Easy Settings</h2>
    	<form method="post" action="options.php">
    		<?php settings_fields( $this->_optionsGroup ); ?>
    		 <table class="form-table">
    		 	<tr valign="top">
					<th scope="row">Shortcode:</th>
					<td>[le_balancecheck] - Customer Balance Check<br />
					[le_register] - Customer Balance Check</td>
				</tr>
                <tr valign="top">
                	<th colspan="2"><h2>Balance Form Settings</h2></th>
            	</tr>
                <tr valign="top">
                	<th scope="row">Require Password:</th>
               		<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[require_password]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_require_password"<?php if(esc_attr($this->ss_le_get_setting('require_password'))=='1') echo ' checked'; ?> /></td>
             	</tr>
                <tr valign="top">
                	<th scope="row">Balance Lookup Campaign ID(s):</th>
                	<td><input type="text" name="<?php echo $this->_optionsName; ?>[balance_campaign]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('balance_campaign')); ?>" id="<?php echo $this->_optionsName; ?>_balance_campaign" /></td>
              	</tr>
				<tr valign="top">
                	<th colspan="2"><h2>Register Form Settings</h2></th>
            	</tr>
                <tr valign="top">
               		<th scope="row">Free Enroll:</th>
            		<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[free_enroll]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_free_enroll"<?php if(esc_attr($this->ss_le_get_setting('free_enroll'))=='1') echo ' checked'; ?> /></td>
            	</tr>
              	<tr valign="top">
               		<th scope="row">Show Campaigns Dropdown:</th>
            		<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[show_campaigns]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_show_campaigns"<?php if(esc_attr($this->ss_le_get_setting('show_campaigns'))=='1') echo ' checked'; ?> /></td>
            	</tr>
             	<tr valign="top">
               		<th scope="row">Default Enrollment Campaign ID(s):</th>
               		<td><input type="text" name="<?php echo $this->_optionsName; ?>[default_campaign]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('default_campaign')); ?>" id="<?php echo $this->_optionsName; ?>_default_campaign" /></td>
             	</tr>
                <tr valign="top">
               		<th scope="row">Default Enrollment Campaign Label:</th>
               		<td><input type="text" name="<?php echo $this->_optionsName; ?>[default_campaign_name]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('default_campaign_name')); ?>" id="<?php echo $this->_optionsName; ?>_default_campaign_name" /></td>
             	</tr>
                <tr valign="top">
               		<th scope="row">Enrollment Campaign ID(s) Auto Add Amount:</th>
               		<td><input type="text" name="<?php echo $this->_optionsName; ?>[auto_add_points]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('auto_add_points')); ?>" id="<?php echo $this->_optionsName; ?>_auto_add_points" /></td>
             	</tr>
             	
              	<tr valign="top">
                	<th scope="row">Show Password Fields:</th>
               		<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[show_password]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_show_password"<?php if(esc_attr($this->ss_le_get_setting('show_password'))=='1') echo ' checked'; ?> /></td>
             	</tr>
              	<tr valign="top">
                 	<th scope="row">Show Phone:</th>
                  	<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[show_phone]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_show_phone"<?php if(esc_attr($this->ss_le_get_setting('show_phone'))=='1') echo ' checked'; ?> /></td>
               	</tr>
              	<tr valign="top">
                 	<th scope="row">Show Address:</th>
                	<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[show_address]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_show_address"<?php if(esc_attr($this->ss_le_get_setting('show_address'))=='1') echo ' checked'; ?> /></td>
               	</tr>
                <tr valign="top">
                	<th scope="row">Show Country:</th>
                	<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[show_country]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_show_country"<?php if(esc_attr($this->ss_le_get_setting('show_country'))=='1') echo ' checked'; ?> /></td>
               	</tr>
               	<tr valign="top">
                	<th scope="row">Show Birthday:</th>
                	<td><input type="checkbox" name="<?php echo $this->_optionsName; ?>[show_birthday]" value="1" class="code" id="<?php echo $this->_optionsName; ?>_show_birthday"<?php if(esc_attr($this->ss_le_get_setting('show_birthday'))=='1') echo ' checked'; ?> /></td>
                </tr>
                <tr valign="top">
               		<th>Register Success Landing Page:</th>
                	<td><select name="<?php echo $this->_optionsName; ?>[success_url]" id="<?php echo $this->_optionsName; ?>_success_url">
                  		<option value="">Select a Page</option>
                   		<?php
                         	$pages = get_pages();
                      		foreach ( $pages as $pagg ) {
                          		if(esc_attr($this->ss_le_get_setting('success_url'))==$pagg->ID) $x=' selected';else $x='';
                            	$option = '<option value="'.$pagg->ID.'"'.$x.'>';
                             	$option .= $pagg->post_title;
                           		$option .= '</option>';
                            	echo $option;
                        	}
                    	?></select>
            		</td>
            	</tr>
                <tr valign="top">
                	<th colspan="2"><h2>API Settings</h2></th>
               	</tr>
        		<tr valign="top">
        			<th scope="row">API URL:</th>
        			<td><input type="text" name="<?php echo $this->_optionsName; ?>[api_url]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('api_url')); ?>" /></td>
        		</tr>
        		<tr valign="top">
        			<th scope="row">API User ID:</th>
        			<td><input type="text" name="<?php echo $this->_optionsName; ?>[user_id]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('user_id')); ?>" /></td>
        		</tr>
        		<tr valign="top">
        			<th scope="row">API Password:</th>
        			<td><input type="text" name="<?php echo $this->_optionsName; ?>[password]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('password')); ?>" /></td>
        		</tr>
        		<tr valign="top">
        			<th scope="row">API Account ID:</th>
        			<td><input type="text" name="<?php echo $this->_optionsName; ?>[account_id]" style="width:250px;" value="<?php echo esc_attr($this->ss_le_get_setting('account_id')); ?>" /></td>
        		</tr>
        		<!--<tr valign="top">
        			<th scope="row">Campaign ID:</th>
        			<td><input type="text" name="<?php echo $this->_optionsName; ?>[campaign_id]" style="width:250px;" placeholder="(optional)" value="<?php echo esc_attr($this->ss_le_get_setting('campaign_id')); ?>" /></td>
        		</tr>-->
        		<tr valign="top">
                	<th colspan="2"><h2>Facebook Connect Settings</h2></th>
               	</tr>
               	<tr valign="top">
                	<th scope="row">App ID:</th>
                	<td><input type="text" name="<?php echo $this->_optionsName; ?>[app_id]" value="<?php echo esc_attr($this->ss_le_get_setting('app_id')); ?>" id="<?php echo $this->_optionsName; ?>_app_id" class="regular-text code" /></td>
              	</tr>
               	<tr valign="top">
                	<th scope="row">App Secret:</th>
                	<td><input type="text" name="<?php echo $this->_optionsName; ?>[app_secret]" value="<?php echo esc_attr($this->ss_le_get_setting('app_secret')); ?>" id="<?php echo $this->_optionsName; ?>_app_secret" class="regular-text code" /></td>
              	</tr>
              	<tr valign="top">
                	<th>Facebook Connect Logout Page:<br /><small><font color="red">*</font> defaults to current page if not specified</small></th>
              		<td><select name="<?php echo $this->_optionsName; ?>[fb_redirect]" id="<?php echo $this->_optionsName; ?>_fb_redirect">
                		<option value="">Select a page</option>
                       	<?php
                        	$pages = get_pages();
                          	foreach ( $pages as $p ) {
                            	if(esc_attr($this->ss_le_get_setting('fb_redirect'))==$p->ID) $x=' selected';else $x='';
                            	$option = '<option value="'.$p->ID.'"'.$x.'>';
                             	$option .= $p->post_title;
                          		$option .= '</option>';
                            	echo $option;
                        	}
                   		?></select>
             		</td>
          		</tr>
    			</table>
    		<?php submit_button('Save Changes','primary','submit'); ?>
		</form>
		</div>
    	<?php
    }
    
	public function ss_le_balancecheck(){		
		check_ajax_referer('ss_le_validation', 'security');
		$user = esc_attr($_POST['username']);
		$pass = esc_attr($_POST['password']);
		$this->ss_le_get_balance($user,$pass);
		die;
	}
	
	private function ss_le_get_balance($customer_user_id,$customer_password){
		$user_id = $this->ss_le_get_setting('user_id');
		$account_id = $this->ss_le_get_setting('account_id');
		$password = $this->ss_le_get_setting('password');
		$campaign_id = $this->ss_le_get_setting('balance_campaign');
		$is_require_password = $this->ss_le_get_setting('require_password');
		
		if(!empty($user_id) && !empty($password) && !empty($account_id)){
			if(!empty($customer_user_id)){
				if(esc_attr($this->ss_le_get_setting('require_password'))=='1'){
					$valid = $this->_validateCustomer($customer_user_id,$customer_password);
					if($valid['@attributes']['status']=='success'){
						$data['user_id'] 		= $user_id;
						$data['user_password'] 	= $password;
						$data['account_id'] 	= $account_id;
						$data['type'] 			= 'customer_search';
						$data['exact_match']	= 'sensitive';
						$data['card_number'] 	= $customer_user_id;
						$data['customer_password'] = $customer_password;
						$result = $this->sendData($data);
						
						if($result['@attributes']['status']=='success'){
							$fname=$result['customer']['first_name'];
							$lname=$result['customer']['last_name'];
							unset($data);
							$output = array();
							$output['customer'] = $result['customer'];
							if(!empty($campaign_id)){
								$data['user_id']		= $user_id;
								$data['user_password'] 	= $password;
								$data['type'] 			= 'customer_balance';
								$data['account_id'] 	= $account_id;
								$data['campaign_id'] 	= $campaign_id;
								$data['card_number'] 	= $customer_user_id;
								$result = $this->sendData($data);
								$a_campaign=$result['campaign'];
								$c_campaign=$result['campaign']['customer'];
								if($a_campaign['campaign_type']=='giftcard' || $a_campaign['campaign_type']=='earned') $temp_campaign['type']='C'; else $temp_campaign['type']='P';
								$temp_campaign['campaign_name']=$a_campaign['campaign_name'];
								$temp_campaign['balance']=$c_campaign['balance'];
								if($temp_campaign['balance']!=0 && $temp_campaign['balance']!=''){
									$ttemp=array();
									$count=0;
									foreach($result['campaign']['customer']['transactions']['transaction'] as $t){
										if($count==8)break;
										$ttemp[]=$t;
										$count++;
									}
									$temp_campaign['transactions']=$ttemp;
								}
								$output['campaigns'][]=$temp_campaign;
								echo $this->ss_le_results($output);
								exit;
							} else {
								unset($data);
								$data['user_id']		= $user_id;
								$data['user_password'] 	= $password;
								$data['type'] 			= 'campaigns_list';
								$data['account_id'] 	= $account_id;
								$result = $this->sendData($data);
								
								if($result['@attributes']['status']=='success'){
									$campaign_id = NULL;
									if(isset($result['campaigns']['campaign'][0])){
										foreach($result['campaigns']['campaign'] as $single_camp){
											unset($data);
											$data['user_id']		= $user_id;
											$data['user_password'] 	= $password;
											$data['type'] 			= 'customer_balance';
											$data['account_id'] 	= $account_id;
											$data['campaign_id'] 	= $single_camp['id'];
											$data['card_number'] 	= $customer_user_id;
											$result = $this->sendData($data);
											
											if($result['@attributes']['status']=='success'){
												$temp_campaign = array();
												if($result['campaign']['campaign_type']=='giftcard' or $result['campaign']['campaign_type']=='earned') $temp_campaign['type']='C'; else $temp_campaign['type']='P';
												$temp_campaign['campaign_name'] = $result['campaign']['campaign_name'];
												$temp_campaign['balance'] = $result['campaign']['customer']['balance'];
												if($temp_campaign['balance']!=0 and $temp_campaign['balance']!=''){
													$ttemp=array();
													$count=0;
													if(isset($result['campaign']['customer']['transactions']['transaction'][0])){
														foreach($result['campaign']['customer']['transactions']['transaction'] as $t){
															if($count==8)break;
															$ttemp[]=$t;
															$count++;
														}
													} else {
														$t = $result['campaign']['customer']['transactions']['transaction'];
														$ttemp[]=$t;
													}
													$temp_campaign['transactions']=$ttemp;
												}
												$output['campaigns'][]=$temp_campaign;
											}
										}
										echo $this->ss_le_results($output);
										exit;
									} else {
										$campaign_id = $result['campaigns']['campaign']['id'];
									}
								}
							}
						} else {
							echo "No customers found with that card number. Please try again.";
							exit;
						}
					} else {
						echo "Your card number and/or password are incorrect. Please try again.";
						exit;
					}
				} else {
					$data['user_id'] 		= $user_id;
					$data['user_password'] 	= $password;
					$data['account_id'] 	= $account_id;
					$data['type'] 			= 'customer_search';
					$data['exact_match']	= 'sensitive';
					$data['card_number'] 	= $customer_user_id;
					//$data['customer_password'] = $customer_password;
					$result = $this->sendData($data);
					
					if($result['@attributes']['status']=='success'){
						$fname=$result['customer']['first_name'];
						$lname=$result['customer']['last_name'];
						unset($data);
						$output = array();
						$output['customer'] = $result['customer'];
						if(!empty($campaign_id)){
							$data['user_id']		= $user_id;
							$data['user_password'] 	= $password;
							$data['type'] 			= 'customer_balance';
							$data['account_id'] 	= $account_id;
							$data['campaign_id'] 	= $campaign_id;
							$data['card_number'] 	= $customer_user_id;
							$result = $this->sendData($data);
							$a_campaign=$result['campaign'];
							$c_campaign=$result['campaign']['customer'];
							if($a_campaign['campaign_type']=='giftcard' || $a_campaign['campaign_type']=='earned') $temp_campaign['type']='C'; else $temp_campaign['type']='P';
							$temp_campaign['campaign_name']=$a_campaign['campaign_name'];
							$temp_campaign['balance']=$c_campaign['balance'];
							if($temp_campaign['balance']!=0 && $temp_campaign['balance']!=''){
								$ttemp=array();
								$count=0;
								foreach($result['campaign']['customer']['transactions']['transaction'] as $t){
									if($count==8)break;
									$ttemp[]=$t;
									$count++;
								}
								$temp_campaign['transactions']=$ttemp;
							}
							$output['campaigns'][]=$temp_campaign;
							echo $this->ss_le_results($output);
							exit;
						} else {
							unset($data);
							$data['user_id']		= $user_id;
							$data['user_password'] 	= $password;
							$data['type'] 			= 'campaigns_list';
							$data['account_id'] 	= $account_id;
							$result = $this->sendData($data);
							
							if($result['@attributes']['status']=='success'){
								$campaign_id = NULL;
								if(isset($result['campaigns']['campaign'][0])){
									foreach($result['campaigns']['campaign'] as $single_camp){
										unset($data);
										$data['user_id']		= $user_id;
										$data['user_password'] 	= $password;
										$data['type'] 			= 'customer_balance';
										$data['account_id'] 	= $account_id;
										$data['campaign_id'] 	= $single_camp['id'];
										$data['card_number'] 	= $customer_user_id;
										$result = $this->sendData($data);
										
										if($result['@attributes']['status']=='success'){
											$temp_campaign = array();
											if($result['campaign']['campaign_type']=='giftcard' or $result['campaign']['campaign_type']=='earned') $temp_campaign['type']='C'; else $temp_campaign['type']='P';
											$temp_campaign['campaign_name'] = $result['campaign']['campaign_name'];
											$temp_campaign['balance'] = $result['campaign']['customer']['balance'];
											if($temp_campaign['balance']!=0 and $temp_campaign['balance']!=''){
												$ttemp=array();
												$count=0;
												if(isset($result['campaign']['customer']['transactions']['transaction'][0])){
													foreach($result['campaign']['customer']['transactions']['transaction'] as $t){
														if($count==8)break;
														$ttemp[]=$t;
														$count++;
													}
												} else {
													$t = $result['campaign']['customer']['transactions']['transaction'];
													$ttemp[]=$t;
												}
												$temp_campaign['transactions']=$ttemp;
											}
											$output['campaigns'][]=$temp_campaign;
										}
									}
									echo $this->ss_le_results($output);
									exit;
								} else {
									$campaign_id = $result['campaigns']['campaign']['id'];
								}
							}
						}
					} else {
						echo "No customers found with that card number. Please try again.";
						exit;
					}
				}
			} else {
				echo "Your card number is required. Please fill it in and try again.";
				exit;
			}
		} else {
			echo "You must first setup your StickyStreet settings for balance lookup to work correctly.";
			exit;
		}
	}
    
    private function ss_le_results($output) {
    	ob_start();
    	?>
		<div id="ss_le_top_left">
			<span class="lp_name">Hello, <?php echo $output['customer']['first_name'].' '.$output['customer']['last_name']; ?><br />Card #:&nbsp;<?php echo $output['customer']['card_number']; ?></span>
		</div>
		<div id="wrapper" style="margin-top:10px;">
			<table id="main_table" cellpadding="2" cellspacing="2" width="100%" align="center">
			<?php
				foreach($output['campaigns'] as $f){
					if(!empty($f['campaign_name'])){
			?>
			<tr>
				<td>
				<span class="ss_le_name_balance" style="margin-bottom:10px;"><strong><?php echo $f['campaign_name']; ?> Balance:&nbsp;</strong></span>
				<span class="ss_le_point_balance"><?php 
					if($f['type']=='P'){
						echo $f['balance'].' Points';
						$tname = 'Points';
					} else{
						printf("$%.2f",$f['balance']);
						$tname = 'Amount';
					}
				?></span>
				<?php if($f['balance']!=0 && $f['balance']!=''){ ?>
				<table width="100%" align="center" cellspacing="0" cellpadding="0" style="margin-top:10px;">
				<thead style="background-color:#eee;">
    			<tr>
    				<th width="50" style="padding:5px;">Date Recorded</th>
        			<th width="50" style="padding:5px;">Recorded By</th>
        			<!--<th width="50" style="padding:5px;">Activity</th>-->
        			<th width="50" style="padding:5px;"><?=$tname;?></th>
        			<th width="100" style="padding:5px;">Description</th>
    			</tr>
    			</thead>
    			<tbody>
				<?php
    			foreach($f['transactions'] as $t){
					if($t['redeemed']=='N') $activity = 'Earned'; else $activity = '';
					if($t['redeemed']=='Y') $activity = 'Spent';
				?>
				<tr>
        			<td style="padding:5px;border-bottom:1px solid #ccc;"><?php echo $t['date']; ?></td>
        			<td style="padding:5px;border-bottom:1px solid #ccc;" align="center"><?php echo $t['user_name']; ?></td>
        			<?php /*?><td style="padding:5px;border-bottom:1px solid #ccc;" align="center"><?php echo $activity; ?></td><?php */?>
        			<td style="padding:5px;border-bottom:1px solid #ccc;" align="center"><?php echo $t['amount']; ?></td>
            		<td style="padding:5px;border-bottom:1px solid #ccc;"><?php if(!empty($t['authorization'])) echo $t['authorization']; ?></td>
        		</tr>
    			<?php } ?>
    			</tbody>
    			</table>
				<?php } ?>
				</td>
			</tr>
			<?php }} ?>
			</table>
		</div>
    	<?php
    	$result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
    
    public function ss_le_form($atts) {
		$obj = new ss_LoyaltyEasy();
		$is_require_password = esc_attr($obj->ss_le_get_setting('require_password'));
    	ob_start();
    	?>
        <div id="ss_le_balance">
         <div class="ss_le_block">
        	<label id="ss_le_user">Card #:</label>
        	<input type="text" name="card_number" id="ss_le_username" />
         </div>
         <?php if($is_require_password=='1'): ?>
         <div class="ss_le_block">
        	<label id="ss_le_pass">Password:</label>
        	<input type="password" name="password" id="ss_le_password" />
         </div>
         <?php endif; ?>
         <div class="clearfix"></div>
         <button type="button" id="ss_le_lookup" class="ss_le_button">Check Balance</button>
        </div>
        <div class="clearfix"></div>
        <div id="balance_report">
        	<a href="#" id="ss_le_close"><img src="<?=plugins_url('images/close_button.png', __FILE__);?>" alt="close" /></a>
        	<div id="balance_results"></div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
	}
	
	public function ss_le_fb_logout(){
    	$app_id = esc_attr($this->ss_le_get_setting('app_id'));
    	$app_secret = esc_attr($this->ss_le_get_setting('app_secret'));
    	$facebook = new Facebook(array(
        	'appId' 	=> $app_id,
        	'secret'	=> $app_secret,
    	));
     	$facebook->destroySession();
     	$fb_redirect = get_permalink($o->ss_le_get_setting('fb_redirect'));
    	wp_redirect( $fb_redirect );
	}
	
	public function ss_le_register_form($atts, $content = null){
        $o = new ss_LoyaltyEasy();
        $error_msg = '';
		$app_id = esc_attr($o->ss_le_get_setting('app_id'));
		$app_secret = esc_attr($o->ss_le_get_setting('app_secret'));
		$url = esc_attr($o->ss_le_get_setting('success_url'));
		if(!empty($app_id) && !empty($app_secret)){
			$fb_redirect = get_permalink(esc_attr($o->ss_le_get_setting('fb_redirect')));
			$facebook = new Facebook(array(
            	'appId'		=> $app_id,
            	'secret'    => $app_secret,
            ));
            $user = $facebook->getUser();
            if($user){
            	try{
                	$user_profile = $facebook->api('/me');
                	$b = explode("/",$user_profile['birthday']);
                	$bday = $b[0]; $bmonth = $b[1]; $byear = $b[2];
              	}catch(FacebookApiException $e){
                	error_log($e);
                	$user = NULL;
              	}
         	}
           	$loginUrl = $facebook->getLoginUrl(array('display'=>'popup','scope'=>'email,user_about_me,user_birthday','redirect_uri'=>$fb_redirect));
  		}
      	if( !empty($_POST['action']) ) {
			echo $url;

        	$result = $o->sendRegistration($_POST);
            if($result['@attributes']['status']!="error"){
            	//if(!empty($url)) wp_redirect(get_permalink($url));
				if(!empty($url)){ echo '<script>window.location = "'.get_permalink($url).'";</script>'; exit;}
				
                $error_msg = '<div class="success">Congratulations you have successfully registered your rewards card. You card is now active and you can start building points.</div>';
              	
			} else {
				$error_msg = '<div class="invalid">ERROR: '.$result['error'].'</div>';
            }
		}
		@ob_start();
		if($error_msg) echo $error_msg;
		if(!empty($loginUrl)) echo '<a href="'.$loginUrl.'" data-role="button" rel="external"><img src="'.plugin_dir_url(__FILE__).'images/f-connect.png" alt="Connect with Facebook" style="border:0;" /></a>';
		if(!empty($logoutUrl)) echo 'You are logged in with Facebook <a href="'.$logoutUrl.'" data-role="button" rel="external">click here</a> to logout';
		?>
		<form name="ss_le_register" id="ss_le_register" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
        <fieldset data-role="fieldcontain">
     		<!--<div class="clear"><br /></div>-->
            <input type="hidden" name="action" value="register" />
      		<?php if(esc_attr($o->ss_le_get_setting('show_campaigns'))=='1'): ?>
         		<label for="campaign_id"><?php echo esc_attr($o->ss_le_get_setting('default_campaign_name'));?></label>
           		<select name="campaign_id" id="campaigns" style="width:200px;">
          		<?php
                	$campaigns = $o->_campaigns;
                 	if($campaigns['status']!='error'):     
                   		foreach($campaigns['campaign'] as $campaign) {
                        	echo '<option value="'.$campaign['id'].'">'.$campaign['name'].'</option>';
                      	}
                   	endif;
          		?>
          		</select>
          		<div class="clear"></div>
          	<?php else: ?>
                <input type="hidden" name="campaign_id" value="<?php echo esc_attr($o->ss_le_get_setting('default_campaign'));?>" />
            <?php endif; ?>
            <?php if(esc_attr($o->ss_le_get_setting('free_enroll'))!='1'): ?>
          	<label for="card_number" class="ui-hidden-accessible">Card Number</label>
          	<input type="text" name="card_number" id="card_number" maxlength="10" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Card Number" />
            <?php endif;?>
           	<?php if(esc_attr($o->ss_le_get_setting('show_password'))=='1'): ?>
                <div class="clear"></div>
                <label for="customer_password" class="ui-hidden-accessible">Password</label>
                <input type="password" name="customer_password" id="customer_password" maxlength="20" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
                <div class="clear"></div>
                <label for="customer_password2" class="ui-hidden-accessible">Password Verify</label>
                <input type="password" name="customer_password2" id="customer_password2" maxlength="20" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
         	<?php endif; ?>
        	<div class="clear"></div>
        	<label for="firstName" class="ui-hidden-accessible">First Name</label><input type="text" name="firstName" id="firstName" maxlength="60" value="<?php if(!empty($user_profile['first_name'])) echo $user_profile['first_name']; ?>" placeholder="First Name" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
            <div class="clear"></div>
            <label for="lastName" class="ui-hidden-accessible">Last Name</label><input type="text" name="lastName" id="lastName" maxlength="60" value="<?php if(!empty($user_profile['last_name'])) echo $user_profile['last_name']; ?>" placeholder="Last Name" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
            <div class="clear"></div>
            <label for="email" class="ui-hidden-accessible">Email Address</label><input type="text" name="email" id="email" maxlength="60" value="<?php if(!empty($user_profile['email'])) echo $user_profile['email']; ?>" placeholder="Email Address" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
            <div class="clear"></div>
            <label for="email2" class="ui-hidden-accessible">Email Verify</label><input type="text" name="email2" id="email2" maxlength="60" value="<?php if(!empty($user_profile['email'])) echo $user_profile['email']; ?>" placeholder="Email Address" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
            <div class="clear"></div>
            <?php if($o->ss_le_get_setting('show_phone')=='1'): ?>
                <label for="phone" class="ui-hidden-accessible">Phone #</label><input type="text" name="phone" maxlength="15" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Phone #" />
                <div class="clear"></div>
            <?php endif; ?>
            <?php if($o->ss_le_get_setting('show_address')=='1'): ?>
                <label for="address1" class="ui-hidden-accessible">Address</label><input type="text" name="address1" id="address1" maxlength="60" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Address" />
                <div class="clear"></div>
                <label for="address2" class="ui-hidden-accessible">Address2</label><input type="text" name="address2" id="address2" maxlength="60" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Address2" />
                <div class="clear"></div>
                <label class="ui-hidden-accessible">City</label><input type="text" name="city" id="city" maxlength="60" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="City" />
                <div class="clear"></div>
                <label for="state" class="ui-hidden-accessible">State</label>
                <?php if($o->ss_le_get_setting('show_country')=='1'): ?>
                <input type="text" name="state" id="state" maxlength="60" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="State/Province" />
            	<?php else: ?>
                <select id="state" name="state" size="1">
                	<option value="" selected>Select a State</option>
                    <?php
                    	$states = $o->_states;
                    	foreach($states as $abv => $state){
                        	echo '<option value="'.$abv.'">'.$state.'</option>';
                    	}
                 	?>
            	</select>
            	<?php endif; ?>
          		<div class="clear"></div>
             	<label class="ui-hidden-accessible">Zipcode</label><input type="text" name="zip" id="zip" maxlength="6" value="" placeholder="Zipcode" />
              	<div class="clear"></div>
       		<?php endif; ?>
        	<?php if(esc_attr($o->ss_le_get_setting('show_country'))=='1'): ?>
           		<label class="ui-hidden-accessible">Country</label>
              	<select id="country" name="country" style="width:200px;">
                	<option value="">Select Country</option>
                  	<?php
                  		$countries = $o->_countries;
                    	foreach($countries as $abv => $country){
                        	echo '<option value="'.$abv.'">'.$country.'</option>';
                    	}
                  	?>
             	</select>
               	<div class="clear"></div>
           	<?php endif; ?>
          	<?php if(esc_attr($o->ss_le_get_setting('show_birthday'))=='1'): ?>
             	<label class="ui-hidden-accessible">Birthday</label>
             	<!--<div class="ui-select-inline" data-inline="true">-->
           		<select name="birthMonth"><option value="">--</option>
              		<?php
              			$months = (array) $o->_months;
                    	for($i=0;$i<=11;$i++) {
                           	if($i==$bmonth) $s = ' selected'; else $s = '';
                           	$mval = $i+1;
                           	if(strlen($mval)<2) $mval = '0'.$mval;
                          	echo '<option value="'.$mval.'"'.$s.'>'.$months[$i].'</option>';
                       	}
                    ?>
               	</select><select name="birthDay"><option value="">--</option>
                	<?php
                    	for($i=1;$i<=31;$i++) {
                        	if(strlen($i)<2) $i = '0'.$i;
                        	if($i==$bday) $s = ' selected'; else $s = '';
                         	echo '<option value="'.$i.'"'.$s.'>'.$i.'</option>';
                      	}
                 	?>
            	</select><select name="birthYear"><option value="">----</option>
				<?php
					for($i=date('Y')-100;$i<=date('Y');$i++) {
 						if($i==$byear) $s = ' selected'; else $s = '';
						echo '<option value="'.$i.'"'.$s.'>'.$i.'</option>';
					}
				?>
				</select>
				<!--</div>-->
			<?php endif; ?>
			<div class="clear"><br /></div>
		<button type="submit" id="ss_le_register" class="ss_le_button">Register</button>
		<div class="clear"></div>
		</fieldset>
		</form>
	<?php
		$content .= @ob_get_contents();
		@ob_end_clean();
     
		return $content;
    }
	
	/* STICKYSTREET Functions */
	private function sendData($postvars){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, esc_attr($this->ss_le_get_setting('api_url')) );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$result = curl_exec($ch);
		curl_close ($ch);
		$c = json_decode(json_encode((array) simplexml_load_string($result)),1);       
		return $c;
	}
		
	private function _validateCustomer($cardnum,$password){
		$valid = array();
		$valid['user_id']      			= $this->ss_le_get_setting('user_id');
		$valid['user_password'] 		= $this->ss_le_get_setting('password');
		$valid['account_id']    		= $this->ss_le_get_setting('account_id');
		$valid['type']          		= 'validate_customer_password';
		$valid['card_number']   		= $cardnum;
		$valid['customer_password']     = $password;
		return $this->sendData($valid);
    }
    
    public function sendRegistration($request){    
    	$new_customer = array();
    	$new_customer['user_id']					= $this->ss_le_get_setting('user_id');
    	$new_customer['user_password']				= $this->ss_le_get_setting('password');
   		$new_customer['type']           			= 'record_customer';
      	$new_customer['customer_action']        	= 'new';
        $new_customer['account_id']              	= $this->ss_le_get_setting('account_id');
      	if(!$this->ss_le_get_setting('default_campaign')){
        	$new_customer['campaign_id']            = $request['campaign_id'];
       	} else {
         	$new_customer['campaign_id']            = $this->ss_le_get_setting('default_campaign');
      	}
      	$new_customer['first_name']               	= $request['firstName'];
      	$new_customer['last_name']               	= $request['lastName'];
       	$new_customer['email']                 		= $request['email'];
		if($this->ss_le_get_setting('free_enroll')!='1'){
			$new_customer['card_number']            	= $request['card_number'];
			$new_customer['code']                     	= $request['card_number'];
		}
      	$new_customer['customer_password']       	= $request['customer_password'];
      	//$new_customer['auto_add']               	= '';
     	if($this->ss_le_get_setting('show_phone')=='1'){
     		$new_customer['phone'] 					= $request['phone'];
     	}
       	if($this->ss_le_get_setting('show_address')=='1'){
      		$new_customer['street1']              	= $request['address1'];
       		$new_customer['street2']             	= $request['address2'];
       		$new_customer['city']                  	= $request['city'];
      		$new_customer['state']                  = $request['state'];
      		$new_customer['postal_code']            = $request['zip'];
      	}
      	if($this->ss_le_get_setting('show_country')=='1'){
      		$new_customer['country'] 				= $request['country'];
      	}
        if($this->ss_le_get_setting('show_birthday')=='1'){
        	$new_customer['custom_date'] 			= $request['birthyear'].'-'.$request['birthmonth'].'-'.$request['birthday'];
        }
     	$response = $this->sendData($new_customer);
		
		/*echo '<pre>';
		print_r($new_customer);
		echo '</pre>';
		echo '<pre>';
		print_r($response);
		echo '</pre>';
		exit;*/

		if($response['@attributes']['status']=='success'){
			if($new_customer['campaign_id']!='' and $this->ss_le_get_setting('auto_add_points')!=false){
				$data['user_id'] 		= $this->ss_le_get_setting('user_id');
				$data['user_password'] 	= $this->ss_le_get_setting('password');
				$data['type'] 			= 'campaigns_list';
				$data['account_id'] 	= $this->ss_le_get_setting('account_id');
				$result = $this->sendData($data);
				if($result['@attributes']['status']=='success'){
					$camps_info = array();
					if(isset($result['campaigns']['campaign'][0])){
						foreach($result['campaigns']['campaign'] as $single_camp){
							$key = $single_camp['id'];
							$camps_info[$key] = $single_camp;
						}
					} else {
						$single_camp = $result['campaigns']['campaign'];
						$key = $single_camp['id'];
						$camps_info[$key] = $single_camp;
					}
					
					$camps = explode(',', $new_customer['campaign_id']);
					foreach($camps as $campaign_id){
						if(isset($camps_info[$campaign_id])){
							if($camps_info[$campaign_id]['type'] == 'points' or $camps_info[$campaign_id]['type'] == 'giftcard'){
								$record_activity['user_id'] 		= $this->ss_le_get_setting('user_id');
								$record_activity['user_password']	= $this->ss_le_get_setting('password');
								$record_activity['type']           	= 'record_activity';
								$record_activity['account_id']      = $this->ss_le_get_setting('account_id');
								$record_activity['code']         	= $response['customer']['code'];
								$record_activity['campaign_id']		= $campaign_id;
								$record_activity['amount']			= $this->ss_le_get_setting('auto_add_points');
								$this->sendData($record_activity);
							}
						}
					}
				}
			}
		}
		return $response;
	}
	
	private function _getCampaigns(){
    	$campaigns = array();
    	$campaigns['API']           	= '1.5';
    	$campaigns['user_id']       	= $this->ss_le_get_setting('user_id');
     	$campaigns['user_api_key']  	= $this->ss_le_get_setting('password');
   		$campaigns['account_id']   	 	= $this->ss_le_get_setting('account_id');
     	$campaigns['type']          	= 'campaigns_list';
    	$campaigns['sortField']         = 'campaign_name';
     	$campaigns['sortOrder']         = 'ASC';
     	$result = $this->sendData($campaigns);
    	$this->_campaigns = wp_parse_args($this->_campaigns, $result);
 	}
    /* END STICKYSTREET Functions */
 
 } // End SS Balance Lookup Class
} // End check if class exists
$ss_LoyaltyEasy = ss_LoyaltyEasy::getInstance();
?>
