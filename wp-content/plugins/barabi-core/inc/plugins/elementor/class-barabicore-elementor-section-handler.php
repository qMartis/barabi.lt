<?php

class BarabiCore_Elementor_Section_Handler {
	private static $instance;
	public $sections = array();
	public $columns  = array();

	public function __construct() {
		// section extension
		add_action( 'elementor/element/section/_section_responsive/after_section_end', array( $this, 'render_parallax_options' ), 10, 2 );
		add_action( 'elementor/element/section/_section_responsive/after_section_end', array( $this, 'render_offset_options' ), 10, 2 );
		add_action( 'elementor/element/section/_section_responsive/after_section_end', array( $this, 'render_grid_options' ), 10, 2 );
		add_action( 'elementor/frontend/section/before_render', array( $this, 'section_before_render' ) );
		add_action( 'elementor/frontend/element/before_render', array( $this, 'section_before_render' ) );

		// column extension
		add_action( 'elementor/element/column/_section_responsive/after_section_end', array( $this, 'render_background_text_options' ), 10, 2 );
		add_action( 'elementor/element/column/_section_responsive/after_section_end', array( $this, 'render_sticky_options' ), 10, 2 );
		add_action( 'elementor/frontend/column/before_render', array( $this, 'column_before_render' ) );
		add_action( 'elementor/frontend/element/before_render', array( $this, 'column_before_render' ) );

		// common stuff
		add_action( 'elementor/frontend/before_enqueue_styles', array( $this, 'enqueue_styles' ), 9 );
		add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
	}

	/**
	 * @return BarabiCore_Elementor_Section_Handler
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	// section extension
	public function render_parallax_options( $section, $args ) {
		$section->start_controls_section(
			'qodef_parallax',
			array(
				'label' => esc_html__( 'Barabi Parallax', 'barabi-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$section->add_control(
			'qodef_parallax_type',
			array(
				'label'       => esc_html__( 'Enable Parallax', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => array(
					'no'       => esc_html__( 'No', 'barabi-core' ),
					'parallax' => esc_html__( 'Yes', 'barabi-core' ),
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_parallax_image',
			array(
				'label'       => esc_html__( 'Parallax Background Image', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'condition'   => array(
					'qodef_parallax_type' => 'parallax',
				),
				'render_type' => 'template',
			)
		);

		$section->end_controls_section();
	}

	public function render_offset_options( $section, $args ) {
		$section->start_controls_section(
			'qodef_offset',
			array(
				'label' => esc_html__( 'Barabi Offset Image', 'barabi-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$section->add_control(
			'qodef_offset_type',
			array(
				'label'       => esc_html__( 'Enable Offset Image', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => array(
					'no'     => esc_html__( 'No', 'barabi-core' ),
					'offset' => esc_html__( 'Yes', 'barabi-core' ),
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_offset_image',
			array(
				'label'       => esc_html__( 'Offset Image', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_offset_parallax',
			array(
				'label'       => esc_html__( 'Enable Offset Parallax', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'default'     => 'no',
				'options'     => array(
					'default' => esc_html__( 'Default', 'barabi-core' ),
					'no'      => esc_html__( 'No', 'barabi-core' ),
					'yes'     => esc_html__( 'Yes', 'barabi-core' ),
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_offset_vertical_anchor',
			array(
				'label'       => esc_html__( 'Offset Image Vertical Anchor', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => array(
					'top'    => esc_html__( 'Top', 'barabi-core' ),
					'bottom' => esc_html__( 'Bottom', 'barabi-core' ),
				),
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_offset_vertical_position',
			array(
				'label'       => esc_html__( 'Offset Image Vertical Position', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '25%',
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_offset_horizontal_anchor',
			array(
				'label'       => esc_html__( 'Offset Image Horizontal Anchor', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'left',
				'options'     => array(
					'left'  => esc_html__( 'Left', 'barabi-core' ),
					'right' => esc_html__( 'Right', 'barabi-core' ),
				),
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$section->add_control(
			'qodef_offset_horizontal_position',
			array(
				'label'       => esc_html__( 'Offset Image Horizontal Position', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '25%',
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$section->end_controls_section();
	}

	public function render_grid_options( $section, $args ) {
		$section->start_controls_section(
			'qodef_grid_row',
			array(
				'label' => esc_html__( 'Barabi Grid', 'barabi-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$section->add_control(
			'qodef_enable_grid_row',
			array(
				'label'        => esc_html__( 'Make this row "In Grid"', 'barabi-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''   => esc_html__( 'No', 'barabi-core' ),
					'grid' => esc_html__( 'Yes', 'barabi-core' ),
				),
				'prefix_class' => 'qodef-elementor-content-',
			)
		);

		$section->add_control(
			'qodef_grid_row_behavior',
			array(
				'label'        => esc_html__( 'Grid Row Behavior', 'barabi-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''      => esc_html__( 'Default', 'barabi-core' ),
					'right' => esc_html__( 'Extend Grid Right', 'barabi-core' ),
					'left'  => esc_html__( 'Extend Grid Left', 'barabi-core' ),
				),
				'condition'    => array(
					'qodef_enable_grid_row' => 'grid',
				),
				'prefix_class' => 'qodef-extended-grid qodef-extended-grid--',
			)
		);

		$section->add_control(
			'qodef_grid_row_behavior_disable_below',
			[
				'label'        => esc_html__( 'Grid Row Behavior Disable Below', 'barabi-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => [
					''     => esc_html__( 'Default', 'barabi-core' ),
					'1440' => esc_html__( 'Screen Size 1440', 'barabi-core' ),
					'1366' => esc_html__( 'Screen Size 1366', 'barabi-core' ),
					'1024' => esc_html__( 'Screen Size 1024', 'barabi-core' ),
					'768'  => esc_html__( 'Screen Size 768', 'barabi-core' ),
					'680'  => esc_html__( 'Screen Size 680', 'barabi-core' ),
					'480'  => esc_html__( 'Screen Size 480', 'barabi-core' ),
				],
				'condition'    => [
					'qodef_enable_grid_row' => 'grid',
				],
				'prefix_class' => 'qodef-extended-grid-disabled--',
			]
		);

		$section->end_controls_section();
	}

	public function section_before_render( $widget ) {
		$data     = $widget->get_data();
		$type     = isset( $data['elType'] ) ? $data['elType'] : 'section';
		$settings = $data['settings'];

		if ( 'section' === $type ) {
			if ( isset( $settings['qodef_parallax_type'] ) && 'parallax' === $settings['qodef_parallax_type'] ) {
				$parallax_type  = $widget->get_settings_for_display( 'qodef_parallax_type' );
				$parallax_image = $widget->get_settings_for_display( 'qodef_parallax_image' );

				if ( ! in_array( $data['id'], $this->sections, true ) ) {
					$this->sections[ $data['id'] ][] = array(
						'parallax_type'  => $parallax_type,
						'parallax_image' => $parallax_image,
					);
				}
			}

			if ( isset( $settings['qodef_offset_type'] ) && 'offset' === $settings['qodef_offset_type'] ) {
				$offset_type                = $widget->get_settings_for_display( 'qodef_offset_type' );
				$offset_image               = $widget->get_settings_for_display( 'qodef_offset_image' );
				$offset_parallax            = $widget->get_settings_for_display( 'qodef_offset_parallax' );
				$offset_vertical_anchor     = $widget->get_settings_for_display( 'qodef_offset_vertical_anchor' );
				$offset_vertical_position   = $widget->get_settings_for_display( 'qodef_offset_vertical_position' );
				$offset_horizontal_anchor   = $widget->get_settings_for_display( 'qodef_offset_horizontal_anchor' );
				$offset_horizontal_position = $widget->get_settings_for_display( 'qodef_offset_horizontal_position' );

				if ( ! in_array( $data['id'], $this->sections, true ) ) {
					$this->sections[ $data['id'] ][] = array(
						'offset_type'                => $offset_type,
						'offset_image'               => $offset_image,
						'offset_parallax'            => $offset_parallax,
						'offset_vertical_anchor'     => $offset_vertical_anchor,
						'offset_vertical_position'   => $offset_vertical_position,
						'offset_horizontal_anchor'   => $offset_horizontal_anchor,
						'offset_horizontal_position' => $offset_horizontal_position,
					);
				}
			}
		}
	}

	// column extension
	public function render_background_text_options( $column, $args ) {
		$column->start_controls_section(
			'qodef_background_text_holder',
			array(
				'label' => esc_html__( 'Barabi Core Background Text', 'barabi-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$column->add_control(
			'qodef_background_text_enable',
			array(
				'label'       => esc_html__( 'Enable Background Text', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => array(
					'no'  => esc_html__( 'No', 'barabi-core' ),
					'yes' => esc_html__( 'Yes', 'barabi-core' ),
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text',
			array(
				'label'       => esc_html__( 'Text', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_color',
			array(
				'label'       => esc_html__( 'Text Color', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::COLOR,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_size',
			array(
				'label'       => esc_html__( 'Text Size (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_size_1440',
			array(
				'label'       => esc_html__( 'Text Size - between 1440 and 1367 (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_size_1366',
			array(
				'label'       => esc_html__( 'Text Size - between 1366 and 1025 (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_size_1024',
			array(
				'label'       => esc_html__( 'Text Size - below 1024 (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_vertical_offset',
			array(
				'label'       => esc_html__( 'Vertical Offset (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_vertical_offset_1440',
			array(
				'label'       => esc_html__( 'Vertical Offset - between 1440 and 1367 (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_vertical_offset_1366',
			array(
				'label'       => esc_html__( 'Vertical Offset - between 1366 and 1025 (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_vertical_offset_1024',
			array(
				'label'       => esc_html__( 'Vertical Offset - below 1024 (px)', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_horizontal_align',
			array(
				'label'       => esc_html__( 'Horizontal Align', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'flex-start',
				'options'     => array(
					'flex-start' => esc_html__( 'Left', 'barabi-core' ),
					'center'     => esc_html__( 'Center', 'barabi-core' ),
					'flex-end'   => esc_html__( 'Right', 'barabi-core' ),
				),
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->add_control(
			'qodef_background_text_vertical_align',
			array(
				'label'       => esc_html__( 'Vertical Align', 'barabi-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'flex-start',
				'options'     => array(
					'flex-start' => esc_html__( 'Top', 'barabi-core' ),
					'center'     => esc_html__( 'Middle', 'barabi-core' ),
					'flex-end'   => esc_html__( 'Bottom', 'barabi-core' ),
				),
				'condition'   => array(
					'qodef_background_text_enable' => 'yes',
				),
				'render_type' => 'template',
			)
		);

		$column->end_controls_section();
	}
	
	public function render_sticky_options( $section, $args ) {
		$section->start_controls_section(
			'qodef_sticky_holder',
			array(
				'label' => esc_html__( 'Barabi Core Sticky', 'barabi-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);
		
		$section->add_control(
			'qodef_sticky_enable',
			array(
				'label'        => esc_html__( 'Make this column "Sticky"', 'barabi-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''       => esc_html__( 'No', 'barabi-core' ),
					'column' => esc_html__( 'Yes', 'barabi-core' ),
				),
				'prefix_class' => 'qodef-sticky-',
			)
		);
		
		$section->end_controls_section();
	}

	public function column_before_render( $widget ) {
		$data     = $widget->get_data();
		$type     = isset( $data['elType'] ) ? $data['elType'] : 'column';
		$settings = $data['settings'];

		if ( 'column' === $type ) {
			if ( isset( $settings['qodef_background_text_enable'] ) && 'yes' === $settings['qodef_background_text_enable'] ) {
				$background_text                      = $widget->get_settings_for_display( 'qodef_background_text' );
				$background_text_color                = $widget->get_settings_for_display( 'qodef_background_text_color' );
				$background_text_size                 = $widget->get_settings_for_display( 'qodef_background_text_size' );
				$background_text_size_1440            = $widget->get_settings_for_display( 'qodef_background_text_size_1440' );
				$background_text_size_1366            = $widget->get_settings_for_display( 'qodef_background_text_size_1366' );
				$background_text_size_1024            = $widget->get_settings_for_display( 'qodef_background_text_size_1024' );
				$background_text_vertical_offset      = $widget->get_settings_for_display( 'qodef_background_text_vertical_offset' );
				$background_text_vertical_offset_1440 = $widget->get_settings_for_display( 'qodef_background_text_vertical_offset_1440' );
				$background_text_vertical_offset_1366 = $widget->get_settings_for_display( 'qodef_background_text_vertical_offset_1366' );
				$background_text_vertical_offset_1024 = $widget->get_settings_for_display( 'qodef_background_text_vertical_offset_1024' );
				$background_text_horizontal_align     = $widget->get_settings_for_display( 'qodef_background_text_horizontal_align' );
				$background_text_vertical_align       = $widget->get_settings_for_display( 'qodef_background_text_vertical_align' );

				if ( ! in_array( $data['id'], $this->columns, true ) ) {
					$this->columns[ $data['id'] ] = array(
						$background_text,
						$background_text_color,
						$background_text_size,
						$background_text_size_1440,
						$background_text_size_1366,
						$background_text_size_1024,
						$background_text_vertical_offset,
						$background_text_vertical_offset_1440,
						$background_text_vertical_offset_1366,
						$background_text_vertical_offset_1024,
						$background_text_horizontal_align,
						$background_text_vertical_align,
					);
				}

				$widget->add_render_attribute( '_wrapper', 'class', 'qodef-background-text' );
			}
		}
	}

	// common stuff
	public function enqueue_styles() {
		wp_enqueue_style( 'barabi-core-elementor', BARABI_CORE_PLUGINS_URL_PATH . '/elementor/assets/css/elementor.min.css' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'barabi-core-elementor', BARABI_CORE_PLUGINS_URL_PATH . '/elementor/assets/js/elementor.min.js', array( 'jquery', 'elementor-frontend' ) );

		$elementor_global_vars = array(
			'elementorSectionHandler' => $this->sections,
			'elementorColumnHandler'  => $this->columns,
		);

		wp_localize_script(
			'barabi-core-elementor',
			'qodefElementorGlobal',
			array(
				'vars' => $elementor_global_vars,
			)
		);
	}
}

if ( ! function_exists( 'barabi_core_init_elementor_section_handler' ) ) {
	/**
	 * Function that initialize main page builder handler
	 */
	function barabi_core_init_elementor_section_handler() {
		BarabiCore_Elementor_Section_Handler::get_instance();
	}

	add_action( 'init', 'barabi_core_init_elementor_section_handler', 1 );
}
