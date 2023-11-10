<?php

namespace WPGraphQL\Type\ObjectType;

use GraphQLRelay\Relay;

/**
 * Class EnqueuedStylesheet
 *
 * @package WPGraphQL\Type\Object
 */
class EnqueuedStylesheet {

	/**
	 * Register the EnqueuedStylesheet Type
	 *
	 * @return void
	 */
	public static function register_type() {
		register_graphql_object_type(
			'EnqueuedStylesheet',
			[
				'description' => __( 'Stylesheet enqueued by the CMS', 'wp-graphql' ),
				'interfaces'  => [ 'Node', 'EnqueuedAsset' ],
				'fields'      => [
					'id'      => [
						'type'        => [ 'non_null' => 'ID' ],
						'description' => __( 'The global ID of the enqueued stylesheet', 'wp-graphql' ),
						'resolve'     => static function ( $asset ) {
							return ! empty( $asset->handle ) ? Relay::toGlobalId( 'enqueued_stylesheet', $asset->handle ) : null;
						},
					],
					'isRtl'   => [
						'type'        => 'Boolean',
						'description' => __( 'Whether the enqueued style is RTL or not', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							return ! empty( $stylesheet->extra['rtl'] );
						},
					],
					'media'   => [
						'type'        => 'String',
						'description' => __( 'The media attribute to use for the link', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							return ! empty( $stylesheet->args ) && is_string( $stylesheet->args ) ? esc_attr( $stylesheet->args ) : 'all';
						},
					],
					'path'    => [
						'type'        => 'String',
						'description' => __( 'The absolute path to the enqueued style. Set when the stylesheet is meant to load inline.', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							return ! empty( $stylesheet->extra['path'] ) && is_string( $stylesheet->extra['path'] ) ? $stylesheet->extra['path'] : null;
						},
					],
					'rel'     => [
						'type'        => 'String',
						'description' => __( 'The `rel` attribute to use for the link', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							return ! empty( $stylesheet->extra['alt'] ) ? 'alternate stylesheet' : 'stylesheet';
						},
					],
					'suffix'  => [
						'type'        => 'String',
						'description' => __( 'Optional suffix, used in combination with RTL', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							return ! empty( $stylesheet->extra['suffix'] ) && is_string( $stylesheet->extra['suffix'] ) ? $stylesheet->extra['suffix'] : null;
						},
					],
					'title'   => [
						'type'        => 'String',
						'description' => __( 'The title of the enqueued style. Used for preferred/alternate stylesheets.', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							return ! empty( $stylesheet->extra['title'] ) && is_string( $stylesheet->extra['title'] ) ? $stylesheet->extra['title'] : null;
						},
					],
					'version' => [
						'type'        => 'String',
						'description' => __( 'The version of the enqueued style', 'wp-graphql' ),
						'resolve'     => static function ( \_WP_Dependency $stylesheet ) {
							global $wp_styles;

							return ! empty( $stylesheet->ver ) && is_string( $stylesheet->ver ) ? $stylesheet->ver : $wp_styles->default_version;
						},
					],
				],
			]
		);
	}
}
