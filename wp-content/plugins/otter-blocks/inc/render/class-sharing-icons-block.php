<?php
/**
 * Icons block.
 *
 * @package ThemeIsle\GutenbergBlocks\Render
 */

namespace ThemeIsle\GutenbergBlocks\Render;

use ThemeIsle\GutenbergBlocks\CSS\Blocks\Sharing_Icons_CSS;

/**
 * Class Sharing_Icons_Block
 */
class Sharing_Icons_Block {

	/**
	 * Return attributes for social media services.
	 *
	 * @param string|null $context Context of the sharing icons block.
	 *
	 * @return array
	 */
	public static function get_social_profiles( $context = null ) {
		$current_url = home_url( add_query_arg( null, null ) );
		$title       = get_the_title( get_queried_object_id() );

		if ( is_archive() ) {
			$title = get_the_archive_title();
		} elseif ( 'query' === $context ) {
			$current_url = get_the_permalink();
			$title       = get_the_title();
		} elseif ( null === get_queried_object() && is_home() ) {
			$title = get_bloginfo( 'name' );
		}

		$social_attributes = array(
			'facebook'  => array(
				'label' => esc_html__( 'Facebook', 'otter-blocks' ),
				'icon'  => 'fab fa-facebook-f',
				'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . esc_url( $current_url ) . '&title=' . esc_attr( $title ),
			),

			'twitter'   => array(
				'label' => esc_html__( 'Twitter', 'otter-blocks' ),
				'icon'  => 'fab fa-twitter',
				'url'   => 'http://twitter.com/share?url=' . esc_url( $current_url ) . '&text=' . esc_attr( $title ),
			),

			'linkedin'  => array(
				'label' => esc_html__( 'Linkedin', 'otter-blocks' ),
				'icon'  => 'fab fa-linkedin-in',
				'url'   => 'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url( $current_url ) . '&title=' . esc_attr( $title ),
			),

			'pinterest' => array(
				'label' => esc_html__( 'Pinterest', 'otter-blocks' ),
				'icon'  => 'fab fa-pinterest-p',
				'url'   => 'https://pinterest.com/pin/create/button/?url=' . esc_url( $current_url ) . '&description=' . esc_attr( $title ),
			),

			'tumblr'    => array(
				'label' => esc_html__( 'Tumblr', 'otter-blocks' ),
				'icon'  => 'fab fa-tumblr',
				'url'   => 'https://tumblr.com/share/link?url=' . esc_url( $current_url ) . '&name=' . esc_attr( $title ),
			),

			'reddit'    => array(
				'label' => esc_html__( 'Reddit', 'otter-blocks' ),
				'icon'  => 'fab fa-reddit-alien',
				'url'   => 'https://www.reddit.com/submit?url=' . esc_url( $current_url ),
			),

			'whatsapp'  => array(
				'label' => esc_html__( 'WhatsApp', 'otter-blocks' ),
				'icon'  => 'fab fa-whatsapp',
				'url'   => 'https://api.whatsapp.com/send?text=' . esc_url( $current_url ),
			),

			'email'     => array(
				'label' => esc_html__( 'Email', 'otter-blocks' ),
				'icon'  => 'fa fa-envelope',
				'url'   => 'mailto:?subject=' . esc_attr( $title ) . '&body=' . esc_url( $current_url ),
			),

			'telegram'  => array(
				'label' => esc_html__( 'Telegram', 'otter-blocks' ),
				'icon'  => 'fab fa-telegram-plane',
				'url'   => 'https://telegram.me/share/url?url=' . esc_url( $current_url ) . '&text=' . esc_attr( $title ),
			),

			'mastodon'  => array(
				'label' => esc_html__( 'Mastodon', 'otter-blocks' ),
				'icon'  => 'fab fa-mastodon',
				'url'   => 'https://mastodonshare.com/?text=' . esc_url( $current_url ),
			),

			'comments'  => array(
				'label'   => esc_html__( 'Comments', 'otter-blocks' ),
				'icon'    => 'fa fa-comments-o',
				'url'     => get_comments_number( get_the_ID() ) ? '#comments' : '#respond',
				'new_tab' => false,
			),
		);

		return $social_attributes;
	}

	/**
	 * Checks if an icon is active and should be visible
	 *
	 * @param array|int $icon Icon to check.
	 *
	 * @return bool
	 */
	private function is_active( $icon ) {
		return ( ( isset( $icon['active'] ) && true === filter_var( $icon['active'], FILTER_VALIDATE_BOOLEAN ) ) || 1 === $icon );
	}

	/**
	 * Block render function for server-side.
	 *
	 * This method will pe passed to the render_callback parameter and it will output
	 * the server side output of the block.
	 *
	 * @param array $attributes Blocks attrs.
	 * @return mixed|string
	 */
	public function render( $attributes ) {
		$social_attributes = $this->get_social_profiles( isset( $attributes['context'] ) ? $attributes['context'] : null );

		$class = '';

		if ( isset( $attributes['align'] ) ) {
			$class .= ' align' . esc_attr( $attributes['align'] );
		}

		$wrapper_attributes = get_block_wrapper_attributes( isset( $attributes['id'] ) ? [ 'id' => $attributes['id'] ] : [] );

		$html = '<div ' . $wrapper_attributes . '><div class="social-icons-wrap">';
		foreach ( $social_attributes as $key => $icon ) {
			if ( 'className' !== $key && $this->is_active( $attributes[ $key ] ) ) {
				$new_tab = isset( $icon['new_tab'] ) && false === $icon['new_tab'] ? '' : ' target="_blank"';

				$html .= '<a class="social-icon is-' . esc_html( $key ) . '" href="' . esc_url( $icon['url'] ) . '"' . $new_tab . '>';
				$html .= '<i class="' . esc_html( $icon['icon'] ) . '"></i><span class="v-line"></span>';
				if ( strpos( $wrapper_attributes, 'is-style-icons' ) === false ) {
					$html .= esc_html( $icon['label'] );
				}
				$html .= '</a>';
			}
		}
		$html .= '</div></div>';

		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			$css = new Sharing_Icons_CSS();
			$css = $css->render_css(
				array(
					'attrs' => $attributes,
				)
			);

			if ( ! empty( $css ) ) {
				$html .= '<style type="text/css">' . $css . '</style>';
			}
		}

		return $html;
	}
}
