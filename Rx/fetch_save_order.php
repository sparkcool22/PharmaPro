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
    $sale_id = $data['sale_id'];
    $selectedPayment = $data['selectedPayment'];
    $selectedValue = $data['selectedValue'];
    $totalColumn6 = $data['totalColumn6'];
    $receivedCash = $data['receivedCash'];
    $change = $data['change'];
    $curDate = $data['curDate'];
    $orderItems = $data['orders'];
    $remark = $data['remark'];

    $conn->begin_transaction();

    if ($act === 'update') {
        // 1. อัปเดตข้อมูลใน tbl_sales
        $stmt = $conn->prepare("UPDATE tbl_sales 
        SET payment = ?, customer_id = ?, total_amount = ?, cash_receive = ?, change_money = ?, remark = ?, update_date = ?
        WHERE sale_id = ?");
        $stmt->bind_param("sidddsss", $selectedPayment, $selectedValue, $totalColumn6, $receivedCash, $change, $remark, $curDate, $sale_id);
        $stmt->execute();
        $stmt->close();    

        // 2. ดึงข้อมูลรายการเดิม (approve = 'A')
        $stmt = $conn->prepare("SELECT product_id, quantity FROM tbl_sale_items WHERE sale_id = ? AND approve_status = 'A'");
        $stmt->bind_param("s", $sale_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $oldItems = [];
        while ($row = $result->fetch_assoc()) {
            $oldItems[$row['product_id']] = $row['quantity'];
        }
        $stmt->close();
    
        // 3. สร้าง Map ของรายการใหม่
        $newItems = [];
        foreach ($orderItems as $item) {
            $newItems[$item['drugid']] = [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount' => $item['discount'],
                'total' => $item['total']
            ];
        }
    
        // 4. ตรวจสอบรายการที่ถูกลบ หรือจำนวนเปลี่ยน
        foreach ($oldItems as $pid => $oldQty) {
            if (!isset($newItems[$pid]) || $newItems[$pid]['quantity'] != $oldQty) {
                // คืน stock
                $stmt = $conn->prepare("UPDATE tbl_product SET quantity_in_stock = quantity_in_stock + ? WHERE id = ?");
                $stmt->bind_param("ii", $oldQty, $pid);
                $stmt->execute();
                $stmt->close();
    
                // mark ว่าถูกลบ
                $stmt = $conn->prepare("UPDATE tbl_sale_items SET approve_status = 'N' WHERE sale_id = ? AND product_id = ?");
                $stmt->bind_param("si", $sale_id, $pid);
                $stmt->execute();
                $stmt->close();
            }
        }
    
        // 5. เพิ่มรายการใหม่ หรือรายการที่มีการเปลี่ยน quantity
        foreach ($newItems as $pid => $info) {
            $insertNew = false;
    
            if (!isset($oldItems[$pid])) {
                $insertNew = true;
            } elseif ($oldItems[$pid] != $info['quantity']) {
                $insertNew = true;
            }
    
            if ($insertNew) {
                // เพิ่มรายการใหม่
                $stmt = $conn->prepare("INSERT INTO tbl_sale_items 
                    (sale_id, product_id, quantity, price, discount, total_price, approve_status)
                    VALUES (?, ?, ?, ?, ?, ?, 'A')");
                $stmt->bind_param("siiddd", $sale_id, $pid, $info['quantity'], $info['price'], $info['discount'], $info['total']);
                $stmt->execute();
                $stmt->close();
    
                // หัก stock
                $stmt = $conn->prepare("UPDATE tbl_product SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");
                $stmt->bind_param("ii", $info['quantity'], $pid);
                $stmt->execute();
                $stmt->close();
            }
        }
                

    } else {
        // 1. INSERT tbl_sales
        $stmt = $conn->prepare("INSERT INTO tbl_sales (user_insert, sale_id, payment, customer_id, total_amount, cash_receive, change_money, insert_date, remark) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issidddss", $userID, $sale_id, $selectedPayment, $selectedValue, $totalColumn6, $receivedCash, $change, $curDate, $remark);
        $stmt->execute();

        // 2. INSERT tbl_sale_items
        $stmtItems = $conn->prepare("INSERT INTO tbl_sale_items (sale_id, product_id, quantity, price, discount, total_price) 
                                     VALUES (?, ?, ?, ?, ?, ?)");
        $stmtUpdateStock = $conn->prepare("UPDATE tbl_product SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");

        foreach ($orderItems as $item) {
            $stmtItems->bind_param("siiddd", $sale_id, $item['drugid'], $item['quantity'], $item['price'], $item['discount'], $item['total']);
            $stmtItems->execute();

            $stmtUpdateStock->bind_param("ii", $item['quantity'], $item['drugid']);
            $stmtUpdateStock->execute();
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>