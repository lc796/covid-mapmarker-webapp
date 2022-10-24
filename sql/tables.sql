CREATE TABLE IF NOT EXISTS tbl_user (
  user_id INTEGER PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(30) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS tbl_visits (
    visit_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    date_time DATETIME NOT NULL,
    duration INTEGER NOT NULL,
    x INTEGER NOT NULL,
    y INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES tbl_user(user_id)
);

CREATE TABLE IF NOT EXISTS tbl_infections (
    infection_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    date_time DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES tbl_user(user_id)
);