CREATE TABLE `Users`(
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `password` VARCHAR(72) NoT NULL
) DEFAULT CHARSET utf8 COLLATE utf8_hungarian_ci;


CREATE TABLE `Items`(
    `name` VARCHAR(10) PRIMARY KEY,
    `column` tinyint UNSIGNED not null,
    `positiony` int UNSIGNED not null
)DEFAULT CHARSET utf8 COLLATE utf8_hungarian_ci;

INSERT INTO Users(`name`, `password`) VALUES("admin", "$2y$10$0ZNdgQpsrtXJYgGS5SYVQO/WZ9bBGSj4A.r6BWWzhhstB/jOv7TEu");


INSERT INTO `Items` VALUES 
("dog",0, 0),
("cat",0, 70),
("frog",0, 140),
("cow",0, 210),
("sheep",0, 280),
("lion",0, 350),
("pound",1, 0),
("fish",1, 70),
("foot",1, 140),
("milk",1, 210),
("super",1, 280),
("heart",1, 350);
