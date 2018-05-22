<!DOCTYPE html>
<html lang="en">
<head>
    <title>Get Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

    @if (isset($errors) && count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (Session::has('errorOfTransaction'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ Session::get('errorOfTransaction') }}</li>
            </ul>
        </div>
    @endif

    @if ((isset($errorOfTransaction) && !empty($errorOfTransaction)))
        <div class="alert alert-danger">
            <ul>
                <li>{{ $errorOfTransaction }}</li>
            </ul>
        </div>
    @endif

    @if (!empty($successOfTransaction))
        <div class="alert alert-success" style="">
            <ul>
                <li>{{ $successOfTransaction }}</li>
            </ul>
        </div>
    @endif

    <div class="container-contact100">
        <div class="wrap-contact100">
            <form action="{{ url('payment') }}" class="contact100-form validate-form" method="POST" enctype="multipart/form-data">
                <span class="contact100-form-title">
                    Registration
                </span>

                <label class="label-input100" for="first-name">Tell us your name *</label>
                <div class="wrap-input100 validate-input" data-validate="Type name">
                    <input id="name" class="input100" type="text" name="name" placeholder="Name">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="email">Enter your email *</label>
                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input id="email" class="input100" type="text" name="email" placeholder="Eg. example@email.com">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="phone">Enter adhar number</label>
                <div class="wrap-input100 validate-input" data-validate="Type valid adhar number">
                    <input id="adhar_no" class="input100" type="number" name="adhar_no" placeholder="Eg. 1234 8907 8907">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="phone">Enter mobile number</label>
                <div class="wrap-input100 validate-input" data-validate="Type mobile number">
                    <input id="mobile_no" class="input100" type="number" name="mobile_no" placeholder="Eg. +91 89078 89078">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="message">Address *</label>
                <div class="wrap-input100 validate-input" data-validate = "Address is required">
                    <textarea id="address" class="input100" name="address" placeholder="Write your address"></textarea>
                    <span class="focus-input100"></span>
                </div>

                <div class="container-contact100-form-btn">
                    <button type="submit" class="contact100-form-btn" >Pay to PatTM</button>
                </div>
            </form>

            <div class="contact100-more flex-col-c-m" style="background-image: url('images/bg-01.jpg');">
                <div class="flex-w size1 p-b-47">
                    <div class="flex-col size2">
                        <span class="txt1 p-b-20">
                            Ticket
                        </span>

                        <span class="txt3">
                            You can generate ticket of price {{ config('app.ticket_price') }} /-
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="dropDownSelect1"></div>

<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <script>
        $(".selection-2").select2({
            minimumResultsForSearch: 20,
            dropdownParent: $('#dropDownSelect1')
        });
    </script>
<!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-23581568-13');
    </script>
</body>
</html>
