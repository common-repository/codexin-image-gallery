<?php
/**
 * Gallery field extend
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/includes
 */

use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Gallery\Gallery_Field;

define( 'Carbon_Field_Gallery\\DIR', __DIR__ );

Carbon_Fields::extend(
	Gallery_Field::class,
	function( $container ) {
		return new Gallery_Field(
			$container['arguments']['type'],
			$container['arguments']['name'],
			$container['arguments']['label']
		);
	}
);
