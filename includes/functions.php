<?php

class wp_sanitize_functions{

	function _construct(){

		register_activation_hook(__FILE__,'wps_optimization_cron_on'); // run wps_optimization_cron_on at plugin activation
		register_deactivation_hook(__FILE__,'wps_optimization_cron_off'); // run wps_optimization_cron_off at plugin deactivation
	}

	function wps_optimization_cron_on(){
    	wp_schedule_event(time(), 'daily', 'wps_optimize_database'); // rdd wps_optimize_database to wp cron events
	}

	function wps_optimization_cron_off(){
	    wp_clear_scheduled_hook('wps_optimize_database'); // remove wps_optimize_database from wp cron events
	}

	function wps_optimize_database(){
	    global $wpdb; // get access to $wpdb object
	    $all_tables = $wpdb->get_results('SHOW TABLES',ARRAY_A); // get all table names
	    foreach ($all_tables as $tables){ // loop through every table name
	        $table = array_values($tables); // get table name out of array
	        $wpdb->query("OPTIMIZE TABLE ".$table[0]); // run the optimize SQL command on the table

	    }

	}
}

new wp_sanitize_functions;



