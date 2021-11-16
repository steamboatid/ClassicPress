<?php

require_once dirname( __FILE__ ) . '/class-basic-object.php';
require_once dirname( __FILE__ ) . '/class-basic-subclass.php';

/**
 * Retrieves PHPUnit runner version.
 */
function tests_get_phpunit_version() {
	if ( class_exists( 'PHPUnit_Runner_Version' ) ) {
		$version = PHPUnit_Runner_Version::id();
	} elseif ( class_exists( 'PHPUnit\Runner\Version' ) ) {
		$version = PHPUnit\Runner\Version::id();
	} else {
		$version = 0;
	}

	return $version;
}

/**
 * Resets various `$_SERVER` variables that can get altered during tests.
 */
function tests_reset__SERVER() {
	$_SERVER['HTTP_HOST']       = WP_TESTS_DOMAIN;
	$_SERVER['REMOTE_ADDR']     = '127.0.0.1';
	$_SERVER['REQUEST_METHOD']  = 'GET';
	$_SERVER['REQUEST_URI']     = '';
	$_SERVER['SERVER_NAME']     = WP_TESTS_DOMAIN;
	$_SERVER['SERVER_PORT']     = '80';
	$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

	unset( $_SERVER['HTTP_REFERER'] );
	unset( $_SERVER['HTTPS'] );
}

// For adding hooks before loading WP
function tests_add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
	global $wp_filter;

	if ( function_exists( 'add_filter' ) ) {
		add_filter( $tag, $function_to_add, $priority, $accepted_args );
	} else {
		$idx = _test_filter_build_unique_id($tag, $function_to_add, $priority);
		$wp_filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
	}
	return true;
}

function _test_filter_build_unique_id($tag, $function, $priority) {
	if ( is_string($function) )
		return $function;

	if ( is_object($function) ) {
		// Closures are currently implemented as objects
		$function = array( $function, '' );
	} else {
		$function = (array) $function;
	}

	if (is_object($function[0]) ) {
		return spl_object_hash($function[0]) . $function[1];
	} else if ( is_string($function[0]) ) {
		// Static Calling
		return $function[0].$function[1];
	}
}

function _delete_all_data() {
	global $wpdb;

	foreach ( array(
		$wpdb->posts,
		$wpdb->postmeta,
		$wpdb->comments,
		$wpdb->commentmeta,
		$wpdb->term_relationships,
		$wpdb->termmeta
	) as $table ) {
		$wpdb->query( "DELETE FROM {$table}" );
	}

	foreach ( array(
		$wpdb->terms,
		$wpdb->term_taxonomy
	) as $table ) {
		$wpdb->query( "DELETE FROM {$table} WHERE term_id != 1" );
	}

	$wpdb->query( "UPDATE {$wpdb->term_taxonomy} SET count = 0" );

	$wpdb->query( "DELETE FROM {$wpdb->users} WHERE ID != 1" );
	$wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE user_id != 1" );
}

function _delete_all_posts() {
	global $wpdb;

	$all_posts = $wpdb->get_results( "SELECT ID, post_type from {$wpdb->posts}", ARRAY_A );
	if ( ! $all_posts ) {
		return;
	}

	foreach ( $all_posts as $data ) {
		if ( 'attachment' === $data['post_type'] ) {
			wp_delete_attachment( $data['ID'], true );
		} else {
			wp_delete_post( $data['ID'], true );
		}
	}
}

function _wp_die_handler( $message, $title = '', $args = array() ) {
	if ( !$GLOBALS['_wp_die_disabled'] ) {
		_wp_die_handler_txt( $message, $title, $args);
	} else {
		//Ignore at our peril
	}
}

function _disable_wp_die() {
	$GLOBALS['_wp_die_disabled'] = true;
}

function _enable_wp_die() {
	$GLOBALS['_wp_die_disabled'] = false;
}

function _wp_die_handler_filter() {
	return '_wp_die_handler';
}

function _wp_die_handler_filter_exit() {
	return '_wp_die_handler_exit';
}

function _wp_die_handler_txt( $message, $title, $args ) {
	echo "\nwp_die called\n";
	echo "Message : $message\n";
	echo "Title : $title\n";
	if ( ! empty( $args ) ) {
		echo "Args: \n";
		foreach( $args as $k => $v ){
			echo "\t $k : $v\n";
		}
	}
}

function _wp_die_handler_exit( $message, $title, $args ) {
	echo "\nwp_die called\n";
	echo "Message : $message\n";
	echo "Title : $title\n";
	if ( ! empty( $args ) ) {
		echo "Args: \n";
		foreach( $args as $k => $v ){
			echo "\t $k : $v\n";
		}
	}
	exit( 1 );
}

/**
 * Set a permalink structure.
 *
 * Hooked as a callback to the 'populate_options' action, we use this function to set a permalink structure during
 * `wp_install()`, so that WP doesn't attempt to do a time-consuming remote request.
 *
 * @since WP-4.2.0
 */
function _set_default_permalink_structure_for_tests() {
	update_option( 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/' );
}

/**
 * Helper used with the `upload_dir` filter to remove the /year/month sub directories from the uploads path and URL.
 */
function _upload_dir_no_subdir( $uploads ) {
	$subdir = $uploads['subdir'];

	$uploads['subdir'] = '';
	$uploads['path'] = str_replace( $subdir, '', $uploads['path'] );
	$uploads['url'] = str_replace( $subdir, '', $uploads['url'] );

	return $uploads;
}

/**
 * Helper used with the `upload_dir` filter to set https upload URL.
 */
function _upload_dir_https( $uploads ) {
	$uploads['url'] = str_replace( 'http://', 'https://', $uploads['url'] );
	$uploads['baseurl'] = str_replace( 'http://', 'https://', $uploads['baseurl'] );

	return $uploads;
}

// Skip `setcookie` calls in auth_cookie functions due to warning:
// Cannot modify header information - headers already sent by ...
tests_add_filter( 'send_auth_cookies', '__return_false' );



function get_caller_func(int $max=1): array {
	$arr=		debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3*$max + 3);
	$lines=	array();
	foreach ($arr as $trace){
		$str=	implode(' ', $trace);
		if (stristr($trace['function'], 'print_rr')) continue;
		if (stristr($trace['function'], 'print_rdie')) continue;
		if (stristr($str, 'swo.php') || stristr($str, 'load.php') || stristr($str, 'amp.php')) continue;

		if (empty($trace['file']) || empty($trace['line'])) continue;
		if (empty($aline)) $lines[]=	$trace['file'] . ' -- ' . $trace['line'];

		if (!empty($lines) && count($lines)>=$max) break;
	}

	return $lines;
}

function print_rr($var){

	$obs=		0;
	$buff=	array();
	while (ob_get_level()) {
		$obs++;
		$buff[]=	ob_get_contents();
		ob_end_clean();
		flush();
	}

	echo "\n\n-- ";
	echo	rtrim(print_r($var, true), "\n");
	echo " --\n";
	flush();

	$arr=		debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
	$strs=	array("\n\nCALLER-print_rr: ");
	foreach ($arr as $trc){
		if ($trc['file'] && $trc['line'])
			$strs[]=	$trc['file']." -- ".$trc['line'];
		if (count($strs) > 5) break;
	}
	echo implode("\n", $strs) .  (empty($buff)? "\n\n" : "\n\n\n" . implode("\n\n", $buff) . "\n\n\n");
}

function print_rdie($var='', $msg=''){

	$obs=		0;
	$buff=	array();
	while (ob_get_level()>0) {
		$obs++;
		$buff[]=	ob_get_contents();
		ob_end_clean();
		flush();
	}

	echo "\n\n";
	echo is_null($var)? rtrim(var_export($var, true)) : rtrim(print_r($var, true))."\n\t$msg \n";
	flush();

	// print caller
	$arr=		debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
	$strs=	array("\n\nCALLER-print_rdie: ");
	foreach ($arr as $trc){
		if ($trc['file'] && $trc['line'])
			$strs[]=	$trc['file']." -- ".$trc['line'];
		if (count($strs) > 5) break;
	}

	$strs[]=	"\n".date('c');
	$strs[]=	time();
	echo implode("\n", $strs) .  (empty($buff)? "\n\n" : "\n\n\n" . implode("\n\n", $buff) . "\n\n\n");
	flush();
	die();
}

function print_rdiefile(){

	$arr=	debug_backtrace();
	$arr=	array_shift($arr);
	$arr=	array($arr['file'], $arr['line']);
	$str=	implode(" ", $arr);
	print_rdie($str);
}
