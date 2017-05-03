DROP TABLE IF EXISTS `my_group_category`;
CREATE TABLE IF NOT EXISTS `my_group_category` (
  `cate_id` smallint(3) NOT NULL auto_increment,
  `cate_name` varchar(100) NOT NULL,
  `cate_view` tinyint(1) NOT NULL default '1',
  `cate_order` smallint(3) NOT NULL default '0',
  PRIMARY KEY  (`cate_id`)
) TYPE=MYISAM AUTO_INCREMENT=10 ;

INSERT INTO `my_group_category` (`cate_id`, `cate_name`, `cate_view`, `cate_order`) VALUES (1, '家居团', 1, 1),
(2, '婚庆团', 1, 2),
(3, '买车团', 1, 3),
(4, '建材团', 1, 4),
(5, '找驴友', 1, 5),
(6, '母婴团', 1, 6),
(9, '其它', 1, 7);
