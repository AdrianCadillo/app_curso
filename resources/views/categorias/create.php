<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear categorias</title>
</head>
<body>
   
    <form action="http://localhost/app_curso/categoria/save" method="post">
        <!--<input type="hidden" name="token_" value="{{$this->Csrf_Token()}}">--> 
        
        <?php echo $this->Csrf() ?>

        <input type="text" name="nombres">
        <br>
        <input type="text" name="apellidos">
        <br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>