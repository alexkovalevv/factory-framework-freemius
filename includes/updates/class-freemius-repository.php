<?php

namespace WBCR\Factory_Freemius_000\Updates;

// Exit if accessed directly
use Exception;
use Wbcr_Factory000_Plugin;
use WBCR\Factory_000\Updates\Repository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alex Kovalev <alex.kovalevv@gmail.com>
 * @link https://webcraftic.com
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */
class Freemius_Repository extends Repository {
	
	/**
	 * @var \WBCR\Factory_Freemius_000\Premium\Provider
	 */
	private $premium;
	
	/**
	 * Freemius constructor.
	 * @since 4.0.0
	 *
	 * @param Wbcr_Factory000_Plugin $plugin
	 *
	 * @throws Exception
	 */
	public function __construct( Wbcr_Factory000_Plugin $plugin, $is_premium = false ) {
		$this->plugin     = $plugin;
		$this->is_premium = $is_premium;
		$this->premium    = $this->plugin->premium;
		
		if ( ! $is_premium && ! $this->premium instanceof \WBCR\Factory_Freemius_000\Premium\Provider ) {
			throw new Exception( "This repository type requires Freemius premium provider." );
		}
		
		if ( ! $is_premium && ! $this->premium->is_activate() ) {
			throw new Exception( "Only premium plugins can check or receive updates via Freemius repository." );
		}
		
		add_filter( 'http_request_host_is_external', array(
			$this,
			'http_request_host_is_external_filter'
		), 10, 3 );
	}
	
	/**
	 * @return bool
	 */
	public function need_check_updates() {
		return true;
	}
	
	/**
	 * @return bool|mixed
	 */
	public function is_support_premium() {
		return true;
	}
	
	/**
	 * @return string|null
	 * @throws Exception
	 */
	public function get_download_url() {
		return $this->premium->get_package_download_url();
	}
	
	/**
	 * @return string|null
	 * @throws Exception
	 */
	public function get_last_version() {
		try {
			$last_package = $this->premium->get_downloadable_package_info();
			
			$last_version = $last_package->version;
			
			if ( empty( $last_version ) ) {
				return null;
			}
		} catch( Exception $e ) {
			if ( defined( 'FACTORY_UPDATES_DEBUG' ) && FACTORY_UPDATES_DEBUG ) {
				throw new Exception( $e->getMessage(), $e->getCode() );
			}
			
			return null;
		}
		
		return $last_version;
	}
	
	/**
	 * Since WP version 3.6, a new security feature was added that denies access to repository with a local ip.
	 * During development mode we want to be able updating plugin versions via our localhost repository. This
	 * filter white-list all domains including "api.freemius".
	 *
	 * @link   http://www.emanueletessore.com/wordpress-download-failed-valid-url-provided/
	 *
	 * @author Vova Feldman (@svovaf)
	 * @since  1.0.4
	 *
	 * @param bool $allow
	 * @param string $host
	 * @param string $url
	 *
	 * @return bool
	 */
	function http_request_host_is_external_filter( $allow, $host, $url ) {
		return ( false !== strpos( $host, 'freemius' ) ) ? true : $allow;
	}
}