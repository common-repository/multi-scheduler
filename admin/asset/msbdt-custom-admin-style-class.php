<?php
class Msbdt_Custom_Admin_Style{

	public static function msbdt_scheduler_admin_custom_css(){ 

    $text_color_for_all_page = ( get_option( 'admin_text_color_active_page') == '2' )?
                                 get_option( 'admin_text_color') :
                                 '#000000';
    ?>
      <style type="text/css">

        .multi-appointment .scheduler_admin,
        .multi-appointment .scheduler_admin_tbody,
        .multi-appointment .text_color_for_all_page{          
             font-family:<?php echo get_option( 'admin_fontfamily' ); ?> ;
             font-size:<?php echo get_option( 'admin_fontsize' ); ?>px ;       
        }
        .multi-appointment .scheduler_admin .scheduler_admin_tbody{         
             color:<?php echo  get_option( 'admin_text_color' ); ?>;         
        } 
        .multi-appointment .scheduler_admin .text_color_for_all_page{
             color:<?php echo $text_color_for_all_page ; ?>;            
        }
        .multi-appointment .scheduler_admin .btn-warning {
            color:<?php echo  get_option( 'admin_submit_button_text_color' ); ?> ;  
            background-color:<?php echo  get_option( 'admin_delete_button_color' ); ?>;
            border-color: #eee;
        }
        .multi-appointment .scheduler_admin .btn-primary {
            color:<?php echo  get_option( 'admin_submit_button_text_color' ); ?>;  
            background-color:<?php echo  get_option( 'admin_edit_button_color' ); ?>; 
            border-color: #eee;
          }
        .multi-appointment .admin_submit_button_color .btn-primary {
           color:<?php echo  get_option( 'admin_submit_button_text_color' ); ?>;  
           background-color:<?php echo  get_option( 'admin_submit_button_color' ); ?>; 
        }
         
        .multi-appointment .table > tbody > tr > td,
        .multi-appointment .table > tfoot > tr > td {        
          vertical-align:none;           
        }
      </style>
     
     <?php
   }
}