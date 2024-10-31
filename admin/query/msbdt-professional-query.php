<?php 
class Msbdt_Professional{
 
  public static function  msbdt_professional_add_process_data($args = null){
       
        global $wpdb;      
        $table_name = $wpdb->prefix.'msbdt_professional';
        $errors = array();     
       
        $add_professional_submit = isset( $_POST['add_professional_submit'] ) ?
                             sanitize_text_field( $_POST['add_professional_submit'] ) :'';
        
        if( isset($add_professional_submit) && $add_professional_submit !== '' ):      
           $professional['pro_id']            = intval($_POST['pro_id']);
           $professional['fname']             = sanitize_text_field($_POST['fname']);
           $professional['lname']             = sanitize_text_field($_POST['lname']);
           $professional['sex']               = sanitize_text_field($_POST['sex']);
           $professional['email']             = sanitize_text_field($_POST['email']);
           $professional['contact_no']        = sanitize_text_field($_POST['contact_no']);
           $professional['website']           = sanitize_text_field($_POST['website']);
           $professional['biographical_info'] = sanitize_text_field($_POST['biographical_info']);
        
           (empty($professional['fname']))? $errors['fname'] = 'Error: required !':'';
           (empty($professional['lname']))? $errors['lname'] = 'Error: required !':'';
           (empty($professional['sex']))? $errors['sex'] = 'Error: required !':'';
           (empty($professional['email']))? $errors['email'] ='Error: required !':'';
           (empty($professional['contact_no']))? $errors['contact_no']='Error: required!':'';
          
         if(!empty($errors)) :
             return $errors ;

          elseif( $professional['pro_id'] != '0' ) : 
               
               
          $update_professional = $wpdb->update( 
                      $table_name , 
                      array( 
                        'fname'             => $professional['fname'] , // column & new value
                        'lname'             => $professional['lname'] , // column & new value
                        'sex'               => $professional['sex'] , // column & new value
                        'email'             => $professional['email'] , // column & new value
                        'contact_no'        => $professional['contact_no'] , // column & new value
                        'website'           => $professional['website'] , // column & new value
                        'biographical_info' => $professional['biographical_info']  // column & new value
                     ), 
                      array( 'pro_id' => $professional['pro_id'] ) ,  // where clause(s)
                      array( '%s' , '%s', '%s', '%s' , '%s' , '%s', '%s') , 
                      // column & new value type.
                      array( '%d' ) // where clause(s) format types  
                    ); 
                          
                $status = ($update_professional)? 'no_error_data_update_successfully' : 'something_is_error';                 
                return $status;
          
            else :
            $add_new_professional =  $wpdb->insert( 
                                     $table_name, 
                                     array(                  
                                        'pro_id'            => '',
                                        'fname'             => $professional['fname'],
                                        'lname'             => $professional['lname'],
                                        'sex'               => $professional['sex'],
                                        'email'             => $professional['email'],
                                        'contact_no'        => $professional['contact_no'],
                                        'website'           => $professional['website'] ,
                                        'biographical_info' => $professional['biographical_info'],
                                        'status'            => '1'));

          
                 $status = ($add_new_professional)? 'no_error_data_save_successfully' : 'something_is_error';                 
                 return $status;           

            endif ;

        elseif( isset($_POST['professional_delete']) ):
          $professional['pro_delete_id'] = intval( $_POST['pro_delete_id'] ) ;       
          $delete = $wpdb->delete( 
                        $table_name ,      // table name 
                        array( 'pro_id' => $professional['pro_delete_id'] ),  // where clause 
                        array( '%d' )      // where clause data type (int)
                    );       
          $status = ($delete)? 'no_error_data_delete_successfully' : 'something_is_error_for_relative_data';
          return $status;
        endif ;

     }

  /**
   *@param  msbdt_select_added_all_professional($id = null )/Return $query OR $result/can select data //.
   *@since  1.0.0
   *@return String OR Array(when id is set)
   */  
   public static function  msbdt_select_added_all_professional($id = null){
          global $wpdb;      
          $table_name = $wpdb->prefix.'msbdt_professional'; 
          $count = 0; 
          $query  = "SELECT  * FROM  $table_name  WHERE  ";

          if( isset( $id ) && (! $id == null ) ) :
                   $query .= "  pro_id = '".$id."'  ";                 
                   $count++; 
                   $results = $wpdb->get_row($query);
                   return $results;
          endif; 

          if($count == 0):
                  $query .= " 1 ORDER BY pro_id DESC";                
                  return $query ;
          endif;
                
   }

} /*  / class Msbdt_Professional */