CREATE TABLE IF NOT EXISTS `task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `progress` int(3) NOT NULL COMMENT 'percentage',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci