<?php 
class Msbdt_Custom_Style_Public{

	public static function msbdt_scheduler_custom(){ ?>

       <style type="text/css">
        .multi-appointment label{
          font-size:<?php echo get_option( 'frontend_fontsize' ); ?>px ;
          color:<?php echo  get_option( 'text_color' ); ?>;
          font-family:<?php echo get_option( 'frontend_fontfamily' ); ?>;
        } 

        .multi-appointment .schedule input{
           margin:1px; 
           color:<?php echo  get_option( 'text_color' ); ?>;
           min-width:200px;
        }

        .multi-appointment .public_error_message_color{
           color:<?php echo  get_option( 'error_message_color' ); ?>;       
        }

        .multi-appointment .public_submit_button input{
           color:<?php echo  get_option( 'submit_button_text_color' ); ?>;
           background-color:<?php echo  get_option( 'submit_button_color' ); ?>;
        }

         .multi-appointment .public_submit_button input.button-primary{
            border: 0;
            padding: 6px 12px;
            color: #fff;
         }
         
       /* Calender default enable div Color */
       .ui-state-default, 
       .ui-widget-content .ui-state-default,  
       .ui-widget-header .ui-state-default {     
         background:<?php echo get_option( 'calender_enable_color' ); ?>; 
         color: <?php echo get_option( 'calender_day_digit_color' ); ?>;     
        } 

       /* Calender active Color */
       .ui-state-active, 
       .ui-widget-content .ui-state-active, 
       .ui-widget-header .ui-state-active {
        background:<?php echo get_option( 'calender_active_color' ); ?> !important; 
       }  

      /* Calender day Text Color */
        .ui-datepicker th {
         color: <?php echo get_option( 'calender_day_text_color' ); ?> !important;
        }

       /* Calender month Text Color */
        .ui-datepicker .ui-datepicker-title {
          color: <?php echo get_option( 'calender_month_text_color' ); ?> !important; 
        }
       /* Calender Header Backgraund Color */
        .ui-datepicker-header {
           background-color: <?php echo get_option( 'calender_header_bg_color' ); ?> !important;
         }

        /* Calender border-color AND radius */
        .ui-corner-all, 
        .ui-corner-bottom, 
        .ui-corner-right, 
        .ui-corner-br {
          -moz-border-radius-bottomright: 4px/*{cornerRadius}*/;
          -webkit-border-bottom-right-radius: 4px/*{cornerRadius}*/;
          -khtml-border-bottom-right-radius: 4px/*{cornerRadius}*/;
          border-bottom-right-radius: 4px/*{cornerRadius}*/;
          border-color: <?php echo get_option( 'calender_border_color' ); ?> !important; 
        }

     
     @media(min-width:768px) and (max-width:1199px){
     
         .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
         
     padding: 1.1em .5em;
font-size: 16px;
}

     }
              @media (min-width: 1200px){
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    padding: 1.4em;
    font-size: 20px;
}
     }
   
      </style>
     
     <?php
    }   
}