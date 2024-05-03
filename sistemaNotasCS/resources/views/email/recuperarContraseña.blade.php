<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credenciales</title>
</head>
<body>
    <h1>Enlace para recuperar contraseña</h1>
    <h2>¡Hola {{ $nombre}}!<br> Ingresa a este link para recuperar tu contraseña:</h2>
    <a href="http://127.0.0.1:2002/public/recuperación/{{$usuario}}">http://127.0.0.1:8000/recuperación/{{$usuario}}</a>
</body>
</html>