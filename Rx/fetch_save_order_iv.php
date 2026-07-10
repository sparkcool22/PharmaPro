<?php
include('db_connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    $act = $data['act'];
    $userID = $data['userID'];
    $order_id = $data['order_id'];
    $totalColumn6 = $data['totalColumn6'];
    $curDate = $data['curDate'];
    $orderItems = $data['orders'];
    $remark = $data['remark'];

    $conn->begin_transaction();

    if ($act === 'update') {
        // 1. อัปเดตตารางหลัก
        $stmt = $conn->prepare("UPDATE tbl_inventory_adjustment SET total_amount = ?, remark = ?, update_date = ? WHERE order_id = ?");
        $stmt->bind_param("dsss", $totalColumn6, $remark, $curDate, $order_id);
        $stmt->execute();
        
        // 2. ดึงรายการเดิมจากฐานข้อมูล (ที่ approve = 'A')
        $stmt = $conn->prepare("SELECT product_id, quantity FROM tbl_inventory_adjustment_items WHERE order_id = ? AND approve_status = 'A'");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $oldItems = [];
        while ($row = $result->fetch_assoc()) {
            $oldItems[$row['product_id']] = $row['quantity'];
        }
        $stmt->close();

        // 3. สร้าง Map รายการใหม่จาก frontend
        $newItems = [];
        foreach ($orderItems as $item) {
            $newItems[$item['drugid']] = [
                'quantity' => $item['quantity'],
                'price' => $item['pricePerUnit'],
                'total' => $item['total']
            ];
        }

        // 4. ตรวจสอบรายการที่ลบออกหรือแก้ไขจำนวน
        foreach ($oldItems as $pid => $oldQty) {
            if (!isset($newItems[$pid]) || $newItems[$pid]['quantity'] != $oldQty) {
                // คืน stock
                $stmt = $conn->prepare("UPDATE tbl_product SET quantity_in_stock = quantity_in_stock + ? WHERE id = ?");
                $stmt->bind_param("ii", $oldQty, $pid);
                $stmt->execute();
                $stmt->close();

                // mark ว่าถูกลบ
                $stmt = $conn->prepare("UPDATE tbl_inventory_adjustment_items SET approve_status = 'N' WHERE order_id = ? AND product_id = ?");
                $stmt->bind_param("si", $order_id, $pid);
                $stmt->execute();
                $stmt->close();
            }
        }

        // 5. เพิ่มรายการใหม่หรือแก้ไขจำนวนใหม่
        foreach ($newItems as $pid => $info) {
            $insertNew = false;

            if (!isset($oldItems[$pid])) {
                $insertNew = true; // ของใหม่
            } elseif ($oldItems[$pid] != $info['quantity']) {
                $insertNew = true; // quantity เปลี่ยน
            }

            if ($insertNew) {
                // insert รายการใหม่
                $stmt = $conn->prepare("INSERT INTO tbl_inventory_adjustment_items (order_id, product_id, quantity, price_per_unit, total_price, approve_status) VALUES (?, ?, ?, ?, ?, 'A')");
                $stmt->bind_param("siidd", $order_id, $pid, $info['quantity'], $info['price'], $info['total']);
                $stmt->execute();
                $stmt->close();

                // ลด stock
                $stmt = $conn->prepare("UPDATE tbl_product SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");
                $stmt->bind_param("ii", $info['quantity'], $pid);
                $stmt->execute();
                $stmt->close();
            }
        }

    } else {
        // 6. กรณี act เป็น new
        $stmt = $conn->prepare("INSERT INTO tbl_inventory_adjustment (user_insert, order_id, total_amount, insert_date, remark) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isdss", $userID, $order_id, $totalColumn6, $curDate, $remark);
        $stmt->execute();

        $stmtItems = $conn->prepare("INSERT INTO tbl_inventory_adjustment_items (order_id, product_id, quantity, price_per_unit, total_price, approve_status) VALUES (?, ?, ?, ?, ?, 'A')");
        $stmtUpdateStock = $conn->prepare("UPDATE tbl_product SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");

        foreach ($orderItems as $item) {
            $stmtItems->bind_param("siidd", $order_id, $item['drugid'], $item['quantity'], $item['pricePerUnit'], $item['total']);
            $stmtItems->execute();

            $stmtUpdateStock->bind_param("ii", $item['quantity'], $item['drugid']);
            $stmtUpdateStock->execute();
        }

        $stmtItems->close();
        $stmtUpdateStock->close();
    }

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>