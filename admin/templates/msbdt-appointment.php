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
global $pagenow , $wpdb;
define('MSBDT_TABLE_BOOKING', $wpdb->prefix.'msbdt_booking' );
define('MSBDT_TABLE_PROFESSIONAL', $wpdb->prefix.'msbdt_professional' );  

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
 
$records_per_page =  get_option( 'admin_pagination' );

if(($_REQUEST['page']==='msbdt_appointment')&& ($pagenow == 'admin.php')){

    $scheduler_admin_custom_css = Msbdt_Custom_Admin_Style::msbdt_scheduler_admin_custom_css();

   	if(isset($_GET['approve_id']) && isset($_GET['status'])):
       $approve_id = intval( $_GET['approve_id']  );
       $status = intval( $_GET['status']  );
   	   $acton = Msbdt_Booking::msbdt_mas_booking_action(  $approve_id  ,  $status );

   	elseif(isset($_GET['reject_id']) && isset($_GET['status'])):
       $reject_id  = intval( $_GET['reject_id']  );
       $status = intval( $_GET['status']  );
       $acton = Msbdt_Booking::msbdt_mas_booking_action( $reject_id  , $status ); 

    elseif(isset($_GET['delete_id']) && isset($_GET['status'])):
       $delete_id  = intval( $_GET['delete_id']  );
       $status = intval( $_GET['status']  );
   	   $acton = Msbdt_Booking::msbdt_mas_booking_action( $delete_id  , $status ); 
    endif;

   ?>   

<h3><?php  echo get_admin_page_title(); ?></h3>
  <div class = "multi-appointment row " >
    <div class="scheduler_admin">           
       <div class = "col-sm-12" >         
         <!-- header color note -->
         <span style = "background-color:<?php echo esc_attr( get_option('request_color') ); ; ?> ;
                        padding: 3px ;
                        margin: 1px; 
                        font-size:bold; 
                        color:#ffffff" >
         <?php esc_html_e('Requested','multi-scheduler');?></span>
         <span style = "background-color:<?php echo esc_attr( get_option('approve_color') ); ?> ; 
                        padding: 3px ; 
                        margin: 1px;
                        font-size:bold;
                        color:#ffffff" >
         <?php esc_html_e('Approved','multi-scheduler');?></span>
         <span style = "background-color:<?php echo esc_attr( get_option('reject_color') ); ?> ; 
                        padding: 3px ; 
                        margin: 1px;
                        font-size: bold;
                        color:#ffffff" >
         <?php esc_html_e('Rejected','multi-scheduler');?></span>

           <!-- end header color note -->
         
         <table class="table table-striped">
         <thead class="scheduler_admin_thead">
         <tr>
         <th><?php esc_html_e( 'SRL','multi-scheduler'  );?></th>
         <th><?php echo get_option( 'frontend_professional' );?></th>
         <th><?php esc_html_e( 'Applicant Name','multi-scheduler'  );?></th>
         <th><?php esc_html_e( 'Applicant Email','multi-scheduler'  );?></th>
         <th><?php esc_html_e( 'Applicant Contact No','multi-scheduler'  );?></th>
         <th><?php esc_html_e( 'Date','multi-scheduler'  );?></th>
         <th><?php esc_html_e( 'Time','multi-scheduler'  );?></th>
         <th><?php esc_html_e( 'Status','multi-scheduler'  );?></th>
         <th><?php esc_html_e( 'Action','multi-scheduler'  );?></th>
         </tr>
         </thead>
         <tbody class="scheduler_admin_tbody">
         <?php 
         $query      = Msbdt_Booking::msbdt_mas_booking();
         $new_query  = Msbdt_Pagenation::msbdt_paging( $query , $records_per_page ) ;
         $results    = $wpdb->get_results($new_query , OBJECT ) ; 

         ?>
         <?php foreach ($results as $result): ?>
               <tr <?php if($result->status !== '4'):
                            if($result->status == '5'): 
                           	echo 'style= background-color:'.get_option('approve_color');
                            elseif($result->status =='6'):
                           	echo 'style= background-color:'.get_option('reject_color'); 
                            endif ;
                         else: echo 'style= background-color:'.get_option('request_color');
                         endif;?>>
                  <td><?php echo $serial_no ; ?></td>
                  <td><?php  

                   if(method_exists('Msbdt_Professional','msbdt_select_added_all_professional')) :
                          $professional = Msbdt_Professional::msbdt_select_added_all_professional( $result->pro_id );
                          echo ucwords($professional->fname.' '.$professional->lname);
                   endif ;

                  ?></td>
                  <td><?php echo ucwords($result->name); ?></td>
                  <td><?php echo $result->email; ?></td>
                  <td><?php echo $result->phone; ?></td>
                  <td><?php echo $result->date; ?></td>
                  <td><?php 
                       $start_time = new DateTime($result->start_time);
                       $start_time = $start_time->format('H:i a');
                       $end_time = new DateTime($result->end_time);
                       $end_time = $end_time->format('H:i a');
                       echo $start_time.' - '.$end_time; ?></td>
                  
                   <td><?php  
                        if($result->status !== '4'):
                           if($result->status == '5'):  esc_html_e('Approve','multi-scheduler');
                           elseif($result->status =='6'): esc_html_e('Reject','multi-scheduler'); 
                           endif ;
                        else: esc_html_e('Request','multi-scheduler');
                        endif;

                   ?></td>
                   <td><?php  
                        if($result->status !== '4'):
                           if($result->status == '5'):?>
                               <button type='button' class='button btn-defult'>
                               <a href="?page=msbdt_appointment&status=6&reject_id=<?php echo $result->id;?>">
                               <?php esc_html_e('Reject','multi-scheduler')?></a>
                               </button> 
                            <?php 
                           elseif($result->status =='6'):?>
                               <button type='button' class='button btn-defult'>
                               <a href="?page=msbdt_appointment&status=3&delete_id=<?php echo $result->id; ?>">
                               <?php esc_html_e('Delete','multi-scheduler')?></a>
                               </button>
                               <button type='button' class='button btn-defult'>
                               <a href="?page=msbdt_appointment&status=5&approve_id=<?php echo $result->id; ?>">
                               <?php esc_html_e('Approve','multi-scheduler')?></a>
                              </button>  
                            <?php 
                           endif ; 
                        else:?>
                              <button type='button' class='button btn-defult'>
                              <a href="?page=msbdt_appointment&status=5&approve_id=<?php echo $result->id; ?>">
                              <?php esc_html_e('Approve','multi-scheduler')?></a>
                              </button> 
                            <?php 
                        endif;
                   ?></td>
               </tr> 
             <?php  $serial_no++ ; ?> 
          <?php endforeach ; ?>
          <tr>
            <td colspan="9" align="center">
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
       </div> <!-- .scheduler_admin -->
      </div><!-- .multi-appointment .row-->
     <?php
     }else{
         wp_die("<p style='color: chocolate;font-weight: bold'>You Are Not Eligible For This Task. No Naughty Business Please!</p>");
     }
 }