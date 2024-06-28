# https://markdown.es/sintaxis-markdown/
## Índice
1. [AutoApiController](#documentación-autopicontroller)
    - [Función `getAll()`](#función-getall)
    - [Función `getAuto()`](#función-getauto)
    - [Función `addAuto()`](#función-addauto)
    - [Función `borrarAuto()`](#función-borrarauto)
    - [Función `autoVendido()`](#función-autovendido)
    - [Función `editarVehiculo()`](#función-editarvehiculo)

2. [MarcaApiController](#documentacion-marcaapicontroller)
    - [Funcion `getAll()`](#funcion-getall)
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

## Endpoints

## Función `getAll()`

### Descripción
Obtiene una lista de todos los vehículos existentes en la base de datos.

### Obtener todos los vehículos
- URL: localhost/TPE_WEB2_API/api/autos
- Método: GET

#### Parámetros:
- direccion (opcional): Orden de los resultados. Puede ser ASC (ascendente, valor predeterminado) o DESC (descendente).
- id_auto (opcional): Filtrar por ID del vehículo.
- marca (opcional): Filtrar por marca del vehículo.
- precio (opcional): Filtrar por precio del vehículo.
- anio (opcional): Filtrar por año del vehículo.
- modelo (opcional): Filtrar por modelo del vehículo.
- color (opcional): Filtrar por color del vehículo.

#### Respuestas:
- 200 OK: Lista de vehículos.
- 404 Not Found: No hay vehículos en la base de datos.


## Función `getAuto()`

### Descripción
La función `getAuto` del controlador obtiene un vehiculo específico de la base de datos, para ello, se necesita especificarle el ID.

### Obtener un vehículo por ID
- URL: localhost/TPE_WEB2_API/api/autos?id_auto=1
- Método: GET

#### Parámetros:
- ID (obligatorio): ID del vehículo.

#### Respuestas:
- 200 OK: Información del vehículo.
- 404 Not Found: No existe el vehículo en la base de datos.

## Función `addAuto()`

### Descripción
La función `addAuto` del controlador crea un nuevo vehiculo pasandole toda la descripcion del mismo en formato JSON.

### Agregar un vehículo
- URL: localhost/TPE_WEB2_API/api/autos
- Método: POST
- Cuerpo:
```json
{
  "modelo": "string", //Cadena
  "anio": "integer", //Entero
  "precio": "float", //Decimal
  "color": "string", //Cadena
  "id_marca": "integer" //Entero
}
```
#### Respuestas:
- 201 Created: Vehículo agregado exitosamente.
- 500 Internal Server Error: Error al insertar el registro.

## Función `borrarAuto()`

### Descripción
Como resultado de esta funcion, se elimina un vehiculo en especifico. Para ello, se necesita especificar en la URL el ID.

### Eliminar un vehículo
- URL: localhost/TPE_WEB2_API/api/autos/1
- Método: DELETE

#### Parámetros:
- ID (obligatorio): ID del vehículo.

#### Respuestas:
- 200 OK: Vehículo eliminado exitosamente.
- 404 Not Found: Vehículo no encontrado.


## Función `autoVendido()`

### Descripción
Como resultado de esta función, se edita el atributo "vendido" del vehiculo, se realiza cambiando el valor booleando a 1, siendo 0 "no vendido" y 1 "vendido". Se necesita especificar el ID en la URL.

### Marcar un vehículo como vendido
- URL: localhost/TPE_WEB2_API/api/autos/1
- Método: PUT

#### Parámetros:
- ID (obligatorio): ID del vehículo.

#### Respuestas:
- 201 Created: Vehículo marcado como vendido.
- 400 Bad Request: Vehículo no encontrado.

## Función `editarVehiculo()`

### Descripción
Como resultado de esta función, se edita la totalidad de los atributos del vehiculo y se actualiza en la base de datos. Se necesita especificar el ID en la URL.

### Editar un vehículo
- URL: localhost/TPE_WEB2_API/api/autos/1
- Método: PUT

#### Parámetros:
- ID (obligatorio): ID del vehículo.
- Cuerpo para mandar la solicitud:
```json
{
  "modelo": "string", //Cadena
  "anio": "integer", //Entero
  "precio": "float", //Decimal
  "color": "string", //Cadena
  "vendido": "boolean" //Verdadero o falso (0 es no vendido y 1 es vendido)
}
```
#### Respuestas:
- 201 Created: Vehículo actualizado exitosamente.
- 400 Bad Request: Vehículo no encontrado.
- 500 Internal Server Error: Error al actualizar el vehículo.

# Uso con Postman
Para probar esta API con Postman, necesitas tener instalado el XAMPP y tener tu proyecto guardado en la carpeta HTDOCS:

- Obtener todos los vehículos: Crear una nueva solicitud GET a localhost/TPE_WEB2_API/api/autos.

- Obtener un vehículo por ID: Crear una nueva solicitud GET a localhost/TPE_WEB2_API/api/autos?id_auto=1, reemplazando 1 con el ID del vehículo que quieras obtener de la base de datos.

- Agregar un vehículo: Crear una nueva solicitud POST a localhost/TPE_WEB2_API/api/autos y agregar el JSON del cuerpo de la solicitud como se mostró anteriormente.

- Eliminar un vehículo: Crear una nueva solicitud DELETE a localhost/TPE_WEB2_API/api/autos/1, reemplazando 1 con el ID del vehículo que se desea eliminar.

- Marcar un vehículo como vendido: Crear una nueva solicitud PUT a localhost/TPE_WEB2_API/api/autos/1, reemplazando 1 con el ID del vehículo.

- Editar un vehículo: Crear una nueva solicitud PUT a localhost/TPE_WEB2_API/api/autos/1, reemplazando 1 con el ID del vehículo y agregar el JSON del cuerpo de la solicitud para enviar la edición del vehiculo a la base de datos.


# Documentación `MarcaApiController`
## Introducción
Esta API permite gestionar una colección de marcas. Se puede obtener información sobre todas las marcas, obtener una marca específica por su ID, por su pais de origen o año de fundación, agregar nuevas marcas y borrar marcas existentes.

## Función `getAll()`

### Descripción
Obtiene una lista de todos los vehículos existentes en la base de datos.

## Endpoints

### Obtener todas las marcas
- URL: localhost/TPE_WEB2_API/api/marcas
- Método: GET

#### Parámetros:
- direccion (opcional): Orden de los resultados. Puede ser ASC (ascendente, valor predeterminado) o DESC (descendente).
- id_marca (opcional): Filtrar por ID de la marca.
- nombre (opcional): Filtrar por nombre de la marca.
- origen (opcional): Filtrar por país de origen de la marca.
- año (opcional): Filtrar por año de fundación de la marca.

#### Respuestas:
- 200 OK: Lista de marcas.
- 404 Not Found: No hay marcas en la base de datos.

## Función `getMarca()`

### Descripción
La función `getMarca` del controlador obtiene una marca específica de la base de datos, para ello, se necesita especificarle el ID.

### Obtener una marca por ID
- URL: localhost/TPE_WEB2_API/api/marca/1
- Método: GET

#### Parámetros:
- ID (obligatorio): ID de la marca.

#### Respuestas:
200 OK: Información de la marca.
404 Not Found: No existe la marca en la base de datos.

## Función `addMarca()`

### Descripción
La función `addMarca` del controlador crea una nueva marca pasandole toda la descripcion de la misma en formato JSON.

### Agregar una marca
- URL: localhost/TPE_WEB2_API/api/marca
- Método: POST
- Cuerpo:
```json
{
  "nombre": "string", //Cadena
  "pais_de_origen": "string", //Cadena
  "ano_de_fundacion": "integer", //Entero
  "descripcion": "string" //Cadena
}
```
#### Respuestas:
- 200 OK: Marca agregada exitosamente.
- 500 Internal Server Error: Error al insertar el registro.

## Función `borrarMarca()`

### Descripción
Como resultado de esta funcion, se elimina una marca en especifico. Para ello, se necesita especificar en la URL el ID.

### Eliminar una marca
- URL: localhost/TPE_WEB2_API/api/marca/1
- Método: DELETE

#### Parámetros:
- ID (obligatorio): ID de la marca.

#### Respuestas:
- 200 OK: Marca eliminada exitosamente.
- 404 Not Found: Marca no encontrada.

## Función `editarMarca()`

### Descripción
Como resultado de esta función, se edita la totalidad de los atributos de la marca y se actualiza en la base de datos. Se necesita especificar el ID en la URL.

### Editar una marca
- URL: /marcas/:ID
- Método: PUT

#### Parámetros:
- ID (obligatorio): ID de la marca.
- Cuerpo:
```json
{
  "nombre": "string",
  "pais_de_origen": "string",
  "ano_de_fundacion": "integer",
  "descripcion": "string"
}
```
#### Respuestas:
- 200 OK: Marca actualizada exitosamente.
- 404 Not Found: Marca no encontrada.
- 500 Internal Server Error: Error al actualizar la marca.

# Uso con Postman
Para probar esta API con Postman, necesitas tener instalado el XAMPP y tener tu proyecto guardado en la carpeta HTDOCS:

- Obtener todas las marcas: Crear una nueva solicitud GET a localhost/TPE_WEB2_API/api/marcas.

- Obtener una marca por ID: Crear una nueva solicitud GET a localhost/TPE_WEB2_API/api/marca/1, reemplazando 1 con el ID de la marca.

- Agregar una marca: Crear una nueva solicitud POST a localhost/TPE_WEB2_API/api/marca y agregar el JSON del cuerpo de la solicitud.

- Eliminar una marca: Crear una nueva solicitud DELETE a localhost/TPE_WEB2_API/api/marca/1, reemplazando 1 con el ID de la marca.

- Editar una marca: Crear una nueva solicitud PUT a localhost/TPE_WEB2_API/api/editMarca/1, reemplazando 1 con el ID de la marca y agregar el JSON del cuerpo de la solicitud.



# Documentación `UserApiController`
## Introducción
La clase UserApiController permite la gestión de usuarios a través de una API. Facilita la obtención de todos los usuarios, la obtención de un usuario específico por su ID, la adición de nuevos usuarios, la eliminación de usuarios existentes y la actualización de inseformación de usuarios. La clase utiliza un modelo para interactuar con la base de datos y una vista para devolver respuestas en formato JSON.

## Función `getAllUsers()`
### Descripción
En esta función,  obtienen todos los usuarios existentes en la base de datos.


## Función `getAllASC()`

### Descripción
Esta función está dedicada a la peticion de todos los usuarios existentes en la base de datos, pero de forma ascendente. Para ello se necesita el ID.


## Función `getUsuario()`
### Descripción
En esta función, se obtiene un usuario en especifico de la base de datos. Para ello se requiere especificar en la URL el ID.





