<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <div>
        <p>Hello,<br></p>
        <p>You have request password reset.
            <br>Code that you got lasts until <strong>{{$time_expire}}</strong>. Please use it to reset your password on following link<br>
        </p>
        <strong>CODE FOR RESETING PASSWORD: </strong>{{$code}}<br />
        <strong>Link FOR RESETING PASSWORD: </strong>{{$link}}<br />        
    </div>
</body>

</html>
