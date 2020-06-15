
CREATE TABLE menu (
  menuId integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  menu varchar(128) NOT NULL
);
CREATE UNIQUE INDEX menuId ON menu (menuId ASC);

CREATE TABLE menuItem (
  menuItemId integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  menuId integer NOT NULL,
  label varchar(128) NOT NULL,
  params text,
  route varchar(255),
  uri varchar(255),
  resource varchar(255),
  visible integer(1) NOT NULL DEFAULT('1'),
  lft integer(128) NOT NULL,
  rgt integer(128) NOT NULL,
  FOREIGN KEY (menuId) REFERENCES menu (menuId)
);
CREATE UNIQUE INDEX pageId ON menuItem (menuItemId ASC);