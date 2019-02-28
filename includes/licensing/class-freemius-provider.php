<?php

namespace WBCR\Factory_Freemius_000\Licensing;

use Exception;
use Wbcr_Factory000_Plugin;
use WBCR\Factory_Freemius_000\Api;
use WBCR\Factory_000\Premium\License\Provider as License_Provider;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alex Kovalev <alex.kovalevv@gmail.com>
 * @link https://webcraftic.com
 * @copyright (c) 2018 Webraftic Ltd, Freemius, Inc.
 * @version 1.0
 */
class Provider extends License_Provider {
	
	/**
	 * @var Storage
	 */
	protected $storage;
	
	/**
	 * @var int
	 */
	protected $plugin_id;
	
	/**
	 * @var string
	 */
	protected $public_key;
	
	/**
	 * @var string
	 */
	protected $slug;
	
	/**
	 * @var \WBCR\Factory_Freemius_000\Entities\Site|null
	 */
	protected $site_data;
	
	/**
	 * @var \WBCR\Factory_Freemius_000\Entities\User|null
	 */
	protected $user_data;
	
	/**
	 * @var \WBCR\Factory_Freemius_000\Entities\License|null
	 */
	protected $license_data;
	
	/**
	 * @var \WBCR\Factory_Freemius_000\Entities\License|null
	 */
	protected $plugin_data;
	
	
	private $site_api;
	private $plugin_api;
	private $user_api;
	
	/**
	 * Manager constructor.
	 *
	 * @param Wbcr_Factory000_Plugin $plugin
	 *
	 * @throws Exception
	 */
	public function __construct( Wbcr_Factory000_Plugin $plugin, array $settings ) {
		parent::__construct( $plugin, $settings );
		
		$this->storage    = new Storage( $plugin );
		$this->plugin_id  = $this->get_setting( 'plugin_id', null );
		$this->public_key = $this->get_setting( 'public_key', null );
		$this->slug       = $this->get_setting( 'slug', null );
		
		if ( empty( $this->plugin_id ) || empty( $this->public_key ) || empty( $this->slug ) ) {
			throw new Exception( 'One of required (plugin_id, public_key, slug) attrs is empty.' );
		}
		
		$this->site_data    = $this->storage->get_site_entity();
		$this->user_data    = $this->storage->get_user_entity();
		$this->license_data = $this->storage->get_license_entity();
		$this->plugin_data  = $this->storage->get_plugin_entity();
	}
	
	/**
	 *
	 * @author Vova Feldman (@svovaf)
	 * @since  1.0.2
	 *
	 * @param bool $flush
	 *
	 * @return \WBCR\Factory_Freemius_000\Api
	 */
	private function get_api_user_scope( $flush = false ) {
		if ( ! isset( $this->user_api ) || $flush ) {
			$this->user_api = Api::instance( $this->plugin, 'user', $this->user_data->id, $this->user_data->public_key, false, $this->user_data->secret_key );
		}
		
		return $this->user_api;
	}
	
	/**
	 * @param bool $flush
	 *
	 * @return \WBCR\Factory_Freemius_000\Api
	 */
	private function get_api_site_scope( $flush = false ) {
		if ( ! isset( $this->site_api ) || $flush ) {
			$this->site_api = Api::instance( $this->plugin, 'install', $this->site_data->id, $this->site_data->public_key, false, $this->site_data->secret_key );
		}
		
		return $this->site_api;
	}
	
	/**
	 * Get plugin public API scope.
	 *
	 * @return \WBCR\Factory_Freemius_000\Api
	 */
	function get_api_plugin_scope() {
		if ( ! isset( $this->plugin_api ) ) {
			$this->plugin_api = Api::instance( $this->plugin, 'plugin', $this->plugin_data->id, $this->plugin_data->public_key, false );
		}
		
		return $this->plugin_api;
	}
	
	public function has_paid_subscription() {
		return true;
	}
	
	public function get_license_provider_name() {
		return $this->get_setting( 'provider' );
	}
	
	public function get_license_key() {
		#sk_f=>}-5vuHp$3*wPQHxd(AD3<);1&i
	}
	
	public function get_secret_license_key() {
		#sk_f=>}-5vuHp$3******d(AD3<);1&i
	}
	
	public function get_license_expiration_time() {
	
	}
	
	public function get_count_active_sites() {
	
	}
	
	public function get_plan() {
	
	}
	
	public function is_install_premium() {
	
	}
	
	public function is_license_activate() {
	
	}
	
	public function is_lifetime() {
	
	}
	
	public function license_activate() {
	
	}
	
	public function license_deactivate() {
	
	}
	
	public function paid_subscription_cancel() {
	
	}
}