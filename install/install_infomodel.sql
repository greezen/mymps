INSERT INTO `my_info_typemodels` (`id`, `name`, `displayorder`, `type`, `options`) VALUES
(1, '空模型', 0, 1, ''),
(2, '二手物品交易模型', 2, 0, '39,9,58'),
(6, '电脑转让模型', 6, 0, '54,58,9,39'),
(7, '全职招聘模型', 7, 0, '43,40,44,42,47,49,61,62'),
(8, '兼职招聘模型', 8, 0, '41,42'),
(9, '简历模型', 9, 0, '45,46,47,48,49'),
(10, '教育培训模型', 10, 0, '50'),
(11, '电动车交易模型', 11, 0, '11,9,58,39'),
(12, '二手轿车模型', 12, 0, '14,16,17,13,58,39'),
(13, '自行车交易模型', 13, 0, '22,9,39,58'),
(14, '拼车顺风车模型', 14, 0, '20,9,21'),
(15, '面包车客车模型', 15, 0, '17,16,13,58,39'),
(16, '大件物品交易模型', 16, 0, '13,58,39'),
(18, '技能交换模型', 18, 0, '51'),
(19, '征婚交友模型', 19, 0, '45,46,52'),
(20, '狗狗模型', 20, 0, '25,26,9,39'),
(21, '猫猫等宠物模型', 21, 0, '27,9'),
(22, '二手房模型', 22, 0, '33,34,35,36,13,30'),
(23, '出租房模型', 23, 0, '33,37,35,38,64'),
(24, '厂房/写字楼出租模型', 24, 0, '33,30,29'),
(25, '商铺/写字楼出售模型', 25, 0, '30,13'),
(26, '店铺转让出租模型', 26, 0, '31,30,32'),
(27, '摩托车模型', 0, 0, '60,9,39');

INSERT INTO `my_info_typeoptions` (`optionid`, `classid`, `displayorder`, `title`, `description`, `identifier`, `type`, `rules`, `available`, `required`, `search`) VALUES
(1, 0, 0, '通用类', '', '', '', '', '0', '0', '0'),
(2, 0, 0, '房产类', '', '', '', '', '0', '0', '0'),
(3, 0, 0, '交友类', '', '', '', '', '0', '0', '0'),
(4, 0, 0, '求职招聘类', '', '', '', '', '0', '0', '0'),
(5, 0, 0, '交易类', '', '', '', '', '0', '0', '0'),
(6, 0, 0, '教育培训类', '', '', '', '', '0', '0', '0'),
(7, 0, 0, '宠物类', '', '', '', '', '0', '0', '0'),
(8, 0, 0, '车辆类', '', '', '', '', '0', '0', '0'),
(9, 5, 1, '价格', '小额价格', 'price', 'number', 'a:2:{s:5:"units";s:2:"元";s:7:"choices";s:98:"1~1000=1000以内\r\n1000~3000=1000~3000\r\n3000~5000=3000~5000\r\n5000~10000=5000~10000\r\n10000~=10000以上";}', 'on', 'on', 'on'),
(11, 8, 3, '电动车品牌', '电动车品牌', 'ebike_brand', 'select', 'a:1:{s:7:"choices";s:46:"1=新日\r\n2=立马\r\n3=绿源\r\n4=爱玛\r\n5=雅迪\r\n6=其它";}', 'on', 'on', 'on'),
(13, 5, 0, '价格', '万元级别的价格', 'prices', 'number', 'a:2:{s:5:"units";s:4:"万元";s:7:"choices";s:99:"1~5=5万以内\r\n5~10=5万~10万\r\n10~50=10万~50万\r\n50~100=50万~100万\r\n100~300=100万~300万\r\n300~=300万以上";}', 'on', 'on', 'on'),
(14, 8, 5, '轿车品牌', '轿车品牌', 'car_brand', 'select', 'a:1:{s:7:"choices";s:148:"1=大众\r\n2=本田\r\n3=丰田\r\n4=别克\r\n5=奥迪\r\n6=奔驰\r\n7=宝马\r\n8=比亚迪\r\n9=现代\r\n10=雪佛兰\r\n11=奇瑞\r\n12=福特\r\n13=日产\r\n14=马自达\r\n15=金杯\r\n16=路虎\r\n17=其它";}', 'on', 'on', 'on'),
(16, 8, 7, '上牌年份', '上牌年份', 'car_year', 'select', 'a:1:{s:7:"choices";s:62:"1=2011年以前\r\n2=2011年\r\n3=2012年\r\n4=2013年\r\n5=2014年\r\n6=2015年";}', 'on', 'on', 'on'),
(17, 8, 8, '行驶里程', '行驶里程', 'mileage', 'number', 'a:2:{s:5:"units";s:6:"万公里";s:7:"choices";s:61:"0~1=1万公里以内\r\n1~3=1~3万公里\r\n3~5=3~5万公里\r\n5~=5万公里以上";}', 'on', 'on', ''),
(18, 8, 9, '面包车类型', '面包车类型', 'minibus_type', 'select', 'a:1:{s:7:"choices";s:28:"1=大客车\r\n2=中巴车\r\n3=面包车";}', 'on', 'on', 'on'),
(19, 8, 10, '摩托车品牌', '摩托车品牌', 'moto_brand', 'select', 'a:1:{s:7:"choices";s:74:"1=雅马哈\r\n2=本田\r\n3=建设\r\n4=铃木\r\n5=宗申\r\n6=力帆\r\n7=豪爵\r\n8=新大洲\r\n9=其它";}', 'on', 'on', 'on'),
(20, 8, 11, '拼车类型', '拼车类型', 'carpool_type', 'select', 'a:1:{s:7:"choices";s:52:"1=长途车拼车\r\n2=上下班拼车\r\n3=上下学拼车\r\n4=其它拼车";}', 'on', 'on', 'on'),
(21, 8, 12, '目的地', '目的地', 'destination', 'text', 'a:1:{s:9:"maxlength";s:0:"";}', 'on', 'on', ''),
(22, 8, 13, '自行车品牌', '自行车品牌', 'bike_brand', 'select', 'a:1:{s:7:"choices";s:32:"1=永久\r\n2=凤凰\r\n3=捷安特\r\n4=其它";}', 'on', 'on', 'on'),
(24, 7, 24, '宠物类型', '宠物类型', 'pet_type', 'select', 'a:1:{s:7:"choices";s:36:"1=狗\r\n2=猫\r\n3=鸟\r\n4=鼠\r\n5=兔\r\n6=其它";}', 'on', 'on', 'on'),
(25, 7, 25, '狗狗品种', '狗狗品种', 'dog_breeds', 'select', 'a:1:{s:7:"choices";s:80:"1=泰迪\r\n2=萨摩耶\r\n3=金毛\r\n4=藏獒\r\n5=雪橇犬\r\n6=哈士奇\r\n7=拉布拉多\r\n8=贵宾\r\n9=其它";}', 'on', 'on', 'on'),
(26, 7, 0, '公母', '动物公母', 'animal_sex', 'radio', 'a:1:{s:7:"choices";s:10:"1=公\r\n2=母";}', 'on', 'on', 'on'),
(27, 7, 26, '宠物类别', '猫猫等其它宠物类别', 'pet_class', 'select', 'a:1:{s:7:"choices";s:30:"1=猫猫\r\n2=水族\r\n3=花鸟\r\n4=其它";}', 'on', 'on', 'on'),
(28, 2, 30, '厂房租售类型', '厂房/仓库/土地租售类型', 'factory_type', 'select', 'a:1:{s:7:"choices";s:94:"1=厂房出租\r\n2=厂房出售\r\n3=仓库出租\r\n4=仓库出售\r\n5=土地出租\r\n6=土地出售\r\n7=其它出租\r\n8=其它出售";}', 'on', 'on', 'on'),
(29, 2, 31, '租金', '厂房/写字楼出租价格', 'min_rent', 'number', 'a:2:{s:5:"units";s:10:"元/平米/天";s:7:"choices";s:56:"1~2=1~2元/平米/天\r\n2~4=2~4元/平米/天\r\n4~=4元以上/平米/天";}', 'on', 'on', 'on'),
(30, 2, 32, '面积', '房屋面积', 'acreage', 'number', 'a:2:{s:5:"units";s:4:"平米";s:7:"choices";s:107:"1~30=30平米以内\r\n30~50=30~50平米\r\n50~90=50~90平米\r\n90~150=90~150平米\r\n150~300=100~300平米\r\n300~=300平米以上";}', 'on', 'on', 'on'),
(31, 2, 0, '店铺分类', '店铺分类', 'store_type', 'select', 'a:1:{s:7:"choices";s:115:"1=餐饮美食\r\n2=服饰鞋包\r\n3=酒店宾馆\r\n4=超市零售\r\n5=空铺转让\r\n6=美容美发\r\n7=家居建材\r\n8=汽修美容\r\n9=电子通讯\r\n10=其它";}', 'on', 'on', 'on'),
(32, 2, 33, '租金', '店铺/房屋租金', 'rent', 'number', 'a:1:{s:5:"units";s:2:"元";}', 'on', 'on', ''),
(33, 2, 34, '身份', '个人/中介', 'position', 'radio', 'a:1:{s:7:"choices";s:16:"1=个人\r\n2=经纪人";}', 'on', 'on', 'on'),
(34, 2, 35, '装修', '装修情况', 'renovation', 'select', 'a:1:{s:7:"choices";s:42:"1=毛坯房\r\n2=简单装修\r\n3=中等装修\r\n4=精装修";}', 'on', 'on', 'on'),
(35, 2, 36, '房型', '房型', 'room_type', 'select', 'a:1:{s:7:"choices";s:71:"1=4室及以上\r\n2=3室2厅\r\n3=3室1厅\r\n4=2室2厅\r\n5=2室1厅\r\n6=1室1厅\r\n7=1室0厅";}', 'on', 'on', 'on'),
(36, 2, 37, '楼层', '', 'floor', 'number', 'a:1:{s:5:"units";s:2:"楼";}', 'on', 'on', ''),
(37, 2, 38, '出租形式', '出租形式', 'rent_type', 'select', 'a:1:{s:7:"choices";s:22:"1=整套\r\n2=单间\r\n3=床位";}', 'on', 'on', 'on'),
(38, 2, 39, '租金', '', 'mini_rent', 'number', 'a:2:{s:5:"units";s:2:"元";s:7:"choices";s:98:"1~1000=1000以内\r\n1000~3000=1000~3000\r\n3000~5000=3000~5000\r\n5000~10000=5000~10000\r\n10000~=10000以上";}', 'on', 'on', 'on'),
(39, 1, 0, '来源', '服务者身份', 'from', 'radio', 'a:1:{s:7:"choices";s:14:"1=个人\r\n2=商家";}', 'on', 'on', 'on'),
(40, 4, 39, '月薪', '月薪', 'salary', 'select', 'a:1:{s:7:"choices";s:112:"1=面议\r\n2=1000以下\r\n3=1000~2000\r\n4=2000~3000\r\n5=3000~6000\r\n6=6000~8000\r\n7=8000~12000\r\n8=12000~30000\r\n9=30000以上";}', 'on', 'on', 'on'),
(41, 4, 41, '日薪', '日薪', 'day_salary', 'number', 'a:2:{s:5:"units";s:5:"元/天";s:7:"choices";s:117:"1~20=20元以内/天\r\n20~50=20~50元/天\r\n50~100=50~100元/天\r\n100~300=100~300元/天\r\n300~500=300~500元/天\r\n500~=500元以上/天";}', 'on', 'on', 'on'),
(42, 4, 42, '公司名称', '公司名称', 'company', 'text', 'a:1:{s:9:"maxlength";s:0:"";}', 'on', 'on', ''),
(43, 4, 43, '性别要求', '性别要求', 'sex_demand', 'checkbox', 'a:1:{s:7:"choices";s:10:"1=男\r\n2=女";}', 'on', 'on', ''),
(44, 4, 44, '职位', '职位', 'job', 'text', 'a:1:{s:9:"maxlength";s:0:"";}', 'on', '', ''),
(45, 4, 45, '性别', '性别', 'sex', 'radio', 'a:1:{s:7:"choices";s:10:"1=男\r\n2=女";}', 'on', '', 'on'),
(46, 4, 46, '年龄', '年龄', 'age', 'number', 'a:1:{s:5:"units";s:2:"岁";}', 'on', 'on', ''),
(47, 4, 47, '学历', '学历', 'education', 'select', 'a:1:{s:7:"choices";s:68:"1=初中及以下\r\n2=高中/中专/技校\r\n3=大专\r\n4=本科\r\n5=硕士\r\n6=博士及以上";}', 'on', 'on', 'on'),
(48, 4, 48, '是否应届', '是否应届', 'graduate', 'radio', 'a:1:{s:7:"choices";s:16:"1=应届\r\n2=非应届";}', 'on', '', 'on'),
(49, 4, 49, '工作年限', '工作年限', 'work_life', 'number', 'a:2:{s:5:"units";s:2:"年";s:7:"choices";s:60:"1~1=1年以下\r\n1~2=1~2年\r\n3~5=3~5年\r\n6~10=6~10年\r\n10~=10年以上";}', 'on', 'on', ''),
(50, 6, 50, '学费', '课程学费', 'tuition', 'number', 'a:2:{s:5:"units";s:2:"元";s:7:"choices";s:98:"1~1000=1000以内\r\n1000~3000=1000~3000\r\n3000~5000=3000~5000\r\n5000~10000=5000~10000\r\n10000~=10000以上";}', 'on', '', 'on'),
(51, 3, 51, '我会', '我的技能', 'ican', 'checkbox', 'a:1:{s:7:"choices";s:125:"1=魔术\r\n2=古玩鉴赏\r\n3=电器维修\r\n4=唱歌\r\n5=方言\r\n6=理财/金融\r\n7=数理化\r\n8=武术\r\n9=象棋/围棋\r\n10=中医\r\n11=平面设计\r\n12=服装设计";}', 'on', '', ''),
(52, 3, 52, '职业', '', 'jobs', 'text', 'a:1:{s:9:"maxlength";s:0:"";}', 'on', '', ''),
(54, 5, 54, '电脑品牌', '电脑品牌', 'pc_brand', 'select', 'a:1:{s:7:"choices";s:109:"1=戴尔\r\n2=华硕\r\n3=惠普\r\n4=联想\r\n5=IBM\r\n6=苹果\r\n7=三星\r\n8=东芝\r\n9=神舟\r\n10=方正\r\n11=清华同方\r\n12=索尼\r\n13=其它";}', 'on', 'on', 'on'),
(55, 5, 55, '电器类型', '电器类型', 'appliances', 'select', 'a:1:{s:7:"choices";s:100:"1=空调\r\n2=厨房电器\r\n3=居家电器\r\n4=影音电器\r\n5=冰箱/冷柜\r\n6=电视机\r\n7=卫浴/护理电器\r\n8=洗衣机\r\n9=其它";}', 'on', 'on', 'on'),
(58, 5, 58, '新旧程度', '新旧程度', 'new_old', 'select', 'a:1:{s:7:"choices";s:33:"1=全新\r\n2=9成新\r\n3=7成新\r\n4=5成新";}', 'on', 'on', 'on'),
(60, 8, 0, '摩托车品牌', '', 'motobrand', 'select', 'a:1:{s:7:"choices";s:74:"1=雅马哈\r\n2=本田\r\n3=建设\r\n4=铃木\r\n5=宗申\r\n6=力帆\r\n7=豪爵\r\n8=新大洲\r\n9=其它";}', 'on', 'on', 'on'),
(61, 4, 0, '福利', '', 'fuli', 'checkbox', 'a:1:{s:7:"choices";s:99:"1=五险一金\r\n2=包住\r\n3=包吃\r\n4=年底双薪\r\n5=周末双休\r\n6=交通补助\r\n7=加班补助\r\n8=餐补\r\n9=话补\r\n10=房补";}', 'on', 'on', 'on'),
(62, 4, 0, '公司性质', '', 'property', 'radio', 'a:1:{s:7:"choices";s:95:"1=私营\r\n2=国有\r\n3=股份制\r\n4=外商独资办事处\r\n5=中外合资/合作\r\n6=上市公司\r\n7=事业单位\r\n8=政府机关";}', 'on', 'on', 'on'),
(64, 2, 0, '房屋配置', '', 'house_pro', 'checkbox', 'a:1:{s:7:"choices";s:81:"1=床\r\n2=衣柜\r\n3=沙发\r\n4=电视\r\n5=冰箱\r\n6=洗衣机\r\n7=空调\r\n8=热水器\r\n9=宽带\r\n10=暖气";}', 'on', 'on', '');


DROP TABLE IF EXISTS `my_information_2`;
CREATE TABLE IF NOT EXISTS `my_information_2` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_6`;
CREATE TABLE IF NOT EXISTS `my_information_6` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `pc_brand` tinyint(1) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_7`;
CREATE TABLE IF NOT EXISTS `my_information_7` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `sex_demand` varchar(100) NOT NULL DEFAULT '0',
  `salary` tinyint(1) NOT NULL DEFAULT '0',
  `job` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `content` mediumtext,
  `education` tinyint(1) NOT NULL DEFAULT '0',
  `work_life` mediumint(7) NOT NULL DEFAULT '0',
  `fuli` varchar(100) NOT NULL DEFAULT '0',
  `property` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_8`;
CREATE TABLE IF NOT EXISTS `my_information_8` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `day_salary` mediumint(7) NOT NULL DEFAULT '0',
  `company` varchar(250) NOT NULL,
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_9`;
CREATE TABLE IF NOT EXISTS `my_information_9` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `age` mediumint(7) NOT NULL DEFAULT '0',
  `education` tinyint(1) NOT NULL DEFAULT '0',
  `graduate` tinyint(1) NOT NULL DEFAULT '0',
  `work_life` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_10`;
CREATE TABLE IF NOT EXISTS `my_information_10` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `tuition` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_11`;
CREATE TABLE IF NOT EXISTS `my_information_11` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `ebike_brand` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_12`;
CREATE TABLE IF NOT EXISTS `my_information_12` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `car_brand` tinyint(1) NOT NULL DEFAULT '0',
  `car_year` tinyint(1) NOT NULL DEFAULT '0',
  `mileage` mediumint(7) NOT NULL DEFAULT '0',
  `prices` mediumint(7) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_13`;
CREATE TABLE IF NOT EXISTS `my_information_13` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `bike_brand` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_14`;
CREATE TABLE IF NOT EXISTS `my_information_14` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `carpool_type` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `destination` varchar(250) NOT NULL,
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_15`;
CREATE TABLE IF NOT EXISTS `my_information_15` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `mileage` mediumint(7) NOT NULL DEFAULT '0',
  `car_year` tinyint(1) NOT NULL DEFAULT '0',
  `prices` mediumint(7) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_16`;
CREATE TABLE IF NOT EXISTS `my_information_16` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `prices` mediumint(7) NOT NULL DEFAULT '0',
  `new_old` tinyint(1) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_18`;
CREATE TABLE IF NOT EXISTS `my_information_18` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `ican` varchar(100) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_19`;
CREATE TABLE IF NOT EXISTS `my_information_19` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `age` mediumint(7) NOT NULL DEFAULT '0',
  `jobs` varchar(250) NOT NULL,
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_20`;
CREATE TABLE IF NOT EXISTS `my_information_20` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `dog_breeds` tinyint(1) NOT NULL DEFAULT '0',
  `animal_sex` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_21`;
CREATE TABLE IF NOT EXISTS `my_information_21` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `pet_class` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_22`;
CREATE TABLE IF NOT EXISTS `my_information_22` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `renovation` tinyint(1) NOT NULL DEFAULT '0',
  `room_type` tinyint(1) NOT NULL DEFAULT '0',
  `floor` mediumint(7) NOT NULL DEFAULT '0',
  `prices` mediumint(7) NOT NULL DEFAULT '0',
  `acreage` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_23`;
CREATE TABLE IF NOT EXISTS `my_information_23` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `rent_type` tinyint(1) NOT NULL DEFAULT '0',
  `room_type` tinyint(1) NOT NULL DEFAULT '0',
  `mini_rent` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  `house_pro` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_24`;
CREATE TABLE IF NOT EXISTS `my_information_24` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `position` tinyint(1) NOT NULL DEFAULT '0',
  `acreage` mediumint(7) NOT NULL DEFAULT '0',
  `min_rent` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_25`;
CREATE TABLE IF NOT EXISTS `my_information_25` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `acreage` mediumint(7) NOT NULL DEFAULT '0',
  `prices` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_26`;
CREATE TABLE IF NOT EXISTS `my_information_26` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `store_type` tinyint(1) NOT NULL DEFAULT '0',
  `acreage` mediumint(7) NOT NULL DEFAULT '0',
  `rent` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `my_information_27`;
CREATE TABLE IF NOT EXISTS `my_information_27` (
  `iid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL DEFAULT '0',
  `motobrand` tinyint(1) NOT NULL DEFAULT '0',
  `price` mediumint(7) NOT NULL DEFAULT '0',
  `from` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext,
  PRIMARY KEY (`iid`),
  KEY `id` (`id`)
) TYPE=MyISAM;