<?php

/**
 * @group wp
 */
class Tests_WP extends WP_UnitTestCase {
	/**
	 * @var WP
	 */
	protected $wp;

<<<<<<< HEAD
	public function setUp() {
=======
	public function set_up() {
		parent::set_up();
>>>>>>> ddb409edca (Build/Test Tools: Implement use of the `void` solution.)
		$this->wp = new WP();
	}

	public function test_add_query_var() {
		$public_qv_count = count( $this->wp->public_query_vars );

		$this->wp->add_query_var( 'test' );
		$this->wp->add_query_var( 'test2' );
		$this->wp->add_query_var( 'test' );

		$this->assertSame( $public_qv_count + 2, count( $this->wp->public_query_vars ) );
		$this->assertTrue( in_array( 'test', $this->wp->public_query_vars ) );
		$this->assertTrue( in_array( 'test2', $this->wp->public_query_vars ) );
	}

	public function test_remove_query_var() {
		$public_qv_count = count( $this->wp->public_query_vars );

		$this->wp->add_query_var( 'test' );
		$this->assertTrue( in_array( 'test', $this->wp->public_query_vars ) );
		$this->wp->remove_query_var( 'test' );

		$this->assertSame( $public_qv_count, count( $this->wp->public_query_vars ) );
	}
}
