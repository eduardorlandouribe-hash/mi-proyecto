<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Campus Virtual</title>
<link rel="stylesheet" href="{{ asset('css/campus.css') }}">
</head>
<body>

<div class="container">
<div class="box">
<h2 >Login</h2>
<form method="POST" action="{{ route('login') }}">
@csrf
<input type="email" name="email" placeholder="Correo electrónico">
<input type="password" name="password" placeholder="Contraseña">
<button type="submit">Entrar</button>
<p>¿No tienes cuenta? <a href="{{ route('register') }}">Registrarse</a></p>
</form>


</div>
</div>
</body>
</html>