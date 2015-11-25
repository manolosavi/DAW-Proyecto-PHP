# DAW-Proyecto-PHP


Sistema de login que usa encriptación para guardar las contraseñas en la base de datos. El sistema incluye una forma para registrar usuarios y una para hacer log in.

La base de datos que utiliza el sistema se llama ‘login’ con una tabla llamada ‘users’, y necesita tener un campo llamado ‘username’ [varchar(32)], uno llamado ‘hash’ [varchar(128)], y un id que se incremente automáticamente.


# Como funciona?

Para hacer el registro de un nuevo usuario se usa javascript para checar que los campos sean llenados correctamente, ademas, se usa ajax para que cuando el usuario escriba su username deseado se le informe si debe escoger un usuario diferente si este ya es usado por alguien mas.

Una vez que se verifican los datos, se manda esta información a el controlador php en donde este usa el algoritmo Blowfish para crear un hash de la contraseña junto con un “random salt”. El hash que se obtiene es el que se guarda en la base de datos junto con el nombre de usuario.

Para hacer log in, se usa el nombre de usuario para obtener el hash del mismo. Después se utiliza este hash como el “salt” para el algoritmo junto con la contraseña ingresada y se compara el hash obtenido con el hash de la base de datos, si estos son iguales significa que la contraseña ingresada fue correcta, y se utilizan cookies para mantener al usuario conectado con su cuenta por un periodo de tiempo limitado.