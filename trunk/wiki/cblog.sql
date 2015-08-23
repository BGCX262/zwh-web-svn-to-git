-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 04 月 25 日 09:23
-- 服务器版本: 5.1.50
-- PHP 版本: 5.3.9-ZS5.6.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cblog`
--

-- --------------------------------------------------------

--
-- 表的结构 `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `nickname` varchar(20) NOT NULL DEFAULT '',
  `sex` varchar(10) NOT NULL,
  `role` varchar(60) NOT NULL DEFAULT '',
  `photo` varchar(255) NOT NULL DEFAULT '/global/images/head/default.jpg',
  `email` varchar(60) NOT NULL DEFAULT '',
  `qq` varchar(20) DEFAULT NULL,
  `msn` varchar(60) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `job` varchar(20) DEFAULT NULL,
  `job_year` varchar(20) DEFAULT NULL,
  `regist_time` date DEFAULT NULL,
  `introduce` text,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `nickname`, `sex`, `role`, `photo`, `email`, `qq`, `msn`, `site`, `job`, `job_year`, `regist_time`, `introduce`, `description`) VALUES
(1, '周文洪', '123456', 'zhouwenhong', '男', 'member', '/upload/image/head/1335163569.jpg', '15191430259@163.com', NULL, NULL, NULL, NULL, NULL, '2012-03-08', NULL, '欢迎来到虫儿飞的博客家园'),
(3, '李凯', '123456', 'likai', '男', 'member', '/upload/image/head/1335144594.jpg', '143@163.com', NULL, NULL, NULL, '部长', '一年', '2012-03-11', NULL, '走过路过不要错过啊'),
(0, '管理员', '123456', 'admin', '男', 'admin', '/global/images/head/default.jpg', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '姜勇泉', '123456', 'jiangyongquan', '男', 'member', '/global/images/head/3.jpg', '15191430259@163.com', NULL, NULL, NULL, '管理', '一年', '2012-03-24', NULL, '放飞梦想，奔向自由！'),
(12, '小雪', '123456', 'xiaoxue', '女', 'member', '/upload/image/head/1334107306.jpg', '1434789302@qq.com', NULL, NULL, NULL, '经理', '五年到十年', '2012-03-30', '', '越活越年轻！');

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text,
  `account_id` int(11) unsigned NOT NULL,
  `atype_id` varchar(10) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `view_counter` int(7) unsigned NOT NULL DEFAULT '0',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `account_id`, `atype_id`, `cate_id`, `sort_order`, `view_counter`, `add_time`) VALUES
(1, '烟雨江南', '<p>\r\n	<br />\r\n	&nbsp;&nbsp;&nbsp; 这是神马啊？青石板上的马蹄声渐渐远去，是谁用若即若离的一笔，将回忆埋葬在烟雨江南里&hellip;&mdash;&mdash;题记<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;江南终于展现出她多雨的一面，雨丝飘飘洒洒，氤氲岚烟，也为铜陵这个江南小城平添了些许灵动。枕上初寒窗外雨，草阶寒露翠欲滴。燕归南浦喜泥润，谁知江南又一春。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;江南如诗，古至今来，多少文人墨客在这有着曼妙容姿的江南留下唱不尽的诗篇。荷花池畔，雨乱碧水，风动荷叶。你可以体味到&ldquo;低头弄莲子，莲子清如水&rdquo;的清新。站在扬州的古桥，你可以走在长满青苔的青石板板上，然后在潺潺流水中，听到&ldquo;念桥边红药，年年知为谁生&rdquo;的诉说。在斑驳的雨巷，你可以撑一把古老的纸伞，彳亍在寂寥的时空，感受江南这独有的淡淡忧愁。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;江南如画，精致而不失典雅，她是一副浓墨淡染的中国画，只有写意的水墨才能描绘出江南的千年风华，而写实则勾勒不出江南淡雅的轮廓。雨中的江南，风轻轻卷起柳絮，散满江南的每一寸肌肤。雨打芭蕉，声声催天语，将江南的忧伤弥漫整个时空。炊烟袅袅，清风微抚，将江南的气息融入每份草木。而江南的风姿又岂是世俗的线条所能描绘的，所以我宁愿江南是我梦中的江南。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;江南如歌，古老的秦淮河畔，至今还能听见百年前的低声呓语。江南应是一首清新质朴的古筝曲，你可以随着那优美的曲调，梦回千年前的江南，忘却这纷纷扰扰的世间，在那如歌的江南做一个潇洒的词人，将喜怒哀乐都积淀在这烟雨江南。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;一缕青丝，无法解读我的思念；一生珍藏，无法追寻曾经的诺言。身在江南，雨落心间，年复一年，徒留谁的孤单，纵然记忆已成灰，我洗涤曾经的回忆，无法转身。再次为你挥毫，将所有思念化于这烟雨中的江南。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;跳跃的雨滴，闪烁着透明的忧伤，天空用深沉的目光，遥测着大地的距离，氤氲的时空，将雨水沉淀，在那烟雨中的江南，风轻柔的托起雨丝，洗尽烦躁浮华，沉醉在那隽永的雨季青春。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;正所谓，烟雨江南，无你何欢。<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;<br />\r\n	&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n', 1, '1', 1, 255, 210, '2012-03-13 05:53:40'),
(2, '浮生若梦，何去何从', '<p><br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;文/落篱<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;浮生若梦呵，我将何去何从？或许，我已经找到自己命运的支点。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;&mdash;&mdash;【题记】<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;我无法抑制每一个音符排列的忧伤旋律，也无法逃避每一支迷茫交汇的沉郁奏曲；<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;我无法隔离每一行<a class="keywordlink" href="http://www.jj59.com">文字</a>铺陈的寂静之旅，也无法握紧每一次微笑传达的欢乐喜讯；<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;我无法阻止每一出生命演绎的痛苦戏剧，也无法留住每一片转瞬即逝的柔美风景；<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;莫非生命的道路注定充满坎坷和苦痛？我在苦行的路上，也常常会问，我这一生所为什么？我的归宿又在哪里？没有谁能回答，我也不奢求谁能回答，或者，根本就没有人能回答。只是，日子依旧这么匆匆的走着，有些东西得到了，有些却在淡漠中丢失。在得与失之间，永远有一个看不清摸不着的动态平衡，教人们去领悟去执行知足常乐的道理。生命，原来只是一场梦。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;我无法用一种确切的概念去衡量自己的得失，却在思绪的涌流中自我折堕，也许我真不该怂恿自己的任意而为。那是一种放纵的任性，是一种疯狂的偏执，却又在一次次的深思中兜兜转转，最后停靠在本不属于自己的港湾，徘徊不定。原来自己在生命中根本无法找到一个支点。可笑的我站在风雨飘摇的航船上，任由起伏，周围狂风巨浪，我做不到岿然不动，也只能任由沉浮。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;也许，就这么突然而然的慌了，开始担忧，开始惊魂不定，开始杞人忧天一般的悲怨，开始一次次的跌入内心的荒原，自我封锁，把自己的快乐囚禁，开始游离在苦痛的边缘把自己当成与这个世界格格不入的人去看待。而似乎自己能做的也就只有这些，漫无目的，毫无价值，无用到奢侈。原来，我的世界注定只有雨天，没有人替我撑伞，而晴天永远都划着一个大大的问号。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;是什么时候起开始有了自己的悲观呢？记不得了，只是觉得自己不过一个矛盾的综合体。甚至把自己判成两个人，把躯体和灵魂撕散。面对<a class="keywordlink" href="http://www.jj59.com/zheliwenzhang/">人生</a>种种，硬是和自己的悲伤过不去，在痛苦中挖掘回忆的资源，在孤独中徘徊疗伤，也许所能做的就只有这些，我找不到更好的理由让自己坦然。经历了人生种种，我已经习惯了把悲伤淡然，有时候淡看总比铭记更能表达自己的意愿。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;生命呵，真的注定只是梦一场么？当快乐走了，痛苦也跟着走了，一切便真只剩虚妄了么，那我的坚守又是为了什么？<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;生命呵，真的注定只是梦一场么？所有的纸醉金迷，所有的灯红酒绿，所有的<a class="keywordlink" href="http://www.jj59.com/zti/fanhua/">繁华</a>、荣耀、金钱和地位将化为尘埃么？<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;生命呵，真的注定只是梦一场么？是一场梦罢，我仍旧多么希望自己的苦痛能少点，再赐我被庇护的安然，可是能么？<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;我常常想起小时候，没有烦恼没有争斗，不需要面对任何忧愁。我知道那时候哭泣可以解决很多问题，我也知道淘气卖乖可以换来微笑和拥抱。而我的本职工作只是好好地乖乖地玩，无忧无虑，用充满好奇的眼光去探寻这个世界展现给我的一切，那些事物的动态，那些人物的表<a class="keywordlink" href="http://www.jj59.com/">情</a>，那些语言和动作、色彩和声音，那些自然界的规律，所有一切人之常情等等。我急切盼望自己能够快点长大。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;可终于等到我渐渐长大了以后，却发现不对劲了，我竟然没有以前那么快乐，大大的出乎意料。我开始面临烦恼的侵袭，开始学会一种叫做自我封闭的东西，开始明白快乐的背后存在着烦恼。我知道这是一种历练，是一种促进，我也知道这是天降大任的征兆，但不是每一个人都能那么幸运的被幸运砸中的。我已清醒，但我怎能服气，我的青春和生命从来都不服输，我知道还有另一条路。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;于是我选择了继续追寻，还学会了使用一个很有用的名词，叫做淡定。在淡定中运筹帷幄，用自己的眼光探索前行的路途，在淡定中放下一切羁绊。我的生命和成长呵，不过需要一个足以让自己坚定的支点，需要一个可以让自己放手一搏的方向，和一个能让自己不断成长的理由。这些我都可以找到，我还能呼吸，还有脉搏和心跳，还有清醒的头脑，还有支撑自己生命的精神力。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;是的，我该感谢生命赋予我的一切，这弥足珍贵经历一次便永不忘却的一切。我才发现我的思想因为磨练而迸发出绚烂的火花，正渐渐迈向高远；我的胸襟也在一次次的陶冶中得到完美的历练，在温厚中沉淀；我的视野正在不断开拓，锐利如雄鹰的双眼；我的足迹正漫延到无际的天边，在那里,有一个单薄的身影朝着远方不断向前、向前，最后，镶嵌在意境浑厚的画中凝成一个点…<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;浮生若梦呵，我将何去何从？或许，我已经找到自己命运的支点。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;落篱文学<a class="keywordlink" href="http://www.jj59.com/yuanchuang/">原创</a>QQ：1764039192<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;</p>', 1, '2', 1, 255, 122, '2012-03-13 05:55:50'),
(3, '千年风华谁暗换，陪君醉笑三万场', '<p>&nbsp;&nbsp;&nbsp;&nbsp;千年风华谁暗换，陪君醉笑三万场<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;文/林雨阳2012.1.14<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;君陪我笑，笑叹千年风华，不诉离伤-----题记<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;一只竖琴，默默拔弹着脑海飘飞的琴思，空气中散沫花香的气息悄然弥漫。不思量，自难忘，闪烁的花影中谁恰似身披一袭霓裳，在古老澄净的水光日影中倒影深深。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;\r\n&nbsp;&nbsp;&nbsp;&nbsp;憩息的曲调用时光去遗忘，静谧湖水缓缓流淌，水草湖岸池塘，青苔满地，暮色越过幽静的栅栏便枯萎了枝头上的光，低吟浅浅忧伤，一片残月被风扯散，跌落在梦中的一湾绿波。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;忆昔千年风波乱，黯然<a class="keywordlink" href="http://www.jj59.com/zti/xue/">雪</a>上弄离伤。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;昨夜小楼春风满，缓缓炊烟孤寂淡。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;笔影横斜照流水，披衣望月思绪寒。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;江边滚滚东逝水，莫叹流霜不觉飞。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;墨迹犹在水犹寒，婉约依稀似前唐。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;嫣然山水笔墨香，醉人不过画藏烟。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;迢迢青路危千丈，段段云清纸上染。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;风打幽居无人迹，孤上静寂流云巅。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;秋风吹瑟青衣展，青衣绣色流云穿。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;袅袅依稀烟瓦村，小桥摇船闹声桨。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;零落山前秋水边，院寺苔青斑驳墙。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;风华去兮叹沧桑，<a class="keywordlink" href="http://www.jj59.com/zti/fanhua/">繁华</a>褪兮夜苍茫。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;遥望长安烽烟战，一曲吹尽烟雨乱。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;谁欲策马剑流光，残垣鼓破兵马散。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;摇曳寒光纱帐暖，挥斥方遒忆周郎。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;洛水畔，泪凝伤，洛川流眄步轻莲，流风隐雪飘飘展，回首建安思风骨，洛神白马登台述，八斗才挥七步诗，铜雀犹有对酒行，烽烟剑阁畔，文思对琵琶，奈何人去，寂寞叹沧桑。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;古道含芳，类冰类雪结叶悬，郁郁萦楼轩，碧螺春色满壶瞰，薄片铁色浮尘远，《茶经》羽著，流水依绕窗前路，壶前弄流水，流水洗青壶，幽然临晚暮，茶香不若酒香苦。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;桃花庵，葬花殇，几许飘零几许伤，万里河山笔墨畔，春华暗换，谁将往事付诗行，空余一生叹，凌乱罗衫暗，悲弦初断，寂寞寄余生。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;窑烧里，青瓷写意，冰裂釉色凝脂透，流水行云晚霞笔，越窑秋色，邢窑素白，千峰翠色淌细腻，青碧梅子，杯上小桥残阳晚风笛。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;梨园春秋浅唱里，霸王别姬西厢记，贵妃醉酒花田错，腔酝浅调梆曲声，京韵画谱，婉转低吟，千秋曲调谁追寻，风尘千里外，唱尽世间红尘意，忘了人间。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;琴瑟里，二泉映月空思忆，汉宫秋月琵琶迷，七弦瑶琴声满地，高山弹流水，阳春送白雪，古筝轻抚对月诉，竹前抚笛游子意，乱了思绪。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;千年已去，独自思往事，往事如烟尘，在历史徐徐打开的画卷中上演后便被风吹尽，飘零宛若一粒沙子，屈原赋离骚，苏武牧羊，七步曹诗，烽火赤壁，诗墨风流，笔墨丹青，留下的，不过书卷上短短的几个字，沧桑一世，风流盛唐，如今已逝，留下几多日落的痕迹，只付东流水，凭栏一声叹,逝去痕迹。<br>\r\n\r\n&nbsp;&nbsp;&nbsp;&nbsp;幽幽霜落地，何处追寻空悲忆，孤月落乌啼，残阳水中意，归去是往昔。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;陪君醉笑三万场，叹千年风华，如秋草满地，穿过历史的尘埃相望，举杯与君共饮。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;笑声远去，敢问，谁是谁的往事，谁又是谁的记忆？不过去去千里烟波中的一浪。<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;交流：976263375林雨阳<br>\r\n&nbsp;&nbsp;&nbsp;&nbsp;</p>', 1, '3', 1, 255, 33, '2012-03-13 09:08:59'),
(79, '刚才是怎么回事呢', '为什么没有一下显示出创建的文章呢？<br />', 1, '1', 1, 255, 2, '2012-04-23 01:22:19'),
(80, '在发表一篇文章', '<p>\r\n	原来这样啊，我明白了 Zend_Cache 的使用方法了。\r\n</p>\r\n<br />', 1, '1', 1, 255, 16, '2012-04-23 01:23:49'),
(69, '我来创建一篇关于css的吧', '<p>\r\n	用来设定table的样式。\r\n</p>\r\n<br />', 1, '1', 8, 255, 29, '2012-03-29 02:34:05'),
(78, '发表一篇问章', '<p>\r\n	看看zend_cache是怎么删掉缓存的。\r\n</p>\r\n<br />', 1, '1', 1, 255, 3, '2012-04-23 01:21:34'),
(66, '李凯来创建一篇问章', '第一次写博客啊！ 伤不起呀！！！<br />', 3, '1', 1, 255, 222, '2012-03-26 06:54:43'),
(68, '关于html5前景', '应用将十分广泛！<br />', 1, '1', 2, 255, 6, '2012-03-28 08:28:59');

-- --------------------------------------------------------

--
-- 表的结构 `atype`
--

CREATE TABLE IF NOT EXISTS `atype` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `atype` varchar(20) NOT NULL,
  `comment` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `atype`
--

INSERT INTO `atype` (`id`, `atype`, `comment`) VALUES
(1, 'original', '原创'),
(2, 'translate', '翻译'),
(3, 'repost', '转载');

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate` varchar(20) NOT NULL,
  `account_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `cate`, `account_id`, `position`) VALUES
(1, '默认分类', 1, 5),
(2, 'html5', 1, 2),
(3, 'javascript', 1, 4),
(4, 'linux', 1, 3),
(6, 'dom', 1, 6),
(7, 'bom', 1, 7),
(8, 'css', 1, 8),
(9, '文学', 3, 1),
(10, '美文', 3, 2),
(11, '默认分类', 4, 1),
(12, '默认分类', 12, 1),
(13, 'php', 1, 9);

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) unsigned NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `replywho` varchar(20) DEFAULT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_id` bigint(20) NOT NULL DEFAULT '0',
  `article_id` bigint(20) unsigned NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `account_id`, `nickname`, `replywho`, `post_time`, `comment_id`, `article_id`, `content`) VALUES
(75, 1, 'zhouwenhong', '', '2012-03-28 01:15:47', 0, 1, '我来输个？号看看。<br />'),
(73, 3, 'likai', '', '2012-03-28 01:00:58', 0, 1, '不错嘛，挺可以的哦！<br />'),
(15, 1, 'zhouwenhong', '', '2012-03-20 08:45:03', 0, 2, '\r\n	测试一下'),
(16, 3, 'likai', '', '2012-03-20 08:57:35', 0, 1, '\r\n	这文章不错!'),
(18, 1, 'zhouwenhong', 'likai', '2012-03-20 08:59:49', 16, 1, '\r\n	真的 挺好'),
(19, 3, 'likai', 'zhouwenhong', '2012-03-20 09:02:53', 18, 1, '\r\n	扫卡'),
(74, 2, 'jiangyongquan', '', '2012-03-28 01:11:29', 0, 1, '老姜来了哦，看看有发表什么新文章了？<br />'),
(69, 1, 'zhouwenhong', '', '2012-03-26 06:57:37', 0, 66, '来啦，我给李凯评论评论！<br />'),
(76, 1, 'zhouwenhong', 'likai', '2012-03-29 02:14:33', 19, 1, '到哪扫卡去？<br />'),
(96, 3, 'likai', '', '2012-04-23 01:32:40', 0, 80, '\r\n	技术男！\r\n'),
(79, 3, 'likai', '', '2012-04-10 07:04:53', 0, 68, '很不错！<br />'),
(100, 1, 'zhouwenhong', '', '2012-04-24 03:27:48', 0, 69, '<pre class="brush:css; toolbar: true; auto-links: false;">&lt;style type="text/css"&gt;\r\n        h1{\r\n            background-color: red;\r\n       }\r\n&lt;/style&gt;</pre>\r\n<br />'),
(99, 12, 'xiaoxue', '', '2012-04-23 06:49:03', 0, 80, '\r\n	两分钟应该可以接收滴。\r\n'),
(98, 1, 'zhouwenhong', '', '2012-04-23 06:35:12', 0, 80, '设置了两分钟的缓存时间，可以承受不？<br />'),
(97, 12, 'xiaoxue', '', '2012-04-23 01:33:51', 0, 3, '美文，很好！very good');

-- --------------------------------------------------------

--
-- 表的结构 `industry`
--

CREATE TABLE IF NOT EXISTS `industry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `career_name` varchar(100) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `memfriend_link`
--

CREATE TABLE IF NOT EXISTS `memfriend_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL,
  `label` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `memfriend_link`
--

INSERT INTO `memfriend_link` (`id`, `account_id`, `label`, `link`, `position`) VALUES
(5, 3, 'csdn', 'http://www.csdn.net', 1),
(3, 1, '百度', 'http://www.baidu.com', 2),
(4, 1, 'google', 'http://www.google.com.hk', 3),
(6, 1, 'csdn', 'http://www.csdn.net', 4);

-- --------------------------------------------------------

--
-- 表的结构 `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `access_level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `menus`
--

INSERT INTO `menus` (`id`, `name`, `access_level`) VALUES
(1, '用户导航链接', 'member'),
(2, '顶部友情链接', 'admin'),
(3, '底部友情链接', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `label` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `access_rule` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `label`, `link`, `position`, `access_rule`) VALUES
(13, 1, '友情链接', '/memfriendlink/index', 10, 'admin'),
(3, 2, 'zend framework 中文手册', 'http://framework.zend.com/manual/zh/manual.html', 1, 'member'),
(4, 2, '51CTO', 'http://www.51cto.com/', 2, 'member'),
(5, 1, '写文章', '/post/index', 9, 'admin'),
(9, 1, '个人设置', '/blogger/profile', 7, 'admin'),
(10, 1, '博客配置', '/blogger/config', 8, 'admin'),
(8, 1, '评论管理', '/blogger/comlist', 3, 'admin'),
(12, 1, '分类管理', '/category/index', 6, 'admin'),
(14, 1, '更新缓存', '/blogger/updatemem', 11, 'admin'),
(15, 3, 'CSDN', 'http://www.csdn.net', 2, 'member'),
(16, 3, '嵌牛学院', 'http://school.2embed.com/', 1, 'member');

-- --------------------------------------------------------

--
-- 表的结构 `view_statistic`
--

CREATE TABLE IF NOT EXISTS `view_statistic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `ip` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `view_statistic`
--

INSERT INTO `view_statistic` (`id`, `account_id`, `ip`) VALUES
(1, 1, '10.65.10.83'),
(2, 1, '10.65.10.71'),
(3, 12, '10.65.10.83'),
(4, 3, '10.65.10.83'),
(5, 13, '10.65.10.83'),
(6, 14, '10.65.10.83'),
(7, 15, '10.65.10.83');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
