<?php
class CSS_Generator {
	/**
	 * scssc class instance
	 *
	 * @access protected
	 * @var scssc
	 */
	protected $scssc = null;
    protected $child_scssc = null;
	/**
	 * Debug mode is turn on or not
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $dev_mode = true;

	/**
	 * Create CSS Map file
	 *
	*/
	protected $dev_mode_map = true;

	/**
	 * opt_name
	 *
	 * @access protected
	 * @var string
	 */
	protected $opt_name = '';

	/**
	 * Constructor
	 */
	function __construct() {
		$this->opt_name = allianz_get_opt_name();

		if ( empty( $this->opt_name ) ) {
			return;
		}
		$this->dev_mode = allianz_get_opt( 'dev_mode', '0' ) === '1' ? true : false;
		add_filter( 'cms_scssc_on', function(){ return $this->dev_mode;} );
		add_filter( 'cms_scssc_lib', function(){ return 'new'; });
		add_action( 'init', array( $this, 'init' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 20 );
		if($this->dev_mode !== true){
			wp_delete_file($this->delete_css_map() );
		}
	}

	/**
	 * init hook - 10
	 */
	function init() {
		if ( !class_exists( '\ScssPhp\ScssPhp\Compiler' ) )
        {
            return;
        }
		add_action( 'wp', array( $this, 'generate_with_dev_mode' ) );
	}

	function generate_with_dev_mode() {
		if ( $this->dev_mode === true ) {
			$this->generate_file();
		}
	}

	/**
	 * Generate options and css files
	 */
	function generate_file() {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            $creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }

		$scss_dir = get_template_directory() . '/assets/scss/';
		$css_dir  = get_template_directory() . '/assets/css/';
		$css_file = $css_dir . 'theme.css';
		
		// Build CSS
		$this->scssc = new \ScssPhp\ScssPhp\Compiler();
		$this->scssc->setImportPaths( $scss_dir );
		// Optimize CSS
		$this->scssc->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);
		// Build Theme Options
		$_options = $scss_dir . 'theme_variables.scss';
		$wp_filesystem->put_contents(
            $_options,
            preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->options_output() ),
           FS_CHMOD_FILE
        );
		// Source Map
		if($this->dev_mode_map === true){
			$this->scssc->setSourceMap(\ScssPhp\ScssPhp\Compiler::SOURCE_MAP_FILE);
			$this->scssc->setSourceMapOptions([
			    // relative or full url to the above .map file
				'sourceMapWriteTo' => $css_file . ".map",
				'sourceMapURL'     => 'theme.css.map',

			    // (optional) relative or full url to the .css file
			    'sourceMapFilename' => $css_file,

			    // partial path (server root) removed (normalized) to create a relative url
			    'sourceMapBasepath' => $scss_dir, //'/var/www/vhost',

			    // (optional) prepended to 'source' field entries for relocating source files
			    'sourceRoot' => $scss_dir,
			]);
		}
	    
	    // CSS
		$result = $this->scssc->compileString('@import "theme.scss";');
		$wp_filesystem->put_contents(
            $css_file.'.map',
            preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $result->getSourceMap() ),
            FS_CHMOD_FILE
        );
        $wp_filesystem->put_contents(
            $css_file,
            preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $result->getCss() ),
            FS_CHMOD_FILE
        );
        // Build Child-Theme CSS
        if(is_child_theme()){
            // Child Theme
            $child_scss_dir = get_stylesheet_directory() . '/assets/scss/';
            $child_css_dir  = get_stylesheet_directory() . '/assets/css/';
            $this->child_scssc = new \ScssPhp\ScssPhp\Compiler();
            $this->child_scssc->setImportPaths( $child_scss_dir );
            $this->child_scssc->setOutputStyle(\ScssPhp\ScssPhp\OutputStyle::COMPRESSED);
            $child_css_file = $child_css_dir . 'child-theme.css';
            $child_result = $this->child_scssc->compileString('@import "child-theme.scss";');

            $wp_filesystem->put_contents(
                $child_css_file,
                preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $child_result->getCss() ),
                FS_CHMOD_FILE
            );
        }
	}
	protected function delete_css_map(){
		return get_template_directory() . '/assets/css/theme.css.map';
	}
	protected function options_output() {
		ob_start();
        // single css options
        printf('%s', $this->print_single_scss_opt());
        // Theme Colors
        printf('%s', $this->print_theme_colors());
		return ob_get_clean();
	}
	protected function print_single_scss_opt() {
        ob_start();
        $accent_color = allianz_configs('accent_color');
        $primary_color = allianz_configs('primary_color');
        $secondary_color = allianz_configs('secondary_color');
        // color
        foreach ($accent_color as $key => $value) {
            printf('$accent_color_%1$s: %2$s;', str_replace(['#',' '], [''],$key), $value );
        }
        foreach ($primary_color as $key => $value) {
            printf('$primary_color_%1$s: %2$s;', str_replace(['#',' '], [''],$key), $value );
        }
        foreach ($secondary_color as $key => $value) {
            printf('$secondary_color_%1$s: %2$s;', str_replace(['#',' '], [''],$key), $value );
        }
        return ob_get_clean();
    }
    protected function print_theme_colors(){
    	$color = allianz_theme_colors();
    	$_color = [];
    	unset($color['']);
    	unset($color['custom']);
    	foreach ($color as $key => $value) {
    		$_color[] = '\''.$key.'\'';
    	}
    	return '$cms_theme_colors:('.implode(',',$_color).')';
    }
}

new CSS_Generator();