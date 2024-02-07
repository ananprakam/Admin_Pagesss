<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Admin_Pages";
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // set the PDO error mode to exception
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit; // ถ้าเกิดข้อผิดพลาดในการเชื่อมต่อ ควรจะหยุดการทำงานทันที
        }
        

?>        
