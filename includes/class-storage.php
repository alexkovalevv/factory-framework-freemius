<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Класс работы с данными лицензирования
 * @author Webcraftic <jokerov@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */
class Wbcr_FactoryLicense000_Storage {
	/**
	 * @var Wbcr_Factory000_Plugin
	 */
	private $_plugin;

	/**
	 * @var array
	 */
	private $_storage = array();

	/**
	 * Инициализация системы хранения данных
	 *
	 * @param Wbcr_Factory000_Plugin $plugin Plugin which is being stored.
	 */
	public function __construct ( $plugin ) {
		$this->_plugin = $plugin;

		$this->load();
	}

	/**
	 * Загрузка данных из хранилища
	 */
	public function load () {
		$plugin = $this->get_plugin();

		// todo: temporary fixed bug with incomplete php class
		$this->_storage = get_option( $plugin::app()->getOptionName('license_storage'), false );

		if ( isset( $this->_storage['user']->id ) and $this->_storage['user']->id ) {
			$this->_storage['user'] = new Wbcr_FactoryLicense000_FS_User( $this->_storage['user'] );
		}
		if ( isset( $this->_storage['site']->id ) and $this->_storage['site']->id ) {
			$this->_storage['site'] = new Wbcr_FactoryLicense000_FS_Site( $this->_storage['site'] );
		}
		if ( isset( $this->_storage['license']->id ) and $this->_storage['license']->id ) {
			$this->_storage['license'] = new Wbcr_FactoryLicense000_FS_Plugin_License( $this->_storage['license'] );
		}
	}

	/**
	 * Сохранение данных
	 */
	public function save () {
		$plugin = $this->get_plugin();

		$plugin::app()->updatePopulateOption( 'license_storage', $this->_storage );
	}

	/**
	 * Получает элемент хранилища по его имени
	 *
	 * @param string $property ключ
	 *
	 * @return mixed
	 */
	public function get ( $property ) {
		if ( isset( $this->_storage[ $property ] ) ) {
			return $this->_storage[ $property ];
		}

		return false;
	}

	/**
	 * Helper to get loaded license key.
	 *
	 * @return Wbcr_FactoryLicense000_FS_Plugin_License|false false on failure, model on success.
	 */
	public function get_license () {
		return $this->get( 'license' );
	}

	/**
	 * Get license key.
	 *
	 * @return null|string NULL when unavailable, string on success.
	 */
	public function get_license_key () {
		$license = $this->get_license();

		if ( isset( $license->secret_key ) ) {
			return $license->secret_key;
		}

		return null;
	}


	/**
	 * Get all storage data.
	 *
	 * @return Wbcr_FactoryLicense000_Storage
	 */
	public function getAll () {
		return $this->_storage;
	}

	/**
	 * Устанавливает значение для элемента хранилища
	 *
	 * @param string $property ключ
	 * @param string $value значение
	 */
	public function set ( $property, $value ) {
		$this->_storage[ $property ] = $value;
	}

	/**
	 * Удаляет значение их хранилища
	 *
	 * @param string $property ключ
	 */
	public function delete ( $property ) {
		if ( isset( $this->_storage[ $property ] ) ) {
			$this->_storage[ $property ] = false;
		}
	}

	/**
	 * @return Wbcr_Factory000_Plugin
	 */
	public function get_plugin () {
		return $this->_plugin;
	}
}
