CREATE TABLE `my_building` (
  `building_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `display_order` smallint(6) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

CREATE TABLE `my_property_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL DEFAULT '0' COMMENT '省份',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市',
  `area_id` int(11) NOT NULL DEFAULT '0' COMMENT '区县',
  `building_id` int(11) NOT NULL DEFAULT '0' COMMENT '小区',
  `room_id` int(11) NOT NULL COMMENT '房号',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=gbk;

CREATE TABLE `my_room` (
  `room_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `building_id` int(10) unsigned NOT NULL,
  `name` varchar(16) CHARACTER SET utf8 NOT NULL,
  `display_order` smallint(6) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=gbk;

CREATE TABLE `my_property_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` int(11) NOT NULL DEFAULT '0' COMMENT '省份',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市',
  `area_id` int(11) NOT NULL DEFAULT '0' COMMENT '区县',
  `building_id` int(11) NOT NULL DEFAULT '0' COMMENT '小区',
  `room_id` int(11) NOT NULL COMMENT '房号',
  `manage_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '管理费',
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  `pay_time` int(11) NOT NULL,
  `status` enum('Y','N') CHARACTER SET utf8 NOT NULL DEFAULT 'N',
  `water_fee` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '水费',
  `electric_fee` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '电费',
  `other_fee` decimal(10,0) NOT NULL DEFAULT '0' COMMENT '其它费用',
  `trade_no` char(22) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '订单号',
  `pay_type` enum('weixin_pay','alipay') CHARACTER SET utf8 NOT NULL COMMENT '支付方式',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '交费人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `trade_no` (`trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;



