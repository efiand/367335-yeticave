
CREATE TABLE categories (
    id CHAR(10) PRIMARY KEY,
    name CHAR(15)
);
CREATE UNIQUE INDEX id ON categories(id);

CREATE TABLE lots (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128),
    description	TEXT,
    price MEDIUMINT,
    step SMALLINT,
    create_ts INT,
    expire_ts BIGINT,
    img	CHAR(128),
    category_id	CHAR(10),
    user_id	SMALLINT,
    winner_id SMALLINT
);
CREATE UNIQUE INDEX id ON lots(id);
CREATE FULLTEXT INDEX lot_search ON lots(name, description);
CREATE INDEX price ON lots(price);
CREATE INDEX step ON lots(step);
CREATE INDEX create_ts ON lots(create_ts);
CREATE INDEX expire_ts ON lots(expire_ts);
CREATE INDEX category_id ON lots(category_id);
CREATE INDEX user_id ON lots(user_id);
CREATE INDEX winner_id ON lots(winner_id);

CREATE TABLE bets (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    create_ts INT,
    price MEDIUMINT,
    lot_id SMALLINT,
    user_id SMALLINT
);
CREATE UNIQUE INDEX id ON bets(id);
CREATE INDEX price ON bets(price);
CREATE INDEX lot_id ON bets(lot_id);
CREATE INDEX user_id ON bets(user_id);

CREATE TABLE users (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(64),
    email CHAR(64),
    password_hash CHAR(60),
    contacts CHAR(255),
    registration_ts INT,
    img	CHAR(128)
);
CREATE UNIQUE INDEX id ON users(id);
CREATE UNIQUE INDEX email ON users(email);
