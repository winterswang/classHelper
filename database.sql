USE curriculum;
CREATE TABLE course(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	courseid VARCHAR(20),
	coursename VARCHAR(100),
	time VARCHAR(100),
	room VARCHAR(50),
	teacher VARCHAR(50),
	type VARCHAR(50),
	term VARCHAR(20)
);

INSERT INTO course(courseid, coursename, time, room, teacher, type, term)
	VALUES
	('COEN0031111047','大学英语1级','1-18周周一1-2节 1-18周周四1-2节','闵一教529','王越','英语类','term-1'),
	('COMS0031121002','线性代数A','2-18周周二1-2节 2-18周周四3-4节','闵四教102','沈超敏','学科基础课','term-1'),
	('COMS0031131006','C语言程序设计','2-18周周四5-6节','闵四教102','陆幼利','专业必修','term-1'),
	('COMS0031131026','计算机导论','3-18周周三3-4节','闵四教102','吕岳','专业必修','term-1'),
	('COMS0031132801','计算机导论实验','3-17周周三9-11节','闵实验A313','窦亮','专业任意选修','term-1'),
	('GFJY0031111000','军事理论（含军训）','1-18周周二7-8节','闵四教111','吴勇刚','其他通识必修','term-1'),
	('GGTY0031111022','排球','1-17周周二3-4节','闵西排球场1','金首旭','体育类','term-1'),
	('MATH0031121000','高等数学A（一）','2-18周周一3-4节 2-18周周三1-2节 2-18周周五3-4节','闵四教102','傅显隆','学科基础课','term-1'),
	('PHYS0031121002','大学物理B（一）','10-18周周二5-6节 10-18周周五5-6节','闵四教102','马红梅','学科基础课','term-1'),
	('SHKX0031111000','思想道德修养与法律基础','1-18周周一5-7节','闵四教323','陈君','思政类','term-1');

UPDATE  `curriculum`.`course` SET  `time` =  '1-18周周六1-2节 1-18周周四1-2节' WHERE  `course`.`id` =1;


UPDATE  `curriculum`.`course` SET  `description` =  'COEN0031111047，大学英语1级，1-18周周一1-2节 1-18周周四1-2节，闵一教529，王越，英语类，term-1， 大英1级' WHERE  `course`.`id` =1;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031121002，线性代数A，2-18周周二1-2节 2-18周周四3-4节，闵四教102，沈超敏，学科基础课，term-1， 线代' WHERE  `course`.`id` =2;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131026，C语言程序设计，2-18周周四5-6节，闵四教102，陆幼利，专业必修，term-1，小王子' WHERE  `course`.`id` =3;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131006，计算机导论， 计导，3-18周周三3-4节，闵四教102，吕岳，专业必修，term-1' WHERE  `course`.`id` =4;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031132801，计算机导论实验，计导实验，3-17周周三9-11节，闵实验A313，窦亮，专业任意选修，term-1' WHERE  `course`.`id` =5;
UPDATE  `curriculum`.`course` SET  `description` =  'GFJY0031111000，军事理论（含军训），军理，1-18周周二7-8节，闵四教111，吴勇刚，其他通识必修，term-1' WHERE  `course`.`id` =6;
UPDATE  `curriculum`.`course` SET  `description` =  'GGTY0031111022，排球，体育课，1-17周周二3-4节，闵西排球场1，金首旭，体育类，term-1' WHERE  `course`.`id` =7;
UPDATE  `curriculum`.`course` SET  `description` =  'MATH0031121000，高等数学A（一），高数上，2-18周周一3-4节 2-18周周三1-2节 2-18周周五3-4节，闵四教102，傅显隆，学科基础课，term-1' WHERE  `course`.`id` =8;
UPDATE  `curriculum`.`course` SET  `description` =  'PHYS0031121002，大学物理B（一），大物上，10-18周周二5-6节 10-18周周五5-6节，闵四教102，马红梅，学科基础课，term-1' WHERE  `course`.`id` =9;
UPDATE  `curriculum`.`course` SET  `description` =  'SHKX0031111000，思想道德修养与法律基础，思修， 思政，1-18周周一5-7节，闵四教323，陈君，思政类，term-1' WHERE  `course`.`id` =10;


INSERT INTO course(courseid, coursename, time, room, teacher, type, term)
	VALUES
	('COEN0031111030','大学英语2、3级','1-18周周一1-2节 1-18周周四1-2节','闵一教529','王越','英语类','term-2'),
	('COMS0031131008','计算机编程实践','1-18周周二5-6节','闵实验A313','陆幼利','专业必修','term-2'),
	('COMS0031131800','电子技术及实验','1-17周（单周）周一5-6节 1-18周周四3-4节','闵四教102','张颖芳','专业必修','term-2'),
	('COMS0031132061','面向对象程序设计(基于C++)','1-18周周四5-6节','闵四教102','陆幼利','专业任意选修','term-2'),
	('LAWS0031112008','程序正义与经典案例解析','1-13周周一9-11节','闵三教233','黄翔','公共选修','term-2'),
	('PHYS0031121801','大学物理实验B','1-18周周一7-8节','闵实验A323','崔璐','学科基础课','term-2'),
	('SHKX0031111011','中国近现代史纲要','1-18周周二1-2节','闵一教203','贾秀堂','思政类','term-2'),
	('MATH0031121001','高等数学A（二）','2-18周周一3-4节 2-18周周三1-2节 2-18周周五3-4节','闵四教102','傅显隆','学科基础课','term-2'),
	('PHYS0031121000','大学物理B（二）','1-18周周三3-4节 1-18周周五5-6节','闵四教102','马红梅','学科基础课','term-2'),
	('SHKX0031111012','毛泽东思想和中国特色社会主义理论体系概论(一)','1-18周周二7-8节','闵四教111','黄亚玲','思政类','term-2');

UPDATE  `curriculum`.`course` SET  `description` =  'COEN0031111030，大学英语2、3级，1-18周周一1-2节 1-18周周四1-2节，闵一教529，王越，英语类，term-2， 大英2、3级' WHERE  `course`.`id` =11;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131008，计算机编程实践，1-18周周二5-6节，闵实验A313，陆幼利，专业必修，term-2，小王子' WHERE  `course`.`id` =12;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131800，电子技术及实验， 模电，1-17周（单周）周一5-6节 1-18周周四3-4节，闵四教102，张颖芳，专业必修，term-2' WHERE  `course`.`id` =13;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031132061，面向对象程序设计(基于C++)，1-18周周四5-6节，闵四教102，陆幼利，专业任意选修， 专选，term-2，小王子' WHERE  `course`.`id` =14;
UPDATE  `curriculum`.`course` SET  `description` =  'LAWS0031112008，程序正义与经典案例解析， 程序正义与案例解析，1-18周周四5-6节，闵三教233，黄翔，公共选修， 公选，term-2' WHERE  `course`.`id` =15;
UPDATE  `curriculum`.`course` SET  `description` =  'PHYS0031121801，大学物理实验B，大物实验，1-18周周一7-8节，闵实验A323，崔璐，学科基础课，term-2' WHERE  `course`.`id` =16;
UPDATE  `curriculum`.`course` SET  `description` =  'SHKX0031111011，中国近现代史纲要，近代史，1-18周周二1-2节，闵一教203，贾秀堂，思政类，term-2' WHERE  `course`.`id` =17;
UPDATE  `curriculum`.`course` SET  `description` =  'MATH0031121001，高等数学A（二），高数下，2-18周周一3-4节 2-18周周三1-2节 2-18周周五3-4节，闵四教102，傅显隆，学科基础课，term-2' WHERE  `course`.`id` =18;
UPDATE  `curriculum`.`course` SET  `description` =  'PHYS0031121000，大学物理B（二），大物下，1-18周周三3-4节 1-18周周五5-6节，闵四教102，马红梅，学科基础课，term-2' WHERE  `course`.`id` =19;
UPDATE  `curriculum`.`course` SET  `description` =  'SHKX0031111012，毛泽东思想和中国特色社会主义理论体系概论(一)，毛概上，1-18周周二7-8节，闵四教111，黄亚玲，思政类，term-2' WHERE  `course`.`id` =20;




INSERT INTO course(courseid, coursename, time, room, teacher, type, term)
	VALUES
	('CHIN0031121001','大学语文','1-18周周五5-6节','闵一教335','孙国强','文化传承类','term-3'),
	('COEN0031111041','大学英语4级','1-18周周一5-6节','闵四教419','张军','英语类','term-3'),
	('COMS0031131003','离散数学','1-18周周一3-4节 1-18周周四5-7节','闵四教402','章炯民','专业必修','term-3'),
	('GGTY0031111024','健美操','1-18周周二3-4节','闵体3F南厅1','虞轶群','体育类','term-3'),
	('SHKX0031111007','毛泽东思想和中国特色社会主义理论体系概论(二)','1-17周周一9-10节','闵一教214','樊建政','思政类','term-3');

UPDATE  `curriculum`.`course` SET  `description` =  'CHIN0031121001，大学语文，1-18周周五5-6节，闵一教335，孙国强，文化传承类，term-3' WHERE  `course`.`id` =21;
UPDATE  `curriculum`.`course` SET  `description` =  'COEN0031111041，大学英语4级，1-18周周一5-6节，闵四教419，张军，英语类，term-3' WHERE  `course`.`id` =22;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131003，离散数学，1-18周周一3-4节 1-18周周四5-7节，闵四教402，章炯民，专业必修，term-3' WHERE  `course`.`id` =23;
UPDATE  `curriculum`.`course` SET  `description` =  'GGTY0031111024，健美操，1-18周周二3-4节，闵体3F南厅1，虞轶群，体育类，term-3' WHERE  `course`.`id` =24;
UPDATE  `curriculum`.`course` SET  `description` =  'SHKX0031111007，毛泽东思想和中国特色社会主义理论体系概论(二)，毛概下，1-17周周一9-10节，闵一教214，樊建政，思政类，term-3' WHERE  `course`.`id` =25;


INSERT INTO course(courseid, coursename, time, room, teacher, type, term)
	VALUES
	('COMS0031131014','计算机组成与结构','1-18周周三3-4节 1-18周周五3-4节','闵四教302','魏同权','专业必修','term-4'),
	('COMS0031131022','信息系统安全概论','1-18周周三1-2节','闵四教302','李东','专业必修','term-4'),
	('COMS0031131015','操作系统','1-18周周四5-7节','闵四教302','李东','专业必修','term-4'),
	('COMS0031131028','抽象代数','1-18周周四3-4节','闵四教302','柳银萍','专业任意选修','term-4'),
	('COMS0031132036','Web应用技术','1-18周周一5-6节','闵实验A313','房爱莲','专业任意选修','term-4'),
	('COMS0031132068','Windows应用程序设计','1-18周周二5-6节','闵四教302','陆幼利','专业任意选修','term-4'),
	('GGTY0031111013','木兰拳','1-18周周五5-6节','闵体健美操房1','韩仲凯','体育类','term-4'),
	('EDTE0031142011','外语学习策略','13-17周周三9-11节','闵一教323','郭宝仙','公共选修','term-4'),
	('SOCI0031112001','休闲学与休闲文化','1-12周周三9-11节','闵一教331','曾明星','公共选修','term-4'),
	('COMC0031111023','Illustrator/CorelDRAW图形设计','1-12周周三9-11节','闵实验A203','李建芳','公共选修','term-4'),
	('COMC0031112034','Photoshop图像处理','1-12周周一9-11节','闵实验A203','李建芳','公共选修','term-4');

UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131014，计算机组成与结构，计组，1-18周周三3-4节 1-18周周五3-4节，闵四教302，魏同权，专业必修，term-4' WHERE  `course`.`id` =26;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131022，信息系统安全概论， 信安，1-18周周三1-2节，闵四教302，李东，东哥， 专业必修，term-4' WHERE  `course`.`id` =27;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131015，操作系统，1-18周周四5-7节，闵四教302，李东，东哥，专业必修，term-4' WHERE  `course`.`id` =28;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031131028，抽象代数，1-18周周四3-4节，闵四教302，柳银萍，专业任意选修，专选，term-4' WHERE  `course`.`id` =29;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031132036，Web应用技术，1-18周周一5-6节，闵实验A313，房爱莲，专业任意选修，专选，term-4' WHERE  `course`.`id` =30;
UPDATE  `curriculum`.`course` SET  `description` =  'COMS0031132068，Windows应用程序设计，1-18周周二5-6节，闵四教302，陆幼利，小王子，专业任意选修，专选，term-4' WHERE  `course`.`id` =31;
UPDATE  `curriculum`.`course` SET  `description` =  'GGTY0031111013，木兰拳，1-18周周五5-6节，闵体健美操房1，韩仲凯，体育类' WHERE  `course`.`id` =32;
UPDATE  `curriculum`.`course` SET  `description` =  'EDTE0031142011，外语学习策略，13-17周周三9-11节，闵一教323，郭宝仙，公共选修，公选' WHERE  `course`.`id` =33;
UPDATE  `curriculum`.`course` SET  `description` =  'SOCI0031112001，休闲学与休闲文化，1-12周周三9-11节，闵一教331，曾明星，公共选修，公选' WHERE  `course`.`id` =34;
UPDATE  `curriculum`.`course` SET  `description` =  'COMC0031111023，Illustrator/CorelDRAW图形设计，1-12周周三9-11节，闵实验A203，李建芳，公共选修，公选' WHERE  `course`.`id` =35;
UPDATE  `curriculum`.`course` SET  `description` =  'COMC0031112034，Photoshop图像处理，1-12周周一9-11节，闵实验A203，李建芳，公共选修，公选' WHERE  `course`.`id` =36;


CREATE DATABASE curriculum DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE user;
CREATE TABLE userinfo(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	subscribe INTEGER(1),
	openid VARCHAR(50),
	nickname VARCHAR(50),
	sex INTEGER(1),
	language VARCHAR(20),
	city VARCHAR(50),
	province VARCHAR(50),
	country VARCHAR(50),
	headimgurl VARCHAR(200),
	subscribe_time VARCHAR(20),
	unionid VARCHAR(200)
);
CREATE DATABASE `test2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci


USE course;
CREATE TABLE text(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	Content text,
	MsgId INTEGER(64)
);

USE course;
CREATE TABLE image(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	PicUrl VARCHAR(200),
	MediaId VARCHAR(200),
	MsgId INTEGER(64)
);

USE course;
CREATE TABLE voice(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	MediaId VARCHAR(200),
	Format VARCHAR(20),
	MsgId INTEGER(64)
);

USE course;
CREATE TABLE video(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	MediaId VARCHAR(200),
	ThumbMediaId VARCHAR(20),
	MsgId INTEGER(64)
);

USE course;
CREATE TABLE location(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	Location_X DOUBLE,
	Location_Y DOUBLE,
	Scale VARCHAR(200),
	Label VARCHAR(200),
	MsgId INTEGER(64)
);

USE course;
CREATE TABLE link(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	Title VARCHAR(200),
	Description text,
	Url VARCHAR(200),
	MsgId INTEGER(64)
);

USE course;
CREATE TABLE event(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ToUserName VARCHAR(50),
	FromUserName VARCHAR(50),
	CreateTime timestamp,
	subscribe int(1);
);

USE curriculum;
CREATE TABLE building(
	id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	bName VARCHAR(20),
	latitude DOUBLE,
	longitude DOUBLE
);

INSERT INTO building(bName)
	VALUES
	('闵实验A'),
	('闵实验B'),
	('闵实验C'),
	('闵实验D'),
	('闵体'),
	('闵一教'),31.03089  121.453781
	('闵二教'),31.030724 121.454712
	('闵三教'),31.028215 121.449989
	('闵四教');31.031166 121.446526

	UPDATE  `curriculum`.`course` SET  `latitude` =  '31.028215', `longitude` =  '121.449989' WHERE  `course`.`room` LIKE '闵三教%';


INSERT INTO user(material,remark,account,status)
	VALUES
	('新中国电影65年', '新中国电影65年：光影变幻映照时代变迁', 'Paul', '已启用'),
	()

