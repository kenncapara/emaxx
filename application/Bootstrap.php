<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => '',
			'basePath'  => dirname(__FILE__),
			));
		return $autoloader;
	}

	protected function _initDoctrine()
	{
		$config = $this->getOptions();
		$manager = Doctrine_Manager::getInstance();

		$manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
		$manager->setAttribute(Doctrine_Core::ATTR_DEFAULT_TABLE_CHARSET, 'utf8');
		$manager->setAttribute(Doctrine_Core::ATTR_DEFAULT_TABLE_COLLATE, 'utf8_unicode_ci');
		$manager->setAttribute(Doctrine_Core::ATTR_DEFAULT_TABLE_TYPE, 'INNODB');
		$manager->setAttribute(Doctrine_Core::ATTR_USE_NATIVE_ENUM, true);
		$manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, false);

		$manager->setAttribute(
			Doctrine_Core::ATTR_MODEL_LOADING, 
			Doctrine_Core::MODEL_LOADING_CONSERVATIVE
			);
    
		// enable validation on save()
		$manager->setAttribute(
			Doctrine_Core::ATTR_VALIDATE,
			Doctrine_Core::VALIDATE_ALL
			);
    
		$manager->setAttribute(
			Doctrine_Core::ATTR_USE_DQL_CALLBACKS,
			true
			);
    
		if ($config['doctrine']['cache']) {
			$cacheDriver = new Doctrine_Cache_Apc();

			$manager->setAttribute(
				Doctrine_Core::ATTR_QUERY_CACHE,
				$cacheDriver
				);
		}
                
		$conn = Doctrine_Manager::connection($config['doctrine']['dsn']);
		$conn->setCharset('utf8');
                
                try { Doctrine_Core::createDatabases(); } catch (Exception $e) { }
                $conn = Doctrine_Core::loadModels(APPLICATION_PATH . '/models', Doctrine_Core::MODEL_LOADING_AGGRESSIVE);
                $conn = Doctrine_Core::createTablesFromModels();
                
		return $manager;
	}

	public function _initConfig()
	{
		$config = new Zend_Config($this->getOptions());
		Zend_Registry::set('config', $config);

		return $config;
	}
    
}
