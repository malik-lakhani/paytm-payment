<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ticket</title>
  </head>
  <body>
    <div>
      Ticket Id: {{ $data['uniqueId'] }}
    </div>
  </body>
</html>
