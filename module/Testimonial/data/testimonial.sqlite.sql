
CREATE TABLE testimonial (
  testimonialId integer PRIMARY KEY AUTOINCREMENT NOT NULL,
  name varchar(255),
  image varchar(255),
  location varchar(255),
  company varchar(255),
  website varchar(255),
  sector varchar(255),
  "text" text NOT NULL,
  dateCreated text(128) NOT NULL,
  dateModified text(128) NOT NULL
);
CREATE UNIQUE INDEX testimonialId ON testimonial (testimonialId ASC);