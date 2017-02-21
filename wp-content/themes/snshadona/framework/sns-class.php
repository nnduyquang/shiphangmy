<?php
if ( ! class_exists( 'snshadona_Class' ) ) {
	class snshadona_Class {
		public function __construct() {
			// Set cookie theme option
			add_action( 'wp_ajax_sns_setcookies', array($this,'snshadona_setcookies') );
			add_action( 'wp_ajax_nopriv_sns_setcookies', array($this,'snshadona_setcookies') );
			// Reset cookie theme option
			add_action( 'wp_ajax_sns_resetcookies', array($this,'snshadona_resetcookies') );
			add_action( 'wp_ajax_nopriv_sns_resetcookies', array($this,'snshadona_resetcookies') );
		}
		public function snshadona_setcookies(){
			setcookie('snshadona_'.$_POST['key'], $_POST['value'], time()+3600*24*1, '/'); // 1 day
			
		}
	
		public function snshadona_resetcookies(){
			setcookie('snshadona_advance_scss_compile', '', 0, '/');
			//setcookie('snshadona_theme_color', '', 0, '/');
			setcookie('snshadona_use_boxedlayout', '', 0, '/');
			setcookie('snshadona_use_stickmenu', '', 0, '/');
		}
		function snshadona_getStyle($compile = 2, $scss = array('dir' => '', 'name' => ''), $css = array('dir' => '', 'name' => ''), $format = 'scss_formatter_compressed', $variables = array() ) {
			if($css['name'] == '') $css['name'] = $scss['name'];
			$scss_variables = '';
			if($variables) {
				//$css['name'] .= '-';
				foreach($variables as $propety => $value) {
					$scss_variables .= $propety . ':' . $value . ';';
					$css['name'] .= '-'.strtolower(preg_replace('/\W/i', '', $value));
				}
			}
			
			if( $compile == 2 || !file_exists(get_template_directory() . '/assets/css/' . $css['name'] . '.css') )
				$this->snshadona_compileScss($scss, $css, $format, $scss_variables);
			return $css['name'] . '.css';
		}
		function snshadona_compileScss($scss, $css, $format, $scss_variables) {
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}
			require "scssphp/scss.inc.php";
			require "scssphp/compass/compass.inc.php";
			$sass = new scssc();
			new scss_compass($sass);
			$format = ($format == NULL) ? 'scss_formatter_compressed' : $format;
			$sass->setFormatter($format);
			$sass->addImportPath($scss['dir']);
			$string_sass = $scss_variables . $wp_filesystem->get_contents($scss['dir'] . $scss['name'] . '.scss');
			$string_css = $sass->compile($string_sass);
			//$string_css = preg_replace('/\/\*[\s\S]*?\*\//', '', $string_css); // remove mutiple comments
			$wp_filesystem->put_contents(
				$css['dir'] . $css['name'] . '.css',
				$string_css,
			  	FS_CHMOD_FILE
			);
		}
		function snshadona_getOption($param, $default = '', $key = ''){
			global $snshadona_opt;
			$value = '';
			// Get config via theme option
			if($key !== ''){
				if ( isset($snshadona_opt[$param][$key]) && $snshadona_opt[$param][$key] ) $value = $snshadona_opt[$param][$key];
			}else{
				if ( isset($snshadona_opt[$param]) && $snshadona_opt[$param] ) $value = $snshadona_opt[$param];
			}
			
			// Get config via cookie
			if ( isset($_COOKIE['snshadona_'.$param]) && $_COOKIE['snshadona_'.$param] != '' ) {
				$value = $_COOKIE['snshadona_'.$param];
			}
			
			// Get config via page config
			if(is_page()){
				if ( function_exists('rwmb_meta') && rwmb_meta('snshadona_'.$param) ) $value = rwmb_meta('snshadona_'.$param);
			}
			
			if($value || class_exists( 'ReduxFramework' ))
				return $value; 
			// return default value
			return $default;
		}
		function snshadona_css_file(){
			$optimize = '';
			$theme_color = $this->snshadona_getOption('theme_color', '#e22020');
			
			// Get page meta data
			if ( is_page() && function_exists('rwmb_meta') && rwmb_meta('snshadona_page_themecolor') == 1) {
				$theme_color = rwmb_meta('sns_theme_color') != '' ? rwmb_meta('snshadona_theme_color') : $theme_color;
			}
			
			$header_bg_color= $this->snshadona_getOption('header_bg_color', '#000000');
			$footer_title_color= $this->snshadona_getOption('footer_title_color', '#ffffff'); 
			$footer_bg_color= $this->snshadona_getOption('footer_bg_color', '#222222'); 
			// Body color
			$body_color = $this->snshadona_getOption('body_font', '#888888', 'color');

			$scss_compile = snshadona_themeoption('advance_scss_compile');
		//	$scss_compile = $this->snshadona_getOption('advance_scss_compile', 1);
			$scss_format = $this->snshadona_getOption('advance_scss_format', 'scss_formatter_compressed');
			
			// Compile scss and get css file name
			$css_file = $this->snshadona_getStyle(
				$scss_compile,
				array('dir' => SNSHADONA_THEME_DIR . '/assets/scss/', 'name' => 'theme'),
				array('dir' => SNSHADONA_THEME_DIR . '/assets/css/', 'name' => 'theme'),
				//array('dir' => SNSHADONA_THEME_DIR . '/assets/scss/', 'name' => 'theme'),
				//array('dir' => SNSHADONA_THEME_DIR . '/assets/css/', 'name' => 'theme'),
				$scss_format,
				array(
					'$color1' => $theme_color,
					'$color' => $body_color,
					'$header_bg_color' => $header_bg_color,
					'$footer_title_color' => $footer_title_color,
					'$footer_bg_color' => $footer_bg_color,
				)
			);
			
			return $css_file;
		}
		
	}
}
?>