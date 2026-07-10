<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <!-- <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script> -->
    <script src="./html5-qrcode.min.js"></script>
</head>
<body>
    <h1>QR Code Scanner</h1>
    <div id="reader" style="width: 300px; height: 300px;"></div>
    <p id="result" style="margin-top:300px;">Result will appear here</p>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // แสดงผลลัพธ์ QR Code ที่อ่านได้
            document.getElementById('result').innerText = `Scanned result: ${decodedText}`;
        }

        function onScanFailure(error) {
            console.warn(`QR error: ${error}`);
        }

        const html5QrCode = new Html5Qrcode("reader");

        // เริ่มการสแกนโดยระบุให้ใช้กล้องหลังโดยตรง
        html5QrCode.start(
            { facingMode: { exact: "environment" } }, // ระบุให้ใช้กล้องหลัง
            { fps: 10, qrbox: { width: 250, height: 250 } },
            onScanSuccess,
            onScanFailure
        ).catch(err => {
            console.error("Error starting the scanner with back camera: ", err);
        });
    </script>
</body>
</html>
