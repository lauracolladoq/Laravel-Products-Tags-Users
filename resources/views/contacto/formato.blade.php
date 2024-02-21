<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>
        <center>Formulario de contacto</center>
    </h2>
    Enviar por: {{ $nombre }} <br>
    Email de contacto {{ $email }} <br>
    Contenido del mensaje: <br>
    <p>{{ $contenido }}</p>
</body>
</html>
