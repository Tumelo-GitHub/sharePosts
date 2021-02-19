# sharePosts
This is a share posts website built on PHP MVC. It has user authentication, and CRUD functionality. MVC is created (coded) from scratch.

TO SET UP THE PROJEC, FIRSTLY YOU NEED TO CREATE DATABASE TABLES FOR THE PROJECT, YOU CAN COPY THE SQL TO CREATE TABLES REQUIRED

CREATE DATABASE TABLE

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SECONDLY :

SETUP app/config.php FILE, AND FILL ALL REQUIRED INFO
