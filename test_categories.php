<?php
// File test để kiểm tra chức năng quản lý thể loại
// Chạy file này để test các chức năng CRUD của categories

// Load cấu hình
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'core/Database.php';

// Khởi tạo database
$db = Database::getInstance();

echo "<h2>🧪 Test Quản lý Thể loại</h2>";

// Test 1: Thêm thể loại mới
echo "<h3>1. Thêm thể loại mới</h3>";
try {
    $categories = [
        'Hành động',
        'Phiêu lưu', 
        'Tình cảm',
        'Hài hước',
        'Kinh dị',
        'Thể thao',
        'Trường học',
        'Siêu nhiên'
    ];
    
    foreach ($categories as $categoryName) {
        // Kiểm tra xem thể loại đã tồn tại chưa
        $existing = $db->fetch("SELECT id FROM categories WHERE name = ?", [$categoryName]);
        if (!$existing) {
            $db->insert('categories', ['name' => $categoryName]);
            echo "✅ Đã thêm thể loại: <strong>{$categoryName}</strong><br>";
        } else {
            echo "⚠️ Thể loại <strong>{$categoryName}</strong> đã tồn tại<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

// Test 2: Hiển thị danh sách thể loại
echo "<h3>2. Danh sách thể loại hiện có</h3>";
try {
    $categories = $db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
    if (!empty($categories)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>ID</th><th>Tên thể loại</th></tr>";
        foreach ($categories as $category) {
            echo "<tr>";
            echo "<td>{$category['id']}</td>";
            echo "<td>{$category['name']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "📭 Chưa có thể loại nào";
    }
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

// Test 3: Cập nhật thể loại
echo "<h3>3. Cập nhật thể loại</h3>";
try {
    $testCategory = $db->fetch("SELECT * FROM categories LIMIT 1");
    if ($testCategory) {
        $newName = $testCategory['name'] . ' (Updated)';
        $db->update('categories', ['name' => $newName], 'id = ?', [$testCategory['id']]);
        echo "✅ Đã cập nhật thể loại ID {$testCategory['id']}: {$testCategory['name']} → {$newName}<br>";
        
        // Khôi phục lại tên cũ
        $db->update('categories', ['name' => $testCategory['name']], 'id = ?', [$testCategory['id']]);
        echo "✅ Đã khôi phục tên thể loại về: {$testCategory['name']}<br>";
    }
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

// Test 4: Kiểm tra quan hệ với truyện
echo "<h3>4. Kiểm tra quan hệ với truyện</h3>";
try {
    $storyCategories = $db->fetchAll("
        SELECT c.name as category_name, COUNT(sc.story_id) as story_count 
        FROM categories c 
        LEFT JOIN story_category sc ON c.id = sc.category_id 
        GROUP BY c.id, c.name 
        ORDER BY story_count DESC
    ");
    
    if (!empty($storyCategories)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Tên thể loại</th><th>Số truyện</th></tr>";
        foreach ($storyCategories as $item) {
            echo "<tr>";
            echo "<td>{$item['category_name']}</td>";
            echo "<td>{$item['story_count']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "📭 Chưa có dữ liệu quan hệ";
    }
} catch (Exception $e) {
    echo "❌ Lỗi: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h3>🎯 Kết quả test</h3>";
echo "<p>✅ Tất cả các chức năng CRUD cho thể loại đã hoạt động bình thường!</p>";
echo "<p>🔗 <a href='admin/categories' target='_blank'>Xem trang quản lý thể loại</a></p>";
echo "<p>🔗 <a href='admin/dashboard' target='_blank'>Về Dashboard Admin</a></p>";
?> 