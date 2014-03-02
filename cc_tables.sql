CREATE TABLE forum_tree (
  materialized_path varchar(225) NOT NULL,
  node_id int(11) unsigned NOT NULL,
  node_type varchar(10) DEFAULT NULL,
  PRIMARY KEY(node_id)
);

CREATE TABLE forum_tree_meta (
  meta_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(50) DEFAULT NULL,
  description varchar(225) DEFAULT NULL,
  url_title varchar(50) DEFAULT NULL,
  permission_flag int(5) unsigned DEFAULT NULL,
  permission_id int(11) unsigned DEFAULT NULL,
  restrict_child_type varchar(10) DEFAULT NULL,
  PRIMARY KEY(meta_id)
);

CREATE TABLE general (
  id tinyint(2) unsigned DEFAULT '1',
  title varchar(50) DEFAULT NULL,
  locked tinyint(2) unsigned DEFAULT '0',
  language varchar(50) DEFAULT NULL,
  template varchar(50) DEFAULT NULL,
  version varchar(11) DEFAULT NULL
);

CREATE TABLE groups (
  group_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(50) DEFAULT NULL,
  PRIMARY KEY(group_id)
);

CREATE TABLE members (
  member_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  group_id int(10) unsigned DEFAULT '0',
  username varchar(20) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  password varchar(60) DEFAULT NULL,
  join_date int(10) unsigned DEFAULT '0',
  banned tinyint(1) unsigned DEFAULT '0',
  post_count int(11) DEFAULT '0',
  rem_data text,
  PRIMARY KEY(member_id)
);

CREATE TABLE permissions (
  permission_id int(11) DEFAULT NULL,
  type int(5) DEFAULT NULL,
  data int(11) DEFAULT NULL
);

CREATE TABLE cc_sessions (
  session_id varchar(40) NOT NULL DEFAULT '0',
  ip_address varchar(16) NOT NULL DEFAULT '0',
  user_agent varchar(50) NOT NULL,
  last_activity int(10) unsigned NOT NULL DEFAULT '0',
  user_data text NOT NULL,
  PRIMARY KEY(session_id)
);

CREATE TABLE tracker (
  ip_address varchar(16) DEFAULT '0',
  attempts tinyint(2) unsigned DEFAULT '0',
  last_attempt int(10) unsigned DEFAULT NULL,
  banned tinyint(1) unsigned DEFAULT '0'
);