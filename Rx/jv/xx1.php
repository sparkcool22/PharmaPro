<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- <div id="dv1">JavaScript</div>
    <p id="p1">Node.js</p>
    <script>
        var dv1 = document.getElementById('dv1').innerText
        // var dv2 = document.getElementsByName('dv1')
        let p1 = document.getElementById('p1')
        var ss = "ddd"
        document.write(dv1)
    </script>
    <br> -->

    <div id="dv1">
        <span>One</span><br>
        <span>Two</span><br>
        <span>Three</span>
    </div>
    <script type="text/javascript">
        var txt = document.getElementsByTagName('span');
        // for (sp of txt) {
        document.write(txt[1].innerHTML);
        // }
    </script>



</body>

</html>