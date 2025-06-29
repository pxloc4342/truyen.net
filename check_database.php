<?php
echo "<h2>Kiểm tra databases hiện có...</h2>";

try {
    // Kết nối MySQL (không chọn database)
    $pdo = new PDO('mysql:host=localhost', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<p>✓ Kết nối MySQL thành công</p>";
    
    // Lấy danh sách databases
    $stmt = $pdo->query("SHOW DATABASES");
    $databases = $stmt->fetchAll();
    
    echo "<h3>Danh sách databases hiện có:</h3>";
    echo "<ul>";
    foreach ($databases as $db) {
        $dbName = $db['Database'];
        if ($dbName != 'information_schema' && $dbName != 'mysql' && $dbName != 'performance_schema' && $dbName != 'phpmyadmin') {
            echo "<li><strong>$dbName</strong></li>";
        }
    }
    echo "</ul>";
    
    // Kiểm tra xem có database nào có bảng stories không
    echo "<h3>Kiểm tra database có bảng stories:</h3>";
    foreach ($databases as $db) {
        $dbName = $db['Database'];
        if ($dbName != 'information_schema' && $dbName != 'mysql' && $dbName != 'performance_schema' && $dbName != 'phpmyadmin') {
            try {
                $pdo->exec("USE $dbName");
                $stmt = $pdo->query("SHOW TABLES LIKE 'stories'");
                if ($stmt->rowCount() > 0) {
                    echo "<p>✓ Database <strong>$dbName</strong> có bảng stories</p>";
                    
                    // Kiểm tra các bảng khác
                    $tables = ['categories', 'chapters', 'admins', 'users'];
                    foreach ($tables as $table) {
                        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                        if ($stmt->rowCount() > 0) {
                            echo "<p>  - Có bảng: $table</p>";
                        } else {
                            echo "<p>  - Thiếu bảng: $table</p>";
                        }
                    }
                }
            } catch (Exception $e) {
                // Bỏ qua lỗi
            }
        }
    }
    
} catch (PDOException $e) {
    echo "<h3 style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</h3>";
}
?> 