-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2014 at 08:16 PM
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
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `user` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `content` varchar(250) NOT NULL,
  `category` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `read` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`ID`, `username`, `IP`, `date`, `date2`) VALUES
(50, 'uriahsanders', '127.0.0.1', '1395450158', '0000-00-00 00:00:00'),
(89, 'uriahsanders', '127.0.0.1', '1395647081', '0000-00-00 00:00:00');

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
  `projects` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `memberinfo`
--

INSERT INTO `memberinfo` (`ID`, `username`, `sex`, `image`, `banner`, `rank`, `country`, `wURL`, `quote`, `age`, `last_login`, `work`, `active_p`, `special`, `points`, `status`, `status_time`, `about`, `resume`, `skills`, `projects`) VALUES
(1, 'relax', 'Male', '9a1111520842d32326809d2e7678defep', '457a42062ca91fb20f0d67020aa89119p', 6, 'Sweden', 'http://moijo.org', 'You don''t get what you want... you get what you work for.', 26, '0000-00-00 00:00:00', 'Student', 'Infinity-forum', 'Co-Founder', 10000, 0, '2014-03-22 13:26:19', 'Testing Relax about', '', '', ''),
(2, 'Uriah', 'Male', '5579265ae3dec2569717c0e0f1f7b5e5j', '', 6, 'USA', 'http://infinity-forum.org', 'My quote', 16, '0000-00-00 00:00:00', 'Infinity', 'infinity-forum', 'Co-Founder', 10000, 1, '2014-03-26 03:11:00', 'This is some information about me.', 'This is my resume.', '', '["106","107","108","109"]'),
(3, 'jeremy', 'Male', '716e08e05e5a92e36e922bc6be9ebd19j', '', 6, 'USA', '', 'I like cookies', 14, '0000-00-00 00:00:00', '', '', 'Co-Founder', 10000, 0, '0000-00-00 00:00:00', '', '', '', ''),
(4, 'wabi', '', '', '', 6, '', '', '', NULL, '0000-00-00 00:00:00', '', '', 'Co-Founder', 10000, 0, '0000-00-00 00:00:00', '', '', '', ''),
(10, 'arty', '', 'b4cb6f5e620a2b31a3065caca393131ap', '566de5d708d32517a1a7c4ca59a6990dp', 5, '', '', '', NULL, '0000-00-00 00:00:00', '', '', 'Member', 0, 0, '0000-00-00 00:00:00', '', '', '', ''),
(11, 'Test123', '', '', '', 1, '', '', '', NULL, '0000-00-00 00:00:00', '', '', 'Member', 0, 0, '2014-01-08 06:04:29', '', '', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ID`, `projectname`, `creator`, `date`, `popularity`, `members`, `short`, `description`, `category`, `image`, `video`, `launched`) VALUES
(106, 'Test', 2, '2014-03-25 20:10:18', 0, '[2]', 'Short description test', 'Long description test.', 'all', 'temporary', 'temporary', 1),
(107, 'Test', 2, '2014-03-25 20:10:19', 0, '[2]', 'Short description test', 'Long description test.', 'all', 'temporary', 'temporary', 1),
(108, 'Test', 2, '2014-03-25 20:10:20', 0, '[2]', 'Short description test', 'Long description test.', 'all', 'temporary', 'temporary', 1),
(109, 'Test', 2, '2014-03-25 20:10:21', 0, '[2]', 'Short description test', 'Long description test.', 'all', 'temporary', 'temporary', 1);

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
-- Table structure for table `suspicious`
--

CREATE TABLE IF NOT EXISTS `suspicious` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `IP` varchar(16) NOT NULL,
  `date` datetime NOT NULL,
  `message` varchar(250) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

CREATE TABLE IF NOT EXISTS `wall` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `wall`
--

INSERT INTO `wall` (`ID`, `type`, `by`, `to`, `privacy`, `date`, `txt`, `child`, `IP`, `geo`, `like`) VALUES
(1, 0, 1, 1, 0, '2013-07-07 15:38:01', 'Testing to write on MY wall', 0, '127.0.0.1', 'NONE', ''),
(2, 0, 1, 1, 0, '2013-07-07 15:38:17', 'Testing to comment on MY WALL', 1, '127.0.0.1', 'NONE', ''),
(3, 0, 1, 2, 0, '2013-07-07 15:38:32', 'Testing to write on YOU WALL', 0, '127.0.0.1', 'NONE', ''),
(4, 0, 1, 2, 0, '2013-07-07 15:38:47', 'Testing to comment on YOU WALL', 3, '127.0.0.1', 'NONE', ''),
(5, 0, 1, 2, 0, '2013-07-07 15:39:00', 'Testing again', 3, '127.0.0.1', 'NONE', ''),
(6, 0, 2, 2, 0, '2013-07-08 03:40:24', 'testing :P', 3, '108.23.116.84', 'NONE', ''),
(7, 0, 2, 2, 0, '2013-07-08 03:40:35', 'testing my own post now :D', 0, '108.23.116.84', 'NONE', ''),
(8, 0, 10, 10, 0, '2013-07-08 06:31:31', 'Testing out the stream here. Nice mono-space!', 0, '108.29.127.124', 'NONE', ''),
(9, 0, 10, 10, 0, '2013-07-08 06:31:31', 'Testing out the stream here. Nice mono-space!', 0, '108.29.127.124', 'NONE', ''),
(10, 0, 10, 10, 0, '2013-07-08 06:57:31', 'Yeah, right. That''s only in the text box. :P', 8, '108.29.127.124', 'NONE', ''),
(11, 0, 10, 10, 0, '2013-07-08 07:28:35', 'Double post! This thing needs to be able to react FASTER, or this will happen a LOT of times.', 9, '108.29.127.124', 'NONE', ''),
(12, 0, 2, 3, 0, '2013-07-14 02:30:52', 'HI jeremy!', 0, '108.23.116.136', 'NONE', ''),
(13, 0, 2, 3, 0, '2013-07-14 02:31:11', 'this is a comment', 12, '108.23.116.136', 'NONE', ''),
(14, 0, 1, 2, 0, '2013-07-18 05:44:41', 'test', 7, '31.4.245.152', 'NONE', ''),
(15, 0, 1, 2, 0, '2013-07-18 05:47:45', 'test', 7, '31.4.245.152', 'NONE', ''),
(16, 0, 1, 2, 0, '2013-07-18 05:47:56', 'test', 0, '31.4.245.152', 'NONE', ''),
(17, 0, 2, 2, 0, '2014-03-25 18:23:45', 'ggggggggggggg', 0, '127.0.0.1', 'NONE', ''),
(18, 0, 2, 2, 0, '2014-03-25 18:23:55', 'nnnnnnnnnnnn', 17, '127.0.0.1', 'NONE', ''),
(19, 0, 2, 2, 0, '2014-03-25 18:26:22', 'Making sure that posts work with ajax, and aren''t vulnerable to injection.', 17, '127.0.0.1', 'NONE', '');

-- --------------------------------------------------------

--
-- Table structure for table `workspace_data`
--

CREATE TABLE IF NOT EXISTS `workspace_data` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `projectID` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `title` varchar(35) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `level` int(11) NOT NULL,
  `by` int(11) NOT NULL,
  `data` text NOT NULL,
  `lastUser` int(11) NOT NULL,
  `branch` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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