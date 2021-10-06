<?php

/**
 * @group general
 */
class Tests_General_Archives extends WP_UnitTestCase {
	function setUp() {
		parent::setUp();

		wp_cache_delete( 'last_changed', 'posts' );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/23206
	 */
	function test_get_archives_cache() {
		global $wpdb;

		self::factory()->post->create_many( 3, array( 'post_type' => 'post' ) );
		wp_cache_delete( 'last_changed', 'posts' );
		$this->assertFalse( wp_cache_get( 'last_changed', 'posts' ) );

		$num_queries = $wpdb->num_queries;

		// Cache is not primed, expect 1 query.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'monthly', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'monthly',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$time1 = wp_cache_get( 'last_changed', 'posts' );
		$this->assertNotEmpty( $time1 );
		$this->assertSame( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Cache is primed, expect no queries.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'monthly', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'monthly',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries, $wpdb->num_queries );

		// Change args, resulting in a different query string. Cache is not primed, expect 1 query.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'monthly', 'echo' => false, 'order' => 'ASC' ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type'  => 'monthly',
				'echo'  => false,
				'order' => 'ASC',
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Cache is primed, expect no queries.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'monthly', 'echo' => false, 'order' => 'ASC' ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type'  => 'monthly',
				'echo'  => false,
				'order' => 'ASC',
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Change type. Cache is not primed, expect 1 query.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'yearly', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'yearly',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Cache is primed, expect no queries.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'yearly', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'yearly',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries, $wpdb->num_queries );

		// Change type. Cache is not primed, expect 1 query.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'daily', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'daily',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Cache is primed, expect no queries.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'daily', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'daily',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries, $wpdb->num_queries );

		// Change type. Cache is not primed, expect 1 query.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'weekly', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'weekly',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Cache is primed, expect no queries.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'weekly', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'weekly',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries, $wpdb->num_queries );

		// Change type. Cache is not primed, expect 1 query.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'postbypost', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'postbypost',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries + 1, $wpdb->num_queries );

		$num_queries = $wpdb->num_queries;

		// Cache is primed, expect no queries.
<<<<<<< HEAD:tests/phpunit/tests/general/archives.php
		$result = wp_get_archives( array( 'type' => 'postbypost', 'echo' => false ) );
		$this->assertInternalType( 'string', $result );
=======
		$result = wp_get_archives(
			array(
				'type' => 'postbypost',
				'echo' => false,
			)
		);
		$this->assertIsString( $result );
>>>>>>> bca693b190 (Build/Test Tools: Replace `assertInternalType()` usage in unit tests.):tests/phpunit/tests/general/wpGetArchives.php
		$this->assertSame( $time1, wp_cache_get( 'last_changed', 'posts' ) );
		$this->assertSame( $num_queries, $wpdb->num_queries );
	}
}
