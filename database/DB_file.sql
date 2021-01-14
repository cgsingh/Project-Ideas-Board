-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 08, 2020 at 06:22 PM
-- Server version: 10.3.17-MariaDB-0+deb10u1
-- PHP Version: 7.3.9-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BTS_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `AdminName` varchar(64) COLLATE utf8_bin NOT NULL,
  `AdminPassword` varchar(256) COLLATE utf8_bin NOT NULL,
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ADMIN`
--

INSERT INTO `ADMIN` (`AdminName`, `AdminPassword`, `AdminID`) VALUES
('AdminChipemba', 'ChipembaPassword', 1),
('AdminMatt', 'MattPassword', 2),
('AdminChristopher', 'ChristopherPassword', 3),
('AdminJohann', 'JohannPassword', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ADMINPROJECTS`
--

CREATE TABLE `ADMINPROJECTS` (
  `ProjectID` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `Title` varchar(64) COLLATE utf8_bin NOT NULL,
  `Details` varchar(1024) COLLATE utf8_bin NOT NULL,
  `Tags` varchar(128) COLLATE utf8_bin NOT NULL,
  `DateCreated` date NOT NULL DEFAULT current_timestamp(),
  `Views` int(11) NOT NULL DEFAULT 0,
  `file` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ADMINPROJECTS`
--

INSERT INTO `ADMINPROJECTS` (`ProjectID`, `AdminID`, `Title`, `Details`, `Tags`, `DateCreated`, `Views`, `file`) VALUES
(2, 1, 'Trial ', 'This is looking like a long day . This is looking \r\nlike a long day .This is looking like a long day \r\n.This is looking like a long day .This is looking \r\nlike a long day .This is looking like a long day \r\n.This is looking like a long day .', 'Trying to create Projects', '2020-04-08', 0, 0),
(3, 1, 'Admin Project2', 'Admin project for users to request.', 'Test trial', '2020-04-08', 0, 0),
(4, 1, 'Delete Project', 'This project will be deleted soon.', 'Project to be deleted', '2020-04-08', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ADMINPROJ_REQUEST`
--

CREATE TABLE `ADMINPROJ_REQUEST` (
  `RequestID` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Message` varchar(1256) COLLATE utf8_bin NOT NULL,
  `DateRequested` date NOT NULL DEFAULT current_timestamp(),
  `AdminProjID` int(11) NOT NULL,
  `HasRead` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `COMMENTS`
--

CREATE TABLE `COMMENTS` (
  `CommentID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `ReplyID` int(11) DEFAULT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `Comment` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `CommentDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `COMMENTS`
--

INSERT INTO `COMMENTS` (`CommentID`, `ProjectID`, `ReplyID`, `StudentID`, `Comment`, `CommentDate`) VALUES
(1, 1, NULL, 8, 'Hey', '0000-00-00 00:00:00'),
(2, 1, 1, 9, 'Hi!', '0000-00-00 00:00:00'),
(3, 18, NULL, 7, 'TESTING 123', '0000-00-00 00:00:00'),
(4, 18, NULL, 7, 'Comments can be posted', '0000-00-00 00:00:00'),
(5, 18, NULL, 7, 'This is a test', '0000-00-00 00:00:00'),
(6, 18, NULL, 7, 'testing redirection', '0000-00-00 00:00:00'),
(7, 5, NULL, 7, 'My first project', '0000-00-00 00:00:00'),
(8, 5, NULL, 7, 'Comments are properly posted', '0000-00-00 00:00:00'),
(9, 5, NULL, 10, 'Wow', '0000-00-00 00:00:00'),
(10, 19, NULL, 10, 'another', '0000-00-00 00:00:00'),
(11, 19, NULL, 7, 'project', '0000-00-00 00:00:00'),
(12, 2, NULL, 8, 'hey', '2019-12-06 00:00:00'),
(13, 2, NULL, 8, 'hi\r\n', '2019-12-06 00:00:00'),
(14, 17, NULL, 7, 'Hello', '2019-12-06 00:00:00'),
(15, 2, NULL, 11, 'dfsfsdfdsf', '2019-12-06 00:00:00'),
(16, 2, NULL, 8, 'great project!', '2019-12-06 00:00:00'),
(17, 5, NULL, 7, 'Yeah...wow', '2019-12-10 00:00:00'),
(18, 41, NULL, 7, 'Hello', '2020-01-08 00:00:00'),
(19, 42, NULL, 7, 'Hello', '2020-01-08 00:00:00'),
(20, 4, NULL, 7, 'Fitness', '2020-01-08 00:00:00'),
(21, 1, NULL, 12, 'cool idea', '2020-01-08 00:00:00'),
(22, 46, NULL, 7, 'Hello', '2020-01-11 00:00:00'),
(23, 46, NULL, 7, 'I am testing to see if the group members will be accepted', '2020-01-11 00:00:00'),
(24, 46, NULL, 7, 'It works now', '2020-01-11 00:00:00'),
(25, 46, NULL, 9, 'Let me try', '2020-01-11 00:00:00'),
(26, 45, NULL, 5, 'test', '2020-01-11 00:00:00'),
(29, 2, 38, 12, 'comments should be ordered by newest now', '2020-01-11 21:22:06'),
(30, 2, NULL, 5, 'indeed it is', '2020-01-11 21:22:24'),
(31, 47, NULL, 5, 'Thanks everyone for showing your interest, unfortunately, I have everyone I need.', '2020-01-11 21:43:12'),
(32, 47, NULL, 7, 'If you change your mind, please consider contacting me. my contact info is on my profile page. I\'ve watched the star wars trilogy 20 times so I\'m highly qualified to be apart of this group.', '2020-01-11 21:47:37'),
(33, 46, NULL, 12, 'I did a validation check', '2020-01-12 00:41:01'),
(34, 50, NULL, 34, 'Nice project idea', '2020-01-26 06:04:26'),
(35, 2, NULL, 5, 'ghfdgdfghdfkjgdfkjghdfjghdfjkghffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffdgfgdfgdfgdfgfdgdfgdfgfgdfgdfgdfg dfgdfgdfg dfgdfg', '2020-02-18 23:36:57'),
(36, 2, 12, 5, 'Extremely long comment. long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. Extremely long comment. ', '2020-02-18 23:51:31'),
(37, 2, NULL, 5, 'comment', '2020-02-19 16:28:18'),
(38, 2, 12, 44, 'I\'m the Prime Minister of Canada.', '2020-02-19 23:50:26'),
(39, 2, NULL, 44, 'fsdfdgdgdsg', '2020-02-25 23:50:29'),
(40, 71, NULL, 44, 'This is my project idea.', '2020-03-04 17:23:00'),
(41, 71, NULL, 44, 'This is still my project idea.', '2020-03-04 17:23:12'),
(42, 52, NULL, 44, 'I like donuts.', '2020-03-04 17:24:24'),
(43, 2, NULL, 8, 'heyo', '2020-03-25 03:38:14'),
(44, 2, NULL, 8, 'oi', '2020-03-25 03:58:58'),
(45, 2, NULL, NULL, NULL, '2020-03-25 04:01:19'),
(46, 2, NULL, NULL, NULL, '2020-03-25 04:20:42'),
(47, 2, NULL, NULL, NULL, '2020-03-25 04:32:30'),
(48, 2, 47, 8, 'test reply 2', '2020-03-25 04:34:30'),
(49, 2, 29, NULL, NULL, '2020-03-25 05:06:16'),
(50, 2, 12, 8, 'does this notify me?', '2020-03-25 05:17:51'),
(51, 2, 37, 8, 'does this notify you?', '2020-03-25 05:18:09'),
(52, 2, 44, 8, 'will I get a notification?', '2020-03-25 05:26:08'),
(53, 2, 52, 8, 'how about now?', '2020-03-25 05:27:18'),
(54, 2, 44, 8, 'what about now?', '2020-03-25 05:29:26'),
(55, 2, 37, 8, 'can you see a notification?', '2020-03-25 05:50:27'),
(56, 2, 48, 5, 'gffdgdfg', '2020-03-25 06:01:00'),
(57, 2, 56, 44, 'tretertrt', '2020-03-25 06:02:31'),
(58, 2, 57, 5, 'rrrrr', '2020-03-25 06:04:50'),
(59, 2, 35, 44, 'jo9j999jojo', '2020-03-25 06:06:13'),
(60, 2, NULL, NULL, NULL, '2020-03-25 16:13:49'),
(61, 2, NULL, NULL, NULL, '2020-03-25 16:15:32'),
(62, 2, 53, 8, 'notify me!', '2020-03-25 16:16:34'),
(63, 2, 62, NULL, NULL, '2020-03-25 16:18:23'),
(64, 2, 63, 8, 'I haven\'t been notified yet :(', '2020-03-25 16:21:32'),
(65, 2, 64, 8, 'why', '2020-03-25 16:23:51'),
(66, 2, 37, 8, 'pls notfiy', '2020-03-25 16:27:20'),
(67, 2, 65, 8, 'I dunno why', '2020-03-25 16:35:42'),
(68, 2, NULL, 8, 'pls help', '2020-03-25 16:36:04'),
(69, 2, 48, NULL, NULL, '2020-03-25 16:44:41'),
(70, 71, NULL, 5, 'This project stinks!', '2020-04-05 22:17:42'),
(71, 2, 67, 8, 'can I be notified pls?', '2020-04-08 04:12:40'),
(72, 2, 71, 8, 'oi', '2020-04-08 04:18:03'),
(73, 2, 44, 8, 'oioi', '2020-04-08 04:28:11'),
(74, 2, 73, 8, 'this works', '2020-04-08 04:28:41'),
(75, 7, NULL, 8, 'do i get a notification?', '2020-04-08 04:52:37'),
(76, 2, NULL, 8, 'do you get a notification?', '2020-04-08 04:52:59'),
(77, 51, NULL, NULL, NULL, '2020-04-08 08:35:28'),
(82, 2, 44, 8, 'cool comment', '2020-04-08 17:59:12');

-- --------------------------------------------------------

--
-- Table structure for table `EMAILED_LINKS`
--

CREATE TABLE `EMAILED_LINKS` (
  `StudentID` int(11) DEFAULT NULL,
  `Expiry` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `ActivatedLink` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `EMAILED_LINKS`
--

INSERT INTO `EMAILED_LINKS` (`StudentID`, `Expiry`, `ActivatedLink`) VALUES
(23, '1579997613', 0),
(23, '1579999236', 1),
(23, '1580013101', 1),
(23, '1580013215', 1),
(34, '1580102825', 1),
(34, '1580104383', 1),
(34, '1580105172', 0),
(40, '1580405421', 1),
(40, '1580406613', 1);

-- --------------------------------------------------------

--
-- Table structure for table `FILES`
--

CREATE TABLE `FILES` (
  `FILE_ID` int(4) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `fileSaveName` varchar(64) COLLATE utf8_bin NOT NULL,
  `actSaveName` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `FILES`
--

INSERT INTO `FILES` (`FILE_ID`, `ProjectID`, `fileSaveName`, `actSaveName`) VALUES
(1, 65, '5e3af7c237ab0.jpg', 'socks.jpg'),
(2, 65, '5e3af7c237f73.pdf', 'UploadTest.pdf'),
(5, 68, '5e485a0879999.png', 'drawn.png'),
(7, 65, '5e4ce44457090.jpg', 'lib2.jpg'),
(11, 52, '5e4d76065d7d1.jpg', 'lib2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `FORUM_CATEGORIES`
--

CREATE TABLE `FORUM_CATEGORIES` (
  `ForumCategoryID` int(11) NOT NULL,
  `ForumCategory` varchar(256) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `FORUM_CATEGORIES`
--

INSERT INTO `FORUM_CATEGORIES` (`ForumCategoryID`, `ForumCategory`) VALUES
(1, 'General'),
(2, 'Questions'),
(3, 'Suggestions'),
(4, 'Critiques'),
(5, 'Settings'),
(6, 'Home Page'),
(7, 'Profile'),
(8, 'Projects'),
(9, 'Groups'),
(10, 'Group Requests'),
(11, 'Files'),
(12, 'Inbox');

-- --------------------------------------------------------

--
-- Table structure for table `FORUM_POSTS`
--

CREATE TABLE `FORUM_POSTS` (
  `ForumPostID` int(11) NOT NULL,
  `ForumParentPostID` int(11) DEFAULT NULL,
  `ForumTopicID` int(11) DEFAULT NULL,
  `ForumPost` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `ForumPostDate` datetime DEFAULT current_timestamp(),
  `StudentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `FORUM_POSTS`
--

INSERT INTO `FORUM_POSTS` (`ForumPostID`, `ForumParentPostID`, `ForumTopicID`, `ForumPost`, `ForumPostDate`, `StudentID`) VALUES
(1, 0, 1, 'Hello everyone my name is JProjectUser123', '2020-03-23 21:25:28', 34),
(2, 0, 1, 'I\'m creating another comment', '2020-03-23 21:38:42', 34),
(3, 0, 1, 'Now I will test the reply feature', '2020-03-25 00:09:33', 34),
(4, 0, 1, 'TESTING 123', '2020-03-25 01:00:52', 34),
(5, 0, 1, 'I will reply to this comment', '2020-03-25 01:05:41', 34),
(6, 0, 1, NULL, '2020-03-25 01:39:20', NULL),
(7, 0, 1, 'The reply feature works', '2020-03-25 01:59:01', 34),
(8, 0, 1, 'TESTING 789 10', '2020-03-25 01:59:15', 34),
(9, 0, 1, 'Hello JProjectUser 123! You have a similar username like me', '2020-03-25 02:00:18', 22),
(10, 0, 1, 'It works TESTING 123456789', '2020-03-25 02:00:40', 22),
(11, 0, 1, 'Thats Good', '2020-03-25 02:55:44', 22),
(12, 0, 1, ' Hello everyone, my name is JProjectUser', '2020-03-25 15:19:37', 22),
(13, 0, 5, 'Easy, just click on the request button in the project you want to join ', '2020-03-25 15:21:56', 34),
(14, 0, 5, 'Thanks for the reply', '2020-03-25 15:46:57', 22),
(15, 0, 8, ' hi', '2020-03-25 16:38:33', 8),
(16, 0, 8, 'hey', '2020-03-25 16:38:43', 8),
(17, 0, 8, ' oi', '2020-03-25 16:38:54', 8),
(18, 0, 1, ' Hello everyone', '2020-03-25 16:52:51', 34),
(19, 0, 1, 'hello', '2020-03-25 16:53:22', 34),
(20, 0, 10, ' this post is a big oof', '2020-04-08 04:43:56', 8),
(21, 0, 10, 'ya bud', '2020-04-08 04:44:04', 8),
(22, 0, 1, 'where does this comment go?', '2020-04-08 04:54:24', 8),
(23, 0, 1, 'uhh ok', '2020-04-08 04:54:40', 8),
(24, 23, 1, 'oi', '2020-04-08 05:51:28', 8),
(25, 24, 1, 'oioi', '2020-04-08 05:51:43', 8),
(26, 23, 1, 'oioioi', '2020-04-08 05:51:50', 8),
(27, 22, 1, 'no comments for u', '2020-04-08 05:54:58', 8),
(28, 23, 1, 'oi', '2020-04-08 05:55:10', 8),
(29, 28, 1, 'oof', '2020-04-08 05:55:26', 8),
(30, 28, 1, NULL, '2020-04-08 05:55:28', NULL),
(31, 27, 1, 'oof', '2020-04-08 05:55:41', 8),
(32, 27, 1, 'oof', '2020-04-08 05:56:10', 8),
(33, 27, 1, 'o', '2020-04-08 05:57:27', 8),
(34, 32, 1, 'ofofofoof', '2020-04-08 05:58:10', 8),
(35, 30, 1, 'big oof', '2020-04-08 05:59:22', 8),
(36, 23, 1, 'work pls', '2020-04-08 06:02:33', 8),
(37, 23, 1, 'work pls', '2020-04-08 06:02:51', 8),
(38, 23, 1, 'work pls', '2020-04-08 06:04:37', 8),
(39, 23, 1, 'oof', '2020-04-08 06:06:20', 8),
(40, 23, 1, 'oof', '2020-04-08 06:07:46', 8),
(41, 23, 1, 'biggest oof', '2020-04-08 06:08:36', 8),
(42, 23, 1, NULL, '2020-04-08 06:09:03', NULL),
(43, 42, 1, 'hey', '2020-04-08 06:15:21', 8),
(44, 0, 1, NULL, '2020-04-08 06:33:59', NULL),
(45, 0, 1, 'main comments now work :) ', '2020-04-08 06:34:47', 8),
(46, 7, 1, 'Now it works', '2020-04-08 08:42:40', 34),
(47, 46, 1, NULL, '2020-04-08 08:42:55', NULL),
(48, 45, 1, 'Thats Good', '2020-04-08 08:43:07', 34),
(54, 0, 10, NULL, '2020-04-08 11:41:09', NULL),
(55, 54, 10, NULL, '2020-04-08 11:41:15', NULL),
(56, 0, 10, ' oof', '2020-04-08 11:41:26', 7),
(57, 28, 1, 'hey', '2020-04-08 18:00:52', 8);

-- --------------------------------------------------------

--
-- Table structure for table `FORUM_TOPICS`
--

CREATE TABLE `FORUM_TOPICS` (
  `ForumTopicID` int(11) NOT NULL,
  `ForumTopicTitle` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `ForumTopicDescription` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
  `ForumTopicDate` datetime DEFAULT current_timestamp(),
  `ForumCategoryID` int(11) DEFAULT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `ActiveForumTopic` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `FORUM_TOPICS`
--

INSERT INTO `FORUM_TOPICS` (`ForumTopicID`, `ForumTopicTitle`, `ForumTopicDescription`, `ForumTopicDate`, `ForumCategoryID`, `StudentID`, `ActiveForumTopic`) VALUES
(1, 'Introduce Yourself', 'This topic is open for users to give a quick introduction.', '2020-03-22 23:39:25', 1, 34, 1),
(2, 'Number of Projects', 'What is the maximum number of projects a user can create?', '2020-03-22 23:46:21', 8, 34, 1),
(5, 'Group Requests', 'How are group requests made?', '2020-03-25 15:20:22', 10, 22, 1),
(8, 'cool stuff', 'only talk about stuff that is super cool', '2020-03-25 16:38:22', 1, 8, 1),
(10, 'oof', 'big oof', '2020-04-08 04:43:46', 1, 8, 1),
(12, 'Filters', 'Are there any filters in the home page?', '2020-04-08 11:25:20', 6, 34, 1);

-- --------------------------------------------------------

--
-- Table structure for table `GROUP`
--

CREATE TABLE `GROUP` (
  `GroupID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `GroupName` varchar(64) COLLATE utf8_bin NOT NULL,
  `StartDate` date NOT NULL DEFAULT current_timestamp(),
  `GroupCount` int(4) NOT NULL,
  `GroupLimit` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `GROUP`
--

INSERT INTO `GROUP` (`GroupID`, `ProjectID`, `GroupName`, `StartDate`, `GroupCount`, `GroupLimit`) VALUES
(1, 1, 'Front End Team', '2019-11-22', 0, 5),
(2, 2, 'Group 2', '2020-01-06', 0, 5),
(3, 3, 'Group 3', '2020-01-06', 0, 5),
(4, 4, 'Test Group', '2020-01-06', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `GROUP_LIST`
--

CREATE TABLE `GROUP_LIST` (
  `GroupID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `GroupName` varchar(64) COLLATE utf8_bin NOT NULL,
  `StartDate` date NOT NULL DEFAULT current_timestamp(),
  `GroupCount` int(4) NOT NULL,
  `GroupLimit` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `GROUP_LIST`
--

INSERT INTO `GROUP_LIST` (`GroupID`, `ProjectID`, `GroupName`, `StartDate`, `GroupCount`, `GroupLimit`) VALUES
(1, 41, 'Test Group 15', '2020-01-06', 0, 5),
(2, 42, 'Test to add group members', '2020-01-08', 0, 5),
(3, 43, 'new idea', '2020-01-08', 0, 5),
(4, 44, 'Test to add group members 2', '2020-01-10', 0, 5),
(5, 45, 'Test to show group member', '2020-01-11', 0, 5),
(6, 46, 'Test to show group member again', '2020-01-11', 0, 5),
(7, 47, 'Space Race: A Sci-Fi Novel', '2020-01-11', 0, 5),
(8, 48, 'Is there a Project', '2020-01-12', 0, 5),
(9, 49, 'Ontario Tourist Application', '2020-01-23', 0, 5),
(10, 50, 'My project', '2020-01-26', 0, 5),
(11, 51, 'All about me', '2020-01-26', 0, 5),
(12, 52, 'Donut', '2020-01-28', 0, 5),
(13, 53, 'Testing Upload', '2020-01-28', 0, 5),
(14, 54, 'Test Uploads', '2020-01-29', 0, 5),
(15, 55, 'Hello', '2020-01-29', 0, 5),
(16, 56, 'escape%20test', '2020-01-29', 0, 5),
(17, 57, 'escape%20test%202', '2020-01-29', 0, 5),
(18, 58, 'escape test 3', '2020-01-29', 0, 5),
(19, 59, 'Project J', '2020-01-29', 0, 5),
(20, 60, 'Jay Yahoo', '2020-01-29', 0, 5),
(21, 61, 'Chris\' Project', '2020-01-29', 0, 5),
(22, 62, 'Test File 2', '2020-01-29', 0, 5),
(23, 63, 'xss test', '2020-02-05', 0, 5),
(24, -1, 'hello', '2020-02-05', 0, 5),
(25, -1, 'hello&#33;', '2020-02-05', 0, 5),
(26, -1, 'hi', '2020-02-05', 0, 5),
(27, -1, 'hi', '2020-02-05', 0, 5),
(28, -1, 'hey', '2020-02-05', 0, 5),
(29, 64, 'hello', '2020-02-05', 0, 5),
(30, 65, 'New File System', '2020-02-05', 0, 5),
(32, 67, 'Testing Project Notifications 1', '2020-02-15', 0, 5),
(33, 68, 'Please Image Upload still work', '2020-02-15', 0, 5),
(34, 69, 'rtertert', '2020-02-15', 0, 5),
(35, 72, 'Monkey and the Turtle', '2020-04-08', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `GROUP_MEMBERS`
--

CREATE TABLE `GROUP_MEMBERS` (
  `GroupID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `JoinDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `GROUP_MEMBERS`
--

INSERT INTO `GROUP_MEMBERS` (`GroupID`, `StudentID`, `JoinDate`) VALUES
(1, 8, '2019-11-22'),
(6, 7, '2020-01-11'),
(6, 12, '2020-01-11'),
(6, 13, '2020-01-11'),
(7, 5, '2020-01-11'),
(7, 10, '2020-01-11'),
(7, 11, '2020-01-11'),
(8, 7, '2020-01-12'),
(7, 7, '2020-01-16'),
(9, 5, '2020-01-23'),
(10, 22, '2020-01-26'),
(10, 23, '2020-01-26'),
(11, 34, '2020-01-26'),
(12, 19, '2020-01-28'),
(13, 19, '2020-01-28'),
(14, 34, '2020-01-29'),
(15, 8, '2020-01-29'),
(16, 8, '2020-01-29'),
(17, 8, '2020-01-29'),
(18, 8, '2020-01-29'),
(19, 37, '2020-01-29'),
(20, 40, '2020-01-29'),
(21, 41, '2020-01-29'),
(22, 19, '2020-01-29'),
(23, 8, '2020-02-05'),
(24, 8, '2020-02-05'),
(24, 8, '2020-02-05'),
(24, 8, '2020-02-05'),
(24, 8, '2020-02-05'),
(24, 8, '2020-02-05'),
(29, 8, '2020-02-05'),
(30, 19, '2020-02-05'),
(32, 37, '2020-02-15'),
(33, 5, '2020-02-15'),
(34, 5, '2020-02-15'),
(35, 34, '2020-04-08'),
(37, 34, '2020-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `GROUP_REQUEST`
--

CREATE TABLE `GROUP_REQUEST` (
  `GroupID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `RequestDate` date NOT NULL,
  `RequestID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `INBOX`
--

CREATE TABLE `INBOX` (
  `StudentID` int(11) NOT NULL,
  `RecipientID` int(11) NOT NULL,
  `Title` varchar(64) COLLATE utf8_bin NOT NULL,
  `Body` varchar(1024) COLLATE utf8_bin NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `HasRead` int(1) NOT NULL DEFAULT 0,
  `MessageID` int(11) NOT NULL,
  `ParentMessageID` int(11) DEFAULT NULL,
  `ParentReplyID` int(11) DEFAULT NULL,
  `HasReplied` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `INBOX`
--

INSERT INTO `INBOX` (`StudentID`, `RecipientID`, `Title`, `Body`, `DateCreated`, `HasRead`, `MessageID`, `ParentMessageID`, `ParentReplyID`, `HasReplied`) VALUES
(44, -1, 't', 't', '2020-04-07 07:07:59', 1, 77, NULL, NULL, 0),
(5, 44, 'REPLY', 'hi', '2020-04-07 07:08:18', 1, 78, 77, NULL, 0),
(44, 5, 'REPLY', 'yo', '2020-04-07 07:08:34', 1, 79, 77, NULL, 0),
(5, 44, 'REPLY', 'sdfsdfsdf', '2020-04-07 07:08:46', 1, 80, 77, NULL, 0),
(44, 5, 'REPLY', 'dsfsdfsdfdsf', '2020-04-07 07:08:55', 1, 81, 77, NULL, 0),
(44, 5, 'REPLY', 'dsfsdfsdf', '2020-04-07 07:09:03', 1, 82, 77, NULL, 0),
(44, 5, 'REPLY', 'sdfsdfsdf', '2020-04-07 07:09:06', 1, 83, 77, NULL, 0),
(5, 44, 'REPLY', 'sdfdsfsdf', '2020-04-07 07:11:58', 1, 84, 77, NULL, 0),
(5, 44, 'REPLY', 'dfgdfgdfg', '2020-04-07 07:13:27', 1, 85, 77, NULL, 0),
(44, 5, 'REPLY', 'rrr', '2020-04-07 07:13:40', 1, 86, 77, NULL, 0),
(5, -1, 'dsfdsfs', 'dfdsfdsf', '2020-04-07 07:37:25', 0, 87, NULL, NULL, 0),
(5, -1, 'dsfdsfs', 'dfdsfdsf', '2020-04-07 07:37:28', 0, 88, NULL, NULL, 0),
(5, -1, 'dsfdsfs', 'dfdsfdsf', '2020-04-07 07:37:29', 0, 89, NULL, NULL, 0),
(5, -1, 'dsfdsfs', 'dfdsfdsf', '2020-04-07 07:38:53', 0, 90, NULL, NULL, 0),
(5, -1, 'dsfdsfs', 'dfdsfdsf', '2020-04-07 07:38:55', 1, 91, NULL, NULL, 0),
(5, -1, 'Tiotle', 'dfgdfgfgdfgdfg', '2020-04-08 17:49:27', 1, 92, NULL, NULL, 0),
(44, 5, 'REPLY', 'fdgdfgdfgdfgdfgfdgdfg', '2020-04-08 17:49:42', 1, 93, 92, NULL, 0),
(5, 44, 'REPLY', 'fgdfgdfgdfg', '2020-04-08 17:49:57', 1, 94, 92, NULL, 0),
(44, 5, 'REPLY', 'drfgdfgdfgd', '2020-04-08 17:51:36', 1, 95, 92, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `LOGIN_SESSIONS`
--

CREATE TABLE `LOGIN_SESSIONS` (
  `LoginKey` varchar(128) COLLATE utf8_bin NOT NULL,
  `ClientIP` varchar(64) COLLATE utf8_bin NOT NULL,
  `ID` int(11) NOT NULL,
  `DateCreated` date NOT NULL DEFAULT current_timestamp(),
  `DateExpires` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `LOGIN_SESSIONS`
--

INSERT INTO `LOGIN_SESSIONS` (`LoginKey`, `ClientIP`, `ID`, `DateCreated`, `DateExpires`) VALUES
('8xhoq7rehedz68vbpbomcej1agordyc5iwgw2yqma5', '24.239.4.222', 8, '2020-04-08', '2020-04-15'),
('isgy83jzc3fj1cbbstj6je5pm0dpylut9cm1ma6konwm', '99.228.128.181', 5, '2020-04-08', '2020-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `NOTIFICATIONS`
--

CREATE TABLE `NOTIFICATIONS` (
  `NotificationID` int(11) NOT NULL,
  `Notification` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `NotificationDate` datetime DEFAULT current_timestamp(),
  `NotificationRead` tinyint(1) DEFAULT 0,
  `ProjectID` int(11) DEFAULT NULL,
  `StudentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `NOTIFICATIONS`
--

INSERT INTO `NOTIFICATIONS` (`NotificationID`, `Notification`, `NotificationDate`, `NotificationRead`, `ProjectID`, `StudentID`) VALUES
(19, 'You have sent a request to join this group: Chris\'s Project 101', '2020-02-15 18:02:54', 1, 1, 10),
(22, 'The group leader has rejected your request to join this project: ', '2020-02-18 23:07:30', 0, 2, 12),
(31, 'You have sent a request to join this group: Testing Project Notifications 1', '2020-03-04 06:29:27', 1, 67, 34),
(32, 'You have a group request for this project: Testing Project Notifications 1', '2020-03-04 06:29:27', 1, 67, 37),
(33, 'You have rejected JProjectUser123 to join this project: Testing Project Notifications 1', '2020-03-04 06:30:14', 1, 67, 37),
(34, 'The group leader has rejected your request to join this project: Testing Project Notifications 1', '2020-03-04 06:30:14', 1, 67, 34),
(35, 'You have sent a request to join this group: Testing Project Notifications 1', '2020-03-04 06:43:50', 1, 67, 34),
(36, 'You have a group request for this project: Testing Project Notifications 1', '2020-03-04 06:43:50', 1, 67, 37),
(37, 'You have rejected JProjectUser123 to join this project: Testing Project Notifications 1', '2020-03-04 06:45:58', 1, 67, 37),
(38, 'The group leader has rejected your request to join this project: Testing Project Notifications 1', '2020-03-04 06:45:58', 1, 67, 34),
(40, 'The group leader has rejected your request to join this project: My project', '2020-03-25 02:56:28', 1, 50, 34),
(50, 'You have sent a request to join this group: All about me', '2020-03-31 02:41:32', 1, 51, 22),
(51, 'You have a group request for this project: All about me', '2020-03-31 02:41:32', 1, 51, 34),
(53, 'You have a group request for this project: All about me', '2020-03-31 02:42:33', 1, 51, 34),
(54, 'You have sent a request to join this group: All about me', '2020-03-31 02:43:19', 0, 51, 37),
(55, 'You have a group request for this project: All about me', '2020-03-31 02:43:19', 1, 51, 34),
(56, 'You have accepted JProjectUser to join this project: All about me', '2020-03-31 02:44:22', 1, 51, 34),
(57, 'You have been added to join this group: All about me', '2020-03-31 02:44:22', 0, 51, 22),
(58, 'You have accepted JohannAleman to join this project: All about me', '2020-03-31 02:44:28', 1, 51, 34),
(59, 'You have been added to join this group: All about me', '2020-03-31 02:44:28', 0, 51, 37),
(60, 'You have accepted JohannAleman to join this project: All about me', '2020-03-31 02:45:22', 1, 51, 34),
(61, 'You have been added to join this group: All about me', '2020-03-31 02:45:23', 0, 51, 37),
(62, 'You have accepted JProjectUser to join this project: All about me', '2020-03-31 02:50:33', 1, 51, 34),
(63, 'You have been added to join this group: All about me', '2020-03-31 02:50:33', 0, 51, 22),
(64, 'You have accepted JohannAleman to join this project: All about me', '2020-03-31 02:50:36', 1, 51, 34),
(65, 'You have been added to join this group: All about me', '2020-03-31 02:50:36', 0, 51, 37),
(66, 'You have sent a request to join this group: Prime Minister: The Simulation', '2020-04-05 22:22:56', 1, 70, 5),
(67, 'You have a group request for this project: Prime Minister: The Simulation', '2020-04-05 22:22:56', 0, 70, 44),
(68, 'You have sent a request to join this group: Wardrobe Randomizer', '2020-04-05 22:25:53', 1, 71, 5),
(69, 'You have a group request for this project: Wardrobe Randomizer', '2020-04-05 22:25:53', 0, 71, 44),
(73, 'A user has replied to your post!', '2020-04-08 04:52:59', 0, 2, 5),
(74, 'You have deleted JProjectUser from this group: All about me', '2020-04-08 08:33:37', 1, 51, 34),
(75, 'The group leader has deleted you from the group: All about me', '2020-04-08 08:33:37', 0, 51, 22),
(76, 'You have accepted JProjectUser to join this project: All about me', '2020-04-08 08:33:59', 1, 51, 34),
(77, 'You have been added to join this group: All about me', '2020-04-08 08:33:59', 0, 51, 22),
(78, 'You have rejected donut to join this project: All about me', '2020-04-08 08:34:10', 1, 51, 34),
(80, 'You have deleted JProjectUser from this group: All about me', '2020-04-08 08:34:35', 1, 51, 34),
(81, 'The group leader has deleted you from the group: All about me', '2020-04-08 08:34:35', 0, 51, 22),
(82, 'You have accepted JProjectUser to join this project: All about me', '2020-04-08 08:34:42', 1, 51, 34),
(83, 'You have been added to join this group: All about me', '2020-04-08 08:34:42', 0, 51, 22),
(84, 'A user has replied to your post!', '2020-04-08 08:35:28', 1, 51, 34),
(85, 'You have deleted JProjectUser from this group: All about me', '2020-04-08 08:39:31', 1, 51, 34),
(86, 'The group leader has deleted you from the group: All about me', '2020-04-08 08:39:31', 0, 51, 22),
(87, 'You have rejected JohannAleman to join this project: All about me', '2020-04-08 08:55:42', 1, 51, 34),
(88, 'The group leader has rejected your request to join this project: All about me', '2020-04-08 08:55:42', 0, 51, 37),
(89, 'You have rejected JProjectUser to join this project: All about me', '2020-04-08 08:55:43', 1, 51, 34),
(90, 'The group leader has rejected your request to join this project: All about me', '2020-04-08 08:55:43', 0, 51, 22),
(91, 'You have sent a request to join this group: Monkey and the Turtle', '2020-04-08 08:59:48', 1, 72, 19),
(92, 'You have a group request for this project: Monkey and the Turtle', '2020-04-08 08:59:48', 1, 72, 34),
(93, 'You have accepted donut to join this project: Monkey and the Turtle', '2020-04-08 09:00:15', 1, 72, 34),
(94, 'You have been added to join this group: Monkey and the Turtle', '2020-04-08 09:00:15', 1, 72, 19),
(95, 'You have deleted donut from this group: Monkey and the Turtle', '2020-04-08 09:10:06', 1, 72, 34),
(96, 'The group leader has deleted you from the group: Monkey and the Turtle', '2020-04-08 09:10:06', 1, 72, 19),
(97, 'You have sent a request to join this group: Monkey and the Turtle', '2020-04-08 09:12:03', 1, 72, 7),
(98, 'You have a group request for this project: Monkey and the Turtle', '2020-04-08 09:12:03', 1, 72, 34),
(99, 'You have accepted username123 to join this project: Monkey and the Turtle', '2020-04-08 09:12:27', 1, 72, 34),
(100, 'You have been added to join this group: Monkey and the Turtle', '2020-04-08 09:12:27', 1, 72, 7),
(101, 'You have deleted username123 from this group: Monkey and the Turtle', '2020-04-08 09:12:34', 1, 72, 34),
(102, 'The group leader has deleted you from the group: Monkey and the Turtle', '2020-04-08 09:12:34', 1, 72, 7),
(119, 'You have deleted JohannAleman from this group: All about me', '2020-04-08 17:52:50', 1, 51, 34),
(120, 'The group leader has deleted you from the group: All about me', '2020-04-08 17:52:50', 0, 51, 37),
(121, 'A user has replied to your comment!', '2020-04-08 17:59:12', 1, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `PROJECT`
--

CREATE TABLE `PROJECT` (
  `ProjectID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Title` varchar(64) COLLATE utf8_bin NOT NULL,
  `Details` varchar(1024) COLLATE utf8_bin NOT NULL,
  `Tags` varchar(128) COLLATE utf8_bin NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `Likes` int(11) NOT NULL DEFAULT 0,
  `Dislikes` int(11) NOT NULL DEFAULT 0,
  `Views` int(7) NOT NULL DEFAULT 0,
  `File` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `PROJECT`
--

INSERT INTO `PROJECT` (`ProjectID`, `StudentID`, `Title`, `Details`, `Tags`, `DateCreated`, `Likes`, `Dislikes`, `Views`, `File`) VALUES
(1, 5, 'Chris&#039;s Project 101', 'Lorem ipsum dolor sit amet, consectetur adipiscing \r\nelit, sed do eiusmod tempor incididunt ut labore \r\net dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut \r\naliquip ex ea commodo consequat. Duis aute irure \r\ndolor in reprehenderit in voluptate velit esse \r\ncillum dolore eu fugiat nulla pariatur. Excepteur \r\nsint occaecat cupidatat non proident, sunt in \r\nculpa qui officia deserunt mollit anim id est \r\nlaborum.', 'html,javascript,css', '2019-11-01 00:00:00', 37, 20, 30, 0),
(2, 5, 'Operation P', 'Lorem ipsum dolor sit amet, consectetur adipiscing \r\nelit, sed do eiusmod tempor incididunt ut labore \r\net dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut \r\naliquip ex ea commodo consequat. Duis aute irure \r\ndolor in reprehenderit in voluptate velit esse \r\ncillum dolore eu fugiat nulla pariatur. Excepteur \r\nsint occaecat cupidatat non proident, sunt in \r\nculpa qui officia deserunt mollit anim id est \r\nlaborum.', 'unity,c#,graphics,sfx', '2019-11-01 00:00:00', 52, 4, 107, 0),
(3, 6, 'Ontario Tourist Application', 'This mobile application will list all tourist \r\nattractions in the province of Ontario. Each \r\ntourist attraction will have a relevant image, \r\naddress, phone number (if available), website (if \r\navailable), and Google Map.\r\n\r\nI&#039;m looking for talented and experienced Android \r\nmobile developers. Please be 21 years of age or \r\nolder.', 'android,java,mobile', '2020-01-22 00:00:00', 3, 1, 5, 0),
(4, 7, 'Fitness Web Application', 'A fitness web application where the user can monitor \r\nworkout and food plans.  Testing 123456', 'HTML,CSS,JavaScript,PHP', '2020-01-22 00:00:00', 2, 1, 5, 0),
(5, 7, 'Fitness Web Application', 'This web application monitors the user&#039;s workout and food \r\nplans. ', 'HTML,CSS,JavaScript,PHP', '2019-11-11 00:00:00', 2, 1, 0, 0),
(6, 5, 'Chris projecjfjf', 'gndfhgkjdfhgkjdhgkdjfghkjfghkjfsghkjhgskjfghskjf', 'gdfgfdg', '2019-11-15 00:00:00', 0, 0, 1, 0),
(7, 8, 'test', 'test summary', 'test', '2019-11-15 00:00:00', 0, 0, 3, 0),
(8, 5, 'kshfkshkgjsdhfkjshd', 'ksdhfkjdhfkjsdhkjghsjgksh sgkjhsgkshdgkjs \r\nsdkghskjdhg', 'sdjkfskdjfhskdj', '2019-11-15 00:00:00', 0, 0, 1, 0),
(9, 8, 'helpmepls', 'I need help pls', 'PHP', '2019-11-15 00:00:00', 0, 0, 0, 0),
(11, 8, 'hey', '\r\n', 'hi', '2019-11-15 00:00:00', 0, 0, 0, 0),
(12, 5, 'skdjghsdkg', 'd', 'dsgsdg', '2019-11-15 00:00:00', 0, 1, 5, 0),
(13, 5, 'udshsdkjg', 'sdgsdgsd', 'sdgsd', '2019-11-15 00:00:00', 0, 0, 0, 0),
(14, 5, 'dsdf', 'dfs', 'dsfds', '2019-11-15 00:00:00', 0, 0, 0, 0),
(15, 5, 'gsdg', 'sdgsdg', 'dg', '2019-11-15 00:00:00', 0, 0, 2, 0),
(16, 8, 'Project', 'hey', 'C  ', '2019-11-15 00:00:00', 0, 0, 0, 0),
(17, 9, 'BTS530 Project', 'Project Idea Board', 'PHP, HTML', '2019-11-15 00:00:00', 13, 1, 4, 0),
(18, 7, 'War', 'Card game editted for testing', 'HTML,CSS,JavaScript,PHP', '2019-11-15 00:00:00', 0, 0, 1, 0),
(19, 10, 'Another Project', 'Another Project Test', 'HTML,CSS,JavaScript,PHP', '2019-12-05 00:00:00', 3, 1, 3, 0),
(20, 11, 'December 6 project', 'dsfsdf', 'fsd', '2019-12-06 00:00:00', 0, 0, 1, 0),
(21, 7, 'Group Project', 'For groups only', 'Groups', '2019-12-06 00:00:00', 0, 0, 1, 0),
(22, 11, 'jjjjjjjjjjjjjjsdghkjghsdkjhgkjsdhgjskdhgjdskhgjskd', 'jjjjjjjjjjjjjjsdghkjghsdkjhgkjsdhgjskdhgjdskhgjskd\r\nhgsjkdhgjskdhgjksdhgkjsdhgkjsdgjjjjjjjjjjjjjjsdghk\r\njghsdkjhgkjsdhgjskdhgjdskhgjskdhgsjkdhgjskdhgjksdh\r\ngkjsdhgkjsdgjjjjjjjjjjjjjjsdghkjghsdkjhgkjsdhgjskd\r\nhgjdskhgjskdhgsjkdhgjskdhgjksdhgkjsdhgkjsdgjjjjjjj\r\njjjjjjjsdghkjghsdkjhgkjsdhgjskdhgjdskhgjskdhgsjkdh\r\ngjskdhgjksdhgkjsdhgkjsdgjjjjjjjjjjjjjjsdghkjghsdkj\r\nhgkjsdhgjskdhgjdskhgjskdhgsjkdhgjskdhgjksdhgkjsdhg\r\nkjsdg', 'jjjjjjjjjjjjjjsdghkjghsdkjhgkjsdhgjskdhgjdskhgjskd', '2019-12-06 00:00:00', 2, 0, 5, 0),
(23, 7, 'Group Project 2', 'Group Project 2', 'Groups', '2019-12-06 00:00:00', 0, 0, 1, 0),
(24, 7, 'Group Project 3', 'Group testing project 3 testing 123', 'Groups', '2019-12-06 00:00:00', 1, 0, 0, 0),
(25, 7, 'Another Project 123', 'For a Project 123', 'Testing', '2019-12-06 00:00:00', 0, 0, 0, 0),
(26, 7, 'Test Group', 'Groups', 'Groups', '2020-01-06 00:00:00', 0, 0, 1, 0),
(27, 7, 'Test Group 2', 'Groups', 'Groups', '2020-01-06 00:00:00', 0, 0, 1, 0),
(28, 7, 'Test Group 3', 'This', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(29, 7, 'Test Group 4', 'Group Test', 'Groups', '2020-01-06 00:00:00', 0, 0, 1, 0),
(30, 7, 'Test Group 5', 'Group Test', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(31, 7, 'Test Group 6', 'Test Group 6', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(32, 7, 'Test Group 7', 'Group 7 test', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(33, 7, 'Test Group 8', 'Group Test', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(34, 7, 'Test Group 9', 'Groups', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(35, 7, 'Test Group 10', 'Groups Test 10', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(36, 7, 'Test Group 11', 'Groups', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(37, 7, 'Test Group 12', 'Test', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(38, 7, 'Test Group 13', 'Group Test', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(39, 7, 'Test Group 14', 'Group 14', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(40, 7, 'Test Group 14.1', 'Test', 'Groups', '2020-01-06 00:00:00', 0, 0, 0, 0),
(41, 7, 'Test Group 15', 'Group 15', 'Groups', '2020-01-06 00:00:00', 0, 0, 1, 0),
(42, 7, 'Test to add group members', 'This is a test to add group members', 'Testing for group', '2020-01-08 00:00:00', 1, 0, 2, 0),
(43, 12, 'new idea', 'cool new idea to work on\r\n', 'javascript', '2020-01-08 00:00:00', 8, 1, 4, 0),
(44, 13, 'Test to add group members 2', 'Test to add group members 2', 'Group', '2020-01-10 00:00:00', 0, 0, 2, 0),
(45, 7, 'Test to show group member', 'Show a group member', 'Group Member', '2020-01-11 00:00:00', 0, 0, 3, 0),
(46, 7, 'Test to show group member again', 'Show again', 'Again', '2020-01-11 00:00:00', 1, 0, 11, 0),
(47, 5, 'Space Race: A Sci-Fi Novel', 'Space Race will be an original, science fiction \r\nnovel set in the Milky Way galaxy. I&#039;m looking for \r\npeople with knowledge of astronomy and those who \r\npossess good writing skills. We can negotiate \r\npayment.\r\n\r\nPlease make sure your profile is properly filled \r\nin. This is how I&#039;ll be making my selection.', 'english,writing,illustration,artist,art,sci-fi', '2020-01-22 04:34:00', 2, 0, 12, 0),
(48, 7, 'Is there a Project', 'Is it added when I press cancel. Yes there is time to fix it', 'Project', '2020-01-12 04:17:02', 0, 0, 7, 0),
(49, 5, 'Ontario Tourist Application', 'This mobile application will list all tourist \r\nattractions in the province of Ontario. Each \r\ntourist attraction will have a relevant image, \r\naddress, phone number (if available), website (if \r\navailable), and Google Map. I&#039;m looking for \r\ntalented and experienced Android mobile \r\ndevelopers. Please be 21 years of age or older.', 'android,java,mobile', '2020-01-23 06:32:12', 0, 0, 1, 0),
(50, 22, 'My project', 'This is my project', 'HTML,CSS,JavaScript,PHP', '2020-01-26 01:48:05', 0, 0, 5, 0),
(51, 34, 'All about me', 'This project is all about me', 'HTML,CSS,JavaScript,PHP', '2020-01-26 18:32:20', 0, 0, 10, 0),
(52, 19, 'Donut', 'Trying to add pics in', 'Donut trial', '2020-01-28 02:54:16', 1, 0, 13, 1),
(53, 19, 'Testing Upload', 'Testing', 'Upload', '2020-01-28 22:52:35', 0, 0, 5, 0),
(54, 34, 'Test Uploads', 'I am testing the upload function.', 'Test upload', '2020-01-29 01:25:58', 0, 0, 3, 0),
(55, 8, 'Hello', 'heyo', 'Hi', '2020-01-29 05:43:20', 0, 0, 2, 0),
(56, 8, 'escape test', '!$@!#', '?!@#', '2020-01-29 05:46:01', 0, 0, 1, 0),
(57, 8, 'escape test 2', '&amp;quot;&#039;:sdoufhg', '  k', '2020-01-29 05:47:14', 0, 0, 2, 0),
(58, 8, 'escape test 3', 'does this break everything?!&amp;gt;.&amp;gt;@', ';.&#039;./&#039;],[!$&amp;amp;^(@!', '2020-01-29 05:54:24', 0, 0, 3, 0),
(59, 37, 'Project J', 'This is project J', 'HTML,CSS,JavaScript,PHP', '2020-01-29 17:02:44', 0, 0, 4, 0),
(60, 40, 'Jay Yahoo', 'Yahoo', 'Yahoo', '2020-01-29 17:31:13', 0, 0, 2, 0),
(61, 41, 'Chris&#039; Project', 'This project will be developed using C++.', 'c++', '2020-01-29 17:35:48', 0, 0, 1, 0),
(62, 19, 'Test File 2', 'Files', 'Image', '2020-01-29 17:58:44', 0, 0, 8, 0),
(63, 8, 'xss test', '&amp;lt;strong onClick=&amp;quot;alert();&amp;quot;&amp;gt;hello?!?&amp;lt;/strong&amp;gt;', 'xss', '2020-02-05 16:00:22', 0, 0, 4, 0),
(65, 19, 'New File System', 'New', 'New File Sys', '2020-02-05 17:13:38', 0, 0, 3, 1),
(67, 37, 'Testing Project Notifications 1', 'Test Project Notifications 1', 'Test', '2020-02-15 04:56:42', 0, 0, 8, 0),
(68, 5, 'Please Image Upload still work', 'what', 'dfgdfgfdg', '2020-02-15 20:52:24', 0, 0, 7, 0),
(69, 5, 'rtertert', 'tertertertertert', 'rtertere', '2020-02-15 22:31:34', 0, 0, 5, 0),
(70, 44, 'Prime Minister: The Simulation', 'I\'m looking for talented software and video-game developer students to help me create a 3D simulator that allows the player to take on the role of me, Justin Trudeau, the 23rd Prime Minister of Canada. Payment will be discussed if you are selected.', 'government,unreal engine,3d,taxes', '2020-02-19 06:19:24', 0, 0, 6, 0),
(71, 44, 'Wardrobe Randomizer', 'I\'m looking for talented software developers to help me create a program that randomizes my clothing for the day. I should be able to input my entire wardrobe and modify it whenever I want.', 'clothes,clothes,more,clothes', '2020-02-19 07:19:24', 1, 0, 12, 0),
(72, 34, 'Monkey and the Turtle', 'This project is about a monkey and a turtle', 'monkey, turtle', '2020-04-08 06:47:43', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `PROJECT_VOTES`
--

CREATE TABLE `PROJECT_VOTES` (
  `ProjectID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `LikeDislike` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `PROJECT_VOTES`
--

INSERT INTO `PROJECT_VOTES` (`ProjectID`, `StudentID`, `LikeDislike`) VALUES
(2, 5, 1),
(47, 5, 1),
(47, 10, 1),
(2, 21, 1),
(61, 41, 0),
(1, 41, 1),
(71, 44, 1),
(2, 44, 1),
(52, 44, 1),
(2, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `REQUESTS`
--

CREATE TABLE `REQUESTS` (
  `REQUESTID` int(11) NOT NULL,
  `USERID` int(11) DEFAULT NULL,
  `PROJECTID` int(11) DEFAULT NULL,
  `REQUESTDATE` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `REQUESTS`
--

INSERT INTO `REQUESTS` (`REQUESTID`, `USERID`, `PROJECTID`, `REQUESTDATE`) VALUES
(1, 13, 42, NULL),
(2, 12, 42, NULL),
(6, 10, 2, NULL),
(12, 10, 3, '2020-01-23 06:33:06'),
(13, 7, 3, '2020-01-23 06:35:32'),
(14, 8, 3, '2020-01-23 06:36:03'),
(15, 22, 3, '2020-01-23 06:37:09'),
(23, 10, 1, '2020-02-15 18:02:54'),
(31, 5, 70, '2020-04-05 22:22:56'),
(32, 5, 71, '2020-04-05 22:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `STUDENT`
--

CREATE TABLE `STUDENT` (
  `StudentID` int(11) NOT NULL,
  `FirstName` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `LastName` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `Phone` varchar(24) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `Address` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `City` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `Province` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `Country` varchar(24) COLLATE utf8_bin NOT NULL DEFAULT 'N/A',
  `PostalCode` varchar(6) COLLATE utf8_bin DEFAULT 'N/A',
  `Biography` varchar(1500) COLLATE utf8_bin NOT NULL DEFAULT 'Write a biography and introduce yourself to the community.',
  `ProfilePic` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT 'default_avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `STUDENT`
--

INSERT INTO `STUDENT` (`StudentID`, `FirstName`, `LastName`, `Phone`, `Address`, `City`, `Province`, `Country`, `PostalCode`, `Biography`, `ProfilePic`) VALUES
(5, 'Christopher', 'Singh', '111-111-1111', '111 Street', 'Toronto', 'Ontario', 'Canada', 'A1B2C3', 'My name is Chris. I like coding.', 'original.png'),
(6, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(7, 'User', 'Last', '555-555-5555', 'Address Entered Here', 'City', 'Province Entered here', 'Country Entered Here', 'H0H0H0', 'This biography has been editted', 'default_avatar.png'),
(8, 'Matthew', 'Rajevski', '123-234-3456', '123 Street', 'Toronto', 'ON', 'CA', '1o1o1o', 'Matt&#039;s Biography', 'default_avatar.png'),
(9, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(10, 'Another', 'Username', '123-456-7890', 'Another Address', 'Another City', 'Another Province', 'This Country', 'A0A0A0', 'Another biography tested for edit', 'default_avatar.png'),
(11, 'N/A', 'N/A', '905-101-1010', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'bla bla blabla bla blabla bla blabla bla blabla bla blabla bla blabla bla blabla bla blabla bla blabla bla blabla bla blabla bla bla', 'default_avatar.png'),
(12, 'Test', 'Uno', '555-555-5555', 'Test', 'Test City', 'Test Province', 'Country', 'H0H0H0', 'Testing edit function', 'default_avatar.png'),
(13, 'Username', 'Lastname', '555-555-5555', '123', 'City', 'Province', 'Country', 'H0H0H0', 'My name is Username456. Nice to meet all of you.', 'default_avatar.png'),
(14, 'N/A', 'N/A', '555-555-5555', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(15, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(16, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(17, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(18, 'Test', 'Six', '666-666-6667', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'This time for sure.', 'default_avatar.png'),
(19, 'Donut', 'Pastry', '123-456-7890', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Test cancel button', 'screen-4.jpg'),
(20, 'Cupcake', 'Pastry', '123-456-7899', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'At least the user can automatically insert profile information. Cancel Button Registration does not work yet.', 'default_avatar.png'),
(21, 'firstname', 'lastname', '111-111-1111', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'no', 'default_avatar.png'),
(22, 'Jay', 'Chris', '555-555-5555', 'Address', 'City', 'Province', 'Country', 'H0H0H0', 'I have tested the email verification function', 'default_avatar.png'),
(23, 'Jay', 'Gamer', '555-555-5555', 'Address', 'City', 'Province', 'Country', 'F5F5F5', 'Tested the email verification again with Unlock account.', 'default_avatar.png'),
(24, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(25, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(26, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(27, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(28, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(29, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(30, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(31, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(32, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(33, 'Johann', 'Aleman', '555-555-5555', 'Address', 'City', 'Province', 'Country', 'H0H0H0', 'I am thou... Thou art I...', 'default_avatar.png'),
(34, 'Jay', 'Christopher', '555-555-5555', 'Address', 'City', 'Province', 'Country', 'H0H0H0', 'Testing profile creation', 'default_avatar.png'),
(35, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(36, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(37, 'Johann', 'Aleman', '555-555-5555', 'Address', 'City', 'Province', 'Country', 'H0H0H0', 'Hello Everyone, this is a test', 'default_avatar.png'),
(38, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(39, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(40, 'JC', 'Aleman', '555-555-5555', 'Address', 'City', 'Province', 'Country', 'H0H0H0', 'Write a biography.', 'default_avatar.png'),
(41, 'Christopher', 'Singh', '111-111-1111', '123 Number Street', 'Toronto', 'Ontario', 'Canada', 'L1L1L1', 'jdfghdkjfghfdkjghfdkjghdfgjdhfgkjdhfgdfg.\r\n\r\ndfgdfgfgfg.', 'default_avatar.png'),
(42, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(43, 'Matt', 'Rajevski', '123-123-1231', '123 street', 'toronto', 'on', 'CA', '1O1O1O', 'nah', 'default_avatar.png'),
(44, 'Justin', 'Trudeau', '613-941-6900', '80 Wellington Street', 'Ottawa', 'Ontario', 'Canada', 'K1A0A2', 'Father, husband, 23rd Prime Minister of Canada. Account run by PM & staff.\r\nPapa, mari, 23e premier ministre du Canada. Compte géré par le PM et son personnel.', 'pmprofilepic.png'),
(45, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png'),
(46, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'Write a biography and introduce yourself to the community.', 'default_avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `Username` varchar(64) COLLATE utf8_bin NOT NULL,
  `Password` varchar(256) COLLATE utf8_bin NOT NULL,
  `Email` varchar(64) COLLATE utf8_bin NOT NULL,
  `AccountStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`ID`, `StudentID`, `Username`, `Password`, `Email`, `AccountStatus`) VALUES
(2, 5, 'chris.singh', '$2y$10$Yfx37Ac9SgTp7pLtxYm1g.RSkd5OAXIc7kStec4Jx6H3W5giuhxiS', 'cgsingh@myseneca.ca', 1),
(3, 6, 'johann111', '$2y$10$7EZd/JhRdFqh1RN1U6jQZ.ILEEag1rwYaGFCol8l/qSEOGW7pfdGi', 'johann@johann.ca', 1),
(4, 7, 'username123', '$2y$10$oAEhL2DYxXmheJzdjZIiyOvfevKR2R.gNfpv0WeL6MRXOTblHgnRW', 'username@email.com', 1),
(5, 8, 'matt', '$2y$10$gUdVcw93ZfYcROSgvmmyl.dofJEiwFDtCvBYwSc7OwOr2UfhlYYU6', '', 1),
(6, 9, 'test', '$2y$10$iXQOcmeojLF16dSewO2JTOfnAn/aVFRAt1xKks9sh7QPXRU20VZPu', 'test@test.ca', 1),
(7, 10, 'another', '$2y$10$GLz16PxQiB9x4Fxnx0xhcOIoUW4/eV1pABzLDfcyJJtiEkct2c6Fy', 'another@email.com', 1),
(8, 11, 'chris123', '$2y$10$D.jqmWUHl5Wef8eB6OOouezQP00D9W8i3JuSqJOx4CQ6/u.ZW38mi', 'isdiofusodif@hotmail.com', 1),
(9, 12, 'test1', '$2y$10$qRdsubb9XSkmEvSfUNnTrupkiE3O1CMHT.IZe8/ozjIgA0OVeHUIe', 'test@email.com', 1),
(10, 13, 'username456', '$2y$10$ARTkqi3G0OHKmYCrLTZuc.ce1OryTnjfM5Gq09iFpOevJ0XMd4kwm', 'username456@email.com', 1),
(11, 14, 'test2', '$2y$10$rVHSCl/E/gRTrE4bbY8oQ..0LegSAZW0L6bNSpbVIUSNwGIwRwuZC', 'test2@test2.ca', 1),
(12, 15, 'test3', '$2y$10$TDR3fJVRH/0eMqStNEpfpun59xQpOFmPuyBoJVnOqKaf/6LYCeAQ.', 'test3@test.ca', 1),
(13, 16, 'test4', '$2y$10$KXwk/cmCrpdrjRxUlYmeeO0LyXgd9rE2o7VpZBOL4H4A5LsTDjdPm', 'test4@test.ca', 1),
(14, 17, 'test5', '$2y$10$oJD5a2Fc1on/vdoH7NL46OFGc3SSsX3QTYQg1L/LeqfQBDvbADd76', 'test5@test.ca', 1),
(15, 18, 'test6', '$2y$10$Kllrt8GAQzmkpw.beUafkeGlo4BzFwZdwuWMbv0hJQPpKTmoACc3u', 'test6@test.ca', 1),
(16, 19, 'donut', '$2y$10$0px5cBo8URgYCxHwYn1cCORoFOOwDP7uAS4PxdzDX.FmJdWzjkOVu', 'cbwacha@myseneca.ca', 1),
(17, 20, 'cupcake', '$2y$10$tOpM0JqjoZyxQIGG97b4pePE7reNgRxg.bObBmIW83g4gCb/ZQu8W', 'cupcake@pastry.com', 1),
(18, 21, 'bla123', '$2y$10$mQMhaMejgpf1XtGyl4/WOOT2JgfOlXea00Oc2rGH/Kh2/H8iQkItS', '123@123.com', 1),
(19, 22, 'JProjectUser', '$2y$10$D8V0ubUj313xabM6xbIiZutYTKKHyL35bY/DTJrPajlbxXTqw2hrG', 'user@email.com', 1),
(20, 23, 'AProjectUser', '$2y$10$do64I5dZECu8wOeht9DeP..zSxpc8JRezuV2PPzeShPgaOGNfsrjq', 'fake@email.com', 1),
(21, 33, 'JProjectUser2', '$2y$10$vOYANWq8PLXIESKh0nred.HXItZ20fVFZJUM.lgFON/2v9a0Nqxue', 'jprojectuser@gmail.com', 1),
(22, 34, 'JProjectUser123', '$2y$10$6ZULh1XjaEDR55F.8ownHOi1HawSRKqjIvnkAqdmKyg0T5cEIF2Ii', 'j_project_user@hotmail.com', 1),
(23, 35, 'Matt2', '$2y$10$YYgrzjiHYhc29QwdY7kwM.M5V7HHITdP8yDi/5Qf9C8wbseCOMshK', 'mrrajevski@myseneca.ca', 1),
(24, 36, 'testing123', '$2y$10$EDnpXf1fzo2CPYBg5TZzM.6hh2S7bulQfyFlxfYMyKpTTmw82p0tu', 'testing123@testing123.ca', 1),
(25, 37, 'JohannAleman', '$2y$10$TufjeCQ7eAdDiseHehHJM.q74VQENjXa67pGV.6D6E6cNatV4NSp2', 'johanncoolman@hotmail.com', 1),
(26, 38, 'JCAleman', '$2y$10$p5AdBrDJkF8YretKIVYSneNyE5Zb2vtTk3ggYjUt3i4na8mBLfomq', 'johann_aleman@outlook.com', 1),
(27, 39, 'johann.aleman', '$2y$10$FOHiGpCGn0bHXZ5yOF/xruHoXJNcguRi4oUhv3aBI9NNNJkdkeECu', 'jcaleman@myseneca.ca', 1),
(28, 40, 'JYahoo', '$2y$10$A6pLbXwU6qAFl4BGYJIpoeiCMpjhazlAE0STrUfk0E/7EpqVSBg/W', 'jprojectuser@yahoo.com', 1),
(29, 41, 'cgsingh1995', '$2y$10$xnNhkVAptt.nWR25E/8/.O3XBPtQkyg8M5hr2McnPdvg6756uAy92', 'cgsingh1995@outlook.com', 1),
(30, 42, 'christopher.singh', '$2y$10$THXRUWQlXgIYPNhpq2B0seTSPsG5bWmfNg8ZMLGkeD6r4qEsT/u1q', 'chrishellovart95@gmail.com', 1),
(31, 43, 'MattR', '$2y$10$scc6EinhCk9BfCodVCHBauJzip1w9YT.na988xFGl1powd0rPTWGS', 'matt.rajevski@gmail.com', 1),
(32, 44, 'thepm', '$2y$10$X9C9EHtINtzJgrntRIVAB.VaReKy4KKcT28CMTkHh9b/fiLHc5P22', 'justin_trudeau@goverment.ca', 1),
(33, 45, 'cbwacha', '$2y$10$XeLlYQe612OGONE0YRFT/e8eJJVHbTKw8zy6GCeFslqItXaF34U5m', 'chipbwa@gmail.com', 1),
(34, 46, 'chipemba', '$2y$10$ifjFUMC6wvd6ieNWwazwfuesXZwhH10xzKYPmzilFJJVIBKbwmqte', 'chipemba15@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `ADMINPROJECTS`
--
ALTER TABLE `ADMINPROJECTS`
  ADD PRIMARY KEY (`ProjectID`);

--
-- Indexes for table `ADMINPROJ_REQUEST`
--
ALTER TABLE `ADMINPROJ_REQUEST`
  ADD PRIMARY KEY (`RequestID`);

--
-- Indexes for table `COMMENTS`
--
ALTER TABLE `COMMENTS`
  ADD PRIMARY KEY (`CommentID`);

--
-- Indexes for table `FILES`
--
ALTER TABLE `FILES`
  ADD PRIMARY KEY (`FILE_ID`),
  ADD KEY `ProjectID` (`ProjectID`);

--
-- Indexes for table `FORUM_CATEGORIES`
--
ALTER TABLE `FORUM_CATEGORIES`
  ADD PRIMARY KEY (`ForumCategoryID`);

--
-- Indexes for table `FORUM_POSTS`
--
ALTER TABLE `FORUM_POSTS`
  ADD PRIMARY KEY (`ForumPostID`);

--
-- Indexes for table `FORUM_TOPICS`
--
ALTER TABLE `FORUM_TOPICS`
  ADD PRIMARY KEY (`ForumTopicID`);

--
-- Indexes for table `GROUP`
--
ALTER TABLE `GROUP`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `GROUP_LIST`
--
ALTER TABLE `GROUP_LIST`
  ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `GROUP_REQUEST`
--
ALTER TABLE `GROUP_REQUEST`
  ADD PRIMARY KEY (`RequestID`);

--
-- Indexes for table `INBOX`
--
ALTER TABLE `INBOX`
  ADD PRIMARY KEY (`MessageID`);

--
-- Indexes for table `LOGIN_SESSIONS`
--
ALTER TABLE `LOGIN_SESSIONS`
  ADD UNIQUE KEY `LoginKey` (`LoginKey`);

--
-- Indexes for table `NOTIFICATIONS`
--
ALTER TABLE `NOTIFICATIONS`
  ADD PRIMARY KEY (`NotificationID`);

--
-- Indexes for table `PROJECT`
--
ALTER TABLE `PROJECT`
  ADD PRIMARY KEY (`ProjectID`);

--
-- Indexes for table `REQUESTS`
--
ALTER TABLE `REQUESTS`
  ADD PRIMARY KEY (`REQUESTID`);

--
-- Indexes for table `STUDENT`
--
ALTER TABLE `STUDENT`
  ADD PRIMARY KEY (`StudentID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`Username`),
  ADD UNIQUE KEY `StudentID` (`StudentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ADMIN`
--
ALTER TABLE `ADMIN`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ADMINPROJECTS`
--
ALTER TABLE `ADMINPROJECTS`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ADMINPROJ_REQUEST`
--
ALTER TABLE `ADMINPROJ_REQUEST`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `COMMENTS`
--
ALTER TABLE `COMMENTS`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `FILES`
--
ALTER TABLE `FILES`
  MODIFY `FILE_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `FORUM_POSTS`
--
ALTER TABLE `FORUM_POSTS`
  MODIFY `ForumPostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `FORUM_TOPICS`
--
ALTER TABLE `FORUM_TOPICS`
  MODIFY `ForumTopicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `GROUP`
--
ALTER TABLE `GROUP`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `GROUP_LIST`
--
ALTER TABLE `GROUP_LIST`
  MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `GROUP_REQUEST`
--
ALTER TABLE `GROUP_REQUEST`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `INBOX`
--
ALTER TABLE `INBOX`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `NOTIFICATIONS`
--
ALTER TABLE `NOTIFICATIONS`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT for table `PROJECT`
--
ALTER TABLE `PROJECT`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `REQUESTS`
--
ALTER TABLE `REQUESTS`
  MODIFY `REQUESTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `STUDENT`
--
ALTER TABLE `STUDENT`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `USER`
--
ALTER TABLE `USER`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `FILES`
--
ALTER TABLE `FILES`
  ADD CONSTRAINT `FILES_ibfk_1` FOREIGN KEY (`ProjectID`) REFERENCES `PROJECT` (`ProjectID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
