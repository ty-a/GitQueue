CREATE TABLE gitqueue (
	gq_id int not null primary key auto_increment,
	gq_requester varchar(255) binary not null,
	gq_gerritname varchar(255) binary not null,
	gq_projectname varchar(255) binary not null,
	gq_status varchar(6) binary not null,
	gq_workflow varchar(5) binary not null,
	gq_comment varchar(255) binary,
	gq_submittime varchar(255) binary not null,
	gq_isdeleted boolean not null default FALSE

);