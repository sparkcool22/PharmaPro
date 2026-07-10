<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Regist Equipment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./public/">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="alte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="alte/dist/css/adminlte.min.css">
    <!-- BS5 -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/customCSS/siwadolCUSTOM.css">


    <!--Style ตาราง -->
    <link rel="stylesheet" href="alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!--Bootsratp icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <style media="screen">
   
    body {
        color: white;
        font-family: 'Prompt', sans-serif;
        background-image: url('img/realTipco.jpg');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        padding-bottom: 30px;
    }
    
    

    
    </style>
</head>

<body>
    
        <div class='container vh-100 d-flex justify-content-center align-content-center'>
            <div class='row justify-content-center align-content-center'>
                <div class='col-12 rounded' style="background-color:rgba(0,0,0,0);">
                    <h5></h5>

                    <div class="row my-4 gx-5 gy-2">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a class="card shadow-sm text-white shadow-sm cardActionRegister" href="./formpage/sap_list.php">
                                <img src="./img/nonSAP_R.jpg" class="card-img" style="max-height: 400px;" alt="nonSAP_R">
                                <div class="card-img-overlay d-flex flex-column">
                                    <h5 class="card-title mt-auto ms-3 fw-bold">Register with SAP's Data</h5>
                                    <h6 class="ms-3">For equipment's data is on SAP, select this.</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <a class="card shadow-sm text-white shadow-sm noClick cardActionRegister" href="#">
                                <img src="./img/SAP_R.jpg" class="card-img" style="max-height: 400px;" alt="SAP_R">
                                <div class="card-img-overlay d-flex flex-column">
                                    <h5 class="card-title mt-auto ms-3 fw-bold">Register non-SAP<sup>WIP</sup></h5>
                                    <h6 class="ms-3">For equipment's data <span class="fw-bold">IS NOT</span> on
                                        SAP, select this. (New)</h6>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    


    <script src="formpage/jquery-1.9.1.min.js.download"></script>
    <script src="./bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    
    
    
</body>

</html>