-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 13 Novembre 2011 à 17:06
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `ginc`
--

-- --------------------------------------------------------

--
-- Structure de la table `ginc_contacts`
--

CREATE TABLE IF NOT EXISTS `ginc_contacts` (
  `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_type` int(1) unsigned DEFAULT NULL,
  `contact_statu` int(11) NOT NULL,
  `contact_read` int(1) NOT NULL,
  `contact_full_name` varchar(36) NOT NULL,
  `contact_last_name` varchar(45) DEFAULT NULL,
  `contact_first_name` varchar(45) DEFAULT NULL,
  `contact_email` varchar(60) NOT NULL,
  `contact_phone` bigint(20) DEFAULT NULL,
  `contact_cellphone` bigint(20) DEFAULT NULL,
  `contact_fax` bigint(20) DEFAULT NULL,
  `contact_website` varchar(300) DEFAULT NULL,
  `contact_date` datetime NOT NULL,
  `contact_object` varchar(300) DEFAULT NULL,
  `contact_content` longtext NOT NULL,
  `contact_ip` int(11) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `ginc_contacts`
--

INSERT INTO `ginc_contacts` (`contact_id`, `contact_type`, `contact_statu`, `contact_read`, `contact_full_name`, `contact_last_name`, `contact_first_name`, `contact_email`, `contact_phone`, `contact_cellphone`, `contact_fax`, `contact_website`, `contact_date`, `contact_object`, `contact_content`, `contact_ip`) VALUES
(3, NULL, 1, 1, 'gggggggggggggg', '', '', 'imc0d3r@hotmail.com', 0, 0, 0, '', '2011-10-19 14:49:51', 'jjjjjjjjjjjjj', 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj', 1270),
(4, NULL, 0, 1, 'fffffffffffffff', '', '', 'indevloper@hotmail.com', 0, 0, 0, '', '2011-10-19 15:07:47', 'fffffffffffffffffffffffffffffff', 'ffffffffffffffffff', 1270),
(5, NULL, 0, 0, 'full_name', '', '', 'qsdqs@qsdqsd.qsd', 0, 0, 0, 'http://127.0.0.1/Ginc_Project/Ginc/contactus', '2011-11-11 13:06:45', 'object', 'contentsite', 1270),
(6, NULL, 0, 0, 'full_name', '', '', 'qsdqs@qsdqsd.qsd', 0, 0, 0, 'http://127.0.0.1/Ginc_Project/Ginc/contactus', '2011-11-11 13:07:22', 'object', 'contentsite', 1270),
(7, NULL, 1, 1, 'full_name', '', '', 'qsdqds@qsdqsd.qsd', 0, 0, 0, 'http://127.0.0.1/Ginc_Project/Ginc/contactus', '2011-11-11 13:12:25', 'object', 'content', 1270);

-- --------------------------------------------------------

--
-- Structure de la table `ginc_contents`
--

CREATE TABLE IF NOT EXISTS `ginc_contents` (
  `content_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content_author_id` bigint(20) unsigned NOT NULL,
  `content_publish_date` datetime NOT NULL,
  `content_start_publishing` varchar(11) DEFAULT NULL,
  `content_finish_publishing` varchar(11) DEFAULT NULL,
  `content_title` varchar(100) NOT NULL,
  `content_slug` varchar(100) NOT NULL,
  `content_language` varchar(255) NOT NULL DEFAULT 'all',
  `content_icon` varchar(250) DEFAULT NULL,
  `content_description` text,
  `content_content` longtext,
  `content_statu` int(10) unsigned NOT NULL DEFAULT '0',
  `content_type` varchar(50) NOT NULL,
  `content_hits` int(50) NOT NULL,
  `content_meta_description` varchar(500) DEFAULT NULL,
  `content_meta_keywords` text,
  `content_meta_robots` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`content_id`),
  KEY `fk_articles_users1` (`content_author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `ginc_contents`
--

INSERT INTO `ginc_contents` (`content_id`, `content_author_id`, `content_publish_date`, `content_start_publishing`, `content_finish_publishing`, `content_title`, `content_slug`, `content_language`, `content_icon`, `content_description`, `content_content`, `content_statu`, `content_type`, `content_hits`, `content_meta_description`, `content_meta_keywords`, `content_meta_robots`) VALUES
(8, 4582, '2011-10-14 14:06:00', '0', '0', 'Article Title', 'article-title', 'all', NULL, '', '', 0, 'article', 0, 'Article Content', 'Article Content', ''),
(9, 0, '2011-10-14 17:43:00', '0', '0', 'Ø­Ø³Ù†Ø§Ù‹ØŒ Ù…Ø§Ø°Ø§ ØªØ¹Ù†ÙŠ H-T-M-L ?', 'rrrrrrrrrrrrrrrr', 'english', NULL, '                    <img width="277" height="157" src="http://www.grafikart.fr/blog/wp-content/uploads/2011/10/formation-277x157.jpg" alt="test" title="formation">Â <p>Ù„ÙƒÙŠ Ù†Ø®ØªØµØ± Ø§Ù„Ù‚ØµØ©ØŒ HTML Ø§Ø®ØªØ±Ø¹Øª ÙÙŠ Ø¹Ø§Ù… 1990Ù… Ù…Ù† Ù‚Ø¨Ù„ Ø¹Ø§Ù„Ù… ÙŠØ³Ù…Ù‰ ØªÙŠÙ… Ø¨ÙŠØ±Ù†Ø±Ø² Ù„ÙŠØŒ Ø§Ù„Ù‡Ø¯Ù Ù…Ù† Ù‡Ø°Ù‡ Ø§Ù„Ù„ØºØ© Ù‡Ùˆ ØªØ¨Ø³ÙŠØ· Ø¹Ù…Ù„ÙŠØ© ÙˆØµÙˆÙ„ Ø§Ù„Ø¹Ù„Ù…Ø§Ø¡ ÙÙŠ Ø¬Ø§Ù…Ø¹Ø§Øª Ù…Ø®ØªÙ„ÙØ© Ø¥Ù„Ù‰ Ø§Ù„Ø¨Ø­ÙˆØ« Ø§Ù„ØªÙŠ ÙŠÙ†Ø´Ø±ÙˆÙ†Ù‡Ø§ØŒ Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ù†Ø¬Ø­ Ø¨Ø´ÙƒÙ„ Ù„Ù… ÙŠØªØµÙˆØ±Ù‡ ØªÙŠÙ… Ø¨ÙŠØ±Ù†Ø±Ø² Ù„ÙŠØŒ Ø¨Ø§Ø®ØªØ±Ø§Ø¹Ù‡ HTML Ù‚Ø§Ù… ØªÙŠÙ… Ø¨ÙˆØ¶Ø¹ Ø£Ø³Ø§Ø³ Ø´Ø¨ÙƒØ© Ø§Ù„ÙˆÙŠØ¨ ÙƒÙ…Ø§ Ù†Ø¹Ø±ÙÙ‡Ø§ Ø§Ù„ÙŠÙˆÙ….</p><p>HTML Ù‡ÙŠ Ù„ØºØ© ØªØ³Ù…Ø­ Ø¨Ø¹Ø±Ø¶ Ø§Ù„Ù…Ø¹Ù„ÙˆÙ…Ø§Øª (Ù…Ø«Ø§Ù„: Ø§Ù„Ø¨Ø­ÙˆØ« Ø§Ù„Ø¹Ù„Ù…ÙŠØ©) Ø¹Ù„Ù‰ Ø´Ø¨ÙƒØ© Ø¥Ù†ØªØ±Ù†ØªØŒ Ù…Ø§ ØªØ±Ø§Ù‡ Ø¹Ù†Ø¯ Ø²ÙŠØ§Ø±ØªÙƒ Ù„Ø£ÙŠ ØµÙØ­Ø© ÙÙŠ Ø§Ù„Ø´Ø¨ÙƒØ© Ù‡Ùˆ ØªØ±Ø¬Ù…Ø© Ø§Ù„Ù…ØªØµÙØ­ Ù„Ø£ÙˆØ§Ù…Ø± HTMLØŒ Ù„ÙƒÙŠ ØªØ±Ù‰ HTML Ù„Ø£ÙŠ ØµÙØ­Ø© ØªØ²ÙˆØ±Ù‡Ø§ Ø¹Ù„ÙŠÙƒ Ø£Ù† ØªØ¶ØºØ· Ø¹Ù„Ù‰ Ù‚Ø§Ø¦Ù…Ø© Ø¹Ø±Ø¶ "View" Ø«Ù… Ø§Ù„Ù…ØµØ¯Ø± "Source".</p>Ø¢Ø®Ø±ÙˆÙ† ÙŠØ¸Ù†ÙˆÙ† Ø£Ù† Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ ÙŠØ­ØªØ§Ø¬ Ø¥Ù„Ù‰ Ø¨Ø±Ø§Ù…Ø¬ ØºØ§Ù„ÙŠØ© ÙˆÙ…ØªÙ‚Ø¯Ù…Ø© ÙˆÙ‡Ø°Ø§ Ø£ÙŠØ¶Ø§Ù‹ ØºÙŠØ± ØµØ­ÙŠØ­ØŒ ØµØ­ÙŠØ­ Ø£Ù† Ù‡Ù†Ø§Ùƒ Ø§Ù„ÙƒØ«ÙŠØ± Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„ØªÙŠ ØªØ¯Ø¹ÙŠ Ø£Ù†Ù‡Ø§ ØªØ³ØªØ·ÙŠØ¹ Ø¥Ù†Ø´Ø§Ø¡ Ù…ÙˆØ§Ù‚Ø¹ Ù„ÙƒØŒ Ø¨Ø¹Ø¶Ù‡Ø§ ÙŠÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ø´ÙƒÙ„ Ø£ÙØ¶Ù„ Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„Ø£Ø®Ø±Ù‰ØŒ Ù„ÙƒÙ† Ø¥Ù† Ø£Ø±Ø¯Øª Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø´ÙƒÙ„ ØµØ­ÙŠØ­ ÙØ¹Ù„ÙŠÙƒ Ø£Ù† ØªÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ù†ÙØ³ÙƒØŒ Ù„Ø­Ø³Ù† Ø§Ù„Ø­Ø¸Â <strong>Ø¹Ù…Ù„ÙŠØ© ØªØ·ÙˆÙŠØ± Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø³ÙŠØ·Ø© ÙˆØ§Ù„Ø£Ø¯ÙˆØ§Øª Ø§Ù„ØªÙŠ ØªØ­ØªØ§Ø¬Ù‡Ø§ Ù…ØªÙˆÙØ±Ø© Ù„Ø¯ÙŠÙƒ ÙˆÙ…Ø¬Ø§Ù†ÙŠØ©</strong>.', '<br><p>Ø¢Ø®Ø±ÙˆÙ† ÙŠØ¸Ù†ÙˆÙ† Ø£Ù† Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ ÙŠØ­ØªØ§Ø¬ Ø¥Ù„Ù‰ Ø¨Ø±Ø§Ù…Ø¬ ØºØ§Ù„ÙŠØ© ÙˆÙ…ØªÙ‚Ø¯Ù…Ø© ÙˆÙ‡Ø°Ø§ Ø£ÙŠØ¶Ø§Ù‹ ØºÙŠØ± ØµØ­ÙŠØ­ØŒ ØµØ­ÙŠØ­ Ø£Ù† Ù‡Ù†Ø§Ùƒ Ø§Ù„ÙƒØ«ÙŠØ± Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„ØªÙŠ ØªØ¯Ø¹ÙŠ Ø£Ù†Ù‡Ø§ ØªØ³ØªØ·ÙŠØ¹ Ø¥Ù†Ø´Ø§Ø¡ Ù…ÙˆØ§Ù‚Ø¹ Ù„ÙƒØŒ Ø¨Ø¹Ø¶Ù‡Ø§ ÙŠÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ø´ÙƒÙ„ Ø£ÙØ¶Ù„ Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„Ø£Ø®Ø±Ù‰ØŒ Ù„ÙƒÙ† Ø¥Ù† Ø£Ø±Ø¯Øª Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø´ÙƒÙ„ ØµØ­ÙŠØ­ ÙØ¹Ù„ÙŠÙƒ Ø£Ù† ØªÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ù†ÙØ³ÙƒØŒ Ù„Ø­Ø³Ù† Ø§Ù„Ø­Ø¸Â <strong>Ø¹Ù…Ù„ÙŠØ© ØªØ·ÙˆÙŠØ± Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø³ÙŠØ·Ø© ÙˆØ§Ù„Ø£Ø¯ÙˆØ§Øª Ø§Ù„ØªÙŠ ØªØ­ØªØ§Ø¬Ù‡Ø§ Ù…ØªÙˆÙØ±Ø© Ù„Ø¯ÙŠÙƒ ÙˆÙ…Ø¬Ø§Ù†ÙŠØ©</strong>.</p>                ', 2, 'article', 25, '', '', ''),
(10, 0, '2011-10-15 17:26:00', '0', '0', ' ÙƒØ§Ù…Ù„ Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… MVC Ø¨Ø¨Ø³Ø§Ø·Ø©', '-mvc-', 'all', 'http://www.grafikart.fr/img/tutos/thumbs/180_205x100.jpg', '<object><param name="movie" value="http://www.megavideo.com/v/IZ2Q32AE016ffac01db537388c6894dbb1173f72"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.megavideo.com/v/IZ2Q32AE016ffac01db537388c6894dbb1173f72" type="application/x-shockwave-flash" allowfullscreen="true"></embed></object>', '                                                            Ø´Ø±Ø­ Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… Ø¥Ù… ÙÙŠ Ø³ÙŠ Ø¨Ø¨Ø³Ø§Ø·Ø© Ù…Ø¹ Ø¹Ù…Ù„ Â ØªØ·Ø¨ÙŠÙ‚ Ø¨Ø³ÙŠØ· Ø¹Ø¨Ø§Ø±Ø© Ø¹Ù† Ù…Ø´Ø±ÙˆØ¹ Ù„ØªÙ†ÙÙŠØ¯ Ø§Ù„Ù…Ù‡Ø§Ù‡Ù… Ø§Ù„ÙŠÙˆÙ…ÙŠØ©                                                ', 2, 'video', 40, '', '', ''),
(11, 0, '2011-10-15 17:26:00', '0', '0', 'Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… MVC Ø¨Ø¨Ø³Ø§Ø·Ø©', '-mvc-', 'all', 'http://www.grafikart.fr/img/tutos/thumbs/180_205x100.jpg', '', '                                                            Ø´Ø±Ø­ Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… Ø¥Ù… ÙÙŠ Ø³ÙŠ Ø¨Ø¨Ø³Ø§Ø·Ø© Ù…Ø¹ Ø¹Ù…Ù„ Â ØªØ·Ø¨ÙŠÙ‚ Ø¨Ø³ÙŠØ· Ø¹Ø¨Ø§Ø±Ø© Ø¹Ù† Ù…Ø´Ø±ÙˆØ¹ Ù„ØªÙ†ÙÙŠØ¯ Ø§Ù„Ù…Ù‡Ø§Ù‡Ù… Ø§Ù„ÙŠÙˆÙ…ÙŠØ©                                                ', 2, 'video', 40, '', '', ''),
(12, 4582, '2011-10-16 19:30:00', '0', '0', 'Ø´Ø±Ø­ Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… Ø¥Ù… ÙÙŠ Ø³ÙŠ', '-', 'all', 'http://www.grafikart.fr/img/tutos/thumbs/180_205x100.jpg', 'Ø´Ø±Ø­ Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… Ø¥Ù… ÙÙŠ Ø³ÙŠ', '                    Ø´Ø±Ø­ Ø¨Ø±Ù…Ø¬Ø© Ù†Ø¸Ø§Ù… Ø¥Ù… ÙÙŠ Ø³ÙŠ Ø¨Ø¨Ø³Ø§Ø·Ø© Ù…Ø¹ Ø¹Ù…Ù„ Â ØªØ·Ø¨ÙŠÙ‚ Ø¨Ø³ÙŠØ· Ø¹Ø¨Ø§Ø±Ø© Ø¹Ù† Ù…Ø´Ø±ÙˆØ¹ Ù„ØªÙ†ÙÙŠØ¯ Ø§Ù„Ù…Ù‡Ø§Ù‡Ù… Ø§Ù„ÙŠÙˆÙ…ÙŠØ©                ', 2, 'video', 2, '', '', ''),
(13, 4582, '2011-10-17 21:47:00', '0', '0', 'Ø§Ø®ØªØ±Ø¹Øª ÙÙŠ Ø¹Ø§Ù… 1990Ù… Ù…Ù† Ù‚Ø¨Ù„ Ø¹Ø§Ù„Ù… ÙŠØ³Ù…Ù‰ ØªÙŠÙ… Ø¨ÙŠØ±Ù†Ø±Ø²', '-1990-', 'all', NULL, '                                                                                                    <img width="277" height="157" src="http://www.grafikart.fr/blog/wp-content/uploads/2011/10/formation-277x157.jpg" alt="test" title="formation">Â <p>Ù„ÙƒÙŠ Ù†Ø®ØªØµØ± Ø§Ù„Ù‚ØµØ©ØŒ HTML Ø§Ø®ØªØ±Ø¹Øª ÙÙŠ Ø¹Ø§Ù… 1990Ù… Ù…Ù† Ù‚Ø¨Ù„ Ø¹Ø§Ù„Ù… ÙŠØ³Ù…Ù‰ ØªÙŠÙ… Ø¨ÙŠØ±Ù†Ø±Ø² Ù„ÙŠØŒ Ø§Ù„Ù‡Ø¯Ù Ù…Ù† Ù‡Ø°Ù‡ Ø§Ù„Ù„ØºØ© Ù‡Ùˆ ØªØ¨Ø³ÙŠØ· Ø¹Ù…Ù„ÙŠØ© ÙˆØµÙˆÙ„ Ø§Ù„Ø¹Ù„Ù…Ø§Ø¡ ÙÙŠ Ø¬Ø§Ù…Ø¹Ø§Øª Ù…Ø®ØªÙ„ÙØ© Ø¥Ù„Ù‰ Ø§Ù„Ø¨Ø­ÙˆØ« Ø§Ù„ØªÙŠ ÙŠÙ†Ø´Ø±ÙˆÙ†Ù‡Ø§ØŒ Ø§Ù„Ù…Ø´Ø±ÙˆØ¹ Ù†Ø¬Ø­ Ø¨Ø´ÙƒÙ„ Ù„Ù… ÙŠØªØµÙˆØ±Ù‡ ØªÙŠÙ… Ø¨ÙŠØ±Ù†Ø±Ø² Ù„ÙŠØŒ Ø¨Ø§Ø®ØªØ±Ø§Ø¹Ù‡ HTML Ù‚Ø§Ù… ØªÙŠÙ… Ø¨ÙˆØ¶Ø¹ Ø£Ø³Ø§Ø³ Ø´Ø¨ÙƒØ© Ø§Ù„ÙˆÙŠØ¨ ÙƒÙ…Ø§ Ù†Ø¹Ø±ÙÙ‡Ø§ Ø§Ù„ÙŠÙˆÙ….</p><p>HTML Ù‡ÙŠ Ù„ØºØ© ØªØ³Ù…Ø­ Ø¨Ø¹Ø±Ø¶ Ø§Ù„Ù…Ø¹Ù„ÙˆÙ…Ø§Øª (Ù…Ø«Ø§Ù„: Ø§Ù„Ø¨Ø­ÙˆØ« Ø§Ù„Ø¹Ù„Ù…ÙŠØ©) Ø¹Ù„Ù‰ Ø´Ø¨ÙƒØ© Ø¥Ù†ØªØ±Ù†ØªØŒ Ù…Ø§ ØªØ±Ø§Ù‡ Ø¹Ù†Ø¯ Ø²ÙŠØ§Ø±ØªÙƒ Ù„Ø£ÙŠ ØµÙØ­Ø© ÙÙŠ Ø§Ù„Ø´Ø¨ÙƒØ© Ù‡Ùˆ ØªØ±Ø¬Ù…Ø© Ø§Ù„Ù…ØªØµÙØ­ Ù„Ø£ÙˆØ§Ù…Ø± HTMLØŒ Ù„ÙƒÙŠ ØªØ±Ù‰ HTML Ù„Ø£ÙŠ ØµÙØ­Ø© ØªØ²ÙˆØ±Ù‡Ø§ Ø¹Ù„ÙŠÙƒ Ø£Ù† ØªØ¶ØºØ· Ø¹Ù„Ù‰ Ù‚Ø§Ø¦Ù…Ø© Ø¹Ø±Ø¶ "View" Ø«Ù… Ø§Ù„Ù…ØµØ¯Ø± "Source".</p>Ø¢Ø®Ø±ÙˆÙ† ÙŠØ¸Ù†ÙˆÙ† Ø£Ù† Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ ÙŠØ­ØªØ§Ø¬ Ø¥Ù„Ù‰ Ø¨Ø±Ø§Ù…Ø¬ ØºØ§Ù„ÙŠØ© ÙˆÙ…ØªÙ‚Ø¯Ù…Ø© ÙˆÙ‡Ø°Ø§ Ø£ÙŠØ¶Ø§Ù‹ ØºÙŠØ± ØµØ­ÙŠØ­ØŒ ØµØ­ÙŠØ­ Ø£Ù† Ù‡Ù†Ø§Ùƒ Ø§Ù„ÙƒØ«ÙŠØ± Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„ØªÙŠ ØªØ¯Ø¹ÙŠ Ø£Ù†Ù‡Ø§ ØªØ³ØªØ·ÙŠØ¹ Ø¥Ù†Ø´Ø§Ø¡ Ù…ÙˆØ§Ù‚Ø¹ Ù„ÙƒØŒ Ø¨Ø¹Ø¶Ù‡Ø§ ÙŠÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ø´ÙƒÙ„ Ø£ÙØ¶Ù„ Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„Ø£Ø®Ø±Ù‰ØŒ Ù„ÙƒÙ† Ø¥Ù† Ø£Ø±Ø¯Øª Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø´ÙƒÙ„ ØµØ­ÙŠØ­ ÙØ¹Ù„ÙŠÙƒ Ø£Ù† ØªÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ù†ÙØ³ÙƒØŒ Ù„Ø­Ø³Ù† Ø§Ù„Ø­Ø¸Â <strong>Ø¹Ù…Ù„ÙŠØ© ØªØ·ÙˆÙŠØ± Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø³ÙŠØ·Ø© ÙˆØ§Ù„Ø£Ø¯ÙˆØ§Øª Ø§Ù„ØªÙŠ ØªØ­ØªØ§Ø¬Ù‡Ø§ Ù…ØªÙˆÙØ±Ø© Ù„Ø¯ÙŠÙƒ ÙˆÙ…Ø¬Ø§Ù†ÙŠØ©</strong>.', '<p>Ø¢Ø®Ø±ÙˆÙ† ÙŠØ¸Ù†ÙˆÙ† Ø£Ù† Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ ÙŠØ­ØªØ§Ø¬ Ø¥Ù„Ù‰ Ø¨Ø±Ø§Ù…Ø¬ ØºØ§Ù„ÙŠØ© ÙˆÙ…ØªÙ‚Ø¯Ù…Ø© ÙˆÙ‡Ø°Ø§ Ø£ÙŠØ¶Ø§Ù‹ ØºÙŠØ± ØµØ­ÙŠØ­ØŒ ØµØ­ÙŠØ­ Ø£Ù† Ù‡Ù†Ø§Ùƒ Ø§Ù„ÙƒØ«ÙŠØ± Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„ØªÙŠ ØªØ¯Ø¹ÙŠ Ø£Ù†Ù‡Ø§ ØªØ³ØªØ·ÙŠØ¹ Ø¥Ù†Ø´Ø§Ø¡ Ù…ÙˆØ§Ù‚Ø¹ Ù„ÙƒØŒ Ø¨Ø¹Ø¶Ù‡Ø§ ÙŠÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ø´ÙƒÙ„ Ø£ÙØ¶Ù„ Ù…Ù† Ø§Ù„Ø¨Ø±Ø§Ù…Ø¬ Ø§Ù„Ø£Ø®Ø±Ù‰ØŒ Ù„ÙƒÙ† Ø¥Ù† Ø£Ø±Ø¯Øª Ø¥Ù†Ø´Ø§Ø¡ Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø´ÙƒÙ„ ØµØ­ÙŠØ­ ÙØ¹Ù„ÙŠÙƒ Ø£Ù† ØªÙØ¹Ù„ Ø°Ù„Ùƒ Ø¨Ù†ÙØ³ÙƒØŒ Ù„Ø­Ø³Ù† Ø§Ù„Ø­Ø¸Â <strong>Ø¹Ù…Ù„ÙŠØ© ØªØ·ÙˆÙŠØ± Ø§Ù„Ù…ÙˆØ§Ù‚Ø¹ Ø¨Ø³ÙŠØ·Ø© ÙˆØ§Ù„Ø£Ø¯ÙˆØ§Øª Ø§Ù„ØªÙŠ ØªØ­ØªØ§Ø¬Ù‡Ø§ Ù…ØªÙˆÙØ±Ø© Ù„Ø¯ÙŠÙƒ ÙˆÙ…Ø¬Ø§Ù†ÙŠØ©</strong>.</p>                                                                                ', 2, 'article', 32, '', '', ''),
(14, 0, '2011-11-09 00:34:00', '0', '0', 'sssssssssssss', 'sssssssssssss', 'all', NULL, '', '', 0, 'article', 0, '', '', ''),
(15, 0, '2011-11-09 00:34:00', '0', '0', 'sssssssssssss', 'sssssssssssss', 'all', NULL, '', '', 0, 'article', 0, '', '', ''),
(16, 0, '2011-11-09 00:39:00', '0', '0', 'sssssssssssssss', 'sssssssssssssss', 'all', NULL, '', '', 0, 'article', 0, '', '', ''),
(17, 0, '2011-11-09 00:39:00', '0', '0', 'sssssssssssssss', 'sssssssssssssss', 'all', NULL, '', '', 0, 'article', 0, '', '', ''),
(18, 0, '2011-11-09 00:39:00', '0', '0', 'sssssssssssssss', 'sssssssssssssss', 'all', NULL, '', '', 0, 'article', 0, '', '', ''),
(19, 0, '2011-11-09 00:46:00', '0', '0', 'rrrrrrrrrrrrrrr', 'rrrrrrrrrrrrrrr', 'english', NULL, '', 'hehoooooooooooooooooooooooooooooooooooooo', 2, 'article', 9, '', '', ''),
(20, 0, '2011-11-09 11:31:00', '0', '0', 'ttttttttttttttttttttttttt', 'ttttttttttttttttttttttttt', 'all', '', '', 'ttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt', 0, 'video', 0, '', '', ''),
(21, 0, '2011-11-09 11:31:00', '0', '0', 'ttttttttttttttttttttttttt', 'ttttttttttttttttttttttttt', 'all', '', '', 'ttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt', 0, 'video', 0, '', '', ''),
(22, 0, '2011-11-09 11:33:00', '0', '0', 'oooooooooooooooooooo', 'oooooooooooooooooooo', 'all', '', '', 'ooooooooooooooooooooooooooooooooooooooooo', 0, 'video', 0, '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_gallerys`
--

CREATE TABLE IF NOT EXISTS `ginc_gallerys` (
  `gallery_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_aurhor_id` bigint(20) unsigned NOT NULL,
  `gallery_title` varchar(100) NOT NULL,
  `gallery_publish_date` datetime NOT NULL,
  `gallery_statu` tinyint(1) NOT NULL DEFAULT '0',
  `gallery_language` varchar(255) NOT NULL DEFAULT 'all',
  `gallery_description` varchar(300) DEFAULT NULL,
  `gallery_imgs` longtext NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ginc_gallerys`
--

INSERT INTO `ginc_gallerys` (`gallery_id`, `gallery_aurhor_id`, `gallery_title`, `gallery_publish_date`, `gallery_statu`, `gallery_language`, `gallery_description`, `gallery_imgs`) VALUES
(1, 4582, 'qqqqqqqqqqq', '0000-00-00 00:00:00', 2, 'all', 'ssssssssssssssssssss', 'ssssssssssssssssssssssssssssss;sssssssssss');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_guestbook`
--

CREATE TABLE IF NOT EXISTS `ginc_guestbook` (
  `guestbook_id` int(11) NOT NULL AUTO_INCREMENT,
  `guestbook_name` varchar(255) NOT NULL DEFAULT '',
  `guestbook_statu` int(11) NOT NULL,
  `guestbook_language` varchar(255) NOT NULL DEFAULT 'all',
  `guestbook_publish_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `guestbook_start_publishing` varchar(11) DEFAULT NULL,
  `guestbook_finish_publishing` varchar(11) DEFAULT NULL,
  `guestbook_message` text NOT NULL,
  PRIMARY KEY (`guestbook_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Contenu de la table `ginc_guestbook`
--

INSERT INTO `ginc_guestbook` (`guestbook_id`, `guestbook_name`, `guestbook_statu`, `guestbook_language`, `guestbook_publish_date`, `guestbook_start_publishing`, `guestbook_finish_publishing`, `guestbook_message`) VALUES
(33, 'hhhhhhhhhhhhhhhhh3', 2, 'all', '2011-10-14 02:53:00', '0', '0', 'hhhhhhhhhhhhhhhhhhhhhhhhhh');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_links`
--

CREATE TABLE IF NOT EXISTS `ginc_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_menu_id` int(20) NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_language` varchar(255) NOT NULL DEFAULT 'all',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` text NOT NULL,
  `link_statu` bigint(20) NOT NULL DEFAULT '0',
  `link_start_publishing` varchar(11) DEFAULT NULL,
  `link_finish_publishing` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `ginc_links`
--

INSERT INTO `ginc_links` (`link_id`, `link_menu_id`, `link_url`, `link_name`, `link_language`, `link_target`, `link_description`, `link_statu`, `link_start_publishing`, `link_finish_publishing`) VALUES
(22, 12, 'http://127.0.0.1/', 'Localhost', 'all', '_none', 'Localhost', 2, '0', '0'),
(23, 11, 'ssssssssssssssssss', 'sssssssssssssssssssssssss', 'all', '_none', 'ssssssssssssssssssssssssss', 0, '0', '0');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_menu`
--

CREATE TABLE IF NOT EXISTS `ginc_menu` (
  `menu_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_language` varchar(255) NOT NULL DEFAULT 'all',
  `menu_statu` int(20) NOT NULL,
  `menu_showname` int(1) NOT NULL,
  `menu_place` varchar(255) NOT NULL,
  `menu_start_publishing` varchar(11) DEFAULT NULL,
  `menu_finish_publishing` varchar(11) DEFAULT NULL,
  `menu_order_as` int(20) NOT NULL,
  `menu_description` text NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `ginc_menu`
--

INSERT INTO `ginc_menu` (`menu_id`, `menu_name`, `menu_language`, `menu_statu`, `menu_showname`, `menu_place`, `menu_start_publishing`, `menu_finish_publishing`, `menu_order_as`, `menu_description`) VALUES
(11, 'Main Menu', 'all', 2, 0, 'left', '0', '0', 0, 'This Is MeNU'),
(12, 'Top Menu', 'all', 2, 1, 'top', '0', '0', 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_messages`
--

CREATE TABLE IF NOT EXISTS `ginc_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_author_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `message_type` int(1) NOT NULL DEFAULT '0',
  `message_display` tinyint(1) NOT NULL DEFAULT '0',
  `message_object` varchar(300) NOT NULL,
  `message_content` longtext NOT NULL,
  `message_joined_files` longtext,
  `message_sending_date` datetime NOT NULL,
  `message_recived_date` datetime NOT NULL,
  `message_statu` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`),
  KEY `fk_messages_users1` (`message_author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `ginc_messages`
--


-- --------------------------------------------------------

--
-- Structure de la table `ginc_offres`
--

CREATE TABLE IF NOT EXISTS `ginc_offres` (
  `offre_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `offre_name` varchar(60) NOT NULL,
  `offre_language` varchar(255) NOT NULL DEFAULT 'all',
  `offre_publish_date` datetime NOT NULL,
  `offre_start_publishing` varchar(11) DEFAULT NULL,
  `offre_finish_publishing` varchar(11) DEFAULT NULL,
  `offre_content` text NOT NULL,
  `offre_statu` int(1) NOT NULL DEFAULT '0',
  `offre_link` varchar(255) NOT NULL,
  `offre_order` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`offre_id`),
  UNIQUE KEY `name_UNIQUE` (`offre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ginc_offres`
--

INSERT INTO `ginc_offres` (`offre_id`, `offre_name`, `offre_language`, `offre_publish_date`, `offre_start_publishing`, `offre_finish_publishing`, `offre_content`, `offre_statu`, `offre_link`, `offre_order`) VALUES
(2, 'ttttttttttzzzzzzzzzzzzzzztttttttt', 'english', '2011-11-21 23:01:00', '0', '0', 'yyyyyyyyyzzzzzzzzzzzzzyyyyyyyyyyyyyyyyyyyyy', 2, 'yyyyyzzzzzzzzzzzzzzzzzyyyyy', 4),
(3, '8888888888888', 'english', '2011-11-12 22:13:00', '0', '0', '888888888888888888888888888888', 2, '8888888888888888888', 88);

-- --------------------------------------------------------

--
-- Structure de la table `ginc_relasionships`
--

CREATE TABLE IF NOT EXISTS `ginc_relasionships` (
  `relation_object_id` bigint(20) unsigned NOT NULL,
  `relation_term_id` bigint(20) unsigned NOT NULL,
  `relation_parrent_id` bigint(20) NOT NULL DEFAULT '0',
  `relation_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ginc_relasionships`
--

INSERT INTO `ginc_relasionships` (`relation_object_id`, `relation_term_id`, `relation_parrent_id`, `relation_order`) VALUES
(8, 9, 0, NULL),
(13, 8, 0, NULL),
(17, 10, 0, NULL),
(18, 10, 0, NULL),
(18, 8, 0, NULL),
(18, 9, 0, NULL),
(19, 10, 0, NULL),
(19, 8, 0, NULL),
(11, 10, 0, NULL),
(11, 9, 0, NULL),
(21, 8, 0, NULL),
(21, 9, 0, NULL),
(22, 10, 0, NULL),
(22, 9, 0, NULL),
(9, 10, 0, NULL),
(9, 8, 0, NULL),
(9, 9, 0, NULL),
(10, 10, 0, NULL),
(10, 8, 0, NULL),
(10, 9, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ginc_sessions`
--

CREATE TABLE IF NOT EXISTS `ginc_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_ip` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `session_expir` int(10) unsigned DEFAULT NULL,
  `session_user_agent` text,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `token_UNIQUE` (`session_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `ginc_sessions`
--


-- --------------------------------------------------------

--
-- Structure de la table `ginc_sliders`
--

CREATE TABLE IF NOT EXISTS `ginc_sliders` (
  `slider_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slider_start_publishing` int(13) NOT NULL,
  `slider_finish_publishing` int(13) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_language` varchar(255) NOT NULL DEFAULT 'all',
  `slider_img` varchar(60) NOT NULL,
  `slider_content` varchar(300) DEFAULT NULL,
  `slider_link` varchar(255) NOT NULL,
  `slider_statu` int(1) NOT NULL DEFAULT '0' COMMENT 'Plublic privé supprimé bloqué (droper pas la xD)',
  `slider_order` int(2) unsigned DEFAULT NULL COMMENT 'Si perssone n''afiche plsu de 99 sliders :P',
  PRIMARY KEY (`slider_id`),
  UNIQUE KEY `title_UNIQUE` (`slider_title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ginc_sliders`
--

INSERT INTO `ginc_sliders` (`slider_id`, `slider_start_publishing`, `slider_finish_publishing`, `slider_title`, `slider_language`, `slider_img`, `slider_content`, `slider_link`, `slider_statu`, `slider_order`) VALUES
(1, 0, 0, 'rrrrrrrrrrrrrrrrrr', 'all', 'sssssssss', '', 'ssssssssssssssss', 2, 0),
(2, 0, 0, '4444444444444444', 'english', '44444444444444tttttttttt444444444444444444444', '4444444444444444', '444444444444444444', 2, 5),
(3, 0, 0, '111111111111111111', 'french', '1111111111111111111111', 'ttttttttttttttttttttttttttttttttt', '11111111111111111111', 2, 11);

-- --------------------------------------------------------

--
-- Structure de la table `ginc_terms`
--

CREATE TABLE IF NOT EXISTS `ginc_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_name` varchar(40) NOT NULL,
  `term_publish_date` datetime DEFAULT NULL,
  `term_start_publishing` varchar(11) DEFAULT NULL,
  `term_finish_publishing` varchar(11) DEFAULT NULL,
  `term_language` varchar(255) NOT NULL DEFAULT 'all',
  `term_slug` varchar(40) NOT NULL,
  `term_type` varchar(50) NOT NULL,
  `term_description` varchar(300) DEFAULT NULL,
  `term_statu` int(11) NOT NULL DEFAULT '0',
  `term_meta_description` text,
  `term_meta_keywords` text,
  `term_meta_robots` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `name_UNIQUE` (`term_name`),
  UNIQUE KEY `url_UNIQUE` (`term_slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `ginc_terms`
--

INSERT INTO `ginc_terms` (`term_id`, `term_name`, `term_publish_date`, `term_start_publishing`, `term_finish_publishing`, `term_language`, `term_slug`, `term_type`, `term_description`, `term_statu`, `term_meta_description`, `term_meta_keywords`, `term_meta_robots`) VALUES
(8, 'Ø¯Ø±ÙˆØ³ ÙÙŠ PHP', '2011-10-14 03:22:00', '0', '0', 'arabic', '-php', 'category', 'Ø¯Ø±ÙˆØ³ ÙÙŠ PHP', 2, 'Ø¯Ø±ÙˆØ³ ÙÙŠ PHP', 'Ø¯Ø±ÙˆØ³ ÙÙŠ PHP', 'nofollow,index'),
(9, 'Ø¯Ø±ÙˆØ³ ÙÙŠ Ruby', '2011-10-14 13:45:00', '0', '0', 'all', '-ruby', 'category', 'Ø¯Ø±ÙˆØ³ ÙÙŠ Ruby', 2, 'Ø¯Ø±ÙˆØ³ ÙÙŠ Ruby', 'Ø¯Ø±ÙˆØ³ ÙÙŠ Ruby', 'noindex,nofollow'),
(10, 'Ø¯ÙˆØ±Ø© Ø§Ù„Ø®ÙˆØ§Ø±Ø²Ù…ÙŠØ§Øª', '2011-11-08 22:52:00', '0', '0', 'all', 'algo', 'category', 'Ø¯ÙˆØ±Ø© Ø§Ù„Ø®ÙˆØ§Ø±Ø²Ù…ÙŠØ§Øª', 2, 'Ø¯ÙˆØ±Ø© Ø§Ù„Ø®ÙˆØ§Ø±Ø²Ù…ÙŠØ§Øª', 'Ø¯ÙˆØ±Ø© Ø§Ù„Ø®ÙˆØ§Ø±Ø²Ù…ÙŠØ§Øª', '');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_trashs`
--

CREATE TABLE IF NOT EXISTS `ginc_trashs` (
  `trash_id` int(19) NOT NULL AUTO_INCREMENT,
  `trash_object_id` int(19) NOT NULL,
  `trash_object_title` varchar(255) NOT NULL,
  `trash_object_table` varchar(50) NOT NULL,
  `trash_component` varchar(50) NOT NULL,
  `trash_date` datetime NOT NULL,
  PRIMARY KEY (`trash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Contenu de la table `ginc_trashs`
--

INSERT INTO `ginc_trashs` (`trash_id`, `trash_object_id`, `trash_object_title`, `trash_object_table`, `trash_component`, `trash_date`) VALUES
(35, 7, 'Article Title', 'contents', 'article', '2011-10-14 14:04:11'),
(38, 14, 'sssssssssssss', 'contents', 'article', '2011-11-09 00:46:15'),
(37, 8, 'Article Title', 'contents', 'article', '2011-10-14 17:41:56'),
(39, 15, 'sssssssssssss', 'contents', 'article', '2011-11-09 00:46:15'),
(40, 16, 'sssssssssssssss', 'contents', 'article', '2011-11-09 00:46:15'),
(41, 17, 'sssssssssssssss', 'contents', 'article', '2011-11-09 00:46:15'),
(42, 18, 'sssssssssssssss', 'contents', 'article', '2011-11-09 00:46:15'),
(43, 20, 'ttttttttttttttttttttttttt', 'contents', 'video', '2011-11-09 11:32:58'),
(44, 21, 'ttttttttttttttttttttttttt', 'contents', 'video', '2011-11-09 11:32:58'),
(45, 22, 'oooooooooooooooooooo', 'contents', 'video', '2011-11-09 11:33:46'),
(46, 23, 'sssssssssssssssssssssssss', 'links', 'links', '2011-11-09 11:34:19'),
(47, 4, 'fffffffffffffffffffffffffffffff', 'contacts', 'contactus', '2011-11-09 11:34:35');

-- --------------------------------------------------------

--
-- Structure de la table `ginc_users`
--

CREATE TABLE IF NOT EXISTS `ginc_users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_username` varchar(32) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_email` varchar(60) DEFAULT NULL,
  `user_statu` int(11) NOT NULL DEFAULT '0',
  `user_onligne` tinyint(1) NOT NULL DEFAULT '0',
  `user_registred` varchar(13) DEFAULT NULL,
  `user_birth_day` int(13) DEFAULT NULL,
  `user_last_signup` int(13) DEFAULT NULL,
  `user_oauth_token` varchar(32) DEFAULT NULL,
  `user_last_ip` varchar(50) DEFAULT NULL,
  `user_fristname` varchar(45) DEFAULT NULL,
  `user_lastname` varchar(45) DEFAULT NULL,
  `user_city` varchar(45) DEFAULT NULL,
  `user_contry` varchar(45) DEFAULT NULL,
  `user_zip_code` int(25) DEFAULT NULL,
  `user_address` text,
  `user_phone` bigint(20) DEFAULT NULL,
  `user_cellphone` bigint(20) DEFAULT NULL,
  `user_fax` bigint(20) DEFAULT NULL,
  `user_web_site` varchar(255) DEFAULT NULL,
  `user_avatar` varchar(255) DEFAULT NULL,
  `user_bio` varchar(45) DEFAULT NULL,
  `user_twitter` varchar(60) DEFAULT NULL,
  `user_facebook` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Les tables de l''utilisateur qu''on utilisera boucoup je ponce' AUTO_INCREMENT=4584 ;

--
-- Contenu de la table `ginc_users`
--

INSERT INTO `ginc_users` (`user_id`, `user_username`, `user_password`, `user_email`, `user_statu`, `user_onligne`, `user_registred`, `user_birth_day`, `user_last_signup`, `user_oauth_token`, `user_last_ip`, `user_fristname`, `user_lastname`, `user_city`, `user_contry`, `user_zip_code`, `user_address`, `user_phone`, `user_cellphone`, `user_fax`, `user_web_site`, `user_avatar`, `user_bio`, `user_twitter`, `user_facebook`) VALUES
(4582, 'root', '5e6efb9fb6a782180278df419565dada', 'imc0d3r@hotmail.com', 2, 0, '0', 0, 1321019019, NULL, '127.0.0.1', 'Ø¹Ø¨Ø¯Ø§Ù„Ø­Ù‚', 'ØºØ§Ø²ÙŠ', 'Ù…Ø±Ø§ÙƒØ´', 'Ø§Ù„Ù…ØºØ±Ø¨', 40000, 'Ø§Ù„Ù…Ø³ÙŠØ±Ø§ Ø§Ù„Ø£ÙˆÙ„Ù‰ Ù…Ø±Ø§ÙƒØ´', 696854515, 696854515, 696854515, 'http://remixcode.com/', 'avatar.png', 'Ù…ØµÙ…Ù… ÙˆÙ…Ø¨Ø±Ù…Ø¬ Ù…ÙˆØ§Ù‚Ø¹ Ù…Ù‡ØªÙ… Ø¨ï', 'http://twitter.com/4x0n', 'http://facebook.com/4x0n'),
(4583, 'rooy', 'sss', 'fffffff@fdfdqs.qsd', 1, 0, '0', 0, 0, NULL, '0.0.0.0', 'uuuuuuuuuuuuuu', 'uuuuuuuuuuuuuuuuuuuuu', 'uuuuuuuuuuuuuuuuuuuuu', 'uuuuuuuuuuuuuuuuuuuuuuuuu', 2147483647, 'kkkkkkkkkkkkk', 1111111111, 1111111111, 1111111111, 'http://google.com/Ginc_Project/', '', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkk', 'ffffffffffffffff', 'fffffffffffffffffffffffffffffffffff');
