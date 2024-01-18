<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $wp_name = htmlspecialchars($_POST['wp_name']);
        $work_type = htmlspecialchars($_POST['work_type']); // Corrected variable name
        $description = htmlspecialchars($_POST['wp_des']);
        $wp_address = htmlspecialchars($_POST['wp_address']);
        $work_tel = htmlspecialchars($_POST['wp_tel']);
        $user_id = $_POST['user_id'];
        $map = $_POST['map'];

        // require the database connection
        require '../connection.php';

        // Use a prepared statement to prevent SQL injection
        $sql = "INSERT INTO workplaces (workplace_name, work_type, description, workplace_address, work_tel, user_id, map) 
            VALUES (:wp_name, :work_type, :description, :wp_address, :work_tel, :user_id, :map)";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':wp_name', $wp_name);
        $stmt->bindParam(':work_type', $work_type);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':wp_address', $wp_address);
        $stmt->bindParam(':work_tel', $work_tel);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':map', $map);

        // Execute the query
        if ($stmt->execute()) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
            echo '<script>
            Swal.fire({
                title: "เพิ่มผู้ใช้สำเร็จ!",
                icon: "success",
                confirmButtonText: "ตกลง"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../teacher-wp.php";
                }
            });
        </script>';
            exit();
        } else {
            // Handle errors
            echo "เกิดข้อผิดพลาด : " . $stmt->errorInfo()[2];
        }
    }
    ?>
</body>

</html>