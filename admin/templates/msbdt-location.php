<?php
/**
 * @package    admin
 * @subpackage admin/templates
 * @author     bdtask<uzzal131@gmail.com> <bdtask@gmail.com>
 * @return void .
 */
function msbdt_appointment_add_location_form(){
   
global $pagenow , $wpdb ;
define('MSBDT_TABLE_LOCATION', $wpdb->prefix.'msbdt_location' ); 

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
 
$records_per_page = get_option( 'admin_pagination' );
   
  /**
   *@param $_REQUEST['page'] is string variable , value will after url . 
   *@since 1.0.0
   *@param check , is page add_location ? 
   */ 
  if(($_REQUEST['page']==='msbdt_location')&& ($pagenow == 'admin.php')):
    
     $scheduler_admin_custom_css = Msbdt_Custom_Admin_Style::msbdt_scheduler_admin_custom_css();
    /**
     *@param $errors , array variable. 
     *@since 1.0.0
     *@param check , is location_add_process_data function exist ? 
     */ 
    if(method_exists('Msbdt_Location','msbdt_location_add_process_data')) :
        $errors = array();
        $errors = Msbdt_Location::msbdt_location_add_process_data();

    endif ; ?>  
<br />
<div class="multi-appointment"  >
   <div class = "container row"  >
     <div class="scheduler_admin">      
        <ul class="nav nav-tabs" >
            <li class="active"  >
            <a  href="#location_list" data-toggle="tab">
            <h5><?php esc_html_e('Location','multi-scheduler') ;?></h5></a></li>
            <li><a href="#add_location" data-toggle="tab">
            <h5><?php esc_html_e('Add New Location','multi-scheduler') ;?></h5></a></li>              
        </ul>

<!--========================================================
 ================ Display message Section ================= -->
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

   <div class="tab-content">
      <div class="tab-pane active"  
           id ="location_list" >        
         <table class="table table-striped" >
             <thead class="scheduler_admin_thead ">
                 <tr>
                 <th><?php esc_html_e('SRL','multi-scheduler');?></th>
                 <th><?php esc_html_e('Address','multi-scheduler');?></th>
                 <th><?php esc_html_e('State','multi-scheduler');?></th>
                 <th><?php esc_html_e('City','multi-scheduler');?></th>
                 <th><?php esc_html_e('Zip','multi-scheduler');?></th>
                 <th><?php esc_html_e('Action','multi-scheduler');?></th>                        
                 </tr>
             </thead>
             <tbody class="text_color_for_all_page" >
                <?php /**
                       *@param $locations , array variable. 
                       *@since 1.0.0
                       *@param check , is select_added_all_location function exist ? 
                       *@param To create pagination .
                       */ ?>
               <?php if(method_exists('Msbdt_Location','msbdt_select_added_all_location')):
                       $locations  = array();
                       $query      = Msbdt_Location::msbdt_select_added_all_location();
                       $new_query  = Msbdt_Pagenation::msbdt_paging( $query , $records_per_page ) ;
                       $locations  = $wpdb->get_results($new_query , OBJECT ) ;                                   
                     endif ; ?>           
               <?php foreach ($locations as $location): ?>
                     <tr>
                        <td><?php echo $serial_no   ; ?></td>
                        <td><?php echo ucwords($location->address) ; ?></td>
                        <td><?php echo $location->state ; ?></td>
                        <td><?php echo $location->city  ; ?></td>
                        <td><?php echo $location->zip ; ?></td>
                        <td>                                                      
                        <span><a class="button btn-warning" 
                                   href="#location_delete<?php echo $location->loc_id; ?>" 
                                   data-toggle="modal"><?php _e('Delete','multi-scheduler');?></a>
                         </span>
                         <div id="location_delete<?php echo $location->loc_id; ?>" class="modal fade">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button class="close" type="button" data-dismiss="modal">×</button>
                                  <h4 class="modal-title"><?php  _e('Delete Location','multi-scheduler');?></h4>
                                </div>
                                <div class="modal-body">                         
                                <?php delete_conform_loc( $location ); ?>                               
                                </div><!-- /.modal-body -->
                               </div><!-- /.modal-content -->                               
                            </div><!-- /.modal-dialog-->
                         </div><!-- / #location_delete -->
                        <span><a class="button btn-primary" 
                                 href="#location_edit<?php echo $location->loc_id ; ?>" 
                                 data-toggle="modal"><?php  _e('Edit','multi-scheduler');?></a>                
                        <div id="location_edit<?php echo $location->loc_id ; ?>" class="modal fade" >
                          <div class="modal-dialog modal-sm">
                             <div class="modal-content">
                               <div class="modal-header">
                                 <button class="close" type="button" data-dismiss="modal">×</button>
                                 <h4 class="modal-title"><?php  _e('Edit Location','multi-scheduler');?></h4>
                               </div>
                               <div class="modal-body">
                               <?php location_form_html( $location , 'col-sm-10') ?>              
                               </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->                               
                         </div><!-- /.modal -->
                        </div><!-- / #slote_edit<?php echo $professional->pro_id; ?> --> 
                        </td>               
                     </tr>
                     <?php  $serial_no++ ; ?>     
                <?php endforeach ; ?>
                      <tr>
                       <td colspan="7" align="center">
                          <div class="<?php esc_attr_e('pagination-wrap');?>">               
                          <?php Msbdt_Pagenation::msbdt_paginglink( $query , $records_per_page ,MSBDT_TABLE_LOCATION ); ?>
                          </div>
                       </td>
                      </tr>                  
            </tbody>
          </table>              
          </div><!-- /.tab-pane active /#location_list-->
          <div id = "add_location" class = "tab-pane" >
          <br />              
          <div class = "col-sm-12">
           <?php location_form_html( null ,'col-sm-4' ); ?>  
          </div><!-- .col-sm-12 -->      
          </div> <!-- .tab-pane -->                       
       </div><!-- .tab-content -->    
    </div><!-- .scheduler_admin -->  
   </div><!-- .container .row -->
  </div><!-- .multi-appointment .row -->  
  <?php //active(); ?>
  <?php else:
      wp_die();
  endif ; 
}

function location_form_html( $loc = null , $col_span = null , $errors = null){ ?>

<form  method="post"  action="" class="row  form-group">    
    <div  class="<?php echo esc_attr( $col_span ) ; ?>" >
      <input name="location_loc_id"; 
             type="hidden"                   
             value="<?php if(isset($loc->loc_id)):echo $loc->loc_id; endif; ?>" 
             class="form-control">  
       <div> 
          <label for="address">
          <?php  esc_html_e('Address','multi-scheduler'); ?></label>
          <span style="color:red;"><?php if(isset($errors['address'])){echo $errors['address'];}?></span>  
          <input  name  = "location_address"; 
                  type  = "text"                                      
                  value = "<?php if(isset($loc->address)):echo $loc->address; endif; ?>" 
                  class = "form-control" >            
        </div>                         
        <div>
            <label for="state">
            <?php esc_html_e('State','multi-scheduler'); ?></label>
            <span style="color:red;"><?php if(isset($errors['state'])){echo $errors['state'];}?></span> 
            <input name  = "location_state" 
                   type  = "text"                       
                   value = "<?php if(isset($loc->state)):echo $loc->state; endif; ?>" 
                   class = "form-control" >         
          </p>          
        </div>
         <div>
              <label for="city"><?php esc_html_e('City','multi-scheduler'); ?></label>
              <span style="color:red;"><?php if(isset($errors['city'])){echo $errors['city'];}?></span>  
              <input name="location_city" 
                     type="text"                       
                     value="<?php if(isset($loc->city)):echo $loc->city; endif; ?>" 
                     class="form-control">                  
         </div> 
         <div>
              <label for="zip">
              <?php esc_html_e('Zip Code','multi-scheduler'); ?></label>
              <span style="color:red;"><?php if(isset($errors['zip'])){echo $errors['zip'];}?></span>
              <input name = "location_zip" 
                    type  = "text"                                               
                    value = "<?php if(isset($loc->zip)):echo $loc->zip; endif; ?>" 
                    class = "form-control">
                 
         </div> 
        
         <?php if( $loc !== null ): ?>
         <div class  = "modal-footer">
            <button class = "btn btn-default" 
                    type  = "button" 
                    data-dismiss="modal"><?php  esc_html_e('Close','multi-scheduler'); ?></button>        
             <input type  = "submit" 
                    name  = "add_location_submit" 
                    class = "btn btn-primary" 
                    value = "<?php echo esc_attr('Save Change','multi-scheduler');?>" >                                          
          </div> 
          <?php else : ?>
          <div class = "admin_submit_button_color">
           <label><br />
           <input   type  = "submit" 
                    name  = "add_location_submit"                      
                    class = "btn btn-primary" 
                    value = "<?php echo esc_attr('Add New Location','multi-scheduler'); ?>"> </label> 
          </div>  
          <?php endif ; ?>                
    </div> <!-- .col-sm-7 -->             
  </form>
  <?php                          
}
function delete_conform_loc($loc){?>

    <form  method="post" action="" class="row">
        <input name  = "loc_delete_id"; 
               type  = "hidden"                
               value = "<?php if(isset($loc->loc_id)):echo $loc->loc_id; endif; ?>" 
               class = "form-control"> 
         <?php  echo esc_html('Are you sure to delete ?.','multi-scheduler') ; ?>

         <div class="modal-footer">
          <button class = "btn btn-default" 
                  type  = "button" 
                  data-dismiss="modal"><?php  esc_html_e('Close','multi-scheduler'); ?></button>        
           <input type  = "submit" 
                  name  = "location_delete" 
                  class = "btn btn-warning" 
                  value = "<?php echo esc_attr('Delete','multi-scheduler'); ?>">                                            
        </div> 

   </form>
                
 <?php }
