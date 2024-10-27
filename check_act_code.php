<?php
require("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $act = $_POST["act"];
    
    // Prepare SQL query to prevent SQL injection
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND activation_code = ?");
    $stmt->bind_param("ss", $email, $act);
    $stmt->execute();
    $response = $stmt->get_result();

    if ($response->num_rows > 0) {
        // Update user status to 'active'
        $update_stmt = $db->prepare("UPDATE users SET status = 'active' WHERE email = ?");
        $update_stmt->bind_param("s", $email);

        if ($update_stmt->execute()) {
            // Get user ID after activating the account
            $id_stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $id_stmt->bind_param("s", $email);
            $id_stmt->execute();
            $id_response = $id_stmt->get_result();
            $id_array = $id_response->fetch_assoc();
            $user_table_name = "user_" . (int)$id_array['id'];

            // Create user table securely
            $create_user_table = "
                CREATE TABLE $user_table_name (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    file_name VARCHAR(100),
                    file_size VARCHAR(100),
                    star VARCHAR(100) DEFAULT 'no',
                    date_time DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY(id)
                )";

            if ($db->query($create_user_table)) {
                // Securely create user directory
                $user_directory = "data/" . $user_table_name;
                if (!file_exists($user_directory)) {
                    if (mkdir($user_directory, 0755, true)) {
                        echo "Your Account Is Active Now";
                    } else {
                        error_log("Failed to create user directory: $user_directory");
                        echo "An error occurred during account setup.";
                    }
                } else {
                    echo "Directory already exists.";
                }
            } else {
                error_log("Failed to create table: " . $db->error);
                echo "An error occurred during account setup.";
            }
        } else {
            echo "Failed to update status.";
        }
    } else {
        echo "Wrong Activation Code.";
    }
} else {
    echo "Unauthorized request.";
}
?>
