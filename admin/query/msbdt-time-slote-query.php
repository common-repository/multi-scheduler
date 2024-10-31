<?php
class Msbdt_Schedule{
  /**
   *@param msbdt_schedule_add_process_data() // Return status // insert //update // edit // delete
   *@since 1.0.0
   *@return string/array(for empty field).
   */  

  public static function msbdt_schedule_add_process_data($id=null){
     
      global $wpdb;      
      $table_name = $wpdb->prefix.'msbdt_time_slote';
      $errors = array();  

      $add_schedule_submit = isset( $_POST['add_schedule_submit'] ) ?
                             sanitize_text_field( $_POST['add_schedule_submit'] ) :'';
        
      if( isset($add_schedule_submit) && $add_schedule_submit !== '' ):    
           
         $schedule['slot_id']    = intval($_POST['slot_id']);
         $schedule['loc_id']     = intval($_POST['loc_id']);
         $schedule['pro_id']     = intval($_POST['pro_id']);
         $schedule['work_date']  = sanitize_text_field($_POST['work_date']);      
         $schedule['start_time'] = sanitize_text_field($_POST['start_time']);
         $schedule['end_time']   = sanitize_text_field($_POST['end_time']);
         $schedule['int_val']    = isset( $_POST['int_val'] ) ?
                                   intval( $_POST['int_val'] ) :'';
      
                 
         (empty($schedule['work_date']))? $errors['work_date'] = 'Error: required !':'';
         (empty($schedule['loc_id']))? $errors['loc_id'] = 'Error: required !':'';
         (empty($schedule['pro_id']))? $errors['pro_id'] = 'Error: required !':'';
         (empty($schedule['start_time']))? $errors['start_time'] = 'Error: required !':'';
         (empty($schedule['end_time']))? $errors['end_time'] = 'Error: End time is required !':'';
        
                
          if(!empty($errors)):
               return $errors ; 

           elseif( $schedule['slot_id'] != '0') : 

               
                $date = new DateTime($schedule['work_date']);
                $schedule['work_date'] = $date->format('Y:m:d');

                $schedule['start_time'] = new DateTime($schedule['start_time']);
                $schedule['start_time'] = $schedule['start_time']->format('H:i:s');

                $schedule['end_time'] = new DateTime($schedule['end_time']);
                $schedule['end_time'] = $schedule['end_time']->format('H:i:s');
               
                $update_schedule = $wpdb->update( 
                          $table_name , 
                          array( 
                            'loc_id'     => $schedule['loc_id'] , // column & new value
                            'pro_id'     => $schedule['pro_id'] , // column & new value
                            'work_date'  => $schedule['work_date'] , // column & new value
                            'start_time' => $schedule['start_time'] , // column & new value
                            'end_time'   => $schedule['end_time']  // column & new value  
                         ), 
                          array( 'slot_id' => $schedule['slot_id'] ) ,  // where clause(s)
                          array( '%d' , '%d', '%s', '%s', '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        ); 

                $status = ($update_schedule)? 'no_error_data_update_successfully' : 'something_is_error';                 
                return $status;
          else :  

                $dateArray = explode(",", $schedule['work_date']);  
                $count = count( $dateArray);            
                $syn = 0;
                           
                for($i = 0; $i < $count ; $i++):
                                   
                    $date = new DateTime($dateArray[$i]);
                    $schedule['work_date'] = $date->format('Y:m:d');

                    $schedule['start_time'] = new DateTime($schedule['start_time']);
                    $schedule['start_time'] = $schedule['start_time']->format('H:i:s');

                    $schedule['end_time'] = new DateTime($schedule['end_time']);
                    $schedule['end_time'] = $schedule['end_time']->format('H:i:s');

                    $query = $wpdb->get_results("
                                     INSERT INTO `$table_name`
                                     (`slot_id`, `loc_id`, `pro_id`, `work_date`, `start_time`, `end_time`, `int_val`, `status`)
                                     VALUES (  
                                            '',
                                            '".$schedule['loc_id']."', 
                                            '".$schedule['pro_id']."',
                                            '".$schedule['work_date']."',
                                            '".$schedule['start_time']."',
                                            '".$schedule['end_time']."',
                                            '".$schedule['int_val']."',
                                            '1' ) ;" 
                                      ) ;             

                      $syn++;
                 
                  endfor ;
  
          endif;
                                  
               $status = (empty($query) && ($syn == $count))? 'no_error_data_save_successfully' : 'something_is_error';                 
               return $status;
            
      elseif(isset($_POST['slote_delete']) ):       
          $schedule['slot_delete_id'] = intval($_POST['slot_delete_id']);
          $delete = $wpdb->delete( 
                        $table_name ,      // table name 
                        array( 'slot_id' => $schedule['slot_delete_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );
          $status = ($delete)? 'no_error_data_delete_successfully' : 'something_is_error_for_relative_data';
          return $status;
        
      endif ;
    
    }

    /**
   *@param  msbdt_select_added_all_schedule($id = null )/ Return $query OR $result / select data //.
   *@since  1.0.0
   *@return String OR Array(when id is set)
   */  

  public static function  msbdt_select_added_all_schedule($id = null){
        
          global $wpdb;      
          $table_name = $wpdb->prefix.'msbdt_time_slote'; 
          $count = 0; 
          $query  = "SELECT * FROM  $table_name  WHERE  ";

          if( isset( $id ) && (! $id == null ) ) :
                   $query .= "  slot_id = '".$id."'  ";                 
                   $count++; 
                   $results = $wpdb->get_row($query);
                   return $results;
          endif; 

          if($count == 0):
                  $query .= " 1 ORDER BY slot_id DESC";
                  return $query ;
          endif;                  
   }

} /* / class Msbdt_Schedule */