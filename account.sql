create table account (
id int auto_increment primary key,
username varchar(50) unique,
password varchar(9),
fullname varchar(50) not null,
dob varchar(10) not null,
gender int,
email varchar(50) not null,
mobile varchar(10) not null,
address varchar(200) not null,
state char(2) not null,
city varchar(20) not null,
permission int
);

insert into account values (
1,
"user1",
"password1",
"Alex Albert",
"1/1/1",
1,
"AlexAlbert@aol.com",
"111-1111",
"111 NE 1st Ave",
"WA",
"Tacoma",
0
);

insert into account values (
2,
"user2",
"password2",
"Bella Bartleson",
"2/2/2",
2,
"BellaB@Bol.com",
"222-2222",
"222 SE 2nd ST",
"OR",
"Portland",
1
);

insert into account values (
3,
"user3",
"password3",
"Charlie Chance",
"3/3/3",
0,
"CharlieC@Col.com",
"333-3333",
"333 SW 3rd CT",
"WA",
"Bellevue",
1
);

insert into account values (
4,
"user4",
"password4",
"Daniel Danielson",
"4/4/4",
1,
"DannyD@Dol.com",
"444-4444",
"444 NW 4th AVE",
"WA",
"Bellevue",
1
);