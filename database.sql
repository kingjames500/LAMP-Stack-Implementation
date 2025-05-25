
CREATE TABLE IF NOT EXISTS `judges`(
    id varchar(36) PRIMARY KEY DEFAULT(UUID()),
    username varchar(20) not null,
    display_name varchar(25) not null
    );

CREATE TABLE  IF NOT EXISTS `users`(
    id varchar(36) PRIMARY KEY DEFAULT(UUID()),
    full_name VARCHAR(100) NOT NULL
);

INSERT INTO users(full_name) VALUE("TEST1");
INSERT INTO users(full_name) VALUE("test2");
INSERT INTO users(full_name) VALUE("John Does");

CREATE TABLE IF NOT EXISTS `scores`(
                        id varchar(36)  PRIMARY KEY DEFAULT(UUID()),
                        judge_id varchar(36),
                        user_id varchar(36),
                        points INT CHECK (points >= 0 AND points <= 100),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (judge_id) REFERENCES judges(id),
                        FOREIGN KEY (user_id) REFERENCES users(id),
                        UNIQUE (judge_id, user_id)
);