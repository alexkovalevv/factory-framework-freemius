<?php

namespace WBCR\Factory_Freemius_000\Licensing;

use Exception;
use stdClass;
use WBCR\Factory_Freemius_000\Entities\Entity;
use Wbcr_Factory000_Plugin;
use WBCR\Factory_Freemius_000\Entities\License;
use WBCR\Factory_Freemius_000\Entities\Site;
use WBCR\Factory_Freemius_000\Entities\User;
use WBCR\Factory_Freemius_000\Entities\Plugin;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Storage {
	
	/**
	 * @var Wbcr_Factory000_Plugin
	 */
	protected $plugin;
	
	/**
	 * @var array
	 */
	protected $license_data = array();
	
	/**
	 * @var array
	 */
	protected $user_data = array();
	
	/**
	 * @var array
	 */
	protected $site_data = array();
	
	/**
	 * @var array
	 */
	protected $plugin_data = array();
	
	/**
	 * Storage Initialization
	 *
	 * @param Wbcr_Factory000_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory000_Plugin $plugin ) {
		$this->plugin = $plugin;
		
		$license = $plugin->getPopulateOption( 'license', array() );
		
		if ( ! empty( $new_license_storage ) ) {
			foreach ( (array) $license as $key => $license_data ) {
				$this->{$key} = $license_data;
			}
		}
	}
	
	/**
	 * @param $type
	 * @param Entity $class
	 */
	protected function set_entity( $type, Entity $class ) {
		$available_attrs = get_object_vars( $class );
		
		foreach ( (array) $available_attrs as $attr => $value ) {
			$entity_name                   = $type . "_data";
			$this->{$entity_name}[ $attr ] = $class->$attr;
		}
	}
	
	/**
	 * @param $type
	 *
	 * @return null
	 * @throws Exception
	 */
	protected function get_entity( $type ) {
		$entity_name = $type . "_data";
		
		if ( isset( $this->{$entity_name} ) && ! empty( $this->{$entity_name} ) ) {
			$entity = new stdClass;
			
			foreach ( (array) $this->{$entity_name} as $key => $prop ) {
				$entity->$key = $prop;
			}
			
			$entity_class_name = ucfirst( $type );
			
			if ( ! class_exists( $entity_class_name ) ) {
				throw new Exception( "Class {$entity_class_name} is not found." );
			}
			
			return new $entity_class_name( $entity );
		}
		
		return null;
	}
	
	/**
	 * Get site license info
	 *
	 * @return License|null
	 * @throws Exception
	 */
	public function get_license_entity() {
		
		return $this->get_entity( 'license' );
	}
	
	/**
	 * Get site info
	 * @return Site|null
	 * @throws Exception
	 */
	public function get_site_entity() {
		return $this->get_entity( 'site' );
	}
	
	/**
	 * Get user info
	 *
	 * @return User|null
	 * @throws Exception
	 */
	public function get_user_entity() {
		return $this->get_entity( 'user' );
	}
	
	/**
	 * Get user info
	 *
	 * @return Plugin
	 * @throws Exception
	 */
	public function get_plugin_entity() {
		return $this->get_entity( 'plugin' );
	}
	
	/**
	 * Set user attrs
	 *
	 * @param User $user
	 */
	public function set_user_data( User $user ) {
		$this->set_entity( 'user', $user );
	}
	
	/**
	 * Set site attrs
	 *
	 * @param Site $site
	 */
	public function set_site_data( Site $site ) {
		$this->set_entity( 'site', $site );
	}
	
	/**
	 * Sets license attrs
	 *
	 * @param License $license
	 */
	public function set_license_data( License $license ) {
		$this->set_entity( 'license', $license );
	}
	
	/**
	 * Sets license attrs
	 *
	 * @param License $plugin
	 */
	public function set_plugin_data( Plugin $license ) {
		$this->set_entity( 'plugin', $license );
	}
	
	/**
	 * Removes the value of their repository.
	 *
	 * @param string $property available properties user, site, license
	 *
	 * @return bool
	 */
	public function delete( $property ) {
		if ( empty( $property ) || ! in_array( $property, array( 'user', 'site', 'license', 'plugin' ) ) ) {
			return false;
		}
		
		$this->$property = array();
		
		return true;
	}
	
	/**
	 * Сlears all license data from storage
	 */
	public function flush() {
		$this->delete( 'site' );
		$this->delete( 'license' );
		$this->delete( 'user' );
		$this->delete( 'plugin' );
		$this->save();
	}
	
	/**
	 * Saving data
	 */
	public function save() {
		$this->plugin->updatePopulateOption( 'license', array(
			'user'    => $this->user_data,
			'site'    => $this->site_data,
			'license' => $this->license_data,
			'plugin'  => $this->plugin_data
		) );
	}
}
