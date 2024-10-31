<?php 
class Msbdt_Booking_Public{
	 public static function msbdt_public_appointment_process($schedule = ''){
   
        global $wpdb;      
        $table_mps_booking  = $wpdb->prefix.'msbdt_booking';
        $table_status       = $wpdb->prefix .'msbdt_status';
        $errors = array();
       
        $add_schedule_submit = isset( $_POST['add_schedule_submit'] ) ?
                               sanitize_text_field( $_POST['add_schedule_submit'] ) :'';
        
        if( isset($add_schedule_submit) && $add_schedule_submit !== '' ):
                         
           $schedule['name']        = sanitize_text_field( $_POST['schedule_name']  );          
           $schedule['email']       = sanitize_email( $_POST['schedule_email'] );
           $schedule['phone']       = sanitize_text_field( $_POST['schedule_phone']  );
           $schedule['loc_id']      = intval( $_POST['schedule_loc_id'] );
           $schedule['pro_id']      = intval( $_POST['schedule_pro_id'] );
           $schedule['date']        = sanitize_text_field( $_POST['schedule_date'] );
           $schedule['start_time']  = sanitize_text_field( $_POST['schedule_start_time'] );
           $schedule['end_time']    = sanitize_text_field( $_POST['schedule_end_time'] );
           $schedule['message']     = sanitize_text_field( $_POST['schedule_message'] );

           /* default set */
           if ( ! $schedule['loc_id'] ) : 
               return ;
           endif;
           if ( ! $schedule['pro_id'] ) : 
               return ; 
           endif;
        
           /* empty message */
           (empty($schedule['name']))? $errors['name']   = get_option('frontend_error_message'):'required !';
           (empty($schedule['email']))? $errors['email'] = get_option('frontend_error_message'):'required !';
           (empty($schedule['phone']))? $errors['phone'] = get_option('frontend_error_message'):'required !';
           (empty($schedule['date']))? $errors['date']   = get_option('frontend_error_message'):'required !';
          
           (empty($schedule['start_time']) && empty($schedule['end_time']))?
                                       $errors['date'] = get_option('frontend_error_message'):'required !';

           (empty($schedule['message']))? $errors['message'] = get_option('frontend_error_message'):'required !'; 

           // for request status   
           $schedule['status'] = '4' ;          

           if(!empty($errors)) :
             return $errors ;
          
            else :

            $date                   = new DateTime($schedule['date']);
            $schedule['date']       = $date->format('Y-m-d');
            $schedule['start_time'] = new DateTime($schedule['start_time']);
            $schedule['start_time'] = $schedule['start_time']->format('H:i:s');
            $schedule['end_time']   = new DateTime($schedule['end_time']);
            $schedule['end_time']   = $schedule['end_time']->format('H:i:s');

          
            $sql = "INSERT INTO  $table_mps_booking  
		            (`id`, `loc_id`, `pro_id`, `name`, `email`, `phone`, `date`, `start_time`, `end_time`, `message`, `status`)VALUES 
		                ('',
		                 '".$schedule['loc_id']."',
		                 '".$schedule['pro_id']."',
		                 '".$schedule['name']."',
		                 '".$schedule['email']."',
		                 '".$schedule['phone']."',
		                 '".$schedule['date']."',
		                 '".$schedule['start_time']."',
		                 '".$schedule['end_time']."',
		                 '".$schedule['message']."',
		                 '".$schedule['status']."' ) " ;
            
                 $appointment = $wpdb->query($sql); 				         
                 $status = ($appointment)? 
                 'no_error_data_save_successfully' : 
                 'something_is_error';                             
                 return $status;           

               endif ;

            endif ;
    }

} /* / class Msbdt_Booking_Public  */