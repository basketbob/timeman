-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Структура таблицы `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id_event` int(10) NOT NULL AUTO_INCREMENT,
  `name_event` varchar(100) DEFAULT '0',
  `start_time` int(11) NOT NULL DEFAULT '0',
  `end_time` int(13) NOT NULL DEFAULT '0',
  `duration` int(11) NOT NULL,
  `bill_duration` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(10) DEFAULT '0',
  `id_project` int(10) DEFAULT '0',
  `id_upg` int(10) NOT NULL,
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Структура таблицы `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id_invoice` int(10) NOT NULL AUTO_INCREMENT,
  `create` int(11) NOT NULL,
  `payday` int(11) NOT NULL,
  `id_project` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_email` varchar(100) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_invoice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Структура таблицы `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id_project` int(10) NOT NULL AUTO_INCREMENT,
  `name_project` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name_user` varchar(100) NOT NULL,
  `department` varchar(255) NOT NULL,
  `timezone` tinyint(3) NOT NULL DEFAULT '0',
  `img` varchar(100) NOT NULL,
  `regdate` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `end_pay_day` datetime NOT NULL DEFAULT '2014-01-01 00:00:00',
  `spam` tinyint(1) NOT NULL DEFAULT '0',
  `confirm_code` varchar(16) NOT NULL,
  `confirm` varchar(20) NOT NULL DEFAULT '0',
  `active` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Индекс 2` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Users table' AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_project_group`
--

CREATE TABLE IF NOT EXISTS `user_project_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL DEFAULT '0',
  `id_project` int(10) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `cost` int(7) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`,`id_project`),
  UNIQUE KEY `id_user_2` (`id_user`,`id_project`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
