<?php
/**
 * @package    admin
 * @subpackage admin/templates
 * @author     bdtask<uzzal131@gmail.com> <bdtask@gmail.com>
 * @return void .
 */

function msbdt_appointment_add_profession_form(){
   
   global $pagenow , $wpdb ;
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
   

  /**
   *@param $_REQUEST['page'] is string variable , value will after url . 
   *@since      1.0.0
   *@param check , is page add_professional ? 
   */ 
   
   if(($_REQUEST['page']==='msbdt_professional')&& ($pagenow == 'admin.php')) :
   
         $scheduler_admin_custom_css = Msbdt_Custom_Admin_Style::msbdt_scheduler_admin_custom_css();

        /**
         *@param $errors , array variable. 
         *@since      1.0.0
         *check , is professional_add_process_data function exist ? 
         */ 

         if(method_exists('Msbdt_Professional','msbdt_professional_add_process_data')) :   
            $errors = array();
            $errors = Msbdt_Professional::msbdt_professional_add_process_data();
         endif ;

         ob_start();  ?>
 <br />   
 <div class="multi-appointment"  >
   <div class = "container row"  >
     <div class="scheduler_admin">      
        <ul class="nav nav-tabs" >
            <li class="active"  >
            <a  href="#professional" data-toggle="tab">
            <h5><?php esc_html_e('professional','multi-scheduler') ;?></h5></a></li>
            <li><a href="#add_professional" data-toggle="tab">
            <h5><?php esc_html_e('Add New professional','multi-scheduler') ;?></h5></a></li>              
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
           id ="professional" >        
         <table class="table table-striped" >
             <thead class="scheduler_admin_thead ">
                 <tr>
                 <th><?php esc_html_e('SRL');?></th>
                 <th><?php esc_html_e('Name');?></th>
                 <th><?php esc_html_e('Sex');?></th>
                 <th><?php esc_html_e('Email');?></th>
                 <th><?php esc_html_e('Contact No');?></th>
                 <th><?php esc_html_e('Action');?></th>                        
                 </tr>
             </thead>
             <tbody class="text_color_for_all_page" >
                <?php /**
                       *@param $locations , array variable. 
                       *@since 1.0.0
                       *@param check , is select_added_all_location function exist ? 
                       *@param To create pagination .
                       */ ?>
                <?php if(method_exists('Msbdt_Professional','msbdt_select_added_all_professional')) :
                    $query      = Msbdt_Professional::msbdt_select_added_all_professional();
                    $new_query  = Msbdt_Pagenation::msbdt_paging( $query , $records_per_page ) ;
                    $professionals = $wpdb->get_results($new_query , OBJECT ) ;
                endif ; ?>          
               <?php foreach ($professionals as $professional): ?>
                     <tr>
                        <td><?php echo $serial_no ; ?></td>
                        <td><?php echo ucwords($professional->fname).' '.ucwords($professional->lname); ?></td>
                        <td><?php echo ucwords($professional->sex); ?></td>
                        <td><?php echo $professional->email; ?></td>
                        <td><?php echo $professional->contact_no; ?></td>                          
                        <td>                                                                      
                        <span><a class="button btn-warning" 
                                href="#professional_delete<?php echo $professional->pro_id; ?>" 
                                data-toggle="modal"><?php  _e( 'Delete','multi-scheduler' );?></a>
                        </span>                        
                        <div id="professional_delete<?php echo $professional->pro_id; ?>" 
                             class="modal fade">                               
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button class="close" type="button" data-dismiss="modal">×</button>
                                      <h4 class="modal-title"><?php  _e('Delete Professional','multi-scheduler');?>
                                      </h4>
                                   </div>
                                    <div class="modal-body">                             
                                        <?php delete_conform_pro( $professional ); ?>     
                                    </div><!-- /.modal-body -->
                                </div><!-- /.modal-content -->                               
                             </div><!-- /.modal -->
                        </div><!-- / #professional_delete -->
                        <span><a   class="button btn-primary" 
                           href="#professional_edit<?php echo $professional->pro_id; ?>" 
                           data-toggle="modal">Edit</a>
                        </span>
                        <div id="professional_edit<?php echo $professional->pro_id; ?>" 
                                 class="modal fade" >                               
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                   <div class="modal-header">
                                     <button class="close" type="button" data-dismiss="modal">×</button>
                                      <h4 class="modal-title"><?php _e('Edit Professional','multi-scheduler');?>
                                      </h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php professional_form_html( $professional , 'col-sm-2' ,'col-sm-6' ); ?>     
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->                               
                            </div><!-- /.modal -->
                        </div><!-- #professional_edit<?php echo $professional->pro_id; ?> --> 
                        </td>               
                     </tr>
                     <?php $serial_no++ ; ?>     
                <?php endforeach ; ?>
                      <tr>
                       <td colspan="7" align="center">
                          <div class="<?php esc_attr_e('pagination-wrap');?>">               
                      <?php Msbdt_Pagenation::msbdt_paginglink( $query , $records_per_page , MSBDT_TABLE_PROFESSIONAL ); ?>
                          </div>
                       </td>
                      </tr>                  
            </tbody>
          </table>              
          </div><!-- /.tab-pane active /#location_list-->
          <div id = "add_professional" class = "tab-pane" >
          <br />              
          <div class = "col-sm-12">
           <?php professional_form_html( null , 'col-sm-2' ,'col-sm-4' ); ?>   
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

function professional_form_html( $pro = null , $col_label = null , $col_span = null , $errors = null){ ?>
  
  <form  method = "post" 
         action = "" 
          class = "row">
          
   <input name ="pro_id"; 
          type ="hidden" 
          id   ="pro_id"                     
          value="<?php if(isset($pro->pro_id)):echo $pro->pro_id; endif; ?>" > 

    <div class = "col-sm-12 form-group">                  
       <label class  = "<?php  echo esc_attr( $col_label  ); ?>" 
                 for = "first_name"><?php _e('First Name','multi-scheduler'); ?>
      </label>
       <span  class = "<?php echo esc_attr( $col_span ) ; ?>" >
       <input name="fname"; 
              type="text" 
                id="first_name"                     
             value="<?php if(isset($pro->fname)):echo $pro->fname; endif; ?>" 
             class="form-control"> 
       <span style="color:red;"><?php if(isset($errors['fname'])){echo $errors['fname'];}?></span> 
       </span> 
    </div>

     <div class = "col-sm-12 form-group">  
          <label class = "<?php echo esc_attr( $col_label ) ;?>" for="last_name">
          <?php  _e('Last Name','multi-scheduler'); ?></label>                   
          <span class = "<?php echo esc_attr( $col_span ) ;?>" >
          <input name = "lname" 
                 type = "text" 
                 id   = "last_name"
                value = "<?php if(isset($pro->lname)):echo $pro->lname; endif; ?>" 
                class = "<?php echo esc_attr('form-control'); ?> ">
          <span style = "color:red;"><?php if(isset($errors['lname'])){echo $errors['lname'];}?></span>
          </span>                     
      </div> 

       <div class = "col-sm-12 form-group">
          <label class  = "<?php echo esc_attr($col_label) ;?>" for="state">
          <?php echo __('Sex','multi-scheduler'); ?>  </label>
          <span class  = "<?php echo esc_attr($col_span) ;?>" >
          <input  type = "radio" 
                  name = "sex" 
                  value="male"
                  <?php if(isset($pro->sex) && $pro->sex=='male'):echo 'checked="checked"'; endif; ?> 
                  checked="checked"><span class="date-time-text format-i18n">
                                   <?php esc_html_e('Male','multi-scheduler'); ?></span>
          <input type="radio" 
                 name="sex"
                 <?php if(isset($pro->sex) && $pro->sex=='female'):echo 'checked="checked"'; endif; ?>  
                 value="female"><span class="date-time-text format-i18n">
                 <?php esc_html_e('Female','multi-scheduler'); ?></span>
            </span>                                
        </div>
        <div class = "col-sm-12 form-group">
              <label  class = "<?php echo esc_attr($col_label) ;?>" for="email">
              <?php echo __('Email','multi-scheduler'); ?>  </label>
              <span class   = "<?php echo esc_attr( $col_span ) ;?>" >
              <input  name  = "email" 
                      type  = "email" 
                      id    = "email"                         
                      value = "<?php if(isset($pro->email)):echo $pro->email ; endif; ?>" 
                      class = "form-control">
               <span style  = "color:red;"><?php if(isset($errors['email'])){echo $errors['email'];}?>
                 
               </span>
               </span>
        </div>
        <div class = "col-sm-12 form-group">
              <label class = "<?php echo esc_attr( $col_label ) ;?>" for="contact_no">
              <?php echo __('Contact No','multi-scheduler'); ?>  </label>
              <span class = "<?php echo esc_attr( $col_span ) ;?>" >
              <input name = "contact_no" 
                     type = "text" 
                      id  = "contact_no"                         
                    value = "<?php if(isset($pro->contact_no)):echo $pro->contact_no; endif; ?>" 
                    class = "form-control">
                <span style="color:red;"><?php if(isset($errors['contact_no'])){echo $errors['contact_no'];}?>
                </span> 
                </span> 
           
        </div> 
        <div class = "col-sm-12 form-group">
              <label class  = "<?php echo esc_attr( $col_label ) ;?>" for="website">
              <?php _e('Website','multi-scheduler'); ?>  </label>
              <span class   = "<?php echo esc_attr( $col_span ) ;?>" >
              <input name   = "website" 
                      type  = "url" 
                      id    = "website"                         
                      value = "<?php if(isset($pro->website)):echo $pro->website; endif; ?>" 
                      class = "form-control">
              </span>
           
        </div>  
        <div class = "col-sm-12 form-group">
            <label class = "<?php echo esc_attr($col_label) ;?>" for="biographical_info">
             <?php echo __('Biographical Information','multi-scheduler'); ?></label>
            <span class = "<?php echo esc_attr($col_span) ;?>" >
            <textarea                      
                       rows = "3"
                       name = "biographical_info" 
                       type = "text" 
                       id   = "biographical_info" 
                       class= "form-control">
                       <?php if(isset($pro->biographical_info)):
                       echo $pro->biographical_info; 
                       endif;  ?>                            
             </textarea>
             </span>
        </div>

     <?php if( $pro !== null ): ?>
       <div class="modal-footer">
          <button class = "btn btn-default" 
                  type  = "button" 
                  data-dismiss="modal">Close</button>        
           <input type="submit" 
            name="add_professional_submit" 
            id="" 
            class="btn btn-primary" 
            value="<?php echo esc_attr('Save Change','multi-scheduler'); ?>">                                            
        </div> 
      <?php else : ?>

        <div class = "col-sm-12 form-group admin_submit_button_color">
            <span class  = "<?php echo esc_attr($col_span) ;?>" >
            <input  type = "submit" 
                    name = "add_professional_submit" 
                    id   = "" 
                    class= "btn btn-primary" 
                    value= "<?php echo esc_attr('Add New Professional','multi-scheduler'); ?>">      
            </span>
        </div>

      <?php endif ; ?>

    </form>
                
<?php }

function delete_conform_pro($pro){?>

    <form  method = "post" 
           action = "" 
           class  = "row">

        <input name = "pro_delete_id"; 
              type  = "hidden" 
              id    = "pro_id"                     
              value = "<?php if(isset($pro->pro_id)):echo $pro->pro_id; endif; ?>" 
              class = "form-control"> 

         <?php  _e('Are you sure to delete ?.','multi-scheduler') ; ?>

         <div class="modal-footer">
        <button class = "btn btn-default" 
                type  = "button" 
                data-dismiss = "modal"><?php _e('Close','multi-scheduler');?></button>        
         <input type  = "submit" 
                name  = "professional_delete" 
                id    = "" 
                class = "btn btn-warning" 
                value = "<?php echo esc_attr('Delete','multi-scheduler'); ?>">                                            
        </div> 

   </form>
                
<?php }?>