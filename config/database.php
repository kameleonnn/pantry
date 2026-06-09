<?php
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'pantry_secure_password');
define('DB_NAME', getenv('DB_NAME') ?: 'pantry_db');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// ... (Your existing code where $conn = new mysqli(...) is established) ...

// 1. Check if the core 'users' table exists
$table_check = $conn->query("SHOW TABLES LIKE 'users'");

if ($table_check->num_rows == 0) {
    // 2. Enable strict error reporting for debugging setup issues
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Create the USERS table
        $conn->query("CREATE TABLE `users` (`id` int(11) NOT NULL AUTO_INC,`email` varchar(127) NOT NULL,`name` varchar(63) DEFAULT NULL,`password` varchar(255) NOT NULL,`accepted_tos` tinyint(1) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        // Create the PANTRIES table
        $conn->query("CREATE TABLE `pantries` (`id` int(11) NOT NULL AUTO_INC,`owner_id` int(11) NOT NULL,`name` varchar(127) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $conn->query("CREATE TABLE `pantry_item` (`id` int(11) NOT NULL AUTO_INC,`pantry_id` int(11) NOT NULL,`name` varchar(127) NOT NULL,`quantity` int(11) NOT NULL DEFAULT 0,`notes` varchar(511) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $conn->query("CREATE TABLE `shopping_list` (`id` int(11) NOT NULL AUTO_INC,`owner_id` int(11) NOT NULL,`item_id` int(11) DEFAULT NULL,`name` varchar(127) NOT NULL DEFAULT 'New item',`quantity` int(11) NOT NULL DEFAULT 1) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $conn->query("ALTER TABLE `shopping_list` ADD PRIMARY KEY (`id`), ADD KEY `item_id` (`item_id`), ADD KEY `owner_id` (`owner_id`);");

        $conn->query("ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email_unique` (`email`);");

        $conn ->query("ALTER TABLE `pantries` ADD CONSTRAINT `pantries_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

        $conn->query("ALTER TABLE `pantry_item` ADD CONSTRAINT `pantry_id` FOREIGN KEY (`pantry_id`) REFERENCES `pantries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

        $conn->query("ALTER TABLE `shopping_list` ADD CONSTRAINT `item_id` FOREIGN KEY (`item_id`) REFERENCES `pantry_item` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE, ADD CONSTRAINT `owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        

    } catch (mysqli_sql_exception $e) {
        error_log("Database Auto-Initialization Failed: " . $e->getMessage());
    }
}
