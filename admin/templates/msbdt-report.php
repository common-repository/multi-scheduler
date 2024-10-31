<?php

/**
 * @package    admin
 * @subpackage admin/templates
 * @author     bdtask<uzzal131@gmail.com> <bdtask@gmail.com>
 */

/**=============================
   status
   1 = active
   2 = inactive
   3 = delete
   4 = request => #dda108
   5 = approve => 
   6 = reject

===================================*/
   
function msbdt_appointment_callback_form(){

 global $pagenow, $wpdb;

 $records_per_page =  get_option( 'admin_pagination' );
 define('MSBDT_TABLE_BOOKING', $wpdb->prefix.'msbdt_booking' ); 

/*======================= Serial No Define ======*/
   $page_no = ( isset( $_GET['s'] ) )? sanitize_text_field( $_GET['s'] ) : null ;
   if( $page_no == 1 ) :
   $serial_no = 1 ;
   elseif( $page_no  > 1 ) :    
   $serial_no = ( ( $page_no - 1 ) * get_option( 'admin_pagination' ) )+1;
   else :
   $serial_no = 1;
   endif ;
 /*======================= / Serial No Define ======*/
 

if(($_REQUEST['page']==='msbdt_report')&& ($pagenow == 'admin.php')):
   $scheduler_admin_custom_css = Msbdt_Custom_Admin_Style::msbdt_scheduler_admin_custom_css();
   $args = array();
   $results = array();
   $args['status'] = '5'; // status = 5 for Approve
   
   $search_submit = isset( $_POST['search_submit'] ) ?
                             sanitize_text_field( $_POST['search_submit'] ) :'';   
  
  if( isset($search_submit) && $search_submit !== '' ):

         $args['location'] = intval( $_POST['search_location']  );  
         $args['professional'] = intval( $_POST['search_professional']  );  
         $args['date']   = sanitize_text_field( $_POST['search_date']  );

         $query      = Msbdt_Booking::msbdt_mas_booking($args);
         $new_query  = Msbdt_Pagenation::msbdt_paging( $query , $records_per_page ) ;
         $results    = $wpdb->get_results($new_query, OBJECT );  
    else:
         $query      = Msbdt_Booking::msbdt_mas_booking($args);
         $new_query  = Msbdt_Pagenation::msbdt_paging( $query , $records_per_page ) ;
         $results    = $wpdb->get_results($new_query, OBJECT );  

    endif; ?>   


<h3><?php echo get_admin_page_title() ; ?></h3>
 <div class = "multi-appointment  " >
   <div class = "container row"  >
        <div class="scheduler_admin">                
          <div class = "col-sm-12">      
          <!-- header search form -->
           <form action="" method="post">
               <div class="row"  >
                 <div class = "col-sm-4">
                   <div class="input-group">
                      <span class = "input-group-addon">
                       <?php  echo get_option('frontend_location') ; ?>
                      </span>

                      <?php 
                      if(method_exists('Msbdt_Location','msbdt_select_added_all_location')) : 
                           $locations = array();
                           $sql       = Msbdt_Location::msbdt_select_added_all_location();
                           $locations = $wpdb->get_results($sql , OBJECT ) ; 
                      endif ; ?> 
                      <select name="search_location"
                           type="text"                   
                           value="" 
                           class="form-control">
                           <option></option>
                           <?php foreach ($locations as $location):?>
                           <option 
                            value="<?php echo $location->loc_id ; ?>">
                            <?php echo ucwords($location->address) ; ?>                                             
                          </option>

                          <?php endforeach ; ?>
                                                
                      </select>                  
                    </div> <!-- / . input-group -->
                 </div><!-- / .col-sm -->
                 <div class = "col-sm-3">
                    <div class="input-group">
                        <span class = "input-group-addon">
                        <?php  echo get_option('frontend_professional') ; ?>
                        </span>
                        <?php 
                         if(method_exists('Msbdt_Professional','msbdt_select_added_all_professional')) :
                            $professionals  = array();
                            $sql            = Msbdt_Professional::msbdt_select_added_all_professional();
                            $professionals  = $wpdb->get_results($sql , OBJECT ) ; 
                         endif ; ?> 
                         <select name="search_professional"
	                           type="text"                   
	                           value=""                           
	                           class="form-control">
	                           <option></option>
	                           <?php foreach ($professionals as $professional) : ?>                                
	                           <?php  $professional_fullName = $professional->fname.' '.$professional->lname ?>
	                           <option 
	                                  value="<?php echo $professional->pro_id ; ?>">
	                                  <?php echo ucwords($professional_fullName) ; ?>
	                                
	                          </option>                           
	                          <?php endforeach ; ?>                                              
                        </select>                  
                    </div> <!-- / . input-group -->
                  </div><!-- end .col-sm -->

                  <div class = "col-sm-2">
                        <div class="input-group">
                           <span class = "input-group-addon">
                              <?php esc_html_e('Date','multi-scheduler') ; ?>
                           </span>
                           <?php 
                            if(method_exists('Msbdt_Admin','msbdt_select_added_all_professional')){
                               $professionals = array();
                               $sql           = Msbdt_Professional::msbdt_select_added_all_professional();
                               $professionals = $wpdb->get_results($sql , OBJECT ) ; 
                            } ?> 
		                   <input  name  = "search_date"
		                           type  = "text"                   
		                           value = "" 
		                           placeholder = "yy-mm-dd"
		                           class="form-control date_slote" >
                        </div> <!-- / . input-group -->
                   </div><!-- end .col-sm -->
		           <div class = "col-sm-2 admin_submit_button_color">                                 
		               <input type = "submit" 
		                name="search_submit" 
		                class="btn btn-primary" 
		                value="<?php esc_html_e('Search','multi-scheduler'); ?>">          
		           </div><!-- end .col-sm -->
	               <div class = "col-sm-1">  
	               <input type='button' id='btn' class="btn btn-primary" value='Print' onclick='printDiv();'>
	               </div>
               </div><!-- end row -->
            </form> <!-- end form -->

	        <div id='DivIdToPrint'>         
	        <table class="table table-striped"   width="100%" >
		         <thead  class="scheduler_admin_thead ">
			         <tr>
			         <th><?php esc_html_e( 'SRL','multi-scheduler' );?></th>
			         <th><?php esc_html_e( 'Applicant Name' ,'multi-scheduler' );?></th>
			         <th><?php esc_html_e( 'Applicant Email' ,'multi-scheduler' );?></th>
			         <th><?php esc_html_e( 'Applicant Contact No','multi-scheduler' );?></th>
			         <th><?php esc_html_e( 'Applicant Message' ,'multi-scheduler' );?></th>
			         <th><?php esc_html_e( 'Date' , 'multi-scheduler' );?></th>
			         <th><?php esc_html_e( 'Time' , 'multi-scheduler' );?></th>          
			         </tr>
		         </thead>
		         <tbody  class="text_color_for_all_page">
	             <?php foreach ($results as $result): ?>
	               <tr>
	                  <td><?php echo $serial_no ; ?></td>
	                  <td><?php echo ucwords($result->name); ?></td>
	                  <td><?php echo $result->email; ?></td>
	                  <td><?php echo $result->phone; ?></td>
	                  <td><?php echo $result->message; ?></td>
	                  <td><?php echo $result->date; ?></td>
	                  <td><?php 
	                       $start_time = new DateTime($result->date.' '.$result->start_time);
	                       $start_time = $start_time->format('H:i A');
	                       $end_time = new DateTime($result->date.' '.$result->end_time);
	                       $end_time = $end_time->format('H:i A');
	                       echo $start_time.' - '.$end_time; ?></td>                                  
	               </tr> 
	               <?php $serial_no++ ; ?>    
	               <?php endforeach ; ?> 
	                <tr>
	                   <td colspan="7" align="center">
	                   <div class="pagination-wrap">
			             <?php
			              /**
			               * @since      1.0.0
			               * @param paginglink( $query , $records_per_page , $table_name )
			               */
			             ?>
			            <?php Msbdt_Pagenation::msbdt_paginglink( $query , $records_per_page , MSBDT_TABLE_BOOKING ); ?>
			            </div>
			            </td>
	                </tr>                              
	            </tbody>
              </table>
            </div>
           </div>  <!-- / col-sm-12 -->
        </div> <!-- / scheduler_admin -->
    </div><!-- / .container row -->
 </div><!-- / .multi-appointment-->
     <?php
     else:
         wp_die("<p style='color: chocolate;font-weight: bold'>You Are Not Eligible For This Task. No Naughty Business Please!</p>");
     endif ;
 }?>

  <script type="text/javascript">
        function printDiv(){
              var divToPrint=document.getElementById('DivIdToPrint');
              var newWin=window.open();
              newWin.document.open();
              newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
              newWin.document.close();
              setTimeout(function(){newWin.close();},10);
            }
  </script>
     