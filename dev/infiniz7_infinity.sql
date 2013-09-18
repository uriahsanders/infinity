SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `affiliation`;
CREATE TABLE IF NOT EXISTS `affiliation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `date` datetime NOT NULL,
  `user` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `index` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`ID`),
  KEY `index` (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

INSERT DELAYED INTO `bookmarks` (`ID`, `user`, `url`, `desc`, `index`) VALUES
(5, 1, 'http://dev.infinity-forum.org/member/forum/', 'Forum', 100),
(4, 1, 'http://dev.infinity-forum.org/member/', 'Member Page', 100),
(6, 1, 'http://dev.infinity-forum.org/about/', 'about', 100),
(7, 1, 'http://dev.infinity-forum.org/help/', '123', 100),
(8, 33, 'http://dev.infinity-forum.org/member/', 'nnn', 100),
(9, 33, 'http://dev.infinity-forum.org/', 'hhh', 100),
(10, 31, 'http://dev.infinity-forum.org/forum/', 'forum', 100),
(11, 1, 'http://dev.infinity-forum.org/member/?freelancing', '''dfgdfg', 100),
(12, 1, 'http://dev.infinity-forum.org/member/?projects', 'sfdfsdf''', 100);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `creator` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

INSERT DELAYED INTO `categories` (`id`, `cat`, `description`, `creator`) VALUES
(8, 'test', 'test', 4),
(7, 'test', 'test', 4),
(9, 'test', 'test', 4),
(10, 'test3', 'r', 4),
(11, 'test3', 'r', 4),
(12, 'test3', 'r', 4),
(13, 'test3', 'r', 4);

DROP TABLE IF EXISTS `challenges`;
CREATE TABLE IF NOT EXISTS `challenges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `reward` varchar(100) NOT NULL,
  `importance` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `asker` varchar(30) NOT NULL,
  `join` varchar(100) NOT NULL,
  `rank` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `check_auth_debug`;
CREATE TABLE IF NOT EXISTS `check_auth_debug` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `IP` varchar(20) NOT NULL,
  `post` text NOT NULL,
  `get` text NOT NULL,
  `session` text NOT NULL,
  `if` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(1000) NOT NULL,
  `user` varchar(30) NOT NULL,
  `postid` int(11) NOT NULL,
  `page` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT DELAYED INTO `comments` (`id`, `comment`, `user`, `postid`, `page`) VALUES
(1, 'test', 'jeremy', 9, 'blog'),
(2, 'hi', '', 9, 'blog'),
(3, 'hi', 'uriahsanders', 19, 'blog'),
(4, 'test', '', 510, 'blog'),
(5, 'test', 'jeremy', 510, 'blog'),
(6, 'test', 'jeremy', 512, 'blog'),
(7, 'test', 'jeremy', 3595, 'challenges'),
(8, 'cc', 'Uriah Sanders', 555, 'blog');

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `page` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT DELAYED INTO `files` (`id`, `name`, `page`) VALUES
(46, 'gsdgsdg_taco.jpg', 'blog'),
(47, 'test_trollking.png', 'blog'),
(10, 'test_taco.jpg', 'affiliation'),
(67, 'Mr._AcuTest1880.jpg', 'products'),
(497, 'Mr._AcuTest3695.jpg', 'products'),
(208, 'Mr._AcuTest5116.jpg', 'blog'),
(72, 'Acunetix_AcuTest3087.jpg', 'affiliation');

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `icon` int(2) NOT NULL,
  `icon2` int(2) NOT NULL,
  `sticky` tinyint(1) NOT NULL,
  `locked` int(1) NOT NULL,
  `subject` varchar(254) NOT NULL,
  `text` text NOT NULL,
  `by` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `child_to_b` int(11) NOT NULL,
  `child_to_t` int(11) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `edited` text NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `forum_structure`;
CREATE TABLE IF NOT EXISTS `forum_structure` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `child_to` int(4) NOT NULL,
  `type` int(1) NOT NULL,
  `name` varchar(30) NOT NULL,
  `desc` text CHARACTER SET utf8 NOT NULL,
  `mods` varchar(50) NOT NULL DEFAULT '1',
  `visible_to` varchar(20) NOT NULL DEFAULT '99',
  `index_` int(4) NOT NULL DEFAULT '0',
  `create_date` date NOT NULL DEFAULT '2013-01-17',
  `created_by` int(7) NOT NULL DEFAULT '1',
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

INSERT INTO `forum_structure` (`ID`, `child_to`, `type`, `name`, `desc`, `mods`, `visible_to`, `index_`, `create_date`, `created_by`) VALUES
(1, 0, 0, 'General', '', '1', '99', 0, '2013-01-16', 1),
(3, 1, 1, 'General discussion', 'General educated discussions', '1', '99', 0, '2013-01-16', 1),
(4, 1, 1, 'Members introduction', 'New members, introduce yourself to the community so we can get to know you!', '1', '99', 1, '2013-01-16', 1),
(5, 1, 1, 'Random', 'Frozen Bananas', '1', '99', 2, '2013-01-16', 1),
(6, 0, 0, 'Infinity', '', '1', '99', 1, '2013-01-16', 1),
(7, 6, 1, 'Annoucements', 'Big news concerning the website', '1', '99', 0, '2013-01-16', 1),
(8, 6, 1, 'Suggestions', 'How can we make this website better?', '1', '99', 2, '2013-01-16', 1),
(9, 8, 2, 'Questions', '', '1', '99', 0, '2013-01-16', 1),
(10, 8, 2, 'Comments', '', '1', '99', 1, '2013-01-16', 1),
(11, 8, 2, 'Support', '', '1', '99', 2, '2013-01-16', 1),
(12, 5, 2, 'Fun', '', '1', '99', 0, '2013-01-17', 1),
(14, 0, 0, 'World', '', '1', '99', 2, '2013-01-17', 1),
(15, 14, 1, 'History', 'What did I eat yesterday?', '1', '99', 0, '2013-01-17', 1),
(16, 14, 1, 'Athletics', '* flex *', '1', '99', 1, '2013-01-17', 1),
(17, 14, 1, 'Language', 'Supurinkura no dansu hadakamashou', '1', '99', 2, '2013-01-17', 1),
(18, 14, 1, 'Literature', '50 shades of gray', '1', '99', 3, '2013-01-17', 1),
(19, 14, 1, 'Economics', 'Give me all your money', '1', '99', 4, '2013-01-17', 1),
(20, 14, 1, 'Politics', 'The one who wins is the one who can lie the best', '1', '99', 5, '2013-01-17', 1),
(22, 14, 1, 'Business', 'Lets be like apple, steal ideas and make money from them', '1', '99', 6, '2013-01-17', 1),
(23, 14, 1, 'Religion', 'I never walked on water', '1', '99', 7, '2013-01-17', 1),
(24, 14, 1, 'Philosophy', 'What if a stone wasn''t a stone would you then be able to be stoned to death?', '1', '99', 8, '2013-01-17', 1),
(25, 0, 0, 'Arts', '', '1', '99', 3, '2013-01-17', 1),
(26, 25, 1, 'Culinary', 'I''m hungry.... DAMN YOU WOMAN WHERES MY FOOD????', '1', '99', 0, '2013-01-17', 1),
(27, 25, 1, 'General Art', 'General Art? is this for graffiti?', '1', '99', 1, '2013-01-17', 1),
(28, 27, 2, '3D design', '', '1', '99', 0, '2013-01-17', 1),
(29, 27, 2, 'Drawng', '', '1', '99', 1, '2013-01-17', 1),
(30, 27, 2, 'Painting', '', '1', '99', 2, '2013-01-17', 1),
(31, 27, 2, 'etc', '', '1', '99', 3, '2013-01-17', 1),
(32, 25, 1, 'Athletic Art', 'Using your body', '1', '99', 2, '2013-01-17', 1),
(33, 32, 2, 'Singing', '', '1', '99', 0, '2013-01-17', 1),
(34, 32, 2, 'Dancing', '', '1', '99', 1, '2013-01-17', 1),
(35, 32, 2, 'etc', '', '1', '99', 2, '2013-01-17', 1),
(36, 0, 0, 'Sciences', '', '1', '99', 4, '2013-01-17', 1),
(37, 36, 1, 'Math', 'Q: How many beers do you have if you go in to a store and buy 5 if you had 3 before? 13 cause I stole 5 from the store and still have 3 in my belly ', '1', '99', 0, '2013-01-17', 1),
(38, 36, 1, 'Pyschology', 'I blame my neighbour for me being screwed up in the head', '1', '99', 1, '2013-01-17', 1),
(39, 36, 1, 'Social Studies', 'Post your facebook here', '1', '99', 2, '0000-00-00', 1),
(40, 36, 1, 'History', 'Didn''t we already have this one?', '1', '99', 3, '2013-01-17', 1),
(41, 36, 1, 'Biological Sciences', 'Urg to boring to even write about', '1', '99', 4, '2013-01-17', 1),
(42, 36, 1, 'Physical Sciences', 'o really? are you sure about that?', '1', '99', 5, '2013-01-17', 1),
(43, 36, 1, 'Computer Science', 'Lets press the start button and see what happens', '1', '99', 6, '2013-01-17', 1),
(44, 36, 1, 'Hacking', 'Making things do stuff they weren''t designed to do.', '1', '99', 7, '2013-01-17', 1),
(45, 36, 1, 'Health', 'Eat you carrots', '1', '99', 8, '2013-01-17', 1),
(46, 36, 1, 'Medical', 'I guess this will be the hangout for drug dealers ', '1', '99', 9, '2013-01-17', 1),
(47, 0, 0, 'Integrated Studdies', '', '1', '99', 5, '2013-01-17', 1),
(48, 43, 2, 'Programming', '', '1', '99', 0, '2013-01-17', 1),
(49, 43, 2, 'Security', '', '1', '99', 1, '2013-01-17', 1),
(50, 43, 2, 'etc', '', '1', '99', 2, '2013-01-17', 1),
(51, 47, 1, 'Discussion', 'Discussing how different fields can work together', '1', '99', 0, '2013-01-17', 1),
(52, 47, 1, 'Brainstorming', 'Would this work?', '1', '99', 1, '2013-01-17', 1);

DROP TABLE IF EXISTS `freelancing`;
CREATE TABLE IF NOT EXISTS `freelancing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `by` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `category` varchar(30) NOT NULL,
  `launched` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `freelancing_comments`;
CREATE TABLE IF NOT EXISTS `freelancing_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `by` int(11) NOT NULL,
  `body` text NOT NULL,
  `date` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(11) NOT NULL,
  `friend` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT DELAYED INTO `friends` (`id`, `friend`) VALUES
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 3),
(4, 2),
(3, 19);

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(50) NOT NULL,
  `creator` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

INSERT DELAYED INTO `groups` (`id`, `group`, `creator`) VALUES
(13, 'fgfd', 4),
(4, 'test', 4),
(12, 'gsdg', 4),
(15, 'work', 3),
(14, 'fsd', 4);

DROP TABLE IF EXISTS `group_members`;
CREATE TABLE IF NOT EXISTS `group_members` (
  `groupId` int(11) NOT NULL,
  `member` varchar(100) NOT NULL,
  `groupCreator` int(11) NOT NULL,
  PRIMARY KEY (`groupId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT DELAYED INTO `group_members` (`groupId`, `member`, `groupCreator`) VALUES
(12, 'uriah', 4),
(13, 'relax', 4),
(14, 'wabi', 4),
(15, '', 3);

DROP TABLE IF EXISTS `karma`;
CREATE TABLE IF NOT EXISTS `karma` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `1` int(11) NOT NULL,
  `2` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `pm` varchar(1) NOT NULL,
  `post` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT DELAYED INTO `karma` (`ID`, `1`, `2`, `time`, `pm`, `post`) VALUES
(1, 6, 3, '1362616675', 'p', 1),
(2, 4, 5, '1362889941', 'p', 6),
(3, 4, 1, '1364691062', 'm', 18),
(4, 3, 5, '1367708891', 'p', 6),
(5, 3, 4, '1367708902', 'p', 9),
(6, 3, 6, '1367708906', 'm', 11);

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `date` varchar(30) NOT NULL,
  `date2` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

DROP TABLE IF EXISTS `memberinfo`;
CREATE TABLE IF NOT EXISTS `memberinfo` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `screenname` varchar(16) NOT NULL,
  `sex` varchar(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `country` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `wURL` varchar(45) NOT NULL,
  `about` mediumtext NOT NULL,
  `signature` varchar(255) NOT NULL,
  `age` int(3) DEFAULT NULL,
  `wn` varchar(30) DEFAULT NULL,
  `wd` varchar(255) DEFAULT NULL,
  `portfolio` varchar(25) DEFAULT NULL,
  `css` varchar(30) DEFAULT NULL,
  `interests` text,
  `skills` text,
  `resume` varchar(50) DEFAULT NULL,
  `rank` int(2) NOT NULL DEFAULT '1',
  `last_login` datetime NOT NULL,
  `reg_date` datetime NOT NULL,
  `plus` bigint(255) NOT NULL,
  `minus` bigint(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

INSERT INTO `memberinfo` (`ID`, `username`, `screenname`, `sex`, `image`, `country`, `location`, `wURL`, `about`, `signature`, `age`, `wn`, `wd`, `portfolio`, `css`, `interests`, `skills`, `resume`, `rank`, `last_login`, `reg_date`, `plus`, `minus`) VALUES
(1, 'relax', 'relax', 'Male', 'c402818a1b9928d876535643fe487c55.jpg', 'Sweden', '', 'http://relax.infinity-forum.org/', 'Don''t touch my code or I''ll kill a seal\r\n', '', 26, 'You can''t click here', '', '', 'darkbsssslue', 'computers, programming, hacking, design, movies, series, languages, beer, music, learning, exploring new places, traveling, snowboarding, swimming, friends, collect broken computer parts &gt;.&gt;, fishing, billiards, poker, wake-board, water-skiing, human psychological behavior...\r\nand ofc WABI!!! ', 'HTML, CSS, JavaScript, PHP, ASP^, Java^, J2ME^, Python, Visual Basic^, AutoIt^, Trolling, C++^, Lua^, QBASIC^ (1337), Photoshop, GIMP^, Drinking, Windows 95^/98^/2000^/ ME^/NT^/XP^/Vista^/7, DOS (1337), Linux, Symbian^, Android, MySQL, Access^, Apache, IIS^, Security analyse^, porn surfing, Security prevention^, Firefox addon dev^, Chrome extension dev^, WoW addon dev^, Hardware, Software...\r\nand ofc the most important skill of all I KNOW FACEBOOK!!!', '', 6, '2013-09-16 18:38:55', '2012-12-01 00:00:00', 10003, 10007),
(2, 'wabi', 'wabi', '', '487c15be192bd40b874506d3df9230bf.jpg', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2013-02-26 10:01:07', '2012-12-03 00:00:00', 7, 0),
(3, 'uriahsanders', 'Uriah Sanders', 'Male', '1e8f8e769d758f8b9b6fb9b2da6488e3.png', 'United States', '', '', 'I love working on projects and creating new ideas and then implementing them. Im interested in many things, and love learning all that there is to learn. I am also head admin of Infinity-Forum, and enjoy improving the website and seeing what it does for people. I believe in information and education being free and easily accessible to everyone, and many of my projects mirror that philosophy.', 'There is no such thing as a bad day. Only those where you learn something and those in which you do not.', 15, 'Infinity-forum', '', '', '', 'Im interested in pretty much everything.', 'Programming and security, science, math, writing, martial arts...I like to delve into a lot of different things.', '', 6, '2013-09-16 18:50:35', '2013-01-18 00:00:00', 12, 458),
(4, 'jeremy', 'jeremy', 'Male', '3ac59519c36af6a7758584c370fc8d55.jpg', 'USA', '', '', '', '', 14, '', '', '', 'dark', 'Computers, Hacking, Programming, Forensics, Security, Swimming, Biking, Linux', 'PHP, Python, HTML, Java, JavaScript', '', 6, '2013-09-14 11:42:23', '2013-01-14 00:00:00', 14, 0),
(5, 'arty', 'arty', '', '', '', '', '', 'Fuck you.', '', 0, '', NULL, '', NULL, 'Being alive.\r\nLogicking.', 'Being alive.\r\nLogicking.', '', 5, '2013-09-08 13:57:42', '2013-01-21 00:00:00', 1, 0),
(6, 'lucid', 'lucid', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2013-05-25 17:02:25', '2013-01-12 00:00:00', 0, 0),
(19, 'TestAdmin', 'test Admin', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2013-03-01 17:40:42', '0000-00-00 00:00:00', 0, 0),
(20, 'testMember', 'Test Member', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2013-02-27 01:18:44', '0000-00-00 00:00:00', 0, 0);

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `admin` int(1) NOT NULL DEFAULT '0',
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `IP` varchar(15) NOT NULL,
  `activatecode` varchar(34) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

INSERT INTO `members` (`ID`, `admin`, `username`, `password`, `email`, `date`, `IP`, `activatecode`, `note`) VALUES
(1, 1, 'relax', '6dee1bba428b3648adbd60785a97cc25', 'relax@infinity-forum.org', '2012-12-01 14:32:46', '44.236.13.114', 'Y-349ab9d9359944343aa2b959ed08ead8', ''),
(2, 1, 'wabi', '1464aedd85cfe3156e2d8166c10ae683', 'wabi@infinity-forum.org', '2012-12-03 05:05:18', '69.130.176.61', 'Y-d8e31433f58337ffa58e4c053e6b52bb', ''),
(3, 1, 'uriahsanders', '8ebc3c4babf7b37eb171b333304e3aa1', 'uriah@infinity-forum.org', '2013-01-18 17:42:16', '108.23.116.84', 'Y-cb33de4d3557c5aa11eb2b9c3961418f', ''),
(4, 1, 'jeremy', '03d2a153ee1e347a26e6eaaa1af7954d', 'jeremy@infinity-forum.org', '2013-01-14 15:15:23', '99.155.32.203', 'Y-b64ed89c66de548973e32e68c70f5cd2', ''),
(5, 0, 'arty', '3ae838c8470f4a7b5c0f34d3fde69c12', 'arty@infinity-forum.org', '2013-01-21 08:07:51', '68.46.133.171', 'Y-0364300cd8cbd57d5c74060f859adc46', ''),
(6, 0, 'lucid', 'd51b6823a8208642398e9f28577b47a8', 'lucid@infinity-forum.org', '2013-01-12 19:15:41', '24.1.27.193', 'Y-7f1ecf09cd2934805f588d64dc56a74b', ''),
(19, 1, 'TestAdmin', '2650fbf817f7248a37e4052f0305764d', '', '2013-02-27 01:07:15', '127.0.0.rawr', 'Y-3044e3188f6755b9f661c0988ade5a82', 'pwd: Test123'),
(20, 0, 'testMember', '2650fbf817f7248a37e4052f0305764d', '', '2013-02-27 01:10:31', '127.0.0.rawr', 'Y-8515b82488cbc32d1f54f4e6428ee9eb', 'pwd: Test123');

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `to` varchar(255) NOT NULL,
  `isread` int(1) NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `sentby` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT DELAYED INTO `messages` (`ID`, `to`, `isread`, `subject`, `body`, `sentby`, `date`) VALUES
(1, '2', 0, 'PM system', 'Feel free to try out the new PM system with <br />notifications and full ajax ;)<br />and yeah i spent a lot of time on this fucking <br />design so if you have complains..<br />Stick em where the sun don''t shine....', 1, '2013-02-26 17:23:14'),
(3, '3', 1, 'PM system', 'Feel free to try out the new PM system with <br />notifications and full ajax ;)<br />and yeah i spent a lot of time on this fucking <br />design so if you have complains..<br />Stick em where the sun don''t shine....', 1, '2013-02-26 17:23:14'),
(4, '1', 1, 'PM system', 'Feel free to try out the new PM system with <br />notifications and full ajax ;)<br />and yeah i spent a lot of time on this fucking <br />design so if you have complains..<br />Stick em where the sun don''t shine....', 1, '2013-02-26 17:23:14'),
(5, '5', 1, 'PM system', 'Feel free to try out the new PM system with <br />notifications and full ajax ;)<br />and yeah i spent a lot of time on this fucking <br />design so if you have complains..<br />Stick em where the sun don''t shine....', 1, '2013-02-26 17:23:14'),
(6, '6', 0, 'PM system', 'Feel free to try out the new PM system with <br />notifications and full ajax ;)<br />and yeah i spent a lot of time on this fucking <br />design so if you have complains..<br />Stick em where the sun don''t shine....', 1, '2013-02-26 17:23:14');

DROP TABLE IF EXISTS `milestones`;
CREATE TABLE IF NOT EXISTS `milestones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `user` int(11) NOT NULL,
  `creator` int(30) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) NOT NULL,
  `project` varchar(100) NOT NULL,
  `finish` varchar(5) NOT NULL,
  `duedate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

INSERT DELAYED INTO `milestones` (`id`, `title`, `user`, `creator`, `date`, `description`, `project`, `finish`, `duedate`) VALUES
(11, 'test f43fgfger trtret', 4, 4, '2013-08-12', 'gdsfgdfg', '21', 'no', '2013-08-17'),
(12, 'ggggg', 0, 3, '2013-01-01', 'ggggggggg', '22', 'no', '2013-01-08'),
(13, 'gsdg gfdg', 4, 4, '2013-08-21', 'gsdg gs gdsg', '21', 'no', '2013-08-26');

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

INSERT DELAYED INTO `news` (`id`, `subject`, `text`, `date`) VALUES
(0, 'Welcome', 'Welcome to Infinity, a place for collaboration and learning! <br/>\r\nWe are glad to have you here. Feel welcome to search through any \"up and coming\" news, browse the forums, and post projects. <br/>\r\nAlso, please take the time to visit the About page, where you can find information about our vision for this website.<br/>\r\nOnce you have familiarized yourself with the site, we encourage you to register and start getting involved.<br /><br />\r\nOur philosophy is that knowledge should be shared and that finding people to work with should be easy.<br/> \r\nWhether you are a seasoned master looking for colleagues, or a curious soul hungry for knowledge, this is the place for you.<br /><br />\r\nIn our forums you will find a wide variety of topics. This is a great place to share what you know as well as learn from others.<br />\r\nHere, you can make a reputation for yourselves and increase your chances of getting into projects. We encourage you to join in.<br />\r\nIn projects you can see what others are creating, offer your skills, or start your own project.<br />\r\nWe make it easy for you to find a way to make cash doing the things you love, and find the right people to help you along your path to success.<br /><br />\r\nYou will also find articles, downloads, and tutorials to add and learn from.<br/>\r\nAs this site expands, so will its content and the opportunities it produces.<br />\r\nSo learn, contribute, debate, create, and make some cash.<br />\r\nWe''re sure you''ll fit right in.<br/><br/>\r\n-The Infinity Staff', '2013-06-05 00:00:00'),
(17, 'CMS', 'The start of the CMS is up now :)<br />\r\nlucid''s news script is implemented and working.<br />\r\nYou can access this by logging in on your account if your admin, if your not contact relax or uriah and we will decide your faith<br />\r\n<br />\r\nand I also forgot to say...RAWR!!!<br />\r\n<br />\r\n/relax', '2013-02-13 20:09:34'),
(25, 'Happy Valentines Day!', 'Im writing this partly to say happy valentines day, but mostly to just test out the new CMS :P<br />\r\nCheers! - Uriah', '2013-02-14 20:07:48'),
(26, 'Profile', 'General settings is mostly finished, and you can see the changes in your profile summary. The rest of the profile stuff is almost done as well, but im probably going to finish it tomorrow, im getting a bit tired of working on it. But feel free to test it out!(Ik its the most interesting part, but no, you still cant change your avatar)', '2013-02-16 02:54:33'),
(27, 'Changing Styles', 'The change style script is now finished, but don''t expect much from it; the actual stylesheets are not finished yet, and there''s not even such a thing as the white-brown one yet. But yeah, it works, and if you change the style youll see everything look all wierd. Ill write a js script to make the change instant soon, but for now you need to switch pages for the change to take effect.', '2013-02-16 18:10:13'),
(28, 'Infinity.php', 'If you read the announcements, youll know that infinity.php and its cms is pretty much up and running, thanks to jeremy. I know i wrote this in announcements, but for some reason I just really love using the news cms, its so awesome :D', '2013-02-16 21:51:07');

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `did` varchar(50) NOT NULL,
  `what` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `url` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `user` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `creator` mediumint(9) NOT NULL,
  `date` datetime NOT NULL,
  `completed` tinyint(4) NOT NULL,
  `popularity` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` longtext NOT NULL,
  `launched` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

INSERT DELAYED INTO `projects` (`id`, `name`, `creator`, `date`, `completed`, `popularity`, `category`, `description`, `launched`) VALUES
(21, 'jeremy', 4, '2013-08-06 01:03:59', 0, 0, 'Just for Fun', 'fdfsfsfd', 1),
(37, 'Infinity', 3, '2013-09-16 07:13:39', 0, 0, '0', 'My first project', 0),
(23, 'Educational Semen', 5, '2013-08-07 08:32:27', 0, 0, 'Education', 'This is a product, that will inject learning into people via semen. Our current testers are: wabi, relax. We only have two &quot;volunteers.&quot; Actually, now that we come to think about it, we have no idea how male volunteers will have the semen inserted into them. We are looking at oral injections, and well as anal injections.', 0),
(25, 'test', 1, '2013-08-25 01:59:03', 0, 0, '0', 'testdsfsdf', 0),
(36, 'asfdasd', 1, '2013-09-16 06:41:26', 0, 0, '0', 'asdasdasd', 0);

DROP TABLE IF EXISTS `projects_comments`;
CREATE TABLE IF NOT EXISTS `projects_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectname` int(11) NOT NULL,
  `by` varchar(100) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `projectcreator` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `projects_data`;
CREATE TABLE IF NOT EXISTS `projects_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` varchar(50) NOT NULL,
  `what` varchar(30) NOT NULL,
  `by` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `to` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `branch` varchar(15) NOT NULL,
  `privilege` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `suggest` tinyint(4) NOT NULL,
  `big_array` longtext NOT NULL,
  `due` varchar(25) NOT NULL,
  `due2` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=258 ;

INSERT DELAYED INTO `projects_data` (`id`, `projectID`, `what`, `by`, `date`, `title`, `body`, `to`, `level`, `branch`, `privilege`, `mark`, `suggest`, `big_array`, `due`, `due2`) VALUES
(198, '21', 'note', 4, '2013-08-07 08:32:17', 'note', 'note', 0, 0, 'Master', 0, 0, 0, '', '', ''),
(199, '23', 'branch', 0, '0000-00-00 00:00:00', 'Master', '', 5, 0, 'Master', 0, 0, 0, '', '', ''),
(200, '21', 'branch', 4, '2013-08-07 08:33:47', 'branch', '', 4, 0, 'branch', 0, 0, 0, '', '', ''),
(201, '21', 'document', 4, '2013-08-07 08:34:27', 'note', 'note', 0, 0, 'Master', 0, 201, 0, '', '', ''),
(195, '21', 'branch', 0, '0000-00-00 00:00:00', 'Master', '', 4, 0, 'Master', 0, 0, 0, '', '', ''),
(197, '21', 'update', 4, '2013-08-07 08:31:18', 'update', 'update', 0, 0, 'Master', 0, 0, 0, '', '', ''),
(211, '23', 'table', 5, '2013-08-08 07:43:21', '0', '', 0, 0, 'Master', 0, 0, 0, '\n                                        &lt;tbody id=&quot;tbody&quot; contenteditable=&quot;true&quot;&gt;\n                                            \n                                            &lt;tr&gt;\n                                                &lt;td&gt;data&lt;/td&gt;\n                                                \n                                            &lt;td&gt;data&lt;/td&gt;&lt;/tr&gt;\n                                        &lt;tr&gt;&lt;td&gt;data&lt;/td&gt;&lt;td&gt;data&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;\n                                    ', '', ''),
(207, '23', 'update', 5, '2013-08-07 09:04:14', 'Fat Bitch Hobbit', 'Fat bitch came it saying she wanted to be a test subject. Fat bitch turned out to be a hobbit. Request denied.', 0, 0, 'Master', 0, 0, 0, '', '', ''),
(225, '0', 'milestone', 3, '2013-08-25 02:27:34', '0', '0', 0, 0, '0', 0, 0, 0, '0', '', ''),
(221, '0', 'milestone', 3, '2013-08-25 01:38:15', '0', '0', 0, 0, '0', 0, 0, 0, '0', '', ''),
(222, '0', 'milestone', 3, '2013-08-25 01:39:57', '0', '0', 0, 0, '0', 0, 0, 0, '0', '', ''),
(223, '25', 'branch', 0, '0000-00-00 00:00:00', 'Master', '', 1, 0, 'Master', 0, 0, 0, '', '', ''),
(257, '37', 'branch', 0, '0000-00-00 00:00:00', 'Master', '', 3, 0, 'Master', 0, 0, 0, '', '', ''),
(255, '36', 'branch', 0, '0000-00-00 00:00:00', 'Master', '', 1, 0, 'Master', 0, 0, 0, '', '', '');

DROP TABLE IF EXISTS `projects_invited`;
CREATE TABLE IF NOT EXISTS `projects_invited` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `projectname` varchar(100) NOT NULL,
  `person` int(11) NOT NULL,
  `privilege` int(4) NOT NULL,
  `role` varchar(30) NOT NULL,
  `status` varchar(50) NOT NULL,
  `request` text NOT NULL,
  `accepted` tinyint(4) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

INSERT DELAYED INTO `projects_invited` (`id`, `projectID`, `creator`, `projectname`, `person`, `privilege`, `role`, `status`, `request`, `accepted`, `date`) VALUES
(24, 23, 5, 'Educational Semen', 5, 0, '', '', '', 1, '2013-08-07 08:32:27'),
(37, 36, 1, 'asfdasd', 1, 0, '', '', '', 1, '2013-09-16 06:41:26'),
(22, 21, 4, 'jeremy', 4, 0, '', '', '', 1, '2013-08-06 01:03:59'),
(26, 25, 1, 'test', 1, 0, '', '', '', 1, '2013-08-25 01:59:03'),
(38, 37, 3, 'Infinity', 3, 0, '', '', '', 1, '2013-09-16 07:13:39');

DROP TABLE IF EXISTS `recover`;
CREATE TABLE IF NOT EXISTS `recover` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `code` varchar(32) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT DELAYED INTO `recover` (`ID`, `email`, `code`, `IP`, `time`) VALUES
(5, 'arty@infinity-forum.org', '42a8dc45e79b2e71c60e3f4dba4b8198', '46.21.99.29', '2013-02-03 00:02:52');

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(5) NOT NULL,
  `status` int(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT DELAYED INTO `status` (`id`, `status`, `date`) VALUES
(4, 2, '2013-06-30 12:06:00'),
(3, 0, '2013-08-27 09:53:00'),
(5, 0, '2013-08-07 09:37:00'),
(1, 2, '2013-08-25 02:13:00'),
(2, 2, '2013-06-21 06:22:00');

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT DELAYED INTO `statuses` (`id`, `user`, `status`) VALUES
(1, 3, 'online'),
(2, 4, 'online');

DROP TABLE IF EXISTS `suspicious_activity`;
CREATE TABLE IF NOT EXISTS `suspicious_activity` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `IP` varchar(16) NOT NULL,
  `data` text NOT NULL,
  `date` datetime NOT NULL,
  `session` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT DELAYED INTO `suspicious_activity` (`ID`, `IP`, `data`, `date`, `session`) VALUES
(1, '127.0.0.rawr', 'POST: plus,1_3GET: ', '2013-03-02 19:44:08', 'auth = 1,curproject = 2,theme = 0,IP = 127.0.0.rawr,data = Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22,0 = 1,ID = 1,1 = 1,admin = 1,2 = relax,username = relax,3 = relax@infinity-forum.org,email = relax@infinity-forum.org,4 = relax,screenname = relax,5 = cc9bfe6f8831e1a599ea5f6967e79f29.png,usr_img = cc9bfe6f8831e1a599ea5f6967e79f29.png,ID = 1,usr = relax,loggedin = YES,screenname = relax,admin = 1');

DROP TABLE IF EXISTS `wall`;
CREATE TABLE IF NOT EXISTS `wall` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `by` int(5) NOT NULL,
  `date` datetime NOT NULL,
  `txt` longtext NOT NULL,
  `child` int(5) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `like` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

INSERT DELAYED INTO `wall` (`ID`, `by`, `date`, `txt`, `child`, `IP`, `like`) VALUES
(4, 1, '2013-02-20 10:09:09', 'This is a beta version of a wall-stream that will use ajax, its far from done...', 0, '', ''),
(5, 1, '2013-02-20 10:10:01', 'yeah its limited to 100 posts and replies.<br />and the ajax does not work on load yet', 4, '', ''),
(7, 2, '2013-02-20 11:31:26', '^.^ ^.^ ^.^', 0, '', ''),
(8, 3, '2013-02-20 16:49:56', ':D Cool!', 0, '', ''),
(9, 1, '2013-02-20 18:29:09', 'thought we developers could post updates here because in Skype announcement it can be lost :)<br />there is no admin options for this yet what you see is what you will have as a normal user.<br />admins will though be able to do what users can to there own posts to every post<br />whats missing is the real &quot;ajax&quot;, edit options, some more logging and security, post links and images even you tube videos, upload your own images, a own coding language for tagging and easy posting, friends synchronization and a lot of design and html5, was also thinking of having a +1/like function and repost (share/retweet) option.<br />yeah all images was deleted due to large images, so you will have to upload a new one and it will work, the profile images are re-sized to 200x200 and re-encoded/compressed to load much faster and take up a lot of less disk space', 0, '', ''),
(10, 1, '2013-02-20 18:44:21', 'Things that needs to be done to the site (comment for assignment or new suggestions)<br />Forum - relax<br />Stream - relax<br />Design(PM/work space/front page/settings) - relax<br />Security - relax<br />Add/remove friends - uriah maybe?<br />cms - uriah<br />blog - jeremy<br />text on site needs to be rewritten - wabi', 0, '', ''),
(11, 1, '2013-02-20 18:45:31', 'also <br />url rewrite for the page - relax<br />implement the recover password function - jeremy or relax?', 10, '', ''),
(12, 1, '2013-02-20 18:46:48', 'also as a member function we could have a photoalbum if ppl are in to photography or have pictures of there own inventions etc<br />unassigned ', 10, '', ''),
(13, 1, '2013-02-20 18:48:13', 'and no we will not be using iframe in the final product :P', 9, '', ''),
(14, 1, '2013-02-20 18:57:52', 'also need to do a have read and have not read script', 9, '', ''),
(15, 3, '2013-02-20 19:19:50', 'i cant try to do that relax, good idea. also, portfolio and resume creator, ill do that too.', 10, '', ''),
(16, 3, '2013-02-20 19:20:46', 'also, i might try to tackle some design challenges, even if only rough drafts to help you out :)', 10, '', ''),
(17, 3, '2013-02-20 19:22:16', 'looks good relax, thanks :D<br />Website development is really picking up, im excited. Also, i learned regex and some design, more php/sql and stuff, so i think im ready for more challenges. Lets do this :D', 0, '', ''),
(18, 1, '2013-02-20 21:25:31', 'write me a good url regex :)', 17, '', ''),
(19, 1, '2013-02-20 21:27:21', 'cool :) help with finding a idea of a image not having a image :P', 10, '', ''),
(20, 3, '2013-02-21 01:31:58', '^no$ :D', 17, '', ''),
(21, 1, '2013-02-21 06:44:10', 'fixed url rewrite for users<br />please link all user requests to /user/[username]<br />if they are not logged in they will automatically be sent to /user/2/[username] from the address :)<br />/user/[username] is the /member/index.php?usr=[username]<br />/user/2/[username] is the /accsummary.php?usr=[username]<br /><br />here''s some nerd code for uriah that wants to learn url_rewrite<br /><br />RewriteCond %{REQUEST_URI} ^/member/index.php$<br />RewriteCond %{QUERY_STRING} !marker  <br />RewriteCond %{QUERY_STRING} usr=([-a-zA-Z0-9_]+)<br />RewriteRule ^/?member\\/index\\.php$ /user/%1? [R=301,L]<br />RewriteCond %{QUERY_STRING} usr=([-a-zA-Z0-9_]+)<br />RewriteRule ^/?member\\/$ /user/%1? [R=301,L]<br />RewriteRule ^\\/?user\\/([-a-zA-Z0-9_]+)\\/?$ /member/index.php?marker&amp;usr=$1 [L]<br /><br />RewriteCond %{REQUEST_URI} ^/accsummary.php$<br />RewriteCond %{QUERY_STRING} !marker  <br />RewriteCond %{QUERY_STRING} usr=([-a-zA-Z0-9_]+)<br />RewriteRule ^/?accsummary\\.php$ /user/2/%1? [R=301,L]<br />RewriteRule ^\\/?user\\/2\\/([-a-zA-Z0-9_]+)\\/?$ /accsummary.php?marker&amp;usr=$1 [L]', 0, '127.0.0.rawr', '');

DROP TABLE IF EXISTS `wall_beta`;
CREATE TABLE IF NOT EXISTS `wall_beta` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `by` int(5) NOT NULL,
  `date` datetime NOT NULL,
  `txt` longtext NOT NULL,
  `child` int(5) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `like` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT DELAYED INTO `wall_beta` (`ID`, `by`, `date`, `txt`, `child`, `IP`, `like`) VALUES
(2, 3, '2013-03-02 23:35:08', 'STARTPAGE:<br />restyle, change to a slideshow, logo and stuff needs be redone to be smaller and faster load especially pictures<br />text needs to be rewritten<br />news needs to be removed before launch<br />news still jumps a bit, needs to be fixed<br />buttons looks awful<br />screen name needs to be removed<br />terms needs a ajax for faster load<br />buttons again (close button)<br />needs fix<br />recover password does not work atm<br />not linked or secured.<br />mod_rewrite needs to be applyed on activation and error messages<br />and also mod rewrite on recover<br />PROJECTS PAGE:<br />Pretty much everything. All existing content will be changed completely.<br />Concept and styling<br />ability to post projects, and view them<br />ability to add people to projects<br />the workspace, and linking existing project data from posts into the workspace when the user starts a new project<br />Projects and freelancing are now the same thing, so any thing differentiating them, you can ignore<br />FORUM:<br />restyling<br />fix the categories<br />securing and tweaking for faster load<br />date on forum needs to be linked to the new date function to save space on layout<br />icons on forum/index needs to be redone, they are ugglyer then new born baby<br />also need to fix somehow the different forum between logged in and not, members or not<br />Admin cms<br />ABOUT PAGE:<br />Reformat text. Change donate button, it doesnt fit.<br />contact form needs to be styled, secured etc, with a captcha<br />staff list<br />INFINITY PAGE:<br />restyling/mod_rewrite/see that someone has tested security on it<br />Tokens on every form(cms ofc)<br />HELP PAGE:<br />styling, text, pictures etc<br />also all links need to be altered with javascript so the javascript is invisible for the user<br />MEMBER LOUNGE:<br />wall on the front page<br />separate page for profile<br /> bookmark script needs to be removed<br />search needs to be programmed with ajax<br />fix styles<br />fix donate button<br />status/friends must be coded<br />everything regarding projects needs to be done<br />PM system needs to be finished with all functions etc<br />make all links work<br />ARTY FINISH THE CHAT :)<br />SETTINGS PAGE:<br />needs restyling or be done with styling<br />change theme removed until after launch.<br />all settings stuff moved to the members lounge<br />mail removed from settings<br />Add input limitations to settings<br />limit output on whats shown like stream has when you write more then 500 chars<br />GENERAL:<br />memberlist altered and fixed<br />everywhere where we have karma the new carma system needs to be implemented and the old needs to be deleted<br />karma tracking system<br />all the icons needs to be overviewd/changed/altered<br />redo all images<br />add dynamic/fun content<br />mod_rewrite on all pages + forum<br />Style resume creator<br />portfolio creator:coded and styled<br /><br />extended profile will not be there at launch, btw.', 0, '108.23.116.84', ''),
(3, 1, '2013-03-02 23:36:42', 'I''ll go kill myself now &gt;.&gt;', 2, '127.0.0.rawr', ''),
(4, 3, '2013-03-06 17:37:25', 'Post around Lucid :D', 0, '108.23.116.84', ''),
(5, 3, '2013-03-06 17:37:42', 'Testing 123....', 4, '108.23.116.84', ''),
(6, 3, '2013-05-12 15:56:34', 'i was thinkiing that below the news box, we could have some thumbnails of the most popular projects, and then some chosen by staff<br />[2:50:34 PM] uriah sanders: and that instead of using stock photos, we use screenshots on the site<br />[2:50:38 PM] uriah sanders: in the slider<br />[2:50:52 PM] uriah sanders: that way they get a beter grasp of the features<br />[2:51:03 PM] uriah sanders: we could do a cms for the projects we want on the front page<br />Then using the cms we could write unique project reviews for each one', 0, '108.23.116.84', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
