<?php

$installer = $this;

$installer->startSetup();

 $installer->run("

DROP TABLE IF EXISTS {$this->getTable('googleanalytics')};
CREATE TABLE {$this->getTable('googleanalytics')} (
  `googleanalytics_id` int(11) unsigned NOT NULL auto_increment,
  `edit_time` datetime NULL,
  PRIMARY KEY (`googleanalytics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 