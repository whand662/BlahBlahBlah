set time_zone = '-5:00';

drop table if exists Users;
create table Users (user VARCHAR(20), pw TINYTEXT, email TINYTEXT, tz varchar(10) default '-5:00', since TIMESTAMP, primary key (user));
insert into Users (user, pw, email) Values ('whand', 'password', 'willishand@gmail.com');

drop table if exists Follows;
create table Follows (follower VARCHAR(20), leader VARCHAR(20), since TIMESTAMP, primary key(follower, leader));

drop table if exists Posts;
create table Chats (pid INT AUTO_INCREMENT, user VARCHAR(20), blurb TEXT, at TIMESTAMP, primary key (cid));

drop table if exists Messages;
create table Messages (sender VARCHAR(20), reciever VARCHAR(20), blurb TEXT, at TIMESTAMP, primary key (sender, reciever, at));

drop table if exists Comments;
create table Comments (cid INT AUTO_INCREMENT, user VARCHAR(20), refid INT, blurb TEXT, at TIMESTAMP, primary key (cid));
