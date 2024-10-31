<?php
/**
 * @package    admin
 * @subpackage admin/templates
 * @author     bdtask<uzzal131@gmail.com> <bdtask@gmail.com>
 * @return void .
 */
function msbdt_appointment_add_time_slote_form(){
   global $pagenow , $wpdb ;
   define('TABLE_TIME_SLOTE', $wpdb->prefix.'msbdt_time_slote' );    
   $records_per_page =  get_option( 'admin_pagination' );
   
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

    /**
     *@param $_REQUEST['page'] is string variable , value will after url . 
     *@since 1.0.0
     *@param check , is page add_location ? 
     */ 
    if(($_REQUEST['page']==='msbdt_schedule')&& ($pagenow == 'admin.php')):
        
      $scheduler_admin_custom_css = Msbdt_Custom_Admin_Style::msbdt_scheduler_admin_custom_css();
        /**
         *@param $errors , array variable. 
         *@since 1.0.0
         *@param check , is schedule_add_process_data function exist ? 
         */ 
        if(method_exists('Msbdt_Schedule','msbdt_schedule_add_process_data')) :
            $errors = array();
            $errors = Msbdt_Schedule::msbdt_schedule_add_process_data();

         endif ; ?> 

<br />
<div class="multi-appointment" >
   <div class = "container row" >
     <div class="scheduler_admin">    
      <ul class="nav nav-tabs ">
          <li class="active" ><a  href="#schedule" data-toggle="tab">
          <h5><?php _e('Schedule','multi-scheduler') ;?></h5></a></li>
          <li><a href="#add_schedule" data-toggle="tab">
          <h5><?php _e('Add New Schedule','multi-scheduler') ;?></h5></a></li>              
      </ul>

   <!-- ================ Display message Section ================= -->
      <div class = "col-sm-7">
      <?php if($errors == 'no_error_data_save_successfully'): ?>
        <div id="message" class="updated notice is-dismissible">
          <p><strong><?php _e('Add successfully','multi_scheduler') ;?></strong></p>
          <button type="button" class="notice-dismiss">
          <span class="screen-reader-text"><?php _e('Dismiss this notice.','multi-scheduler') ;?></span>
          </button>
        </div>          
         <?php elseif($errors == 'no_error_data_update_successfully') : ?>
          <div id="message" class="updated notice is-dismissible">
            <p><strong><?php _e('Update successfully','multi-scheduler') ;?></strong></p>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"><?php _e('Dismiss this notice.','multi-scheduler') ;?></span>
            </button>
          </div>

          <?php elseif($errors == 'no_error_data_delete_successfully') : ?>
          <div id="message" class="updated notice is-dismissible">
            <p><strong><?php _e('Delete successfully','multi-scheduler') ;?></strong></p>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"><?php _e('Dismiss this notice.','multi-scheduler') ;?></span>
            </button>
          </div>

          <?php elseif($errors == 'something_is_error_for_relative_data') : ?>
            <div id="message" class="updated notice is-dismissible">
              <p><strong>
              <?php _e('Delete imposible ! . Because relative data already created .','multi-scheduler') ;?> 
              </strong></p>
              <button type="button" class="notice-dismiss">
              <span class="screen-reader-text"><?php _e('Dismiss this notice.','multi-scheduler') ;?></span>
              </button>
            </div>

            <?php elseif($errors == 'something_is_error') : ?>
            <div id="message" class="updated notice is-dismissible">
              <p><strong>
              <?php _e('You are already exist or Some thing is Error . Please try again ! .','multi-scheduler') ;?></strong></p>
              <button type="button" class="notice-dismiss">
              <span class="screen-reader-text"><?php _e('Dismiss this notice.','multi-scheduler') ;?></span>
              </button>
            </div>         
        <?php endif ; ?>
    </div><!-- end .col-sm-7 -->
   <!-- ================ Display message Section ================= -->

   <div class="tab-content">
     <div class="tab-pane active"  id="schedule" >             
         <table class="table table-striped" >
         <thead class="scheduler_admin_thead ">
         <tr>
         <th><?php  esc_html_e('SRL');?></th>
         <th><?php echo get_option( 'frontend_professional' );?></th>
         <th><?php echo get_option( 'frontend_location' );?></th>
         <th><?php  esc_html_e('Date');?></th>
         <th><?php  esc_html_e('Start Time');?></th>
         <th><?php  esc_html_e('End Time');?></th>
         <th><?php  esc_html_e('Action');?></th>                        
         </tr>
         </thead>
         <tbody class="text_color_for_all_page" >
         <?php /**
                 *@param $locations , array variable. 
                 *@since 1.0.0
                 *@param check , is select_added_all_schedule function exist ? 
                 *@param To create pagination .
                 */ ?>
         <?php if(method_exists('Msbdt_Schedule','msbdt_select_added_all_schedule')):
                 $slotes  = array();
                 $query      = Msbdt_Schedule::msbdt_select_added_all_schedule();
                 $new_query  = Msbdt_Pagenation::msbdt_paging( $query , $records_per_page ) ;
                 $slotes  = $wpdb->get_results($new_query , OBJECT ) ;                                   
               endif ; ?> 
                  
         <?php foreach ($slotes as $slote): ?>
               <tr>
                  <td><?php echo $serial_no ; ?></td>
                  <td><?php 
                   $pro = Msbdt_Professional::msbdt_select_added_all_professional( $slote->pro_id );
                   echo ucwords($pro->fname."  ".$pro->lname); ?></td>
                  <td><?php 
                   $loc = Msbdt_Location::msbdt_select_added_all_location( $slote->loc_id );
                   echo ucwords($loc->address); ?></td>
                  <td><?php echo $slote->work_date; ?></td>
                  <td>
                  <?php $start_time = date("h:i A", strtotime($slote->work_date.' '. $slote->start_time  ));
                  echo $start_time; ?></td>
                  <td><?php $end_time = date("h:i  A", strtotime($slote->work_date.' '. $slote->end_time  ));
                  echo $end_time;  ?></td>                
                  <td>                             
                    <!-- Button trigger modal -->
                    <span><a class="button btn-warning" 
                       href="#slote_delete<?php echo $slote->slot_id; ?>" 
                       data-toggle="modal"><?php _e('Delete','multi-scheduler');?></a></span>

                      <!-- Modal -->
                      <div id="slote_delete<?php echo $slote->slot_id; ?>" class="modal fade">                               
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button class="close" type="button" data-dismiss="modal">×</button>
                              <h4 class="modal-title"><?php  _e('Delete Schedule','multi-scheduler');?></h4>
                            </div>
                            <div class="modal-body">
                             <?php
                              /**
                               * @since      1.0.0
                               * @param delete_conform_slote($object)
                               */
                             ?>
                             <?php delete_conform_slote( $slote ); ?>                               
                             </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->                               
                      </div><!-- /.modal -->
                     </div><!-- / #slote_delete -->
                   
                    <!-- Button trigger modal -->
                    <a class="button btn-primary" 
                       href="#slote_edit<?php echo $slote->slot_id; ?>" 
                       data-toggle="modal"><?php  _e('Edit','multi-scheduler');?></a>

                      <!-- Modal -->
                      <div id="slote_edit<?php echo $slote->slot_id; ?>" class="modal fade" >                               
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button class="close" type="button" data-dismiss="modal">×</button>
                              <h4 class="modal-title">
                              <?php  echo esc_html('Edit Schedule','multi-scheduler');?></h4>
                            </div>
                            <div class="modal-body">
                             <?php
                              /**
                               * @since      1.0.0
                               * @param schedule_form_html($object , $col_span = null , $errors = null)
                               */
                             ?>
                             <?php schedule_form_html( $slote , 'col-sm-4') ?>              
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->                               
                         </div><!-- /.modal -->
                       </div><!-- / #slote_edit<?php echo $professional->pro_id; ?> --> 
                  </td>               
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
            <?php Msbdt_Pagenation::msbdt_paginglink( $query , $records_per_page ,TABLE_TIME_SLOTE ); ?>
            </div>
            </td>
         </tr>                  
         </tbody>
         </table>
         
    </div><!-- end #schedule -->

     <div id="add_schedule" class="tab-pane" >  
       <br/>             
       <div class = "<?php echo esc_attr('col-sm-12');?>">
       <?php
        /**
         * @since      1.0.0
         * @param schedule_form_html($object , $col_label = null , $col_span = null , $errors = null)
         */
       ?>
       <?php schedule_form_html( null ,'col-sm-4' ); ?>  
       </div><!-- .col-sm-12 -->      
      </div> <!-- .tab-pane -->                       
  </div><!-- .tab-content -->    
</div><!-- .container .row -->  
</div><!-- .container .row -->  
</div><!-- .container .row -->  
<?php //active(); ?>
<?php else:
      wp_die();

  endif ; 
}

function schedule_form_html( $slote = null , $col_span = null , $errors = null){ ?>
<?php global $wpdb ; ?>

<form  method = "post" 
       action = "" 
       class  = "row  form-group">

 <?php if(!isset($slote->slot_id)): $col_span = 'col-sm-5'; endif ; ?>  
                   
 <?php if(!isset($slote->slot_id)):  ?>

    <div class = "col-sm-3"> 
    <div><label for=""><?php  echo esc_html( 'Avoilable Date', 'multi-scheduler' ); ?></label></div>
    <div id    = "withAltField"  
         class = "form-group" >
      <div id  = "with-altField"></div>
        <input  name  = "work_date"
               class  = "form-control"
               type   = "hidden"  
               id     = "altField" 
               value  = ""> 
               <span class="mas_required">
                          <?php if(isset($errors['work_date'])){echo $errors['work_date'];}?>
              </span>
      </div>
    </div><!-- .col-sm-7 -->
  <?php endif ; ?>
 
  <div  class="<?php echo esc_attr(  $col_span ) ; ?>">
    <input  name   = "slot_id"; 
            type   = "hidden" 
            id     = "slote_edit_id"                     
            value  = "<?php if(isset($slote->slot_id)): echo $slote->slot_id ; endif; ?>" 
            class  = "form-control"> 

    <div class = "form-group" >
      <label  for  = "pro_id"><?php echo esc_html( get_option( 'frontend_professional' ) ) ;?></label>
      <select name = "pro_id"; 
              type = "text"                                    
              class= "form-control">
             <?php 
             $query = Msbdt_Professional::msbdt_select_added_all_professional();
             $professionals = $wpdb->get_results($query , OBJECT ) ;
             foreach ($professionals as $professional) : ?>
             <?php  $display = $professional->fname.' '.$professional->lname ; ?>  
             <?php if( $slote->pro_id == $professional->pro_id ): 
             $set= "selected";
             else : $set = ""; endif ; ?>                                                    
             <?php  echo  '<option class="form-control"  
                                    value="'. $professional->pro_id.'" '.$set.'>'.$display.'</option>'; ?>                             
            <?php endforeach ; ?>                               
         </select>                  
       </div>
              
   <div class = "<?php echo esc_attr('form-group');?>">
     <label for="loc_id"><?php echo get_option( 'frontend_location' );?></label>
     <select name="loc_id"
             type="text"                   
             value="" 
             class="form-control">

             <?php if(method_exists('Msbdt_Location','msbdt_select_added_all_location')){
                     $locations = array();
                     $query = Msbdt_Location::msbdt_select_added_all_location();
                     $locations = $wpdb->get_results($query , OBJECT ) ;
                     foreach ($locations as $location) : ?>
                     <?php $display =  ucwords($location->address) ; ?> 
                      <?php if( $slote->loc_id == $location->loc_id ): 
                         $set= "selected";
                         else : $set = "";
                         endif ; ?> 
                         <?php  echo  '<option class="form-control"  
                          value="'. $location->loc_id.'" '.$set.'>'.$display .'</option>'; ?>           
                    <?php endforeach ; ?>
              <?php }?>                      
      </select>                  
    </div>

    <?php if( $slote !== null ): ?>  
      <div class = "form-group" >
        <label for   = "city"><?php esc_html_e('Work Date','multi-scheduler'); ?></label>
        <span style  = "color:red;"><?php if(isset($errors['city'])){echo $errors['city'];}?></span>
        <?php  ?>
        <input name  = "work_date" 
               type  = "text"
               id    = ""                       
               value = "<?php if(isset($slote->work_date)):echo $slote->work_date; endif; ?>" 
               class = "form-control date_slote">        
      </div>
    <?php endif ; ?> 

    <?php if(!isset($slote->int_val)):  ?>
      <div class = "form-group">
        <label for   =  "int_val"><?php echo __('Time per schedule','multi-scheduler'); ?></label>
        <input name  =  "int_val" 
               type  =  "" 
               id    =  ""
               value =  "" 
               class =  "form-control">
         <span class =  "mas_required">
                      <?php if(isset($errors['int_val'])){echo $errors['int_val'];}?>
         </span>                                  
      </div>
      <?php endif ; ?>  
  </div>


<div  class="<?php echo esc_attr( $col_span ); ?>"> 

     <div class = "form-group" >
          <label for  = "start_time" ><?php  esc_html_e('Start Time','multi-scheduler'); ?></label>
          <span style = "color:red;"><?php if(isset($errors['zip'])){echo $errors['zip'];}?></span>
          <input name = "start_time" 
                 type = "text"                                               
                 value= "<?php if(isset($slote->start_time)):
                          $start_time = date("h:i A", strtotime($slote->work_date.' '. $slote->start_time  ));
                          echo $start_time; endif; ?>" 
                class ="<?php echo esc_attr('form-control timepiker'); ?> ">                      
     </div>  
      <div class = "form-group">
          <label for  =  "end_time"><?php esc_html_e('End Time','multi-scheduler'); ?></label>
          <span style =  "color:red;"><?php if(isset($errors['zip'])){echo $errors['zip'];}?></span>
          <input name =  "end_time" 
                 type =  "text"                                               
                 value=  "<?php if(isset($slote->end_time)):
                           $end_time = date("h:i A", strtotime($slote->work_date.' '. $slote->end_time  ));
                           echo $end_time; endif; ?>" 
                 class="form-control timepiker">     
              
     </div>    
  </div>    
        
  <?php if( $slote !== null ): ?>
    <div class="col-sm-12"> 
       <div class="modal-footer">
          <button class       = "btn btn-default" 
                  type        = "button" 
                  data-dismiss= "modal"><?php  esc_html_e('Close','multi-scheduler'); ?></button>        
           <input type        = "submit" 
                  name        = "add_schedule_submit" 
                  id          = "" 
                 class        = "btn btn-primary" 
                 value        = "<?php  esc_attr_e('Save Change','multi-scheduler'); ?>">                                            
      </div> 
    </div>    
    <?php else : ?>
        <div class="col-sm-12 admin_submit_button_color">  
        <label><input  type  = "submit" 
                       name  = "add_schedule_submit"                      
                       class = "btn btn-primary" 
                       value = "<?php  esc_attr_e('Add New Schedule','multi-scheduler'); ?>"> 
                       </label>   
        </div>  
      <?php endif ; ?>                                 
  </form>
<?php }


function delete_conform_slote($slote){?>

    <form  method = "post" 
           action = "" 
           class  = "row ">

        <input name  =  "slot_delete_id"; 
               type  =  "hidden" 
               id    =  "slot_id"                     
              value  =  "<?php if(isset($slote->slot_id)):echo $slote->slot_id; endif; ?>" 
              class  =  "form-control"> 

         <?php  esc_html_e('Are you sure to delete ?.','multi-scheduler') ; ?>

         <div class="modal-footer">
          <button class        = "btn btn-default" 
                  type         = "button" 
                  data-dismiss = "modal"><?php  esc_attr_e('Close','multi-scheduler'); ?></button>        
           <input type         = "submit" 
                  name         = "slote_delete" 
                  id           = "" 
                  class        = "btn btn-warning" 
                  value        = "<?php esc_attr_e('Delete','multi-scheduler'); ?>">                                            
        </div> 

   </form>
                
 <?php } ?>