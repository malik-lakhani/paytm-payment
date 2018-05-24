<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    font-family: Arial;
}

.coupon {
    border: 5px dotted #bbb;
    width: 80%;
    border-radius: 15px;
    margin: 0 auto;
    max-width: 600px;
}

.container {
    padding: 2px 16px;
    background-color: #f1f1f1;
}

</style>
</head>
<body>

<div class="coupon">
  <div class="container">
    <h3>Ticket: {{ $data['uniqueId'] }}</h3>
  </div>
  <div class="container" style="background-color:white">
    <h2><b>Thank you for your order.</b></h2>
    <p>Your order has been received and is now being processed. Your order detail are shown below for your reference:</p>
    <h3>Order Detail:</h3>
    <p>
      OrderId: {{ $data['orderId'] }}<br><br>
      OrderDate: {{ $data['orderDate'] }}<br><br>
    </p>
    <h3>Customer Detail:</h3>
    <p>
      Name: {{ $data['name'] }}<br><br>
      Email: {{ $data['toEmail'] }}<br><br>
      Mobile No: {{ $data['mobile_no'] }}<br><br>
      Adhar No: {{ $data['adhar_no'] }}<br><br>
    </p>
  </div>
  <div class="container">
    <p>Your ticket price: <strong><span style='font-family:DejaVu Sans;'>₹</span> {{ $data['price'] }}</strong></p>
  </div>
</div>

</body>
</html>

</html>
