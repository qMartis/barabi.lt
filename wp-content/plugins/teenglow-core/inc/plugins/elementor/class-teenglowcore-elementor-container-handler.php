<?php

class TeenglowCore_Elementor_Container_Handler {
	private static $instance;
	public $containers = array();

	public function __construct() {
		// container extension
		add_action( 'elementor/element/container/_section_responsive/after_section_end', array( $this, 'render_parallax_options' ), 10, 2 );
		add_action( 'elementor/element/container/_section_responsive/after_section_end', array( $this, 'render_offset_options' ), 10, 2 );
		add_action( 'elementor/element/container/_section_responsive/after_section_end', array( $this, 'render_grid_options' ), 10, 2 );
		add_action( 'elementor/frontend/container/before_render', array( $this, 'container_before_render' ) );

		// column extension
		add_action( 'elementor/element/container/_section_responsive/after_section_end', array( $this, 'render_sticky_options' ), 10, 2 );

		// common stuff
		add_action( 'elementor/frontend/before_enqueue_styles', array( $this, 'enqueue_styles' ), 9 );
		add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ), 9 );
	}

	/**
	 * @return TeenglowCore_Elementor_Container_Handler
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	// container extension
	public function render_parallax_options( $container, $args ) {
		$container->start_controls_section(
			'qodef_parallax',
			array(
				'label' => esc_html__( 'Teenglow Parallax', 'teenglow-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$container->add_control(
			'qodef_parallax_type',
			array(
				'label'       => esc_html__( 'Enable Parallax', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => array(
					'no'       => esc_html__( 'No', 'teenglow-core' ),
					'parallax' => esc_html__( 'Yes', 'teenglow-core' ),
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_parallax_image',
			array(
				'label'       => esc_html__( 'Parallax Background Image', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'condition'   => array(
					'qodef_parallax_type' => 'parallax',
				),
				'render_type' => 'template',
			)
		);

		$container->end_controls_section();
	}

	public function render_offset_options( $container, $args ) {
		$container->start_controls_section(
			'qodef_offset',
			array(
				'label' => esc_html__( 'Teenglow Offset Image', 'teenglow-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$container->add_control(
			'qodef_offset_type',
			array(
				'label'       => esc_html__( 'Enable Offset Image', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => array(
					'no'     => esc_html__( 'No', 'teenglow-core' ),
					'offset' => esc_html__( 'Yes', 'teenglow-core' ),
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_offset_image',
			array(
				'label'       => esc_html__( 'Offset Image', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_offset_parallax',
			array(
				'label'       => esc_html__( 'Enable Offset Parallax', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'default'     => 'no',
				'options'     => array(
					'default' => esc_html__( 'Default', 'teenglow-core' ),
					'no'      => esc_html__( 'No', 'teenglow-core' ),
					'yes'     => esc_html__( 'Yes', 'teenglow-core' ),
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_offset_vertical_anchor',
			array(
				'label'       => esc_html__( 'Offset Image Vertical Anchor', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => array(
					'top'    => esc_html__( 'Top', 'teenglow-core' ),
					'bottom' => esc_html__( 'Bottom', 'teenglow-core' ),
				),
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_offset_vertical_position',
			array(
				'label'       => esc_html__( 'Offset Image Vertical Position', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '25%',
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_offset_horizontal_anchor',
			array(
				'label'       => esc_html__( 'Offset Image Horizontal Anchor', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'left',
				'options'     => array(
					'left'  => esc_html__( 'Left', 'teenglow-core' ),
					'right' => esc_html__( 'Right', 'teenglow-core' ),
				),
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$container->add_control(
			'qodef_offset_horizontal_position',
			array(
				'label'       => esc_html__( 'Offset Image Horizontal Position', 'teenglow-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '25%',
				'condition'   => array(
					'qodef_offset_type' => 'offset',
				),
				'render_type' => 'template',
			)
		);

		$container->end_controls_section();
	}

	public function render_grid_options( $container, $args ) {
		$container->start_controls_section(
			'qodef_grid_row',
			array(
				'label' => esc_html__( 'Teenglow Grid', 'teenglow-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$container->add_control(
			'qodef_enable_grid_row',
			array(
				'label'        => esc_html__( 'Make this row "In Grid"', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''     => esc_html__( 'No', 'teenglow-core' ),
					'grid' => esc_html__( 'Yes', 'teenglow-core' ),
				),
				'prefix_class' => 'qodef-elementor-content-',
			)
		);

		$container->add_control(
			'qodef_grid_row_behavior',
			array(
				'label'        => esc_html__( 'Grid Row Behavior', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''      => esc_html__( 'Default', 'teenglow-core' ),
					'right' => esc_html__( 'Extend Grid Right', 'teenglow-core' ),
					'left'  => esc_html__( 'Extend Grid Left', 'teenglow-core' ),
				),
				'condition'    => array(
					'qodef_enable_grid_row' => 'grid',
				),
				'prefix_class' => 'qodef-extended-grid qodef-extended-grid--',
			)
		);

		$container->add_control(
			'qodef_grid_row_behavior_disable_below',
			array(
				'label'        => esc_html__( 'Grid Row Behavior Disable Below', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''     => esc_html__( 'Default', 'teenglow-core' ),
					'1440' => esc_html__( 'Screen Size 1440', 'teenglow-core' ),
					'1366' => esc_html__( 'Screen Size 1366', 'teenglow-core' ),
					'1024' => esc_html__( 'Screen Size 1024', 'teenglow-core' ),
					'768'  => esc_html__( 'Screen Size 768', 'teenglow-core' ),
					'680'  => esc_html__( 'Screen Size 680', 'teenglow-core' ),
					'480'  => esc_html__( 'Screen Size 480', 'teenglow-core' ),
				),
				'condition'    => array(
					'qodef_enable_grid_row' => 'grid',
				),
				'prefix_class' => 'qodef-extended-grid-disabled--',
			)
		);

		$container->end_controls_section();
	}

	public function container_before_render( $widget ) {
		$data     = $widget->get_data();
		$type     = isset( $data['elType'] ) ? $data['elType'] : 'container';
		$settings = $data['settings'];

		if ( 'container' === $type ) {
			if ( isset( $settings['qodef_parallax_type'] ) && 'parallax' === $settings['qodef_parallax_type'] ) {
				$parallax_type  = $widget->get_settings_for_display( 'qodef_parallax_type' );
				$parallax_image = $widget->get_settings_for_display( 'qodef_parallax_image' );

				if ( ! in_array( $data['id'], $this->containers, true ) ) {
					$this->containers[ $data['id'] ][] = array(
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

				if ( ! in_array( $data['id'], $this->containers, true ) ) {
					$this->containers[ $data['id'] ][] = array(
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

	public function render_sticky_options( $container, $args ) {
		$container->start_controls_section(
			'qodef_sticky_column',
			array(
				'label' => esc_html__( 'Teenglow Core Sticky Column', 'teenglow-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			)
		);

		$container->add_control(
			'qodef_sticky_column_behavior',
			array(
				'label'        => esc_html__( 'Enable Sticky Column', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''       => esc_html__( 'No', 'teenglow-core' ),
					'enable' => esc_html__( 'Yes', 'teenglow-core' ),
				),
				'prefix_class' => 'qodef-sticky-column--',
			)
		);
		
		$container->add_control(
			'qodef_sticky_column_full_height',
			array(
				'label'        => esc_html__( 'Sticky Column Full Height', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'auto',
				'options'      => array(
					'auto'        => esc_html__( 'No', 'teenglow-core' ),
					'full-height' => esc_html__( 'Yes', 'teenglow-core' ),
				),
				'condition'    => array(
					'qodef_sticky_column_behavior' => 'enable',
				),
				'prefix_class' => 'qodef-sticky-column-height--',
			)
		);

		$container->add_control(
			'qodef_sticky_column_behavior_snap_to',
			array(
				'label'        => esc_html__( 'Sticky Column Behavior Snap To', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''       => esc_html__( 'Middle', 'teenglow-core' ),
					'top'    => esc_html__( 'Top', 'teenglow-core' ),
					'bottom' => esc_html__( 'Bottom', 'teenglow-core' ),
				),
				'condition'    => array(
					'qodef_sticky_column_behavior' => 'enable',
				),
				'prefix_class' => 'qodef-sticky-column-snap-to--',
			)
		);

		$container->add_control(
			'qodef_sticky_column_behavior_disable_from',
			array(
				'label'        => esc_html__( 'Sticky Column Behavior Disable From', 'teenglow-core' ),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => '',
				'options'      => array(
					''     => esc_html__( 'Default', 'teenglow-core' ),
					'1440' => esc_html__( 'Screen Size 1440', 'teenglow-core' ),
					'1366' => esc_html__( 'Screen Size 1366', 'teenglow-core' ),
					'1024' => esc_html__( 'Screen Size 1024', 'teenglow-core' ),
					'768'  => esc_html__( 'Screen Size 768', 'teenglow-core' ),
					'680'  => esc_html__( 'Screen Size 680', 'teenglow-core' ),
				),
				'condition'    => array(
					'qodef_sticky_column_behavior' => 'enable',
				),
				'prefix_class' => 'qodef-sticky-column-disabled--',
			)
		);

		$container->end_controls_section();
	}

	// common stuff
	public function enqueue_styles() {
		wp_enqueue_style( 'teenglow-core-elementor', TEENGLOW_CORE_PLUGINS_URL_PATH . '/elementor/assets/css/elementor.min.css' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'teenglow-core-elementor', TEENGLOW_CORE_PLUGINS_URL_PATH . '/elementor/assets/js/elementor.min.js', array( 'jquery', 'elementor-frontend' ) );

		$elementor_global_vars = array(
			'elementorContainerHandler' => $this->containers,
		);

		wp_localize_script(
			'teenglow-core-elementor',
			'qodefElementorContainerGlobal',
			array(
				'vars' => $elementor_global_vars,
			)
		);
	}
}

if ( ! function_exists( 'teenglow_core_init_elementor_container_handler' ) ) {
	/**
	 * Function that initialize main page builder handler
	 */
	function teenglow_core_init_elementor_container_handler() {
		TeenglowCore_Elementor_Container_Handler::get_instance();
	}

	add_action( 'init', 'teenglow_core_init_elementor_container_handler', 1 );
}
