<?php
class Msbdt_Location{

	/**
   *@param msbdt_location_add_process_data() // Return $status // can update // edit // delete
   *@since 1.0.0
   *@return string.
   */ 
   public static function  msbdt_location_add_process_data( $args = null ){
     
      global $wpdb ; 
   
      $table_location = $wpdb->prefix.'msbdt_location';
     
      $errors = array(); 

      $add_location_submit = isset( $_POST['add_location_submit'] ) ?
                             sanitize_text_field( $_POST['add_location_submit'] ) :'';
        
      if( isset($add_location_submit) && $add_location_submit !== '' ):
                                 
             $location['loc_id']   = intval( $_POST['location_loc_id']  );  
             $location['address']  = sanitize_text_field( $_POST['location_address']  );  
             $location['state']    = sanitize_text_field( $_POST['location_state']  );  
             $location['city']     = sanitize_text_field( $_POST['location_city']  );  
             $location['zip']      = intval( $_POST['location_zip']  );            

             (empty($location['address']))? $errors['address'] = 'Error: required !':'';
             (empty($location['state']))? $errors['state'] = 'Error: required !':'';
             (empty($location['city']))? $errors['city'] = 'Error: required !':'';
             (empty($location['zip']))? $errors['zip']='Error: required !':'';           
             
             if( !empty($errors)  ):

             return $errors ;

             elseif( $location['loc_id'] != '0' ) : 
              
             $update_location = $wpdb->update( 
                          $table_location, 
                          array( 
                            'address' => $location['address'] , // column & new value
                            'state'   => $location['state'] , // column & new value
                            'city'    => $location['city'] , // column & new value
                            'zip'     => $location['zip']  // column & new value
                         ), 
                          array( 'loc_id' => $location['loc_id'] ) ,  // where clause(s)
                          array( '%s' , '%s', '%s', '%s') , // column & new value type.
                          array( '%d' ) // where clause(s) format types  
                        ); 
               
              
              $status = ($update_location)? 
                        'no_error_data_update_successfully' : 
                        'something_is_error';                 
                 return $status;

              else:
                
                 $add_new_location =  $wpdb->insert( 
                                                $table_location, 
                                                array(                  
                                                  'loc_id' => '',
                                                  'address'=> $location['address'],
                                                  'state'  => $location['state'],
                                                  'city'   => $location['city'],
                                                  'zip'    => $location['zip'],            
                                                  'status' => '1' ));
               
                   $status = ($add_new_location)? 'no_error_data_save_successfully' : 'something_is_error';                 
                   return $status;

              endif ;
        

        elseif(isset($_POST['location_delete']) ):
         
          $location['loc_delete_id'] = intval( $_POST['loc_delete_id'] ) ;
          $delete = $wpdb->delete( 
                        $table_location,      // table name 
                        array( 'loc_id' => $location['loc_delete_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );
          $status = ($delete)? 'no_error_data_delete_successfully' : 'something_is_error_for_relative_data';
          return $status;
        
        endif ;
    
    }

/**
 *@param msbdt_select_added_all_location($id = null).
 *@since 1.0.0
 *@return string ($query) or $results.
 */ 
  public static function  msbdt_select_added_all_location( $id = null ){
          global $wpdb;      
          $table_name = $wpdb->prefix.'msbdt_location';
          $count = 0; 
          $query  = "SELECT * FROM  $table_name  WHERE  ";       
          if( isset($id) && (! $id ==null) ) :
                   $query .= "  loc_id = '".$id."'  ";                 
                   $count++; 
                   $results = $wpdb->get_row($query);
                   return $results;
          endif;        
          if($count == 0):
                  $query .= " 1 ORDER BY loc_id DESC ";
                  return $query ;
          endif;       
  }

}/*  / class Msbdt_Location */
