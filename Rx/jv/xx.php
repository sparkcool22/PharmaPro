<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="padding:16px;background-color:lightgray">
        <h3>A DIV element</h3>
        <p id="myDIV"></p>
        <p>ddddd</p>
    </div>
    <script>
        let h_div2 = document.createElement("input");
        h_div2.value = "lord11111";
        document.body.appendChild(h_div2);

        let h_div = document.createElement("div");
        h_div.innerText = "lord";
        document.body.appendChild(h_div);

        let h_div1 = document.createElement("div");
        h_div1.innerText = "lord11111555555";
        h_div1.setAttribute("style", "font-weight: bold");
        // document.body.appendChild(h_div1);
        document.getElementById("myDIV").appendChild(h_div1);
    </script>
    <br>
    <div id="dv1">JavaScript</div>
    <p id="p1">Node.js</p>
    <script>
        var dv1 = document.getElementById('dv1')
        // var dv2 = document.getElementsByName('dv1')
        let p1 = document.getElementById('p1')
        document.write(dv1).innerText
    </script>


</body>

</html>