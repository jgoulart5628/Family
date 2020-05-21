DROP TABLE IF EXISTS chat;
CREATE TABLE IF NOT EXISTS chat (
  id bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `text` varchar(255) COLLATE utf8_bin NOT NULL,
  ip varchar(255) COLLATE utf8_bin NOT NULL,
  color varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;