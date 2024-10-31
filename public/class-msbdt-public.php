<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://scheduler.bdtask.com/
 * @since      1.0.0
 *
 * @package    Msbdt
 * @subpackage Msbdt/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Msbdt
 * @subpackage Msbdt/public
 * @author     bdtask <bdtask@gmail.com>
 */
class Msbdt_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;


        add_action('init',array($this,'msbdt_public_dependence_file'));
       
        add_action('init',array($this,'msbdt_shortcode_register'));
        add_action('init',array($this,'msbdt_select_disable_date_agnist_doctor_ajax'));

        add_action( 'wp_ajax_disableDate_ajaxProsessData',
	  	            array($this,'msbdt_select_disable_date_agnist_professional'));
	      add_action( 'wp_ajax_selectTimeSlote_ajaxProsessData',
	  	            array($this,'msbdt_select_time_slote_date_agnist_professional'));
        add_action( 'wp_ajax_nopriv_disableDate_ajaxProsessData',
    	            array($this,'msbdt_select_disable_date_agnist_professional'));
        add_action( 'wp_ajax_nopriv_selectTimeSlote_ajaxProsessData',
      	            array($this,'msbdt_select_time_slote_date_agnist_professional'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Msbdt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Msbdt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_style( 'msbdt-bootstrap-style',
                           plugin_dir_url( __FILE__ ).'css/msbdt-bootstrap.css', 
                           array(), $this->version, 'all' );

        wp_enqueue_style( 'msbdt-ui-style',
                           plugin_dir_url( __FILE__ ) .'css/msbdt-ui.css', 
                           array(), $this->version, 'all' );

        wp_enqueue_style('msbdt-fontawesome', 
                           plugin_dir_url( __FILE__ ) .'font-awesome/css/font-awesome.min.css', 
                           array(), $this->version, 'all' );

        wp_enqueue_style('msbdt-custom', 
                           plugin_dir_url( __FILE__ ).'css/msbdt-custom-style.css', 
                           array(), $this->version, 'all' );


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/msbdt-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Msbdt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Msbdt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


        wp_enqueue_script(  'msbdt-bootstrap-jquery', 
                          plugin_dir_url( __FILE__ ) . 'js/msbdt-bootstrap.min.js',
                          array( 'jquery' ), $this->version,false );

	      wp_enqueue_script( 'msbdt-ui-jquery', 
                            plugin_dir_url( __FILE__ ) . 'js/msbdt-jquery-ui.js',
                            array( 'jquery' ), $this->version, false );

        wp_enqueue_script( 'msbdt-ui-jquery', 
                            plugin_dir_url( __FILE__ ) .'js/msbdt-jquery-1.12.4.js',
                            array( 'jquery' ), $this->version, false );
      
        wp_enqueue_script( 'msbdt-slimscroll-jquery', 
                            plugin_dir_url( __FILE__ ) .'js/msbdt-jquery.slimscroll.min.js',
                            array( 'jquery' ), $this->version, false );
      
		    wp_enqueue_script( $this->plugin_name, 
                             plugin_dir_url( __FILE__ ) . 'js/msbdt-public.js', 
                             array( 'jquery' ), $this->version, false );

	}

   public function msbdt_public_dependence_file(){

        require_once plugin_dir_path( __FILE__ ) . '/../admin/query/msbdt-location-query.php';
        require_once plugin_dir_path( __FILE__ ) . '/../admin/query/msbdt-professional-query.php';
        require_once plugin_dir_path( __FILE__ ) . 'query/msbdt-booking-query-for-public.php';
        require_once plugin_dir_path( __FILE__ ) . 'asset/msbdt-custom-style-for-public.php';
   }

   public function msbdt_select_disable_date_agnist_doctor_ajax(){

         wp_enqueue_script( 'mas_select_disable_date_agnist_doctor_ajax', 
			                  plugin_dir_url( __FILE__ ).'ajax/multi-appointment-select-disable-date-agnist-doctor-ajax.js', 
			                  array( 'jquery' ), $this->version, false ); 

         wp_localize_script( 'mas_select_disable_date_agnist_doctor_ajax', 
                        'object',
                         array(  'ajaxurl'  => admin_url( 'admin-ajax.php' ),
                                 'nonce'    => wp_create_nonce('randomnonce'),
                                 'someData' => 'extra data you want  available to JS'
                             )
                    );

    }

    public function msbdt_select_disable_date_agnist_professional($id=''){
         
         global $wpdb;
         $table_name = $wpdb->prefix.'msbdt_time_slote'; 

    	   $work_date  ='';
    	   $start_time ='';
    	   $end_time   ='';
    	   $interval   ='';
    	   $total_time_per_day = '';
    	   $enableDateArray = array();
    	   $id = intval($_POST['data'] );     
           $query  = "SELECT * FROM  $table_name  WHERE `pro_id` = $id ";
           $results = $wpdb->get_results($query, OBJECT );
           $i = 0;
           foreach ($results as $result ): 
           	 if(date('yy-mm-dd') <= date('yy-mm-dd',strtotime($result->work_date))) :                  
                 $enableDateArray[$i] = $result->work_date ;
                 $i++;

             endif;         
           endforeach ;
          return wp_send_json($enableDateArray)  ;  	
    	 wp_die();    

    }

    public function msbdt_select_time_slote_date_agnist_professional(){
    
    /*======================================   
  	      html status color showing 	
     ========================================*/

        ?>
        <script>
            jQuery(function () {            
                jQuery('.button_inner').slimScroll({
                    height:'100px',
                    size: '3px',
                    color: '#5bbc2e'
                });
            });
        </script>

        <div class = "public_status_button">

         <button class  =  "button btn" style = "background-color:<?php echo get_option('avoilable_color'); ?> ">
         <?php esc_html_e('Available','multi-scheduler');?></button>
       
         <button class  =  "button btn" style  =  "background-color:<?php echo get_option('request_color'); ?> ">
          <?php esc_html_e('Requested','multi-scheduler');?></button>
         
         <button class  =  "button btn" style = "background-color:<?php echo get_option('approve_color'); ?> ">
           <?php esc_html_e('Booked','multi-scheduler');?></button>
        
         
        </div>


        <?php
    	/*==================================*/
    	 
    	   global $wpdb; 
         $table_time_slote  = $wpdb->prefix .'msbdt_time_slote';
         $table_mps_booking = $wpdb->prefix .'msbdt_booking';

    	   $work_date  ='';
    	   $start_time ='';
    	   $end_time   ='';
    	   $interval   ='';
    	   $date       ='';
    	   $pro_id     ='';      
    	   $date       = sanitize_text_field( $_POST['date'] );;
    	   $pro_id     = intval( $_POST['pro_id'] ); 
    	  	          
           $query = $wpdb->prepare( "SELECT * FROM $table_time_slote
                                     WHERE `pro_id`   = %d 
                                     AND  `work_date` = %s", $pro_id, $date );
      
           $time_slote = $wpdb->get_row($query);

           $booking_start_time = $time_slote->work_date .'  '. $time_slote->start_time;
           $booking_end_time   = $time_slote->work_date .'  '.$time_slote->end_time; 			
           // The slot frequency per hour, expressed in minutes.
           $booking_frequency  = $time_slote->int_val;
           // Calculate how many slots there are per day
	       $slots_per_day = 0;	
        ?>
        <div class="button_inner">
        <?php
	       for($i = strtotime($booking_start_time); $i<= strtotime($booking_end_time); $i = $i + $booking_frequency * 60):
		     
                 $startTime = date('h:i a', $i );
                 $endTime   = date('h:i a', $i + $booking_frequency * 60 );

                /*==============  cheack status============== */
                 $startTime_dbf = date('H:i:s', $i );  
                 $date          = date('Y-m-d', $i) ;
               
                 $sql_check_status   = " SELECT * 
                                         FROM  $table_mps_booking
                                         WHERE  `start_time` = '".$startTime_dbf."' " ; 
              
                 $check_status = $wpdb->get_row( $wpdb->prepare(($sql_check_status))); 
                 if(($check_status ->status == '4') && ($check_status ->date == $date)):
                    $request_color  = (get_option('request_color'))? 
                                       get_option('request_color') : 
                                       '#9b5800';
                   
                    $this->msbdt_onclick_inputbutton($startTime,$endTime,$time_slote->work_date, $request_color ) ;

                 elseif(($check_status ->status == '5') && ($check_status ->date == $date)):
                    $booked_color   = (get_option('approve_color'))? 
                                       get_option('approve_color') : 
                                       '#ff0000';
                    $this->msbdt_onclick_inputbutton($startTime,$endTime,$time_slote->work_date,$booked_color) ; 
                 else:
                 	$avoilable_color = (get_option('avoilable_color'))? 
                                        get_option('avoilable_color') : 
                                        '#ff0000';
                 	$this->msbdt_onclick_inputbutton($startTime,$endTime,$time_slote->work_date,$avoilable_color) ;
                 endif;

		     $slots_per_day ++;
	       endfor;
         ?>
        </div>
      <?php
	   wp_die();    	 

    }

    public function msbdt_onclick_inputbutton($startTime,$endTime,$work_date,$status_color){
  	echo $status ;
    ?>
    <span class="schedule">
   
     <a href="#" class  =  "btn thme-btn"
                 style  =  "background-color:<?php echo $status_color ; ?> ;" 
                  id    =  "<?php echo 'bts'.strtotime($startTime) ; ?>"
                onclick =  "clickTimeSloteButton( '<?php echo esc_js($startTime) ; ?>' ,
                                                  '<?php echo esc_js($endTime) ; ?>'  , 
                                                  '<?php echo esc_js($work_date) ; ?>' ,
                                                  '<?php echo esc_js("bts".strtotime($startTime)) ; ?>' ) ">
     <i class="glyphicon glyphicon-time"></i>
     <?php echo sprintf(__( '%s', 'appointment' ), $startTime ); ?></a>                     
    </span>
   <?php
   }

 
	  public function msbdt_shortcode_register(){
          
          add_shortcode('mas_bdtask',array($this,'msbdt_shortcode_cb'));
    }
    
    public function msbdt_shortcode_cb($atts , $content = null){ ?>

    <?php 
    global $pagenow , $wpdb ; 

    $errors = '';
    $msbdt_scheduler_custom_css = Msbdt_Custom_Style_Public::msbdt_scheduler_custom();
    $errors = Msbdt_Booking_Public::msbdt_public_appointment_process(); 
	  ob_start();

    ?>

     <script type="text/javascript">	

	  var count  =  0  ;
    var pre_id =  '' ;

	  function clickTimeSloteButton(start_time = null , end_time = null , date = null, btn = null ){
          
	     if(start_time != null && 
	        end_time   != null && 
	        date       != null && 
	        btn        != null ){
	        var schedule_start_time = start_time;
	        var schedule_end_time   = end_time ;
	        var schedule_date       = date ;
	       

            if(count == 0){
            	  document.getElementById('schedule_date').value       = '' ;
                document.getElementById('schedule_start_time').value = '' ;
                document.getElementById('schedule_end_time').value   = '' ;  
                
                document.getElementById(btn).style.backgroundColor =
                 '<?php echo get_option( 'request_color' ) ; ?>';
                document.getElementById('schedule_date').value       = schedule_date ;
                document.getElementById('schedule_start_time').value = schedule_start_time ;
                document.getElementById('schedule_end_time').value   = schedule_end_time ;                 
                count = 1 ;
              
            }else if(count == 1){
                document.getElementById('schedule_date').value       = '' ;
                document.getElementById('schedule_start_time').value = '' ;
                document.getElementById('schedule_end_time').value   = '' ;     
                document.getElementById(btn).style.backgroundColor = 
                '<?php echo get_option( 'avoilable_color' ) ; ?>';;

                count = 0 ;
            }                       
             
          }	 
            
        }

	   </script>

    <div class="multi-appointment ">
    <div class="multi-appointment row public_include_border">
      <div class="col-md-10 col-md-offset-2">
        <div class="booking_area">

             <!---    Message Section --> 
             <div class = "row">
                 <div class = "col-sm-7">
                    <?php if($errors == 'no_error_data_save_successfully'): ?>
                      <div class="alert alert-success alert-dismissible fade in" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                       <strong> <?php _e('Appointment Request has been taken') ?> </strong>
                     </div>       
                  <?php elseif($errors == 'something_is_error') : ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                        <strong><?php _e('Error !! Please try again') ?></strong> 
                     </div>              
                <?php endif ; ?>               
              </div><!-- end .col-sm-7 --> 
             </div><!-- end .row -->  
          <!---   / Message Section --> 


            <form method="post" action=""> 
               <div class="form-area"> 
                  <div class="row theme-margin">
                    <div class="col-sm-4 theme-padding">
                          <div class="form-group">      
    	                       <label for="name">
                              <?php echo esc_html( get_option('frontend_name') ); ?></label>
    	                        <span class="public_error_message_color">
    	                       <?php if(isset($errors['name'])){echo $errors['name'];}?>
    	                       </span>                       
            	              <input name = "schedule_name" 
            		                 type = "text"
            		                 id   = ""
            		                 placeholder=" Your Name " 
            		                 class= "form-control">	                            
                         
                       </div>
                    </div>
                    <div class="col-sm-4 theme-padding">
                         <div class = "form-group">
                                <label for   = "email">
                                <?php echo esc_html( get_option('frontend_email') );  ?></label>
                                <span class="public_error_message_color" >
                                <?php if(isset($errors['email'])){echo $errors['email'];}?>
                                </span>
                                                                                      
                                <input  name   =  "schedule_email" 
              	                    type   =  "email"
              	                    id     =  ""
              	                    placeholder ="Your Email Address" 
              	                    class  =  "form-control">	                                                   
                               
                          </div>
                      </div>
                      <div class="col-sm-4 theme-padding">
                          <div class = "form-group">
                              <label for="phone">
                              <?php echo esc_html( get_option('frontend_contact') ) ; ?></label>
                              <span class="public_error_message_color" >
                              <?php if(isset($errors['phone'])){echo $errors['phone'];}?>
                              </span>
                            
                                <input name  = "schedule_phone" 
              		                      type = "" 
              		                        id = ""
                                 placeholder ="Your Phone Number "          
              		                  class    = "form-control">	                         
                          
                          </div>
                      </div>
                      <div class="col-sm-4 theme-padding">                    
                          <div class = "form-group">
                              <label for="loc_id">
                              <?php echo esc_html( get_option('frontend_location')  ) ; ?></label>                                                
                              <div class="select-filters">
                              <select   name = "schedule_loc_id" type = "text" class = "form-control">
                                     <?php if(method_exists('Msbdt_Location','msbdt_select_added_all_location')):
                                             $locations = array();
                                             $query = Msbdt_Location::msbdt_select_added_all_location();
                                             $locations  = $wpdb->get_results($query , OBJECT ) ; 
                                             foreach ($locations as $location) : ?>                                 
                                                <option 
                                                        value="<?php echo $location->loc_id ; ?>">
                                                        <?php echo ucwords($location->address) ; ?>                                             
                                                </option>

                                            <?php endforeach ; ?>
                                      <?php endif ; ?>                      
                                </select>                  
                                                   
                               </div>                        
                            </div>
                        </div>
                        <div class="col-sm-4 theme-padding">
                            <div class = "form-group">
                               <label for="pro_id">
                               <?php echo esc_html( get_option('frontend_professional') );?></label> 
                               <div class="select-filters">       
                               <select    name = "schedule_pro_id"; 
                                          type = "text"                   
                                          id   = "mas_public_professional_id"                   
                                          class= "form-control">
                                  <?php if(method_exists('Msbdt_Professional','msbdt_select_added_all_professional')):

                                          $professionals = array();
                                          $query = Msbdt_Professional::msbdt_select_added_all_professional();
                                          $professionals = $wpdb->get_results($query , OBJECT ) ;
                                          foreach ($professionals as $professional) : ?>                                           
                                             <?php  $professional_fullName = $professional->fname.' '.
                                                                             $professional->lname ?>

                                            <option 
                                                    value="<?php echo $professional->pro_id ; ?>">
                                                    <?php echo ucwords($professional_fullName) ; ?>
                                                  
                                            </option>

                                          <?php endforeach ; ?>
                                <?php endif ; ?>        
                                  </select> 
                                                                  
                             </div> 
                             </div> 
                         </div> 
                         <input type = "hidden" 
                                name = "schedule_date" 
                                id   = "schedule_date">

                         <input type = "hidden"  
                                name = "schedule_start_time" 
                                id   = "schedule_start_time">
                        
                         <input type = "hidden"  
                                name = "schedule_end_time" 
                                id   = "schedule_end_time">                      
                   
                    <div class="col-sm-12 theme-padding">
                         <div class="calender_area">           
                             <div class="row theme-margin">
                                <div class="theme-padding">
                                       <p id="date">
                                       <span type="text" id="datepicker"></span>
                                       </p>
                                      
                                </div>
                             </div>
                          </div>
                    </div>
                                     
                    <div class="col-sm-12 theme-padding">
                          <div class="calender_area">   
                              <div class="row theme-margin">
                                <div class="theme-padding">
                                    <div class="theme-padding">
                                      <p id="showTimeSlote"></p>
                                    </div> 
                                </div> 
                              </div> 
                           </div> 
                    </div> <!-- /. calender_area -->

                        <div class="col-sm-12 theme-padding">        
                                <div class = "form-group">
                                     <label for="int_val">
                                     <?php echo esc_html( get_option('frontend_message') ); ?></label>
                                     <span class="public_error_message_color">
                                     <?php if(isset($errors['message'])){echo $errors['message'];}?>
                                     </span> 
                                     <textarea name  = "schedule_message"
                                               class = "form-control"
                                               type  = "text"  
                                               id    = "altField"
                                               rows  = "5" 
                                         placeholder = "Please Write Your Message"       
                                               ></textarea>
                                                                                      
                                </div>
                          </div>
                         <div class="col-sm-12 theme-padding">           
                               <div class="public_submit_button">
              	                   <input type="submit"
              	                    style = "background-color:<?php echo esc_attr(get_option('submit_button_color') ) ;?>" 
              	                    name="add_schedule_submit" 
              	                    class="button button-primary" 
              	                    value="<?php echo esc_attr( get_option('frontend_button') ); ?>"> 
                              </div>              
                        </div>              
                     </div> <!-- .row theme-margin -->     
                  </div> <!-- .form-area -->     
                </form>
              </div><!-- .booking_area -->
            </div><!-- .col-md-8 col-md-offset-2 -->
          </div><!-- . row -->
     </div><!-- .multi-appointment row  -->
    <?php
    $output = ob_get_clean();
    return $output;
    } 
}