<!DOCTYPE html>
<html lang="en">
<head>
    <title>Get Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

    <div class="message-alert-container">
        <div class="message-alert-warp-container">
            @if (isset($errors) && count($errors) > 0)
                <div class="alert alert-danger message-alert-div">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('errorOfTransaction'))
                <div class="alert alert-danger message-alert-div">
                    <ul>
                        <li>{{ Session::get('errorOfTransaction') }}</li>
                    </ul>
                </div>
            @endif

            @if ((isset($errorOfTransaction) && !empty($errorOfTransaction)))
                <div class="alert alert-danger message-alert-div">
                    <ul>
                        <li>{{ $errorOfTransaction }}</li>
                    </ul>
                </div>
            @endif

            @if (!empty($successOfTransaction))
                <div class="alert alert-success message-alert-div" style="">
                    <ul>
                        <li>{{ $successOfTransaction }}</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="container-contact100">
        <div class="wrap-contact100">
            <form action="{{ url('payment') }}" class="contact100-form validate-form" method="POST" enctype="multipart/form-data">
                <span class="contact100-form-title">
                    Buy Ticket
                </span>

                <label class="label-input100" for="first-name">Tell us your name *</label>
                <div class="wrap-input100 validate-input" data-validate="Enter valid name">
                    <input id="name" class="input100" type="text" name="name" placeholder="Name" maxlength="255">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="email">Enter your email *</label>
                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input id="email" class="input100" type="email" name="email" placeholder="Eg. example@email.com">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="adhar_no">Enter adhar number</label>
                <div class="wrap-input100 validate-input" data-validate="Enter valid adhar number">
                    <input id="adhar_no" class="input100" type="number" name="adhar_no" placeholder="Eg. 1234 8907 8907">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="mobile_no">Enter mobile number</label>
                <div class="wrap-input100 validate-input" data-validate="Enter valid mobile number">
                    <input id="mobile_no" class="input100" type="number" name="mobile_no" placeholder="Eg.89078 89078">
                    <span class="focus-input100"></span>
                </div>

                <label class="label-input100" for="message">Address *</label>
                <div class="wrap-input100">
                    <textarea id="address" class="input100" name="address" placeholder="Write your address"></textarea>
                    <span class="focus-input100"></span>
                </div>

                <div class="checkbox">
                    <label class="agreed-label">
                      <input
                        type="checkbox"
                        id="agreed"
                        tabindex="1"
                        name="agreed"
                        onchange="document.getElementById('paymentBtn').disabled = !this.checked;" >
                        Are you sure with all terms and conditions for payment?
                    </label>
                </div>

                <div class="container-contact100-form-btn">
                    <button type="submit" class="contact100-form-btn" id="paymentBtn" disabled>Buy Now</button>
                </div>
            </form>

            <div class="contact100-more flex-col-c-m">
                <div class="flex-w size1 p-b-47">
                    <div class="flex-col size2">
                        <span class="txt1 p-b-20">
                            Ticket
                        </span>

                        <span class="txt3">
                            You can generate ticket of price <br><span class="price-symbol">₹ {{ config('app.ticket_price') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>
</body>
</html>
