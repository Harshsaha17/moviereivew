<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class Movie_Critic_Review_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'movie-critic-review-typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'movie-critic-review' ),
				'family'      => esc_html__( 'Font Family', 'movie-critic-review' ),
				'size'        => esc_html__( 'Font Size',   'movie-critic-review' ),
				'weight'      => esc_html__( 'Font Weight', 'movie-critic-review' ),
				'style'       => esc_html__( 'Font Style',  'movie-critic-review' ),
				'line_height' => esc_html__( 'Line Height', 'movie-critic-review' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'movie-critic-review' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'movie-critic-review-ctypo-customize-controls' );
		wp_enqueue_style(  'movie-critic-review-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'movie-critic-review' ),
        'Abril Fatface' => __( 'Abril Fatface', 'movie-critic-review' ),
        'Acme' => __( 'Acme', 'movie-critic-review' ),
        'Anton' => __( 'Anton', 'movie-critic-review' ),
        'Architects Daughter' => __( 'Architects Daughter', 'movie-critic-review' ),
        'Arimo' => __( 'Arimo', 'movie-critic-review' ),
        'Arsenal' => __( 'Arsenal', 'movie-critic-review' ),
        'Arvo' => __( 'Arvo', 'movie-critic-review' ),
        'Alegreya' => __( 'Alegreya', 'movie-critic-review' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'movie-critic-review' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'movie-critic-review' ),
        'Bangers' => __( 'Bangers', 'movie-critic-review' ),
        'Boogaloo' => __( 'Boogaloo', 'movie-critic-review' ),
        'Bad Script' => __( 'Bad Script', 'movie-critic-review' ),
        'Bitter' => __( 'Bitter', 'movie-critic-review' ),
        'Bree Serif' => __( 'Bree Serif', 'movie-critic-review' ),
        'BenchNine' => __( 'BenchNine', 'movie-critic-review' ),
        'Cabin' => __( 'Cabin', 'movie-critic-review' ),
        'Cardo' => __( 'Cardo', 'movie-critic-review' ),
        'Courgette' => __( 'Courgette', 'movie-critic-review' ),
        'Cherry Swash' => __( 'Cherry Swash', 'movie-critic-review' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'movie-critic-review' ),
        'Crimson Text' => __( 'Crimson Text', 'movie-critic-review' ),
        'Cuprum' => __( 'Cuprum', 'movie-critic-review' ),
        'Cookie' => __( 'Cookie', 'movie-critic-review' ),
        'Chewy' => __( 'Chewy', 'movie-critic-review' ),
        'Days One' => __( 'Days One', 'movie-critic-review' ),
        'Dosis' => __( 'Dosis', 'movie-critic-review' ),
        'Droid Sans' => __( 'Droid Sans', 'movie-critic-review' ),
        'Economica' => __( 'Economica', 'movie-critic-review' ),
        'Fredoka One' => __( 'Fredoka One', 'movie-critic-review' ),
        'Fjalla One' => __( 'Fjalla One', 'movie-critic-review' ),
        'Francois One' => __( 'Francois One', 'movie-critic-review' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'movie-critic-review' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'movie-critic-review' ),
        'Great Vibes' => __( 'Great Vibes', 'movie-critic-review' ),
        'Handlee' => __( 'Handlee', 'movie-critic-review' ),
        'Hammersmith One' => __( 'Hammersmith One', 'movie-critic-review' ),
        'Inconsolata' => __( 'Inconsolata', 'movie-critic-review' ),
        'Indie Flower' => __( 'Indie Flower', 'movie-critic-review' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'movie-critic-review' ),
        'Julius Sans One' => __( 'Julius Sans One', 'movie-critic-review' ),
        'Josefin Slab' => __( 'Josefin Slab', 'movie-critic-review' ),
        'Josefin Sans' => __( 'Josefin Sans', 'movie-critic-review' ),
        'Kanit' => __( 'Kanit', 'movie-critic-review' ),
        'Lobster' => __( 'Lobster', 'movie-critic-review' ),
        'Lato' => __( 'Lato', 'movie-critic-review' ),
        'Lora' => __( 'Lora', 'movie-critic-review' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'movie-critic-review' ),
        'Lobster Two' => __( 'Lobster Two', 'movie-critic-review' ),
        'Merriweather' => __( 'Merriweather', 'movie-critic-review' ),
        'Monda' => __( 'Monda', 'movie-critic-review' ),
        'Montserrat' => __( 'Montserrat', 'movie-critic-review' ),
        'Muli' => __( 'Muli', 'movie-critic-review' ),
        'Marck Script' => __( 'Marck Script', 'movie-critic-review' ),
        'Noto Serif' => __( 'Noto Serif', 'movie-critic-review' ),
        'Open Sans' => __( 'Open Sans', 'movie-critic-review' ),
        'Overpass' => __( 'Overpass', 'movie-critic-review' ),
        'Overpass Mono' => __( 'Overpass Mono', 'movie-critic-review' ),
        'Oxygen' => __( 'Oxygen', 'movie-critic-review' ),
        'Orbitron' => __( 'Orbitron', 'movie-critic-review' ),
        'Patua One' => __( 'Patua One', 'movie-critic-review' ),
        'Pacifico' => __( 'Pacifico', 'movie-critic-review' ),
        'Padauk' => __( 'Padauk', 'movie-critic-review' ),
        'Playball' => __( 'Playball', 'movie-critic-review' ),
        'Playfair Display' => __( 'Playfair Display', 'movie-critic-review' ),
        'PT Sans' => __( 'PT Sans', 'movie-critic-review' ),
        'Philosopher' => __( 'Philosopher', 'movie-critic-review' ),
        'Permanent Marker' => __( 'Permanent Marker', 'movie-critic-review' ),
        'Poiret One' => __( 'Poiret One', 'movie-critic-review' ),
        'Quicksand' => __( 'Quicksand', 'movie-critic-review' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'movie-critic-review' ),
        'Raleway' => __( 'Raleway', 'movie-critic-review' ),
        'Rubik' => __( 'Rubik', 'movie-critic-review' ),
        'Rokkitt' => __( 'Rokkitt', 'movie-critic-review' ),
        'Russo One' => __( 'Russo One', 'movie-critic-review' ),
        'Righteous' => __( 'Righteous', 'movie-critic-review' ),
        'Slabo' => __( 'Slabo', 'movie-critic-review' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'movie-critic-review' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'movie-critic-review'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'movie-critic-review' ),
        'Sacramento' => __( 'Sacramento', 'movie-critic-review' ),
        'Shrikhand' => __( 'Shrikhand', 'movie-critic-review' ),
        'Tangerine' => __( 'Tangerine', 'movie-critic-review' ),
        'Ubuntu' => __( 'Ubuntu', 'movie-critic-review' ),
        'VT323' => __( 'VT323', 'movie-critic-review' ),
        'Varela Round' => __( 'Varela Round', 'movie-critic-review' ),
        'Vampiro One' => __( 'Vampiro One', 'movie-critic-review' ),
        'Vollkorn' => __( 'Vollkorn', 'movie-critic-review' ),
        'Volkhov' => __( 'Volkhov', 'movie-critic-review' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'movie-critic-review' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'movie-critic-review' ),
			'100' => esc_html__( 'Thin',       'movie-critic-review' ),
			'300' => esc_html__( 'Light',      'movie-critic-review' ),
			'400' => esc_html__( 'Normal',     'movie-critic-review' ),
			'500' => esc_html__( 'Medium',     'movie-critic-review' ),
			'700' => esc_html__( 'Bold',       'movie-critic-review' ),
			'900' => esc_html__( 'Ultra Bold', 'movie-critic-review' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'movie-critic-review' ),
			'normal'  => esc_html__( 'Normal', 'movie-critic-review' ),
			'italic'  => esc_html__( 'Italic', 'movie-critic-review' ),
			'oblique' => esc_html__( 'Oblique', 'movie-critic-review' )
		);
	}
}
