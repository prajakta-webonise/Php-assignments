<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 16/9/14
 * Time: 1:04 PM
 * To change this template use File | Settings | File Templates.
 */
    require_once("databaseConfig.php");
    require_once("Registry/Registry.php");
    class factory {
        public $registry;
        public static function selectDb($config) {
            $database = $config['datasource']."Class";

            if(class_exists($database)) {
                $registry = registry::getInstance();
                $registry->set("db", new $database($config));
                return $registry->get("db");
            }
            else {
                throw new Exception("Invalid class type given.");
            }
        }
    }