-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2014 at 07:12 PM
-- Server version: 5.5.34-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `infinity`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`ID`, `subject`, `text`, `date`) VALUES
(1, 'About', 'Welcome to Infinity, a place for collaboration and learning. <br />\r\nThere are many talented people in the world hindered by a lack of money and a dedicated team. <br />\r\nWe believe opportunity shouldn''t be decided by wealth or reasorces. <br />\r\nOur goal is to provide intellectual stimulation, free project management, easy learning, and opportunities for collaboration. <br />\r\nMost importantly, this website is free. <br />\r\nSo join in and have fun. What have you got to lose? <br /><br />\r\n\r\nIf you like what we''re doing and share our vision, please take the time to donate. <br />\r\nYour contributions will be used to improve your experience in drastic ways. <br />\r\nWith your help, we''ll be able to offer more support for our users, provide more activities, and add new features. <br />\r\nWe don''t charge money for the services we provide. <br />\r\nWith your help we can keep it that way and have a more efficient website. <br />\r\nWe thank you for your support! <br /><br />\r\n\r\n-The Infinity Staff', '2013-04-16 00:00:00'),
(2, 'FAQ', '<div class="Q_1">1. Q: <span class="Qt"> Who is the Infinity Staff?</span></div>\r\n<div class="A_1">A: <span class="At"> We are a group of people who want to expand the knowledge available, \r\nas well as it''s quality. We also want to provide the opportunity of success for anyone who is willing to learn.</span></div>\r\n\r\n<div class="Q_2">2. Q: <span class="Qt"> What is the purpose of this website?</span></div>\r\n<div class="A_2">A: <span class="At"> In short, Infinity is designed to expand knowledge and collaboration. A place where intellectuals can have \r\ndiscussions, create projects, and even make some money.</span></div>\r\n\r\n<div class="Q_3">3. Q: <span class="Qt"> What is the difference between projects and freelancing?</span></div>\r\n<div class="A_3">A: <span class="At"> By definition, you could say there is little difference, but at infinity-forum we divide the two. \r\nIn projects, you reveal the full scope of your plan, can ask for donations, and can provide other incentives for help than money. \r\nYou can not require work by the hour in a project. In freelancing, you only pay with money, you can pay by the hour or \r\nonce the work is completed, you cannot request donations to help with your task, and you are not expected to reveal much \r\nof the purpose behind the work you are asking. In general, freelancing is better for companies, while projects are better for the average user.</span></div>\r\n\r\n<div class="Q_4">4. Q: <span class="Qt"> I hear a lot of talk about "growing" the site. What does that mean, and what does it entail?</span></div>\r\n<div class="A_4">A: <span class="At"> As we expand in funds, we will be providing better software for use on the site, as well as optimizing the website itself. \r\nAlso, funds will be directed towards community projects, challenges, and activities.</span></div>\r\n\r\n<div class="Q_5">5. Q: <span class="Qt"> Can I have an example of one of these activities?</span></div>\r\n<div class="A_5">A: <span class="At"> Sure! One plan is utilizing funds in order to compete on challenge.gov, where we can submit \r\nsolutions to government problems and gain prize money for both the site, and those who helped.</span></div>\r\n\r\n<div class="Q_6">6. Q: <span class="Qt"> There is no "Challenge.gov" in my country... does that mean I am excluded?</span></div>\r\n<div class="A_6">A: <span class="At"> Of course not! That is merely one example of many. Also, there will be community managers in different areas, \r\nwho''s job is to come up with projects for people in that area to work on.</span></div>\r\n\r\n<div class="Q_7">7. Q: <span class="Qt"> I hear that the forums are a great way to get to know one another, and make good choices for your projects. \r\nThat''s fine, but I don''t think I''ll have time to be active on these forums. Is there any way I can still be sure that I am working with trustworthy people?</span></div>\r\n<div class="A_7">A: <span class="At"> Of course! You are able to list your qualifications on your profile, and even create a portfolio of your work. \r\nTry checking through these to find out if they are who you need. Also, there is an Elite position granted by staff, \r\nthat will display to the community that you are a great contributor. It is fairly easy to get into this position, \r\nall that is required is proof that you are serious, hardworking, and trustworthy.</span></div>\r\n\r\n<div class="Q_8">8. Q: <span class="Qt"> Sounds great! If I find that I want to work with Infinity, what positions are there, and how can I get in?</span></div>\r\n<div class="A_8">A: <span class="At"> You can be a site admin, moderator, or community manager. You can apply for these positions HERE.</span></div>\r\n\r\n<div class="Q_9">9. Q: <span class="Qt"> How many different positions are there and what are they?</span></div>\r\n<div class="A_9">A: <span class="At"> There are several different postions you can obtain, and each higher position has the priveleges of \r\nall those below them. In ascending order:Guests- Un-registered visitors to the website, Members-Registered users, \r\nFrequenters- Members with a significant number of posts, Elites- Members who are individually promoted by proving \r\nthemselves as trustworthy,great contributors, VIP''s-Members who are designated a role in helping others along with \r\nprojects/topics they are familiar in. You can not apply for this position, we will contact you for it. \r\nModerators(Mods)- Staff members who keep the peace, regualte content, and provide as much help as possible. \r\nThey have a designated board to manage. Global Moderators(GMods)- Moderators who are able to manage every board. \r\nAdmins- In addition to the previous roles, they manage the overall site, are very influential and skilled members, \r\nand also manage the website at a technical level. They make the big descisions.</span></div>\r\n\r\n<div class="Q_10">10. Q:<span class="Qt">Okay, well, all this sounds great, but what makes you special? Why not a website like Elance, or just another forum?</span></div>\r\n<div class="A_10">&nbsp;&nbsp;&nbsp;A: <span class="At"> Happy that you asked. Infinity is special because it allows you to grow as a family, \r\nwith opportunities for you to learn, as well as create. It is a wonderful experience, being a part of this community. \r\nYou will gain friends, connections, knowledge, and money. Also, the forums give you an opportunity to communicate with other \r\nintellectuals. Most importantly, unlike others, this site is absolutely free!</span></div>\r\n\r\n<div class="Q_11">11. Q: <span class="Qt"> That''s not enough for me...</span></div>\r\n<div class="A_11">&nbsp;&nbsp;&nbsp;A: <span class="At"> Infinity is also the ONLY thing of it''s kind with a purpose to support you and your endeavors. \r\nWe will use funds to advertise your companies, we will form partnerships with you and actively search for ways to advance \r\nyour company or dream. We will even designate personnel to personally help you along your way. We do not see our clients as \r\nmere words on a sheet of paper, but as people.</span></div>\r\n\r\n<div class="Q_12">12. Q: <span class="Qt"> I heard that you can make money on this site... how is that?</span></div>\r\n<div class="A_12">&nbsp;&nbsp;&nbsp;A: <span class="At"> You can earn cash from helping with other people''s projects, with the pay decided by the creator of the project.\r\nYou can also sign up for a position as site staff and get payed for it. Various community activities will also provide a way to earn money. \r\nFor example, challenges are a unique way to advance your skills, do some good in the world, and earn cash prizes.</span></div>\r\n\r\n<div class="Q_13">13. Q: <span class="Qt"> Okay, but how does Infinity make money?</span></div>\r\n<div class="A_13">&nbsp;&nbsp;&nbsp;A: <span class="At"> This site will always be free. We feel that requesting membership fees will hinder the availability of \r\nsuccess and knowledge to the populace. Instead, we maintain and expand the website through the donations of our users, \r\nand minimal use of ads. If you like what we are doing here, and would like to donate below.</span></div>\r\n\r\n<div class="Q_14">14. Q: <span class="Qt"> Are you guys a company? Or just a website?</span></div>\r\n<div class="A_14">&nbsp;&nbsp;&nbsp;A: <span class="At"> When we recieve enough funds to begin branching out and and doing more things outside of just the website, \r\nwe will do so. We hope to make Infinity a company that utilizes the expertise of all different fields to create amazing things, \r\nand hires based on proven skills rather than solely college information. Most importantly, members who give amazing contributions \r\nand stand out in the forums will have a great chance of being hired!</span></div>\r\n\r\n<div class="Q_15">15. Q: <span class="Qt"> I still have more questions!</span></div>\r\n<div class="A_15">&nbsp;&nbsp;&nbsp;A: <span class="At"> Email us at Infinityprojects@yahoo.com.</span></div>', '2013-04-16 00:00:00'),
(3, 'Contact', '<form action="#" method="post" id="cf_form">\r\n	<table class="cf">\r\n    <tr>\r\n    	<td>Subject:</td>\r\n        <td><input type="text" name="subject" id="cf_subject"/></td>\r\n    </tr>\r\n    <tr>\r\n    	<td></td>\r\n        <td><div class="cf_err">The subject needs to be at least 4 characters.</div></td>\r\n    </tr>\r\n    <tr>\r\n    	<td>Your email:</td>\r\n        <td><input type="text" name="email" id="cf_email"/>\r\n    </tr>\r\n    <tr>\r\n    	<td></td>\r\n        <td><div class="cf_err">The email you entered if not valid.</div></td>\r\n    </tr>\r\n    <tr>\r\n    	<td>Message:</td>\r\n        <td><textarea id="cf_msg" name="msg"></textarea></td>\r\n    </tr>\r\n    <tr>\r\n    	<td></td>\r\n        <td><div class="cf_err">The message is to short, please write a message with at least 30 characters.</div></td>\r\n    </tr>\r\n    <tr>\r\n    	<td><input type="hidden" name="token" value="" id="cf_token" /></td>\r\n        <td><span class="btn" id="cf_submit">Send</span></td>\r\n    </tr>\r\n    \r\n    </table>\r\n</form>', '2013-04-16 00:00:00'),
(4, 'Terms and agreements', '<div class="terms">\r\n<b>Terms and conditions, Agreement between user and Infinity:</b><br />\r\nWelcome to Infinity. The Infinity website (the "site") is comprised of various pages operated by Infinity. Infinity is offered to you conditioned on your acceptance without modification of the terms, conditions, and notices contained herein (the "Terms"). Your use of Infinity constitutes your agreement to all such Terms. Please read these terms carefully, and keep a copy of them for your reference.\r\n<br /><br /><b>Privacy:</b><br />\r\nYour use of Infinity is subject to Infinity''s Privacy Policy. Please review our Privacy Policy, which also governs the Site and informs users of our data collection practices.\r\n<br /><br /><b>Electronic Communications:</b><br />\r\nVisiting Infinity or sending emails to Infinity constitutes electronic communications. You consent to receive electronic communications and you agree that all agreements, notices, disclosures and other communications that we provided to you electronically, via email and on the Site, satisfy any legal requirement that such communications be in writing.\r\n<br /><br /><b>Your account:</b><br />\r\nIf you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibly for all activities that occur under your account of password. You may not assign or otherwise transfer your account to any other parson or entity. You acknowledge that Infinity is not responsible for third party access to your account that results from theft or misappropriation of your account. Infinity and its associates reserve the right to refuse or conceal service, terminate accounts, or remove or edit content in our sole discretion.\r\n<br /><br /><b>Cancellation Policy:</b><br />\r\nYou may cancel your account at any time. Infinity reserves the right to keep all data related to your account indefinitely.\r\n<br /><br /><b>Links to third party sites:</b><br />\r\nInfinity may contain links to other websites ("Linked Sites"). The Linked Sites are not under the control of Infinity and Infinity is not responsible for the content of any Linked Site, including without limitation any link contained in a Linked Site, or any changes or updates to a Linked Site. Infinity is providing these links to you only as a convenience, and the inclusion of any link does not imply endorsement by Infinity of the site or any association with its operators.\r\n<br /><br /><b>No unlawful or prohibited use/Intellectual Property:</b><br />\r\nYou are granted a non-exclusive, non-transferable, revocable license to access and use Infinity strictly in accordance with these terms of use. As a condition of your use of the Site, you warrant Infinity that you will not use the Site for any purpose that is unlawful or prohibited by these Terms. You may not use the Site in any manner which could damage, overburden, or impair the Site or interfere with any other party''s use and enjoyment of the Site. You may not obtain or attempt to obtain any materials or information through any means not intentionally made available or provided through the Site.\r\nAll content included as part of the Service, such as text, graphics, logos, images, as well as the compilation thereof, and any software used on the Site, is the property of Infinity or its suppliers and protected by copyright and other laws that protect intellectual property and proprietary rights. You agree to observe and abide by all the copyright and other proprietary notices, legends or other restrictions contained in any such content and will not make any changes thereto.\r\nYou will not modify, publish, transmit, reverse engineer, participate in the transfer or sale, create derivative works, or in any way exploit any of the content, in whole or in part, found on the Site. Infinity content is not for resale. Your use of the Site does not entitle you to make any unauthorized use of any protected content, and in particular you will not delete or alter any proprietary rights or attribution notices in any content. You will use protected content solely for your personal use, and will make no other use of the content without the express written permission of Infinity and the copyright owner. You agree that you do not acquire any ownership right in any protected content. We do not grant you any licenses, express or implied, to the intellectual property of Infinity or our licensors except as expressly authorized by the Terms.\r\n<br /><br /><b>Use of communication services:</b><br />\r\nThe Site may contain bulletin board services, chat areas, news groups, forums, communities, personal web pages, calendars, and/or other message or communication facilities designed to enable you to communicate with the public at large or with a group (collectively, "Communication Services"), you agree to use the Communication Services only to post, send and receive messages and material that are proper and related to the particular Communication Service.\r\nBy way of example, and not as a limitation, you agree that when using a Communication Service, you will not: defame, abuse, harass, stalk, threaten or otherwise violate the legal rights (such as rights of privacy and publicity) of others; publish, post, upload, distribute or disseminate any inappropriate, profane, defamatory, infringing, obscene, indecent or unlawful topic, name material or information; upload files that contain software or other material protected by intellectual property laws (or by rights of privacy of publicity) unless you own or control the rights thereto or have received all necessary consents; upload files that contain viruses, corrupted files, or any other similar software or programs that may damage the operation of another''s computer; advertise or offer to sell or buy any goods or services for any business purpose, unless such Communication Service specifically allows such messages; conduct or forward surveys, contests, pyramid schemes or chain letters; download any file posted by another user of a Communication Service that you know, or reasonably should know, cannot be legally distributed in such manner; falsify or delete any author attributions, legal or other proper notices of proprietary designations or labels of the origin or source of software or other material contained in a file that is uploaded, restrict or inhibit any other user from using and enjoying the Communication Services; violate any code of conduct or other guidelines which may be applicable for any particular Communication Service; harvest or otherwise collect information about others, including email addresses, without their consent; violate any applicable laws or regulations.\r\nInfinity has no obligation to monitor the Communication Services. However, Infinity reserves the right to review materials posted to a Communication Service and to remove any materials in its sole discretion. Infinity reserves the right to terminate you access to any or all of the Communication Services at any time without notice for any reason whatsoever.\r\nInfinity reserves the right at all times to disclose any information as necessary to satisfy applicable law, regulation, legal process or government request, or to edit, refuse to post or to remove any information or materials, in whole or in part, in Infinity''s sole discretion.\r\nAlways use caution when giving out any personally identifying information about yourself or your children in any Communication Service. Infinity does not control or endorse the content, messages or information found in any Communication Service and, therefore, Infinity specifically disclaims any liability with regard to the Communication Services and any actions resulting from you participation in and Communication Service. Managers and hosts are not authorized Infinity spokespersons, and their views do not necessarily reflect those of Infinity.\r\nMaterials uploaded to a Communication Service may be subject to posted limitations on usage, reproduction and/or dissemination. You are responsible for adhering to such limitations if you upload the materials.\r\n<br /><br /><b>Materials provided to Infinity or posted on any Infinity web page:</b><br />\r\nInfinity does not claim ownership of the materials you provide to Infinity (including feedback and suggestions) or post, upload, input or submit to any Infinity Site or our associated services (collectively "Submissions"). However, by posting, uploading, inputting, providing or submitting you Submission you are granting Infinity, our affiliated companies and necessary sub-licensees permission to use you Submission in connection with the operation of their Internet businesses including, without limitations, the rights to: copy, distribute, transmit, publicly, display, publicly perform, reproduce, edit, translate and reformat your Submission; and to publish your name in connection with your Submission.\r\nNo compensation will be paid with respect to the use of your Submission, as provided herein. Infinity is under no obligation to post of use any Submission you may provide and may remove any Submission at any time in Infinity''s sole discretion.\r\nBy posting, uploading, inputting, providing or submitting you Submission you warrant and represent that you own or otherwise control all of the rights to your Submission as described in this section including, without limitation, all the rights necessary for you to provide, post, upload input or submit the Submissions.\r\n<br /><br /><b>Indemnification:</b><br />\r\nYou agree to indemnify, defend and hold harmless Infinity, its officers, directors, employees, agents and third parties, for any losses, costs, liabilities and expenses (including reasonable attorneys'' fees) relating to or arising out of your use of or inability to use the Site or services, any user postings made by you, your violation of any terms of this Agreement or you violation of any rights of a third party, or your violation of any applicable laws, rules or regulations. Infinity reserves the right, at its own cost, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, in which event you will fully cooperate with Infinity in asserting any available defenses.\r\n<br /><br /><b>Liability disclaimer:</b><br />\r\nThe information, software, products, and services included in or available through the site may include inaccuracies or typographical errors. Changes are periodically added to the information herein. Infinity and/or its suppliers may make improvements and/or changes in the site at any time.\r\nInfinity and/or its suppliers make no representations about the suitability, reliability, availability, timeliness, and accuracy of the information, software, products, services and related graphics contained on the site for any purpose to the maximum extent permitted by applicable law, all such information, software, products, services and related graphics are provided "as is" without warranty or condition of any kind. Infinity and/or its suppliers hereby disclaim all warranties and condition with regard to this information, software, products, services, and related graphics, including all implied warranties or conditions of merchant ability, fitness for a particular purpose, title and non-infringement.\r\nTo the maximum extent permitted by applicable law, in no event shall Infinity and/or its suppliers be liable for any direct, indirect, punitive, incidental, special, consequential damages or any damages whatsoever including. Without limitation, damages for loss of data or profits, arising out of or in any way connected with the use or performance of the site, with the delay or inability to use the site or related services, the provision of or failure to provide services, or for any information, software, products, services and related graphics graphics obtained through the site, or otherwise arising out of the use of the site, whether based on contract, tort, negligence, strict liability or otherwise, even if Infinity or any of its suppliers has been advised of the possibility of damages. Because some states/jurisdiction do not allow the exclusion or limitation of liability for consequential or incidental damages, the above limitation may not apply to you. If you are dissatisfied with any portion of the site, or with any of these terms of use, your sole and exclusive remedy is to discontinue using the site.\r\n<br /><br /><b>Termination/access restriction</b>:<br />\r\nInfinity reserves the right, in its sole discretion, to terminate your access to the Site and the related services or any portion thereof at any time, without notice. To the maximum extent permitted by law, this agreement is governed by the law of the United States of America and you hereby consent to the exclusive jurisdiction and venue of courts in the United States of America in all disputes arising out of or relating to the use of the Site. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these Terms, including, without limitation, this section.\r\nYou agree that no joint venture, partnership, employment, or agency relationship exists between you and Infinity as result of this agreement or use of the Site. Infinity''s performance of this agreement is subject to existing laws and legal process, and nothing contained in this agreement is subject to existing laws and legal process, and nothing contained in the agreement is in derogation of Infinity''s right to comply with governmental, court law enforcement requests or requirements relating to your use of the Site or information provided to or gathered by Infinity with respect to such use. If any part of this agreement is determined to be invalid or unenforceable pursuant to applicable law including, but not limited to, the warranty disclaimers and liability limitations set forth above, then the invalid or unenforceable provision will be deemed superseded by a valid, enforceable provision that most closely matches the intent of the original provision and the remainder of the agreement shall continue in effect.\r\nUnless otherwise specified herein, this agreement constitutes the entire agreement between the user and Infinity with respect to the Site and it supersedes all prior contemporaneous communication and proposals, whether electronic, oral or written, between the user and Infinity with respect to the Site. A printed version of this agreement and of any notice given in electronic form shall be admissible in judicial or administrative proceeding base upon or relating to this agreement to the same extent and subject to the same condition as other business documents and records originally generated and maintained in printed form. It is the express with to the parties that this agreement and all related documents be written in English.\r\n<br /><br /><b>Changes to Terms:</b><br />\r\nInfinity reserves the right, in its sole description, to change the Terms under which Infinity is offered. The most current version of the Terms will supersede all previous versions. Infinity encourages you to periodically review the Terms to stay informed of our updates\r\nInfinity welcomes your questions or comments regarding the terms and agreements!\r\n<br /><br />Effective as of 12/8/2012</div>', '2013-04-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `index_` int(11) NOT NULL DEFAULT '1000',
  `min_rank` int(2) NOT NULL DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`name`),
  KEY `min_rank` (`min_rank`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `name`, `index_`, `min_rank`, `visible`) VALUES
(1, 'General', 1000, 1, 1),
(2, 'Infinity', 1000, 1, 1),
(3, 'World', 1000, 1, 1),
(4, 'Arts', 1000, 1, 1),
(5, 'Sciences', 1000, 1, 1),
(6, 'Integrated Studdies', 1000, 1, 1),
(7, 'VIP', 1000, 3, 0),
(8, 'Admins', 1000, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fee_l` int(11) NOT NULL,
  `fee_n` int(11) NOT NULL,
  `fee_f` int(11) NOT NULL,
  `fee_a` int(11) NOT NULL,
  `comments` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `usr_ID` int(10) NOT NULL,
  `friend_ID` int(10) NOT NULL,
  `block` tinyint(1) NOT NULL DEFAULT '0',
  `block_by` int(11) NOT NULL,
  `accepted` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`ID`, `usr_ID`, `friend_ID`, `block`, `block_by`, `accepted`, `date`) VALUES
(18, 9, 1, 0, 0, 1, '2013-06-20 05:45:40'),
(14, 1, 2, 0, 0, 1, '2013-06-20 04:41:10'),
(15, 1, 3, 0, 0, 1, '2013-06-20 04:41:22'),
(16, 1, 4, 0, 0, 0, '2013-06-20 04:41:33'),
(21, 2, 3, 0, 0, 1, '2013-06-20 18:43:16'),
(20, 3, 4, 0, 0, 0, '2013-06-20 17:49:27');

-- --------------------------------------------------------

--
-- Table structure for table `infinity_messages`
--

CREATE TABLE IF NOT EXISTS `infinity_messages` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `msg` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `IP` varchar(15) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `date` varchar(30) NOT NULL,
  `date2` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`ID`, `username`, `IP`, `date`, `date2`) VALUES
(50, 'uriahsanders', '127.0.0.1', '1395450158', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `memberinfo`
--

CREATE TABLE IF NOT EXISTS `memberinfo` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `sex` varchar(11) NOT NULL,
  `image` varchar(40) NOT NULL,
  `banner` varchar(33) NOT NULL,
  `rank` int(2) NOT NULL DEFAULT '1',
  `country` varchar(30) NOT NULL,
  `wURL` varchar(45) NOT NULL,
  `quote` varchar(255) NOT NULL,
  `age` int(3) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `work` varchar(30) NOT NULL,
  `active_p` varchar(40) NOT NULL,
  `special` varchar(20) NOT NULL DEFAULT 'Member',
  `points` int(8) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `status_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `about` text NOT NULL,
  `resume` text NOT NULL,
  `skills` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `memberinfo`
--

INSERT INTO `memberinfo` (`ID`, `username`, `sex`, `image`, `banner`, `rank`, `country`, `wURL`, `quote`, `age`, `last_login`, `work`, `active_p`, `special`, `points`, `status`, `status_time`, `about`, `resume`, `skills`) VALUES
(1, 'relax', 'Male', '9a1111520842d32326809d2e7678defep', '457a42062ca91fb20f0d67020aa89119p', 6, 'Sweden', 'http://moijo.org', 'You don''t get what you want... you get what you work for.', 26, '0000-00-00 00:00:00', 'Student', 'Infinity-forum', 'Co-Founder', 10000, 0, '2014-03-22 06:26:19', 'Testing Relax about', '', ''),
(2, 'Uriah', 'Male', '5579265ae3dec2569717c0e0f1f7b5e5j', '', 6, 'USA', 'http://infinity-forum.org', 'My quote', 16, '0000-00-00 00:00:00', 'Infinity', 'infinity-forum', 'Co-Founder', 10000, 1, '2014-03-24 02:12:04', 'This is some information about me.', 'This is my resume.', ''),
(3, 'jeremy', 'Male', '716e08e05e5a92e36e922bc6be9ebd19j', '', 6, 'USA', '', 'I like cookies', 14, '0000-00-00 00:00:00', '', '', 'Co-Founder', 10000, 0, '0000-00-00 00:00:00', '', '', ''),
(4, 'wabi', '', '', '', 6, '', '', '', NULL, '0000-00-00 00:00:00', '', '', 'Co-Founder', 10000, 0, '0000-00-00 00:00:00', '', '', ''),
(10, 'arty', '', 'b4cb6f5e620a2b31a3065caca393131ap', '566de5d708d32517a1a7c4ca59a6990dp', 5, '', '', '', NULL, '0000-00-00 00:00:00', '', '', 'Member', 0, 0, '0000-00-00 00:00:00', '', '', ''),
(11, 'Test123', '', '', '', 1, '', '', '', NULL, '0000-00-00 00:00:00', '', '', 'Member', 0, 0, '2014-01-07 22:04:29', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `ID` mediumint(11) NOT NULL AUTO_INCREMENT,
  `admin` int(1) NOT NULL DEFAULT '0',
  `username` varchar(16) NOT NULL,
  `password` varchar(65) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `IP` varchar(15) NOT NULL,
  `activatecode` varchar(34) NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`ID`, `admin`, `username`, `password`, `email`, `date`, `IP`, `activatecode`, `note`) VALUES
(1, 1, 'relax', '$2a$12$pCFVjYScazDMlGUBV1wVoO77jspOCBODetA6yXUuDXJPp3WLOmeOy', 'relax@infinity-forum.org', '2013-05-25 13:54:03', '127.0.0.1', 'Y-71ad8cdc6c38455d9d9d6c176b6a6090', ''),
(2, 1, 'Uriah', '$2a$12$1HXLUsxcf8ZB6INXDgqb7.FYzkec1vp9SpuQQ43WtTrMEr9oIvCre', 'uriah@infinity-forum.org', '2013-05-25 22:54:37', '108.23.116.84', 'Y-655e1e2bcd17683de73b22b9767475d9', ''),
(3, 1, 'jeremy', '$2a$12$Xlo9eARyi6eleXabNVVhneuPdnxvxGyk1h2Vnfh.8CIN1JwSWor4G', 'jeremy@infinity-forum.org', '2013-05-25 23:41:27', '99.155.45.129', 'Y-536429b4778c171b9cf8a310380d123d', ''),
(4, 1, 'wabi', '$2a$12$2oBcqX8VPj.Pi7JU3YOQ9OcqM.VIEIvS8HkOzPCzumEcOgwg2baSO', 'd4us.mach1na@gmail.com', '2013-05-29 21:28:15', '50.40.124.192', 'Y-72a2fe57959f27f115853c86448e556a', ''),
(10, 0, 'arty', '$2a$12$Cy7sAPwYED7HdtjQaZ/3HuwAJSG8WeiiE/jXuGSh1.o1048e..9DK', 'arty@infinity-forum.org', '2013-07-08 05:41:57', '108.29.127.124', 'Y-59e097bbfb029344030c1afe48057839', ''),
(11, 0, 'Test123', '$2a$12$.9cxEkRi2SQUpsYxPBbhWeFjK8F7vF7yZ/7XfebgGzxdp0bcQGnE2', 'r3lax.uwh@gmail.com', '2014-01-07 22:49:04', '127.0.0.1', 'Y-b4455d0ad203ac2001eefb639f1e2e04', '');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `subject`, `text`, `date`) VALUES
(0, 'Welcome', 'Welcome to Infinity, a place for collaboration and learning! <br/>\r\nWe are glad to have you here. Feel welcome to search through any "up and coming" news, browse the forums, and post projects. <br/>\r\nAlso, please take the time to visit the About page, where you can find information about our vision for this website.<br/>\r\nOnce you have familiarized yourself with the site, we encourage you to register and start getting involved.<br /><br />\r\nOur philosophy is that knowledge should be shared and that finding people to work with should be easy.<br/> \r\nWhether you are a seasoned master looking for colleagues, or a curious soul hungry for knowledge, this is the place for you.<br /><br />\r\nIn our forums you will find a wide variety of topics. This is a great place to share what you know as well as learn from others.<br />\r\nHere, you can make a reputation for yourselves and increase your chances of getting into projects. We encourage you to join in.<br />\r\nIn projects you can see what others are creating, offer your skills, or start your own project.<br />\r\nWe make it easy for you to find a way to make cash doing the things you love, and find the right people to help you along your path to success.<br /><br />\r\nYou will also find articles, downloads, and tutorials to add and learn from.<br/>\r\nAs this site expands, so will its content and the opportunities it produces.<br />\r\nSo learn, contribute, debate, create, and make some cash.<br />\r\nWe''re sure you''ll fit right in.<br/><br/>\r\n-The Infinity Staff', '2013-06-05 00:00:00'),
(17, 'CMS', 'The start of the CMS is up now :)<br />\r\nlucid''s news script is implemented and working.<br />\r\nYou can access this by logging in on your account if your admin, if your not contact relax or uriah and we will decide your faith<br />\r\n<br />\r\nand I also forgot to say...RAWR!!!<br />\r\n<br />\r\n/relax', '2013-02-13 20:09:34'),
(25, 'Happy Valentines Day!', 'Im writing this partly to say happy valentines day, but mostly to just test out the new CMS :P<br />\r\nCheers! - Uriah', '2013-02-14 20:07:48'),
(26, 'Profile', 'General settings is mostly finished, and you can see the changes in your profile summary. The rest of the profile stuff is almost done as well, but im probably going to finish it tomorrow, im getting a bit tired of working on it. But feel free to test it out!(Ik its the most interesting part, but no, you still cant change your avatar)', '2013-02-16 02:54:33'),
(27, 'Changing Styles', 'The change style script is now finished, but don''t expect much from it; the actual stylesheets are not finished yet, and there''s not even such a thing as the white-brown one yet. But yeah, it works, and if you change the style youll see everything look all wierd. Ill write a js script to make the change instant soon, but for now you need to switch pages for the change to take effect.', '2013-02-16 18:10:13'),
(28, 'Infinity.php', 'If you read the announcements, youll know that infinity.php and its cms is pretty much up and running, thanks to jeremy. I know i wrote this in announcements, but for some reason I just really love using the news cms, its so awesome :D', '2013-02-16 21:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `ID` int(15) NOT NULL AUTO_INCREMENT,
  `usr_ID` int(8) NOT NULL,
  `extra_ID` int(8) NOT NULL,
  `type_` int(11) NOT NULL,
  `text_` varchar(255) NOT NULL,
  `read_` int(1) NOT NULL DEFAULT '0',
  `friend_answ` int(11) NOT NULL,
  `date_` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `msg` mediumtext NOT NULL,
  `IP` varchar(16) NOT NULL,
  `by_` mediumint(9) NOT NULL,
  `parent_ID` bigint(9) NOT NULL,
  `time_` datetime NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `by_` (`by_`),
  KEY `parent_ID` (`parent_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `msg`, `IP`, `by_`, `parent_ID`, `time_`) VALUES
(2, 'tidool igra bihoa stach oast owheejeem eetheewa oangoz fiwhokruk gloshihapt ram gry oovemsag eji tohoani phocmeck roj ujoangoo otowoopt oadra oag yte ', '127.0.0.1', 4, 1, '1996-09-16 20:43:22'),
(3, 'eegnic eestephit theeksece icul zeeptips ich perdompeet ehirtoogr eecu hiftansoax belroalafu ooka editchess dooj huzodsipi tapta oaksomten ', '127.0.0.1', 10, 1, '2002-10-28 05:14:39'),
(4, 'ootsyngogn hecmas ptehithoa eshej iwaghi eediwoo jooc thooshe grigl voovoo stawhotsyv goowha pho kad oamp dyk ptupsydool tooku epsistac ', '127.0.0.1', 4, 1, '2010-07-25 02:29:49'),
(6, 'itheepteep etor oody goad ewheefoas ynyb sogheeds sheewytsix esoansa eewoo phoolrydi ula ozulsalric hoanyvoo ypyho ', '127.0.0.1', 10, 1, '2011-05-19 09:24:39'),
(7, 'ocoseroptu nynguft ubee ewh zoopsocho oosh oavelre oof hurgyl oardi zoopt ptiglemto ugr hoa deptaj ifehoa ', '127.0.0.1', 4, 1, '2006-09-05 05:35:25'),
(8, 'ilakreftej oongoampoa rerg foon oageemads ugl voophoama uxyt wifimta eglecooc uchej ygassi eerg thoo gloalsa ptoo fas oglu liry whyps cer gru psoocoargu agelysseez ', '127.0.0.1', 10, 1, '1992-07-25 03:34:21'),
(9, 'yphuwes ochythos eec sho etishoas uwaftoo weepoogi phu eevogr icyma ytipirdee uwhiglee ools yjolsilso joa istachu xapesh mox agreepsa kedroojadr phi ooc peevocamu oortan ', '127.0.0.1', 1, 2, '1973-10-08 05:38:44'),
(10, 'uxyjin pseed psooz glasty ystijo waji galt jeemeepha oshiwh fodegylrit oatu iloapepta apsoast ', '127.0.0.1', 4, 2, '1984-12-04 18:22:59'),
(12, 'gloamso oboow imukeltu numogr kupti chuts ujogr oaphoashep yransybe yxosh ereensad geebypte gli ithuptelen oomucoonoo whutivalti ydoargo iphachek ytheefoon umyck roaptybept loa eemo vorsadem stoatahiv iph ', '127.0.0.1', 1, 2, '1990-11-16 00:08:44'),
(16, 'psi ogoa asoals eeree whoagroamt psootsipt glimpeelsu doak ugly azunuhozi anolikr xepheest whi ophy cilop ofoapseet nems tho sooptibo yku kuphat stene eeltyrgiw oacefook xoal otoophyth iridsee ', '127.0.0.1', 1, 2, '2013-08-22 02:59:58'),
(18, 'eepsir ocoftelr yroagl eshepsut eephy exeep sheewoolaj aloaw ishusoofoo soopt iroo stirda opeert noagl xeeryvukim ozybeeceds oshych det mew namsipo guhydr goozohi agoadrudu fagloolsu psyjoa joaladoaho bipeetchoa oampoortim evu ', '127.0.0.1', 10, 3, '1993-06-15 06:44:34'),
(19, 'icha lylsimtog mibygri weenaptyci pher ugo pan omop oosuds yphuboomi zaghycirgi eess mys epu vahijir unyjof tagreej how ipophee grykrec ohigloa mimteed eenon phooh odagnotch cydredux wheest ', '127.0.0.1', 4, 3, '1984-12-27 05:54:21'),
(20, 'oachoal covee ytaghor pyv giphy noo caft eexytcheep oatsoots ith cheethick oduglompev steeptaj greekr alykroosta ', '127.0.0.1', 1, 3, '1991-05-15 02:06:59'),
(21, 'omiphoak ugo aceempyf oaxyco voaglozy weegloche griro ipte moofoogro guty adex jeft oazyrdeecm foowhahomi zawhoofun ooxelr chysytyj zensathyms hoanogo oord yfoardoa egli anenangoa ', '127.0.0.1', 4, 3, '1977-11-07 07:36:44'),
(25, 'oomtoaft oast ekups codeesubi ooksoa alycm oaks eegnoa gook ushys grongy ewheecegy eedredrapt ivom oodroge oovybune eezixu oadoockyxe moawhid ypsyxyh anedyroo oacma oato oomsoothy goace aphophuwe ', '127.0.0.1', 3, 4, '1982-02-04 03:55:46'),
(26, 'hisixodse psi soar oleergeeft nishoheek ijoakrapo steex oog oglolijej fatsydoop zoaptoasha yheedardy kite oolreersee upeetchyng soam ufedewop rokr poox echafeej opsoogl ', '127.0.0.1', 4, 4, '1998-01-20 08:49:05'),
(27, 'zoazy hampajoo ivehak ifishoroa ryms voohuzushe oaph mewhonsek usy shyzeeg eecu gleel dansoongum sheeholt suk osydsoa ekutsudroa psuste nagnegaj ewhoch ', '127.0.0.1', 3, 5, '2009-01-08 21:03:46'),
(30, 'fun xompa veefaptejo ech yzingy jyt uwhipsee hoa meestada opt zoarir hoopsigro poostigere oocmaps taghyss whudroarto haw oocheza lar ikeempok exina eejoachirg iloagryns ', '127.0.0.1', 4, 5, '1993-07-13 20:14:07'),
(31, 'anymsij iptaboo noaf greezooms ipeete sakro phyxood ptu ewhee etumseec moamips kapore esomisse ceenulufib groahoafe jasheph eevukoa psofytsap hoany ewhe ', '127.0.0.1', 1, 5, '1996-01-31 07:33:49'),
(32, 'tyksoce oat veeliph aphun ciptogla loa yne oagheessix chisisogh uchoat gleexoo teftexe mekseelra areergukri song ecysap ziphyh ydoogh eertodiwi meer ash stengar largoowyd ', '127.0.0.1', 10, 5, '1987-09-21 12:23:06'),
(33, 'sty oog jalti bangyssono eersoolr azastee whydoomoaj ikoapeemte ywh zipt epoojoadi wumool iri eempocuzo ashidoagri ixeemym ', '127.0.0.1', 1, 5, '2001-10-29 22:46:52'),
(34, 'poaz mosasti xaxa koobyry lymiho psoardoci apsafeze nerycmistu eelsucmex ovoachu onoon fee ptunsohums verditcha akoatchoap ykebehag deecooni kipteesa vamsurdumy bafuftooz osho ', '127.0.0.1', 2, 5, '1977-05-13 12:57:31'),
(35, 'eertyfynsi heesoowy phyr ochee joadeez kergoofest thoo eemp yximsu rampekry ptyglopsol alegh ugleexiv aglufoa uzart ste oamsyv fapab ohits mybordo ipsoabobi ', '127.0.0.1', 3, 6, '1998-04-02 10:19:27'),
(36, 'ooksumsoo ptoox poaw yth ptemsoath oocku iptoadoalo shyxap biz pty otiwhoals igregy ygavi oojapoocmy yphoad pseenee psyghi pekydsur shoagnudr mis tumtee zyng oazeecke xogr uchoa ygosheeg ohons ophi ysoassyl evoaphy sool stoa whu ibeef forgoomoo toj punoawu ', '127.0.0.1', 1, 6, '1997-12-06 19:04:17'),
(37, 'shecmo shororoads cho tapsy stalritan gygl whee yjy xop soconsee oamp eest pseegringy onem egoo eesh feks uzolsoo ', '127.0.0.1', 4, 6, '1989-02-22 08:52:49'),
(38, 'ezugiboa yluchu glicol sheeluxo oocmym zyj thockoofe udilseef dofuc zoopheec shidedsax kecm eetch owikom whoak wee ', '127.0.0.1', 10, 6, '2009-01-17 09:30:28'),
(39, 'ooxopo uwhagrugly opeekri oajix xeed ptalagek shelte oorsoamt ajoah ech egr ogru mergoaph ekikseds uma zoaky uxigaxense oobesh igujoam mosypooc xeethab ukisodsys mosholr zeveemee thestydsy ikoadulos oolra xoaje voogoteex ', '127.0.0.1', 1, 6, '1993-05-16 08:21:07'),
(41, 'vyboacicku ichyzups gow fyshals tha eekackexyl eetsoathu agroam joo oaphi wohutheehi igezakoga oans puteempuk oam oozoaptow ypighudri kuf oahultossa ychoglin ixorym boahocyx oampumt egeghub wipudre durta oog ymyglymem cyhu ', '127.0.0.1', 2, 6, '1976-10-20 21:43:07'),
(42, 'ashu oockaby ruta doaloos ykoolsoc oarsock coobas neksa oackoo goow psoatsoopt epi jishee psoksof uphy meekov shift eer sytax uth eglu upsoonoota oaboa stumte eezecmun coagyfooti oagne glognerdi ', '127.0.0.1', 10, 7, '1990-10-02 13:13:05'),
(43, 'ylep ugoamsoa yglujivaj ugrajoaph peeglor oapsec oolteept roogaxob eecergaro roajoopu phignoojy rooroo atheepheeg coosoophee oomseft shoo iku yglufemeec weef ', '127.0.0.1', 3, 7, '2005-07-16 22:37:24'),
(44, 'stotaghi meesuzeed cassoa sugloompoh whu eelrakr eegn themsi okargy grobicki oogrynirt ifot choadrept xetsolt soafoptee ystoosupty ushu ept ceepepipo eboorti xofta lami alakeepej oarimt ', '127.0.0.1', 4, 7, '1976-05-16 17:15:09'),
(45, 'uwo oolry istoogryg stoaksad oaphez lutuk iph jeepsu gleeng avulsoang ewyls seezukez uju thypsicm agroveefoa fywadi amulogakac yphees ipho eempaguwaw grymoft shyck uchistyg uto ykylreecku ooksuptoa ', '127.0.0.1', 2, 8, '1977-01-09 05:06:14'),
(47, 'psoahuw ugroops idez veehoage guxuv ducheedydo glujagnept owhuloos ehynsunek ptyje phiksev ywopt eensoaxi ptingirse ', '127.0.0.1', 4, 8, '1976-08-28 21:32:06'),
(48, 'dujoawhep imypteerte glofty ooghoowh coar ewossikaro stedra tazakugily epsiguwam coditse shoz istoozu isoothordu stygros boo ichuche shoard yzoltugho evuwoogucm aptoataph rodsa gaglasho oatir ', '127.0.0.1', 1, 8, '1997-12-19 19:21:52'),
(49, 'ochuwoglo foawhe roofoo nyj hudycmug whu eptoo ceebopter thade phufeesh avungop oshookujee thee hulydooc asilsoac thonotcha tiruwoag suthe sersonerd umikasha oaftutchee oceegn eeshyhadse tupsy taptumt gumichusy opybe ', '127.0.0.1', 1, 9, '1970-06-19 02:12:37'),
(50, 'xyltyrdub cynoogn vosse ikorsers teckunsowa zafuds meept aloa ywepoal ynolsiha ygle huchognoom grytsoolr lowhy amo alulsucmi ', '127.0.0.1', 10, 9, '2000-10-11 10:33:20'),
(51, 'atuk ugoadsivu iptoaweet muz zoo phumt walsabee uchasiz thalteerd ikoada ticic oaz bylsor iptoof xope deepuphosy tyglynga zee oapi ukode sheeksoaw edoan yglos leemal lejansys kordashuha lydrumt ', '127.0.0.1', 2, 9, '1986-05-02 15:53:43'),
(52, 'eewh esoak rikrits rooreeshed agloochih upango lypsoan fav ptooxu xoahiwi joace phiksojo ptekso whargu uzadsen ewo chutyvoox yduho ookug ', '127.0.0.1', 10, 9, '1998-07-19 02:57:36'),
(53, 'ced oak pooglee upheekicho nedsooph yptoahe wheecas yciw othazythy oodsishee iwoofetcho garise yzoom pysy ixajogrit lut oopsoamad oheep ycuwulsopy ', '127.0.0.1', 1, 9, '2011-09-06 19:07:54'),
(54, 'eevyj koo ethash eedr oogipsotha evoagnalse phoag usuts ylod chabelansu awee dursapti eenastat zeng voogl poabujyzuz elult obisytoodo eexoaphee zam poaru cijokrulre akossoazod oah ostoaroaf ygr ', '127.0.0.1', 4, 9, '1979-03-07 06:43:48'),
(55, 'ahyfefta pteckoax utheecy ptoocm ochoa roghof mygryr ygutoa ygoglelr aptag phengoaksa yvu griphoapt eelsoopuch psevixee psi ', '127.0.0.1', 3, 9, '1983-07-21 09:13:05'),
(56, 'deegletoo psufed uvees eetsee obeer wha stooghoa uje uglasamy ceej isolry yfee foa aveengih ', '127.0.0.1', 10, 9, '1983-08-22 04:56:13'),
(57, 'pti weephoa chawunooc ydygh uphoageza unubutchyd deefe nura choodut lazateec oozochooph oac oaxitsoa ', '127.0.0.1', 2, 9, '2002-03-30 23:09:39'),
(58, 'zorseharti teeglive feerolyree bygre abamywh ydee ushatoobiw thukegre toovibo wussy philtartes ycoah hoalipsa ohook ptarteet nuryckoky oveer oardachoo egly edyltoa eepeze ihyvo astoashi yshy oofa ichopha keepte beer oodratchi oaguthej noa ', '127.0.0.1', 4, 10, '1971-09-06 09:25:15'),
(59, 'apipheewi pymso esteeg eshy vypogn epsi xoazakeest woavyfa psoo eeck voagreep cim jumoa avoopsu ', '127.0.0.1', 2, 10, '1993-05-19 13:01:22'),
(60, 'udeksoaju eeceboache heebipsee soopsewh ptomy itoas eegoophun eemacobu ejely othexeetho muhe ojineemsu godseftage zoojeewh luvigy ate oruj oamsuva loomiglu exarta heegoama wechatef oacmee nupeedso ubessoc theriz ', '127.0.0.1', 2, 10, '1972-11-18 18:24:11'),
(61, 'ovoachyh eeghozaft xeest eeh joafy ptoxeevi upoawoa eejidsa oockasurgu geesh ejag dart oangyrsex ewh lopsucho otho ulaltam ezaxo uphamipta oxi ', '127.0.0.1', 4, 10, '1997-07-07 11:03:53'),
(62, 'ugyvept oobecadsan epsyb ekogroagoa oasoamtoa lultaxi neenizo estoaw itu akaxeepus peev ostoososh hargedri loneftompy greecm ugeegheds yshephowys aha oomsufoawi eriks chi mimsee opoostooms oamsimtee imoo roodake pezensol whory eesap zoo ', '127.0.0.1', 2, 10, '1982-08-24 20:22:48'),
(63, 'oan show nidrejes epsyhoo teem byrt choozydyh uxeelt xumpoa sty imudsa ibooltylso ynyphas cafoajuz psi xeephy ptoojydsy evumygu oawhyciwoo oasevoa sonsokru imunsix uroajiwy koolap ogikry apsoasetho oobelr acech sordor geetoz wupomeg gra ', '127.0.0.1', 2, 11, '1986-12-13 15:05:14'),
(64, 'igred glok oansojood oagna oachump tims epybooc ooh onishoa phijoaroah sipe eedul jeeglara umoargi noagroovy nuf oocmo stootasti eemsag opheecaz exe ', '127.0.0.1', 1, 11, '1987-07-24 04:24:17'),
(65, 'chafy ychoothoas eekr pekroagnef pelo oams uxusseeki eej xuck emyrirtoj pumtooshec goxoamsoxo owhasyr ', '127.0.0.1', 3, 11, '1971-05-06 21:33:40'),
(66, 'theerga ach geem ytargiwh oorduv oapokrird rishi woakist whypheglut oongyptooc glaw ootsyp gewhebib itholegl ath mooxevuz vemti thoamtish ubookigny stiw oriksitso aso oather eecy achin phoatsy vingeeks axoo glymsoagh gleghooks iwhecubiwh rydrugl ', '127.0.0.1', 2, 11, '1997-03-27 11:42:38'),
(67, 'fongools chuchoa oansar uryh horga gluks gro yshygoof eereensuft phyrsi eph koalu kewh gli poav muneek oglat grumt ', '127.0.0.1', 1, 11, '1983-03-07 14:07:00'),
(68, 'tadrigoo chuzyp yphe ojugli tanijoomee oabums oomoj ptud oas madsy apoo whooshylsu idedsa bam phed heftoabely eethoah odab anoaraw six ', '127.0.0.1', 1, 11, '2013-02-15 01:03:08'),
(78, 'ookegnyssy oadsoor ptoal ufuw ooxi moo eempadem footh beepsopa yhoa ypoachoo ypseephush tiphuvist xurdah ', '127.0.0.1', 2, 13, '1981-01-05 08:19:25'),
(79, 'cyb soghoapoo tiwhacoaz thi xoojekishu gleewhoapi whupoa ubee eeksujup efomteech akysocic whyrdavel opeegna stafu iph eda ucicmostov uth boo ', '127.0.0.1', 1, 13, '1997-03-25 06:44:36'),
(81, 'yrigroothu bickegn eewaphigh psymsoo asomun oopoof osu xoodeer ypsoaj eejoag ootuj ptoo egre voaserad ganuckuh tyzast iwhoa enawignee colsicuse ozusoteep yptekegoow weeth ojoam ipt rocketsoo zartoosti zoj obootheeck bosho geeroolef cox ', '127.0.0.1', 3, 13, '1977-10-04 18:31:48'),
(82, 'chooralt ypowh eertuche eth idugneelt eemsyd ekookr eeg peecheth eeckivoa awha iburtekeev eesha oapsa ooc woow oacoakem gokroz ooxo edyf oot daloakelta psem ookoost ywoaxa uwhoashi larg oars che mybe ', '127.0.0.1', 4, 13, '1989-02-15 18:57:11'),
(84, 'hump yhyrtefe ekuksoatch seeth psod ujeeh seeshomo whoaltoaf whe ogloanusta gonilr oosigroo xeglyrg ', '127.0.0.1', 4, 13, '2006-05-10 12:33:11'),
(85, 'ywoolux ewo uhesikree lirg ebo jomoav oonipteegl sta uzu phegy ikuchysu beeheku opeeg oogriloolr pheeglydr phizyth hyri grexovylru psa compoo ooci psy oawe boojo ', '127.0.0.1', 10, 14, '2011-05-08 03:10:47'),
(86, 'aphoa oognodra ketchodruw soat ojoangocm omij roa chyh feex eevacma estah eruthygrir toaps sothygl izult nov whepob ishewu xooshetyke wheezaph gloro groaksach thooloansi oowhi yceecmohi ', '127.0.0.1', 1, 14, '1995-01-27 08:18:07'),
(87, 'stecmo stychudr eechoa ibuk eshoa phoazulito adeti igipydirsy coj evatchocmo esanizudr lap ptoshoa raxeer emeghyv efafuno amoo ihilresh hul ', '127.0.0.1', 3, 14, '1985-02-27 06:38:02'),
(88, 'enewhe azywhane toogre roo ubeerdoo ineef vood shimaltud reetho stoadsols rurgeetcha yfeloat pybargyts oak ', '127.0.0.1', 2, 14, '2003-03-18 13:16:08'),
(93, 'thydr eew ysyjutcho furdy eeb ocooho biwhinoft whonsoo birt ceevi oshuphacha tyksans eewh tyteep afon oal xaz shyx oal oakuj seewoako ooj xooro peloaz ythoophas thinsebel ', '127.0.0.1', 4, 14, '1978-12-04 07:53:56'),
(95, 'yboompy eetee ustytejowa phifetchin aboa xoalest iredseka cookolid zexoo stomtoac zoakoshit ozoocoaf peegloja ', '127.0.0.1', 3, 15, '1993-02-23 22:22:55'),
(96, 'yglunuvoa tulubogny ysty ixyngoa varso foagrol phijirif ptoo eecmolr oogoghe xafepoatso awh ptuph phod doocos oabyme grensoow ', '127.0.0.1', 2, 15, '1975-12-04 02:47:24'),
(97, 'gloa oro kyftoalrar odyt boa utooshymp pipipsyds oofuh chuphuleed gekraho ixeeloo leebuf ptalruj eegykoagr jeesileko vopt ocyrgoamy ymooltishi sissylsaju chirsatsaz hoo ptucoa wooptu whedroon ', '127.0.0.1', 1, 16, '1988-10-12 20:37:41'),
(98, 'keksy duphycheer joopoopu ptoareew ipsa eepong uhidsy oomsoarta oogloaso yshithethy owhov nah shypse anooks eek eepifabeep ooch eekroalsyn ', '127.0.0.1', 10, 16, '1983-01-18 07:50:41'),
(99, 'icord roshetsa icegimy ostoaz oagnyt iptokij kergard ixeeck estyj buheenowhi iboampeef whinyb gympogr eeceewho osyfyp otukru ptadogr gacmigh enocyk ekoocmee ', '127.0.0.1', 4, 16, '2012-07-13 09:36:11'),
(100, 'footyshym ywhaxo ywawupsu mopooth sycygni ithooj ptaksee grukrecm phirga ypteegron psameegle tomsuphep echori pee ybiryba ipoamsoasi ubansordy damoocmoo oxyruft jac thartafus koxekos hungi najochef ', '127.0.0.1', 4, 16, '2010-09-14 11:05:41'),
(101, 'eengul nugleeghuc ohe ekur yfameet epacuck pyshoshyw boodoow shampee philsoltoo kow modurty pyckeegow chyth regra upoamtord cifapirgoo ', '127.0.0.1', 2, 16, '1996-05-15 12:44:27'),
(102, 'psutsupew mycmoahefe ygryxud dedrochub foagriwh oolrosheec wonergy cooph ekonoazy shotilso sugigy foar whu yvuj istatustod ', '127.0.0.1', 1, 16, '2010-04-12 22:20:46'),
(103, 'asypip psysiwy oosy oaxoac ylih wilr tatchyd oassofif thuruceegh eets shazeedoo pymoaksoa ishux yven eegoazar thurg eempuckov thooghils owhamy doaptudon oox ', '127.0.0.1', 10, 16, '1976-05-20 13:31:39'),
(104, 'ycoabacoss thoa ogrisoamoo whal opsucostuv oosteefu pseen agrucheedi ooshoathoo tidsy koom eeptapse epo amin ikoopee ivuthacufa onymseko ', '127.0.0.1', 3, 16, '2004-10-28 04:15:42'),
(105, 'ush yzyb oampoord gremoa eroopseeh vidim ovurootch zoo ptaks uthoo uth nusolruc steeltad psojawaf eemsyruj zeepta toociza deeptooxyg ', '127.0.0.1', 2, 17, '1979-03-11 15:05:14'),
(106, 'zoa chej ogrosizy edoopsy acaksagruc stu whi whoo eegnymso pheeshuv avu stil eecmootch awheem oagritchu ijoan oonsu dabo iwh cik ', '127.0.0.1', 3, 17, '1999-10-03 04:38:58'),
(107, 'reepsowhac fosto choo zidr eecmapsaz thywu ulinseenso ihoocmo psigelse glocma itagn nucmyglods ideeboo xeehysigri oacmuf ostuwh shy awheesy enimed icissan eewhe xapturdyma aneekr okoops cykoakree ', '127.0.0.1', 1, 17, '1993-05-15 10:50:19'),
(111, 'ozyrgeev oagny odub merteet glum oagnareecy xoo shev iwheehevyw ophojoaf ocharapt eekseech shej meesod ziltas chyth oheev ree sho iglept ooje fee ynoarsee nohoabipys eef ', '127.0.0.1', 4, 18, '1996-03-28 14:34:00'),
(113, 'doogreesoa ofoogh igloolo aduwhagiwh agruthoow soaxeewhok oogrythe nocket taz avoogerde teefyji codazu aphemee etyltadry poothee choo gowin oateedoo oduwoor optox adad joa zehytchu oorga ykignup tucomsi uwebocmyt inethygl efoodro ', '127.0.0.1', 4, 18, '2007-03-22 12:21:53'),
(115, 'dehoo shixepy gyw izuwu uphoogryc omuf ata koavogl eelteegr gleecoort gethy oolralru xamybewycm pharsa owood eglugixeh sostokekr athozefy ootocm coshumoart ozoazoo she chonsudru hyji oogurg befte yjicoothyv ysoalta yphavab wohys yptoagi gle igradooni whoos thugoash eekseeh ', '127.0.0.1', 1, 18, '1983-04-04 05:19:02'),
(116, 'recmoashat tupyc ochyp goasukyb ohu storsucmyc psylro ukoapsux sto ugr hekenecomt uboan makirgee ixaloawoa mulsyxu cixongupt ukugn whoshymu oshoa def ', '127.0.0.1', 3, 19, '1996-07-20 01:27:06'),
(117, 'ysimomsoo exoc rechi ehir oodeeroaf epsygresoo todoo vicods stoarde groaphoan vafoam grym mooch kynoo phudse roogro ypsoo onoviphu ', '127.0.0.1', 1, 19, '1996-09-17 19:17:16'),
(118, 'uwh kev gyftoast awessoart oong gloxe phoodra lolrax isycumpyv yshul jywaphoamy stoj whoolsoaph ucoadree fyrtagluh loa ', '127.0.0.1', 2, 19, '1974-02-21 15:17:25'),
(120, 'orelre ihy oarteh yshejubec ducas noateenej cudra ones whorgo wewhocki uthacix emel machag ybympivec ', '127.0.0.1', 4, 19, '2000-03-25 04:15:52'),
(121, 'groaphoowu glugreglu cufeegr ifeks ejeelsycko eteezat ycuth ifyfi che oacudsa uhuv ethoawysh emoamsa ulissu gree mighyk oomsuloavo eedr ethupsugr ucoacitch oatuce bisoashe psotchakr oamsu eegr obompi jept ugre mexoo yhynsung ichophigr ', '127.0.0.1', 3, 19, '2008-10-26 23:14:19'),
(122, 'oadsognee igocma zoosih voawel yps opsoalikoo oolrysta joozeeshee iroafezuty ymoothe ugraj loob ceelaroa psoawoad shocmopim cichith grilrety feeco gomo ciptulsong oodreckyp bycheg oax ', '127.0.0.1', 3, 19, '2009-08-30 16:38:17'),
(126, 'whekroov fetsoveel ovyh thoa oagl ujemsic ohowonewu uwits whav fyksast yglez bolroods oluri xoostag iwositaha ujojif uwhiga fooch footafush whic groo roapeec peebed ', '127.0.0.1', 10, 21, '1993-07-19 17:32:34'),
(127, 'oartaftu enum eexep reewheci stytchy soolud awhoaj uxo ufonoa epasyglib wibygh nunsoa egi ryglisseew whee seech igoasock zongyrdyh soaxoo ', '127.0.0.1', 3, 21, '1970-02-07 08:29:52'),
(128, 'eezy eptoloza ishisuwhee xirt shaveemto ooth oochu glynoap custoorsa joagrof cengoocor ceetobephe usocheelr shyrseeks neek apocmecmi ', '127.0.0.1', 3, 21, '1973-03-19 16:40:34'),
(129, 'sezutymtob groodro owhoo hoaneeptoa ragry ygaw oakoans ekydsort veekooxu itampyr diftuftee booteratu eersookroa phic eestuz steefe edoo oostyhoo rimsahe toachuh ilomso she rab leecha och psuka themongof hyxywh roax chamtobuch glus ', '127.0.0.1', 3, 21, '1992-12-10 16:31:02'),
(130, 'uxaboab udoar eepoomtuge hix oni griks avicm nolsex goophoowoa gelegr pho pexiphiksa umoang tuptogy eeds teereegrig eglyceec whodorsisy egrep otatch unisoath uphiwi oabeleersy adux leez ', '127.0.0.1', 3, 21, '1988-03-23 11:27:16'),
(131, 'zygrensoar sho afeet dunsoomso choagyhi mitu newha daduft psyj woalam yhyhoa jidre owobu raxurdoath steengo jee ', '127.0.0.1', 3, 21, '1981-02-13 11:41:09'),
(133, 'eezoameeks cha ytyno pheckog aneetife deth odirtadobo zoagoo gloob ichop glo ybeev ubodiw juf irood foop oanyf gleegnupt toafeecak ', '127.0.0.1', 3, 21, '1986-10-10 02:09:23'),
(134, 'gooshoofoo ushujokeev igeepsoo idortoomee eest gliwumte chifexest athoapsee leboodroa psyrtu huchugluks vedri xickeek paftoacujy stogl eptoog uforegro rozuhak sug ptee esup pseepesoob whinughix ', '127.0.0.1', 4, 21, '2002-02-05 04:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `projectname` varchar(15) NOT NULL,
  `creator` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `popularity` int(11) NOT NULL,
  `members` text NOT NULL,
  `short` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(15) NOT NULL,
  `image` varchar(50) NOT NULL,
  `video` varchar(50) NOT NULL,
  `launched` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ID`, `projectname`, `creator`, `date`, `popularity`, `members`, `short`, `description`, `category`, `image`, `video`, `launched`) VALUES
(8, 'Infinity', 2, '2014-03-23 00:28:16', 0, '2', 'This is a short description of my project.', 'This is a description.', 'all', 'temporary', 'temporary', 1),
(9, 'Testing', 2, '2014-03-23 19:08:57', 0, '2', 'Testing short description.', 'Testing a big description.', 'all', 'temporary', 'temporary', 1),
(10, 'Testing', 2, '2014-03-23 19:08:59', 0, '2', 'Testing short description.', 'Testing a big description.', 'all', 'temporary', 'temporary', 1),
(11, 'Testing', 2, '2014-03-23 19:09:01', 0, '2', 'Testing short description.', 'Testing a big description.', 'all', 'temporary', 'temporary', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE IF NOT EXISTS `ranks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ranks`
--

INSERT INTO `ranks` (`ID`, `name`) VALUES
(0, 'Banned'),
(1, 'Member'),
(2, 'Trusted'),
(3, 'VIP'),
(4, 'MOD'),
(5, 'GMOD'),
(6, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `recover`
--

CREATE TABLE IF NOT EXISTS `recover` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `ID_usr` int(5) NOT NULL,
  `code` varchar(32) NOT NULL,
  `IP` varchar(15) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `subcat`
--

CREATE TABLE IF NOT EXISTS `subcat` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `parent_ID` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `index_` int(11) NOT NULL DEFAULT '1000',
  `desc_` varchar(100) NOT NULL,
  `min_rank` int(2) NOT NULL DEFAULT '1',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `parent_ID` (`parent_ID`),
  KEY `min_rank` (`min_rank`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `subcat`
--

INSERT INTO `subcat` (`ID`, `parent_ID`, `name`, `index_`, `desc_`, `min_rank`, `visible`) VALUES
(1, 1, 'General discussion', 1000, 'General educated discussions', 1, 1),
(2, 1, 'Members introduction', 1000, 'New members, introduce yourself to the community so we can get to know you!', 1, 1),
(3, 1, 'Random', 1000, 'Frozen Bananas', 1, 1),
(4, 2, 'Annoucements', 1000, 'Big news concerning the website\r\n', 1, 1),
(5, 2, 'Suggestions', 1000, 'How can we make this website better?\r\n', 1, 1),
(6, 3, 'History', 1000, 'What did I eat yesterday?\r\n', 1, 1),
(7, 3, 'Athletics', 1000, '* flex *', 1, 1),
(8, 3, 'Language', 1000, 'Supurinkura no dansu hadakamashou\r\n', 1, 1),
(9, 3, 'Literature', 1000, '50 shades of gray\r\n', 1, 1),
(10, 3, 'Economics', 1000, 'Give me all your money\r\n', 1, 1),
(11, 3, 'Politics', 1000, 'The one who wins is the one who can lie the best\r\n', 1, 1),
(12, 3, 'Business', 1000, 'Lets be like apple, steal ideas and make money from them\r\n', 1, 1),
(13, 3, 'Religion', 1000, 'I never walked on water\r\n', 1, 1),
(14, 3, 'Philosophy', 1000, 'What if a stone wasn''t a stone would you then be able to be stoned to death?\r\n', 1, 1),
(15, 4, 'Culinary', 1000, 'I''m hungry.... DAMN YOU WOMAN WHERES MY FOOD????\r\n', 1, 1),
(16, 4, 'General Art', 1000, 'General Art? is this for graffiti?', 1, 1),
(17, 4, 'Athletic Art', 1000, 'Using your body\r\n', 1, 1),
(18, 5, 'Math', 1000, 'Q: How many beers do you have if you go in to a store and buy 5 if you had 3 before? 13 cause I stol', 1, 1),
(19, 5, 'Pyschology', 1000, 'I blame my neighbour for me being screwed up in the head\r\n', 1, 1),
(20, 5, 'Social Studies', 1000, 'Post your facebook here\r\n', 1, 1),
(21, 5, 'History', 1000, 'Didn''t we already have this one?\r\n', 1, 1),
(40, 5, 'Social Studies', 1000, 'Post your facebook here\r\n', 1, 1),
(41, 5, 'History', 1000, 'Didn''t we already have this one?\r\n', 1, 1),
(42, 5, 'Biological Sciences', 1000, 'Urg to boring to even write about\r\n', 1, 1),
(43, 5, 'Physical Sciences', 1000, 'o really? are you sure about that?\r\n', 1, 1),
(44, 5, 'Computer Science', 1000, 'Lets press the start button and see what happens\r\n', 1, 1),
(45, 5, 'Hacking', 1000, 'Making things do stuff they weren''t designed to do.\r\n', 1, 1),
(46, 5, 'Health', 1000, 'Eat you carrots\r\n', 1, 1),
(47, 5, 'Medical', 1000, 'I guess this will be the hangout for drug dealers\r\n', 1, 1),
(48, 6, 'Discussion', 1000, 'Discussing how different fields can work together', 1, 1),
(49, 6, 'Brainstorming', 1000, 'Would this work?\r\n', 1, 1),
(50, 8, 'Trolling', 1000, 'Only Admins See This', 1, 1),
(51, 7, 'Random', 1000, 'Only VIP see this', 1, 1),
(52, 7, 'hidden VIP', 999, 'This should not be visible unless your an admin', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subforum`
--

CREATE TABLE IF NOT EXISTS `subforum` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `parent_ID` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `min_rank` int(11) NOT NULL DEFAULT '1',
  `index_` int(11) NOT NULL DEFAULT '1000',
  `desc_` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `parent_ID` (`parent_ID`),
  KEY `min_rank` (`min_rank`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `subforum`
--

INSERT INTO `subforum` (`ID`, `name`, `parent_ID`, `visible`, `min_rank`, `index_`, `desc_`) VALUES
(1, 'Fun', 3, 1, 1, 1000, ''),
(2, 'Questions', 5, 1, 1, 1000, ''),
(3, 'Comments', 5, 1, 1, 1000, ''),
(4, 'Support', 5, 1, 1, 1000, ''),
(5, '3D design', 16, 1, 1, 1000, ''),
(6, 'Drawng', 16, 1, 1, 1000, ''),
(7, 'Painting', 16, 1, 1, 1000, ''),
(8, 'other', 16, 1, 1, 1000, ''),
(9, 'Singing', 17, 1, 1, 1000, ''),
(10, 'Dancing', 17, 1, 1, 1000, ''),
(11, 'other', 17, 1, 1, 1000, ''),
(12, 'Programming', 44, 1, 1, 1000, ''),
(13, 'Security', 44, 1, 1, 1000, ''),
(14, 'other', 44, 1, 1, 1000, '');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `sub` tinyint(1) NOT NULL DEFAULT '0',
  `msg` mediumtext NOT NULL,
  `title` varchar(100) NOT NULL,
  `parent_ID` bigint(20) NOT NULL,
  `time_` datetime NOT NULL,
  `by_` mediumint(9) NOT NULL,
  `IP` varchar(16) NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `by` (`by_`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`ID`, `sub`, `msg`, `title`, `parent_ID`, `time_`, `by_`, `IP`) VALUES
(1, 0, 'sha chigru gleec gemtuka eegre papsyh yrooheev iboordoaz thooch yxiptu gly pse egroboar googluster oachoatoop uwupti ', 'ootchi zoaloapt astyloo ', 1, '2007-12-03 02:09:04', 10, '127.0.0.1'),
(2, 1, 'phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee mphawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy aksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee makphawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy suv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy phawhoaf atypsee poazewa nudremtoam oaf mift oopeejoj oarsyxywhy ebat ekee maksuv anapsi oowonsoord oozysylu whegliwh see nishoalsef apoa aph jissy ', 'zitam ape feeja ', 1, '2000-02-16 02:01:11', 1, '127.0.0.1'),
(3, 0, 'leelocafe vylre mirt eecordee nems psyz yjomp gleetsoatu awosheegov roptoack gak ekelroshon whe fefturs oots iglysto gughaph kythuksy toowhyt iween psigroo thoa eeckeeco staruds iwughergoo zaw wodsept oxiroachur ejaltir foati oagnissolr steempub upeekycoo goasiwo ', 'choassys meepte ootu sto ithoamops ', 1, '2009-10-23 05:07:28', 10, '127.0.0.1'),
(4, 0, 'chicmal geekehyv awhooz ooc oard psoo gadseeca vomsu roo uthiwa kodricmy agr cugnen ujoosh eec yfe glilsi ifechee zyz ahateekro wyfer evucketee coak oal choaba ', 'ufu eeftech vodee ceestu icoomsuf grodsy ', 1, '2013-03-29 20:23:10', 4, '127.0.0.1'),
(5, 0, 'iptochoka atoam psewho tyfaps wibeth baxampoady koxoost oglyptoagl peeda umagyps soapsocag ochi oawoalso ', 'unessa seghudref zoobeej uchoshu oatchi ', 1, '2012-12-29 17:14:41', 3, '127.0.0.1'),
(6, 0, 'odiwads azeesh ooreewh ochit aheewh aboglolr jeeh enoastexee ihezaseeb oatsefi oogluthi ekoali xept leg pseerga ooptyky psymtuz wirde gixol eelseksy egee agloonaw jish agl molsoomsih jyd megnos ', 'phegher ekydeelt stiry ', 1, '2000-08-02 20:45:36', 3, '127.0.0.1'),
(7, 0, 'mirgoofe astystety psirsa ookrilt poag stoolyph ykyh epaft ebywh stoop efiworda obersempe dalrytsoa iptu ujoleewh phofa phoo ', 'imuxo sampe styk ykatse ', 1, '2002-02-03 13:57:49', 10, '127.0.0.1'),
(8, 0, 'voghoampo psoabym etoam woaglar ysheepsupt ewhoafoa ehee agloglapto zoatyceer ihoohoadoa enukoozelt shudrephoa xawhootcho ubuthivess vits ytypseluli enydadra ', 'abigida uzikse ysage ithy eptute oagassoow ', 1, '2005-09-14 15:27:09', 10, '127.0.0.1'),
(9, 0, 'the axamp chem cempeerg shu tethoof eegnolta thegnooz erybyftu ihoakrucm wher pidsee ageets igroa glehymp opteegl sha eemp lee anooptee oaftecke iru ajal iryngux loopeve icusoa ipoo oow rikooss gybuhox wheegly jar chiv obophoafec ', 'stoamt upsegrojy das ', 2, '2010-12-10 01:01:16', 3, '127.0.0.1'),
(10, 0, 'ecudri chemacka groabog coanukicha biftythycu eexewhopho oass ypessaf nodroshoal domi noapse huhigh oozissoa hursoanguk oanso stoa sungij arergood midroals vyz ozasoach olegys machewhoss phaneemsoo nylrep ypsu oapooz ugryphygli oageem ipoaxat churgosooc compuchu oxoosheeg ogloobiw ', 'jerufte atartoock gyptij ', 2, '2000-02-02 13:46:21', 1, '127.0.0.1'),
(11, 0, 'fee pooree boomycy oadrekroos jecikseep ooghahov eedsipsoos noamud pej veeroanoof iheex ugulsotchi vaphoarsu isoomu grojossy ooryzons edoohocm chipsyc ', 'alorg phomsucky eegnodryb echah ', 2, '2010-07-14 15:06:50', 2, '127.0.0.1'),
(13, 0, 'oagh oockic gragrixos ugregu vexamtetoo exav ixoohe psesi ogred pyrtu lypema psyps oophaw oonsoa shojanativ ech pso thu rixy apteele phyftur ', 'sto eensa oanoo ', 2, '2002-11-29 02:10:05', 2, '127.0.0.1'),
(14, 0, 'ugoa zith olijiw ysh epseb tengeeshy oavuds ooz kotee ychesajoa eec oavygroo racmu ', 'ufalti stiltast sho ymoostep ', 2, '2005-03-02 08:37:54', 10, '127.0.0.1'),
(15, 0, 'ala vagy eephyp jitsadsowh yceejeez oackoa iwomtywhoo opsefoad mikywi aheev ozy cywuchel koax keds ogruz oorgeex gleece ogle ilooso ipag ', 'oart leltilsig cha ', 2, '2007-05-06 13:06:43', 10, '127.0.0.1'),
(16, 0, 'oagloo belr liwheess xytchuneen choong rop imogokubu uhongimoa egycoteecm awybefoasu pteeshoo jampov luroh phoakrixo ijecmo ', 'oamtahy chetsu ust ', 3, '2007-02-19 21:42:04', 1, '127.0.0.1'),
(17, 0, 'mersacm lees veftux ecergeeph ekoo ipadseemen saksylr zoalos owu yba eetchaftoa shee beepapsugl agyptoa baphoa thoxeksuds zoakooxet vimpu akyglolug sahyg eek grersinsod doochoozis wholaloa agr xoost emis okyta estor oag ptoo ', 'xileel goothez vizosooj ewhyz adeegopy ', 3, '2006-05-01 20:16:56', 1, '127.0.0.1'),
(18, 0, 'othymyni eeceleeth stoovogh fifick chic vee foacuwhu shooroath jugoa ahuphupse oodsilsilr thavo koogroo dyvoad oalrih ', 'reedeexez eegeegub estywob ', 3, '2012-08-02 11:49:47', 4, '127.0.0.1'),
(19, 0, 'ykoa epoocheef ptoavyz eshunood yboophe oov pterteew azagib ysite oawhazile pheeh iwetch uwooshiz doavoch ptoakeron igilsoob oohoaby edoapsi cyw oolikeecox eer oan oardaghyr achepsogle cheerseh optypt irooweek ephacogle ', 'toaboojeh xajeegh tocooloak hytchubyc oat ', 3, '2004-12-10 05:20:36', 1, '127.0.0.1'),
(21, 0, 'puwywyrd upt aboordaz kat cidses aheeltor achoasofa ixoarga buftydr egra wylroab ywhee oongoopt roftyxyg fupsoofim wherge itophoogr xockywev dudruw glissu ylishoar oate upicom yreeksec ptod stexu ymookryfty ', 'ebee eegr cyrtuj choax ', 3, '2011-07-08 07:11:15', 2, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

CREATE TABLE IF NOT EXISTS `wall` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `by` int(5) NOT NULL,
  `to` int(11) DEFAULT '0',
  `privacy` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `txt` longtext NOT NULL,
  `child` int(5) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `geo` varchar(50) DEFAULT NULL,
  `like` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `wall`
--

INSERT INTO `wall` (`ID`, `by`, `to`, `privacy`, `date`, `txt`, `child`, `IP`, `geo`, `like`) VALUES
(1, 1, 1, 0, '2013-07-07 15:38:01', 'Testing to write on MY wall', 0, '127.0.0.1', 'NONE', ''),
(2, 1, 1, 0, '2013-07-07 15:38:17', 'Testing to comment on MY WALL', 1, '127.0.0.1', 'NONE', ''),
(3, 1, 2, 0, '2013-07-07 15:38:32', 'Testing to write on YOU WALL', 0, '127.0.0.1', 'NONE', ''),
(4, 1, 2, 0, '2013-07-07 15:38:47', 'Testing to comment on YOU WALL', 3, '127.0.0.1', 'NONE', ''),
(5, 1, 2, 0, '2013-07-07 15:39:00', 'Testing again', 3, '127.0.0.1', 'NONE', ''),
(6, 2, 2, 0, '2013-07-08 03:40:24', 'testing :P', 3, '108.23.116.84', 'NONE', ''),
(7, 2, 2, 0, '2013-07-08 03:40:35', 'testing my own post now :D', 0, '108.23.116.84', 'NONE', ''),
(8, 10, 10, 0, '2013-07-08 06:31:31', 'Testing out the stream here. Nice mono-space!', 0, '108.29.127.124', 'NONE', ''),
(9, 10, 10, 0, '2013-07-08 06:31:31', 'Testing out the stream here. Nice mono-space!', 0, '108.29.127.124', 'NONE', ''),
(10, 10, 10, 0, '2013-07-08 06:57:31', 'Yeah, right. That''s only in the text box. :P', 8, '108.29.127.124', 'NONE', ''),
(11, 10, 10, 0, '2013-07-08 07:28:35', 'Double post! This thing needs to be able to react FASTER, or this will happen a LOT of times.', 9, '108.29.127.124', 'NONE', ''),
(12, 2, 3, 0, '2013-07-14 02:30:52', 'HI jeremy!', 0, '108.23.116.136', 'NONE', ''),
(13, 2, 3, 0, '2013-07-14 02:31:11', 'this is a comment', 12, '108.23.116.136', 'NONE', ''),
(14, 1, 2, 0, '2013-07-18 05:44:41', 'test', 7, '31.4.245.152', 'NONE', ''),
(15, 1, 2, 0, '2013-07-18 05:47:45', 'test', 7, '31.4.245.152', 'NONE', ''),
(16, 1, 2, 0, '2013-07-18 05:47:56', 'test', 0, '31.4.245.152', 'NONE', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`min_rank`) REFERENCES `ranks` (`ID`);

--
-- Constraints for table `memberinfo`
--
ALTER TABLE `memberinfo`
  ADD CONSTRAINT `memberinfo_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `members` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`by_`) REFERENCES `memberinfo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`parent_ID`) REFERENCES `topics` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcat`
--
ALTER TABLE `subcat`
  ADD CONSTRAINT `subcat_ibfk_1` FOREIGN KEY (`parent_ID`) REFERENCES `categories` (`ID`),
  ADD CONSTRAINT `subcat_ibfk_2` FOREIGN KEY (`min_rank`) REFERENCES `ranks` (`ID`);

--
-- Constraints for table `subforum`
--
ALTER TABLE `subforum`
  ADD CONSTRAINT `subforum_ibfk_1` FOREIGN KEY (`parent_ID`) REFERENCES `subcat` (`ID`),
  ADD CONSTRAINT `subforum_ibfk_2` FOREIGN KEY (`min_rank`) REFERENCES `ranks` (`ID`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`by_`) REFERENCES `memberinfo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;