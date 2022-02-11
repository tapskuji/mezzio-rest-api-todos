--
-- Table structure for table `todos`
--

DROP TABLE IF EXISTS `todos`;

CREATE TABLE `todos` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `title` varchar (100) NOT NULL,
                        `is_complete` tinyint(1) NOT NULL DEFAULT 0,
                        `created` DATETIME NOT NULL,
                        `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='list of todos';

--
-- Dumping data for table `todos`
--

LOCK TABLES `todos` WRITE;

INSERT INTO `todos`
    (`id`, `title`, `is_complete`, `created`)
VALUES
       (1,'Vanilla PHP TODO List',1,'2022-02-09 13:05:10'),
       (2,'Zend Expressive PHP TODO List',0,'2022-02-09 22:02:59'),
       (3,'Mezzio PHP TODO List',0,'2022-02-09 13:05:10');

UNLOCK TABLES;
