create database amusement;
use amusement;
create table amusement (
	name	char(32)	 not null primary key, character set utf8
	enter_child	int(3),
	enter_adult	int(3),
	big3_child 	int(3),
	big3_adult	int(3),
	free_child	int(3),
	free_adult	int(3),
	year_child	int(3),
	year_adult	int(3),
);
describe amusement;
