<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table id="ordertable">
    <thead>
        <tr>
            <th>No</th>
            <th>ชื่อทางการค้า</th>
            <th>จำนวน</th>
            <th>มูลค่า</th>
            <th>ส่วนลด</th>
            <th>รวม</th>
            <th>ลบ</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td><div style="text-align: left; padding-left:10px">NEOTICA BALM Cool 60g.</div></td>
            <td contenteditable="true" onkeypress="acceptOnEnter(event)">2</td>
            <td>25</td>
            <td contenteditable="true">0</td>
            <td>50</td>
            <td><i class="fa-regular fa-rectangle-xmark" style="color: red; font-size:20px; padding-top:5px"></i></td>
        </tr>
        <tr>
            <td>2</td>
            <td><div style="text-align: left; padding-left:10px">NEOTICA BALM Cool 100g.</div></td>
            <td contenteditable="true">1</td>
            <td>36</td>
            <td contenteditable="true">0</td>
            <td>36</td>
            <td><i class="fa-regular fa-rectangle-xmark" style="color: red; font-size:20px; padding-top:5px"></i></td>
        </tr>
        <tr>
            <td>3</td>
            <td><div style="text-align: left; padding-left:10px">M-CIN Spray 50 ml.</div></td>
            <td contenteditable="true">1</td>
            <td>42</td>
            <td contenteditable="true">2</td>
            <td>40</td>
            <td><i class="fa-regular fa-rectangle-xmark" style="color: red; font-size:20px; padding-top:5px"></i></td>
        </tr>
        <tr>
            <td>4</td>
            <td><div style="text-align: left; padding-left:10px">Difelene gel 60g</div></td>
            <td contenteditable="true">1</td>
            <td>54</td>
            <td contenteditable="true">0</td>
            <td>54</td>
            <td><i class="fa-solid fa-rectangle-xmark" style="color: red;font-size:20px;padding-top:5px"></i></td>
        </tr>
        <tr>
            <td>5</td>
            <td><div style="text-align: left; padding-left:10px">BIO Lyte 25g.x25 ซอง ส้ม </div></td>
            <td contenteditable="true">1</td>
            <td>106</td>
            <td contenteditable="true">0</td>
            <td>106</td>
            <td><i class="fa-regular fa-rectangle-xmark" style="color: red; font-size:20px; padding-top:5px"></i></td>
        </tr>
    </tbody>
</table>										
<p id="total">ผลรวมของจำนวน: </p>
<script>
    // เลือกตารางจาก id
    var table = document.getElementById('ordertable');

    // ดึงค่าคอลัมน์ที่ 2 แถวที่ 3
    var row = table.rows[2]; // แถวที่ 3 (index เริ่มจาก 0)
    var column = row.cells[1]; // คอลัมน์ที่ 2 (index เริ่มจาก 0)
    
    // ดึงค่าข้อความที่อยู่ใน div
    var value = column.querySelector('div').innerText;

    // แสดงค่าที่ได้ใน console
    console.log("ค่าคอลัมน์ที่ 2 แถวที่ 3: ", value);
</script>
<script>
    // ฟังก์ชันสำหรับคำนวณผลรวมของคอลัมน์ที่ 3 (จำนวน)
    function calculateTotal() {
        var table = document.getElementById('ordertable'); // เลือกตาราง
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr'); // เลือกแถวใน tbody
        var total = 0;

        // วนลูปผ่านแต่ละแถวและรวมค่าของคอลัมน์ที่ 3 (จำนวน)
        for (var i = 0; i < rows.length; i++) {
            var cell = rows[i].getElementsByTagName('td')[2]; // เลือกคอลัมน์ที่ 3 ของแต่ละแถว
            var value = parseFloat(cell.innerText); // แปลงค่าข้อความเป็นตัวเลข
            total += isNaN(value) ? 0 : value; // ถ้าค่าไม่ใช่ตัวเลขให้ถือว่าเป็น 0
        }

        // อัพเดตค่าผลรวมในแท็ก <p> ที่มี id="total"
        document.getElementById('total').innerText = "ผลรวมของจำนวน: " + total;
    }

    // ฟังก์ชันสำหรับตรวจจับการเปลี่ยนแปลงค่าในเซลล์
    function setupEditableListeners() {
        var table = document.getElementById('ordertable');
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (var i = 0; i < rows.length; i++) {
            var cell = rows[i].getElementsByTagName('td')[2]; // เลือกคอลัมน์ที่ 3 ของแต่ละแถว
            cell.addEventListener('input', calculateTotal); // เพิ่ม Event Listener สำหรับการแก้ไขข้อมูล
        }
    }

    // เรียกใช้ฟังก์ชันเมื่อโหลดหน้าเว็บเสร็จ
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal(); // คำนวณผลรวมเมื่อโหลดหน้าเว็บครั้งแรก
        setupEditableListeners(); // ตั้งค่าการตรวจจับการเปลี่ยนแปลงค่า
    });
</script>
<script>
    function acceptOnEnter(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // ป้องกันการเพิ่มบรรทัดใหม่ใน `<td>`
            event.target.blur(); // ออกจากโหมดแก้ไขเพื่อยืนยันค่า
            // เพิ่มโค้ดที่คุณต้องการให้ทำงานเมื่อค่าถูกยอมรับ เช่น บันทึกค่า หรือแสดงข้อความ
            console.log("Value accepted: " + event.target.innerText);
        }
    }
</script>

</body>
</html>