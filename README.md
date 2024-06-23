# https://markdown.es/sintaxis-markdown/
## Índice
1. [AutoApiController](#documentación-autopicontroller)
    - [Función `getAll()`](#función-getall)
    - [Función `getAllDESC()`](#función-getalldesc)
    - [Función `getAuto()`](#función-getauto)
    - [Función `addAuto()`](#función-addauto)
    - [Función `borrarAuto()`](#función-borrarauto)
    - [Función `autoVendido()`](#función-autovendido)
    - [Función `getAllxMarca()`](#función-getallxmarca)
    - [Función `editarVehiculo()`](#función-editarvehiculo)

2. [MarcaApiController](#documentacion-marcaapicontroller)
    - [Funcion `getAll()`](#funcion-getall)
    - [Funcion `getAllDESC()`](#funcion-getalldesc)
    - [Funcion `getMarca()`](#funcion-getmarca)
    - [Funcion `addMarca()`](#funcion-addmarca)
    - [Funcion `borrarMarca()`](#funcion-borrarmarca)
    - [Funcion `editarMarca()`](#funcion-editarmarca)


3. [UserApiController](#documentación-userapicontroller)
    - [Función `getAllUsers()`](#función-getallusers)
    - [Funcion `getAllASC()`](#funcion-getallasc)
    - [Función `getUsuario()`](#función-getusuario)
    - [Función `deleteUser()`](#función-deletuser)

3. [Requisitos y notas adicionales](#requisitos-y-notas-adicionales)

___

# Documentación `AutoApiController`
## Introducción
Esta API permite gestionar una colección de vehículos. Se puede obtener información sobre todos los vehículos, obtener un vehículo específico por su ID, agregar nuevos vehículos, borrar vehículos existentes, marcar un vehículo como vendido, obtener todos los vehículos de una marca específica y editar la información de un vehículo.
## Función `getAll()`

### Descripción
Obtiene una lista de todos los vehículos.

### CÓDIGO:

```php
public function getAll() {
        try {
            // Obtener todos los autos del modelo
            $vehicles = $this->model->getAll();
            if ($vehicles) {
                $response = [
                    "status" => 200,
                    "data" => $vehicles
                ];
                // Si hay autos, devolverlas con un código 200 (éxito)
                $this->view->response($response, 200);
            } else {
                // Si no hay autos, devolver un mensaje con un código 404
                $this->view->response("No hay autos en la base de datos", 404);
            }
        } catch (Exception) {
            $this->view->response("Error de servidor", 500);
        }
    }
```


### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los vehiculos.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay autos en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay autos en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener los autos.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);
```


## Ejemplos de uso `localhost/TPE_WEB2_API/api/autos`
### Ejemplo 1: Obtención exitosa de Vehiculos

Si hay vehiculos en la base de datos, la función enviará una respuesta con código 200 y las tareas en formato JSON:
```json
{
    "status": 200,
    "data": [ ... ] // Lista de vehículos
}

```

### Ejemplo 2: Vehiculos no encontrados

Si no existen vehiculos en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No hay autos en la base de datos"
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___




## Función `getAllDESC()`

### Descripción
La función `getAllDESC` del controlador obtiene todos los vehiculos  de la base de datos y envía una respuesta de todos los vehiculos ordenados de forma DESCENDENTE por ID.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
public function getAllDESC() {
        try {
            // Obtener todos los autos del modelo
            $vehicles = $this->model->getAllDESC();
            if ($vehicles) {
                $response = [
                    "status" => 200,
                    "data" => $vehicles
                ];
                // Si hay autos, devolverlas con un código 200 (éxito)
                $this->view->response($response, 200);
            } else {
                // Si no hay autos, devolver un mensaje con un código 404
                $this->view->response("No hay autos en la base de datos", 404);
            }
        } catch (Exception) {
            $this->view->response("Error de servidor", 500);
        }
    }
```


### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los vehiculos ordenados descentemente.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay autos en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay autos en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener los autos.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);
```

## Ejemplos de uso `localhost/TPE_WEB2_API/api/autosDESC`
### Ejemplo 1: Obtención exitosa de Vehiculos

Si hay vehiculos en la base de datos, la función enviará una respuesta con código 200 y las tareas en formato JSON:
```json
{
    "status": 200,
    "data": [ ... ] // Lista de vehículos ordenados descendentemente
}

```

### Ejemplo 2: Vehiculos no encontrados

Si no existen vehiculos en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No hay autos en la base de datos"
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil   para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___

## Función `getAuto()`

### Descripción
La función `getAuto` del controlador obtiene un vehiculo específico de la base de datos y envía una respuesta adecuada al cliente basado en el resultado.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
 public function getAuto($params = null) {
        $id = $params[':ID'];
        try {
            $vehicle = $this->model->get($id);
            if($vehicle){
                $response = [
                "status" => 200,
                "message" => $vehicle
               ];
                $this->view->response($response, 200);

            }
            else{
                $response = [
                    "status" => 404,
                    "message" => "No existe el auto en la base de datos."
                ];
                $this->view->response($response, 404);

            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }

    }  
 
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador del vehiculo que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los vehiculos ordenados descentemente.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay autos en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay autos en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener los autos.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);
```

## Ejemplos de uso `localhost/TPE_WEB2_API/api/auto`
### Ejemplo 1: Obtención exitosa del Vehiculo

Si el vehiculo con el ID proporcionado existe, la función enviará una respuesta con código 200 y la tarea en formato JSON:
```json
{
    "status": 200,
    "message": { ... } // Información del vehículo
}

```

### Ejemplo 2: Tarea no encontradas

Si no existe una tarea con el ID proporcionado, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No existe el auto en la base de datos."
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil   para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___

## Función `addAuto()`

### Descripción
La función `addAuto` del controlador crea un nuevo vehiculo pasandole todos la descripcion del mismo.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
 public function getAuto($params = null) {
        $id = $params[':ID'];
        try {
            $vehicle = $this->model->get($id);
            if($vehicle){
                $response = [
                "status" => 200,
                "message" => $vehicle
               ];
                $this->view->response($response, 200);

            }
            else{
                $response = [
                    "status" => 404,
                    "message" => "No existe el auto en la base de datos."
                ];
                $this->view->response($response, 404);

            }
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
        }

    }  
 
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador del vehiculo que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los vehiculos ordenados descentemente.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay autos en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay autos en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener los autos.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);
```

## Ejemplos de uso `localhost/TPE_WEB2_API/api/auto`
### Ejemplo 1: Obtención exitosa del Vehiculo

Si el vehiculo con el ID proporcionado existe, la función enviará una respuesta con código 200 y la tarea en formato JSON:
```json
{
    "status": 200,
    "message": { ... } // Información del vehículo
}

```

### Ejemplo 2: Tarea no encontradas

Si no existe una tarea con el ID proporcionado, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No existe el auto en la base de datos."
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil   para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___



## Función `getAllxMarca()`

### Descripción
La función `getAllxMarca` del controlador   trae todos los autos que tengan el mismo id que la marca

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
 public function getAllxMarca($params = null){
        $id = $params[':ID'];
        $vehicles= $this->model->getAllByMarca($id);
        try {
            if($vehicles){
                $response = [
                    "status" => 200,
                    "data" => $vehicles
                ];
                $this->view->response($vehicles, 200);
       
            }else
                $this->view->response("No hay autos en la base de datos", 404);
        
           
        } catch (Exception $e) {
            $this->view->response("Error de servidor", 500);
            }
    }  
 
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador del vehiculo que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los vehiculos ordenados descentemente.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay autos en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay autos en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener los autos.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);
```

## Ejemplos de uso 'localhost/TPE_WEB2_API/api/autos/2'
### Ejemplo 1: Obtención exitosa del Vehiculo

Si el vehiculo con el id_marca proporcionado existe, la función enviará una respuesta con código 200 y el auto en formato JSON:
```json
{
    "status": 200,
    "message": { ... } // Información del vehículo
}

```

### Ejemplo 2: si el id no existe no encontradas

Si no existe una tarea con el ID proporcionado, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No existe el auto en la base de datos."
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil   para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___


# Documentación `UserApiController`
## Introducción
La clase UserApiController permite la gestión de usuarios a través de una API. Facilita la obtención de todos los usuarios, la obtención de un usuario específico por su ID, la adición de nuevos usuarios, la eliminación de usuarios existentes y la actualización de información de usuarios. La clase utiliza un modelo para interactuar con la base de datos y una vista para devolver respuestas en formato JSON.

## Función `getAllUsers()`
### Descripción
En esta función, se obtienen todos los usuarios existentes en la base de datos.

### CÓDIGO:
```php
        public function getAll() {
            try {
                // Obtener todos los usuarios del modelo
                $users = $this->model->getAll();
                if ($users) {
                    $response = [
                        "status" => 200,
                        "data" => $users
                    ];
                    // Si hay usuarios, devolverlos con un código 200 (éxito)
                    $this->view->response($response, 200);
                } else {
                    // Si no hay usuarios, devolver un mensaje con un código 404
                    $this->view->response("No hay usuarios en la base de datos", 404);
                }
            } catch (Exception) {
                $this->view->response("Error de servidor", 500);
            }
        }
```
## Ejemplos de uso `localhost/TPE_WEB2_API/api/usuarios`

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los usuarios.

### CÓDIGO:
```php
$this->view->response($marcas, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay usuarios en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay usuarios en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener las marcas.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);

```
Si hay marcas en la base de datos, la función enviará una respuesta con código 200 y las tareas en formato JSON:
```json
{
    "status": 200,
    "data": [ ... ] // Lista de usuarios
}

```

### Ejemplo 2: Usuarios no encontrados

Si no existen marcas en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No hay usuarios en la base de datos"
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

## Función `getAllASC()`

### Descripción
Esta función está dedicada a la peticion de todos los usuarios existentes en la base de datos, pero de forma ascendente. Para ello se necesita el ID.

### CÓDIGO:
```php
        public function getAllASC() {
            try {
                // Obtener todos los usuarios del modelo
                $users = $this->model->getAllASC();
                if ($users) {
                    $response = [
                        "status" => 200,
                        "data" => $users
                    ];
                    // Si hay usuarios, devolverlos con un código 200 (éxito)
                    $this->view->response($response, 200);
                } else {
                    // Si no hay usuarios, devolver un mensaje con un código 404
                    $this->view->response("No hay usuarios en la base de datos", 404);
                }
            } catch (Exception) {
                $this->view->response("Error de servidor", 500);
            }
        }
```
## Ejemplos de uso `localhost/TPE_WEB2_API/api/usuariosASC`

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los usuarios de forma ascendente.

### CÓDIGO:
```php
$this->view->response($marcas, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay usuarios en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay usuarios en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener las marcas.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);

```
Si hay marcas en la base de datos, la función enviará una respuesta con código 200 y las tareas en formato JSON:
```json
{
    "status": 200,
    "data": [ ... ] // Lista de usuarios
}

```

### Ejemplo 2: Usuarios no encontrados

Si no existen marcas en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No hay usuarios en la base de datos"
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

## Función `getUsuario()`
### Descripción
En esta función, se obtiene un usuario en especifico de la base de datos. Para ello se requiere especificar en la URL el ID.

### CÓDIGO:
```php
        public function getUsuario($params = null) {
            $id = $params[':ID'];
            try {
                $usuario = $this->model->get($id);
                if($usuario){
                    $response = [
                    "status" => 200,
                    "message" => $usuario
                   ];
                    $this->view->response($response, 200);
    
                }
                else{
                    $response = [
                        "status" => 404,
                        "message" => "No existe el usuario en  la base de datos."
                    ];
                    $this->view->response($response, 404);
    
                }
            } catch (Exception $e) {
                $this->view->response("Error de servidor", 500);
            }
    
        }  
```
## Ejemplos de uso `localhost/TPE_WEB2_API/api/usuario/:ID`

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajero el usuario.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no existe el usuario en la base de datos.

### CÓDIGO:
```php
$this->view->response("No existe el usuario en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener las marcas.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);

```
Si hay usuarios en la base de datos, la función enviará una respuesta con código 200 y las tareas en formato JSON:
```json
{
    "status": 200,
    "data": [ ... ] // Muestra el usuario especifico
}

```

### Ejemplo 2: Usuarios no encontrados

Si no existen usuarios en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No hay existe el usuario en la base de datos"
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```
## Función `deleteUser()`

### Descripción
Como resultado de esta funcion, se elimina un usuario en especifico. Para ello, se necesita especificar en la URL el ID.

### CÓDIGO:
```php
    public function deleteUser($params = null) {
        $id = $params[':ID'];
    
        $usuario = $this->model->get($id);
        if ($usuario) {
            $this->model->delete($id);

            $this->view->response("usuario $id, eliminado", 200);
        } else {
            $this->view->response("usuario $id, no encontrado", 404);
        }
    }
```
## Ejemplos de uso `localhost/TPE_WEB2_API/api/usuario/:ID`

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajero el usuario.

### CÓDIGO:
```php
$this->view->response("usuario $id eliminado", 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no existe el usuario en la base de datos.

### CÓDIGO:
```php
$this->view->response("usuario $id, no encontrado", 404);
```


## Requisitos y notas adicionales
- Modelo de tarea debe implementar los siguientes métodos `getTasks`, `getTask`.
- Modelo de usuario debe implementar los siguientes métodos `getAllUsers`, `getUser`.
- Vista que implemente el método `response`.
