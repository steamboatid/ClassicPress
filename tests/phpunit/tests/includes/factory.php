<?php

class TestFactoryFor extends WP_UnitTestCase {

	function test_create_creates_a_category() {
		$id = self::factory()->category->create_object( array( 'name' => 'BooBoo1') );
		$this->assertTrue( (bool) get_term_by( 'id', $id, 'category' ) );
	}

	function test_get_object_by_id_gets_an_object() {
		$id = self::factory()->category->create_object( array( 'name' => 'BooBoo2') );
		$this->assertTrue( (bool) self::factory()->category->get_object_by_id( $id ) );
	}

	function test_get_object_by_id_gets_an_object_with_the_same_name() {
		$id = self::factory()->category->create_object( array( 'name' => 'Boo') );
		$object = self::factory()->category->get_object_by_id( $id );
		$this->assertSame( 'Boo', $object->name );
	}

	function test_the_taxonomy_argument_overrules_the_factory_taxonomy() {
		$id = self::factory()->term->create_and_get( array( 'taxonomy' => 'post_tag' ) );
		$term = get_term( $id, 'post_tag' );
		$this->assertSame( $id->term_id, $term->term_id );
	}

	/**
	 * @see https://core.trac.wordpress.org/ticket/32536
	 */
	public function test_term_factory_create_and_get_should_return_term_object() {
		register_taxonomy( 'wptests_tax', 'post' );
		$term = self::factory()->term->create_and_get( array( 'taxonomy' => 'wptests_tax' ) );
		$this->assertIsObject( $term );
		$this->assertNotEmpty( $term->term_id );
	}
}
