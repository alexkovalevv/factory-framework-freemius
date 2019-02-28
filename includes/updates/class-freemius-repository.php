<?php

namespace WBCR\Factory_Freemius_000\Updates;

// Exit if accessed directly
use Wbcr_Factory000_Plugin;
use WBCR\Factory_000\Updates\Repository;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alex Kovalev <alex.kovalevv@gmail.com>
 * @link https://webcraftic.com
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */
class Freemius_Repository extends Repository {
	
	/**
	 * Freemius constructor.
	 * @since 4.0.0
	 *
	 * @param Wbcr_Factory000_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory000_Plugin $plugin, $is_premium = false ) {
		$this->plugin     = $plugin;
		$this->is_premium = $is_premium;
	}
	
	public function need_check_updates() {
		return true;
	}
	
	public function is_support_premium() {
		return true;
	}
	
	public function get_download_url() {
		/*$site_scope   = $this->license_manager->get_site_api();
		$user_scope   = $this->license_manager->get_user_api();
		$plugin_scope = $this->license_manager->get_plugin_api();
		
		$plugin_id  = $this->license_manager->get_plugin_id();
		$site       = $this->license_manager->get_storage()->get( 'site' );
		$install_id = $site->id;*/
		//$updates       = $site_scope->Api( 'updates.json?version=1.2.0', 'GET' );
		
		//$tag    = $user_scope->Api( "/plugins/$plugin_id/updates/latest.json" );
		//$tag_id = $tag->id;
		
		//$updates = $site_scope->Api( "/updates/$tag_id.zip?is_premium=true", 'GET' );
		
		//$download_url = $site_scope->GetSignedUrl("/plugins/".$plugin_id."/tags/". $tag_id . ".zip?is_premium=true");
		
		//$updates       = $site_scope->Api( 'updates.json?version=1.2.0', 'GET' );
		
		//$ee         = $site_scope->Api( "/updates/latest.json?is_premium=true" );
		
		//$tag    = $user_scope->Api( "/plugins/$plugin_id/updates/latest.zip?is_premium=true&type=all" );
		
		//$test = 'fsfsd';
		//return $this->license_manager->get_upgrade_url();
		//https://private-anon-f0ca70055f-freemius.apiary-mock.com/v1/users/{user_id}/plugins/{plugin_id}/updates/latest.json
		
		//https://private-anon-f0ca70055f-freemius.apiary-mock.com/v1/developers
		///developer_id/plugins/plugin_id/installs/install_id/updates/tag_id.zip?is_premium=true
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
	/*function http_request_host_is_external_filter( $allow, $host, $url ) {
		return ( false !== strpos( $host, 'freemius' ) ) ? true : $allow;
	}*/
	
	public function get_check_version_url() {
		//
	}
}