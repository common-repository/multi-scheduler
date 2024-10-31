<?php

/**
 * Fired during plugin activation
 *
 * @link       http://scheduler.bdtask.com/
 * @since      1.0.0
 *
 * @package    Msbdt
 * @subpackage Msbdt/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Msbdt
 * @subpackage Msbdt/includes
 * @author     bdtask <bdtask@gmail.com>
 */
class Msbdt_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            global $wpdb ; 

        $charset_collate    = $wpdb->get_charset_collate();
        $table_professional = $wpdb->prefix .'msbdt_professional';
        $table_location     = $wpdb->prefix .'msbdt_location';
        $table_organization = $wpdb->prefix .'msbdt_organization';
        $table_time_slote   = $wpdb->prefix .'msbdt_time_slote';
        $table_booking      = $wpdb->prefix .'msbdt_booking';
        $table_template     = $wpdb->prefix .'msbdt_template';


        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );


       /*============================ create table professional =============================
       =================================================================================*/  
        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_professional;
        $sql .= '  (  ';
        $sql .= 'pro_id INTEGER(10) UNSIGNED AUTO_INCREMENT,  ';
        $sql .= 'fname tinytext NOT NULL,  ';
        $sql .= 'lname tinytext NOT NULL,  ';
        $sql .= 'sex varchar(10)  NOT NULL,  ';
        $sql .= 'email varchar(100)  NULL,  ';
        $sql .= 'contact_no varchar(20)  NULL, ';
        $sql .= 'website varchar(100)  NULL,  ';
        $sql .= 'biographical_info varchar(255)  NULL, ';
        $sql .= 'status varchar(10) NOT NULL,  ';
        $sql .= 'PRIMARY KEY (pro_id),  ';
        $sql .= 'UNIQUE (email) ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_professional = (!$table_professional=='')?dbDelta($sql) : '';

       /*============================ create table location =============================
       =================================================================================*/
        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_location;
        $sql .= '  (  ';
        $sql .= 'loc_id INTEGER(10) UNSIGNED AUTO_INCREMENT,  ';
        $sql .= 'address varchar(255)  NOT NULL,  ';
        $sql .= 'state varchar(100) NOT NULL,  ';
        $sql .= 'city varchar(50) NOT NULL,  ';
        $sql .= 'zip varchar(50)  NOT NULL,  ';
        $sql .= 'status varchar(10) NOT NULL, ';
        $sql .= 'PRIMARY KEY (loc_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_location = (!$table_location  =='')?dbDelta($sql):'';


        /*======================= create table organization ============================
        ================================================================================ */
        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS ';
        $sql .= $table_organization;
        $sql .= '  (  ';
        $sql .= 'org_id INTEGER(10) UNSIGNED AUTO_INCREMENT,  ';
        $sql .= 'name varchar(100)  NOT NULL,  ';
        $sql .= 'email varchar(100)  NOT NULL,  ';
        $sql .= 'contact_no varchar(20) NOT NULL, ';
        $sql .= 'website varchar(100)  NOT NULL,  ';
        $sql .= 'PRIMARY KEY (org_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ;  
        
        $ct_organization = (!$table_organization =='')? dbDelta($sql): '';
       
       

        /*========================== create table time slote =============================
        ================================================================================== */
       

         $sql = '';
         $sql .= "CREATE TABLE IF NOT EXISTS  " ;
         $sql .= $table_time_slote;
         $sql .= '  (  ';
         $sql .= "slot_id INTEGER(10) UNSIGNED AUTO_INCREMENT, ";
         $sql .= "loc_id INTEGER(10) UNSIGNED NOT NULL, ";
         $sql .= "pro_id INTEGER(10) UNSIGNED NOT NULL,  ";
         $sql .= "work_date DATE NOT NULL,  ";
         $sql .= "start_time TIME NOT NULL, ";
         $sql .= "end_time TIME NOT NULL, ";
         $sql .= "int_val INTEGER(10) NOT NULL, ";
         $sql .= "status varchar(10) NOT NULL, ";
         $sql .= "PRIMARY KEY (slot_id), ";
         $sql .= "FOREIGN KEY (loc_id) REFERENCES $table_location(loc_id), ";
         $sql .= "FOREIGN KEY (pro_id) REFERENCES $table_professional(pro_id) ) ";                      
         $ct_time_slote = dbDelta($sql); 


         /*========================== create table booking =============================
        ================================================================================== */


         $sql = '';
         $sql .= "CREATE TABLE IF NOT EXISTS  " ;
         $sql .= $table_booking;
         $sql .= '  (  ';
         $sql .= "id INTEGER(10) UNSIGNED AUTO_INCREMENT, ";
         $sql .= "loc_id INTEGER(10) UNSIGNED NOT NULL, ";
         $sql .= "pro_id INTEGER(10) UNSIGNED NOT NULL,  ";
         $sql .= "name varchar(10) NOT NULL, ";
         $sql .= "email varchar(100) NOT NULL, ";
         $sql .= "phone varchar(10) NOT NULL, ";
         $sql .= "date DATE NOT NULL,  ";
         $sql .= "start_time TIME NOT NULL, ";
         $sql .= "end_time TIME NOT NULL, ";
         $sql .= "message varchar(255) NOT NULL, ";
         $sql .= "status varchar(10) NOT NULL, ";      
         $sql .= "PRIMARY KEY (id), "; 
         $sql .= "FOREIGN KEY (loc_id) REFERENCES $table_location(loc_id), ";   
         $sql .= "FOREIGN KEY (pro_id) REFERENCES $table_professional(pro_id) ) ";

                          
         $ct_mps_booking = dbDelta($sql);


         /*========================== create table template =============================
        ================================================================================== */


        $sql = ' ';
        $sql .= 'CREATE TABLE  IF NOT EXISTS  ';
        $sql .= $table_template;
        $sql .= '  (  ';
        $sql .= 'temp_id INTEGER(10) UNSIGNED AUTO_INCREMENT,  ';
        $sql .= 'temp_name varchar(255)  NOT NULL,  ';
        $sql .= 'template varchar(255)  NOT NULL,  ';
        $sql .= 'status varchar(10) NOT NULL, ';
        $sql .= 'PRIMARY KEY (temp_id)  ';
        $sql .= ' ) ';
        $sql .=  $charset_collate ; 
       
        $ct_template = (!$table_template  =='')?dbDelta($sql):'';
        
	}

}
