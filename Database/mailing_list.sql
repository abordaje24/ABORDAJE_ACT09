-- Step 1: Create a Database named "sample_db"

-- Step 2: Delete any existing "mailing_list" table, if any
DROP TABLE IF EXISTS `mailing_list`;

-- Step 3: Create "mailing_list" table
CREATE TABLE `mailing_list` (
	`id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`person_email` VARCHAR(255) NOT NULL,
	`person_name` VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;