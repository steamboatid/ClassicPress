<?php

/**
 * @group option
 */
class Tests_Option_Theme_Mods extends WP_UnitTestCase {

	public function test_theme_mod_default() {
		$this->assertFalse( get_theme_mod( 'non_existent' ) );
	}

	public function test_theme_mod_defined_default() {
		$this->assertSame( 'default', get_theme_mod( 'non_existent', 'default' ) );
	}

	public function test_theme_mod_set() {
		$expected = 'value';
		set_theme_mod( 'test_name', $expected );
		$this->assertSame( $expected, get_theme_mod( 'test_name' ) );
	}

	public function test_theme_mod_update() {
		set_theme_mod( 'test_update', 'first_value' );
		$expected = 'updated_value';
		set_theme_mod( 'test_update', $expected );
		$this->assertSame( $expected, get_theme_mod( 'test_update' ) );
	}

	public function test_theme_mod_remove() {
		set_theme_mod( 'test_remove', 'value' );
		remove_theme_mod( 'test_remove' );
		$this->assertFalse( get_theme_mod( 'test_remove' ) );
	}
}
