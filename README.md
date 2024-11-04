# **Participantes:**
-Maria Jose Giannaccini
-Juan Pablo Chiclana Urraco
![DIAGRAMA](imagen_tablas.png)  

# Descripcion:
Elegimos realizar una pagina de pedidos en un local de comidas rapidas. Va a constar inicialmente de dos tablas: una llamada product, la cual contiene un id de tipo primary, auto incremental; un name, de tipo varchar; un price y una description del producto.
Y una segunda tabla llamada orders, que se relaciona con la tabla producto a traves de su clave foranea id_product. Tambien cuenta con su id de tipo primary auto incremental; una cant_products; un total, que va a definir el total a pagar y una date, de tipo date. 
Agregamos una tecera tabla llamada review donde se muestran las valoraciones de los clientes de los productos. En ella se guarda el id del producto junto con el nombre del Cliente, su valoracion del 1 al 5 y un comentario. Un usuario administrador puede agregar una respuesta a esta review.  

# Pautas para el despliegue de la web:
Tener instalado xampp y encendido Apache y MySQL.
Clonar el repositorio en la carpeta xampp/htdocs.
Crear la base de datos con el nombre pedidos_today (las tablas se crean automaticamente por la implementacion del auto Deploy), o se puede importar la base de datos completa desde phpMyAdmin, el archivo llamado db/pedidos_today.sql
Luego en el browser, ingresar al localhost y dirigirse a la carpeta donde se guardo el repositorio, y de esta forma la pagina se carga y se visualiza.
Para poder realizar las modificaciones en las tablas se debe iniciar sesion, para ello el usuario registrado es: usuario: webadmin contraseña: admin  
  
# Pautas para el uso de la api: 
Para hacer uso de la api debe utilizarse la aplicacion POSTMAN, la cual puede descargarse de esta direccion: https://www.postman.com/downloads/ (debe descargarse al equipo si va a utilizarse en local, es decir desde la propia maquina),
o puede descargarse una extension en visual studio llamada Thunder Client y usarse desde ahi mismo.
Para ingresar informacion para agregar o modificar con POST o PUT puede hacerse agregando los datos a ingresar desde el apartado: body- raw y con el formato JSON, pasando la informaion como un objeto:  ej:

![alt text](image-1.png)  

# A continuacion quedan cargados los endpoint para las diferentes tablas
**Nota:** 
>Tabla reviews  
  
Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/reviews 
Se puede implementar el orden mediante las siguentes maneras: orderBy=score, orderBy=name, orderBy=id_product, por defecto ordena por id.
Se puede elegir el orden: order=desc ó order=asc, por defecto ordena de forma asc.  
Se puede filtrar de las siguientes maneras:   
- name = (name = ); => aqui se tiene en cuenta que la palabra este contenida en el name  
- score = (score = );  
- coment = (coment = ); => aqui se tiene en cuenta que la palabra este contenida dentro del comentario  
- reply = (reply = ); => aqui se tiene en cuenta que la palabra este contenida dentro de la respuesta    
Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/reviews/:id  
Metodo DELETE: /trabajo-web2-Api-Chiclana-Giannaccini/api/reviews/:id  
Metodo PUT: /trabajo-web2-Api-Chiclana-Giannaccini/api/reviews/:id  
Metodo POST /trabajo-web2-Api-Chiclana-Giannaccini/api/reviews   
Los campos que se pueden modificar o agregar son:  
 {  
   "id_product": ..,  
    "client_name": "..",  
    "score": ..,   
    "coment": "..."  
}  

- Si el usuario ingresa un valor de score que esta fuera del rango de valores se lo acomoda a los valores de entre 1 a 5. (si es negativo se setea 1, si es mayor a 5 se setea a 5);
- El campo replay no esta permitido completarlo, ya que solo podria hacerlo el usuario administrador, si lo completa un usuario no autorizado queda vacio.
  
**Nota:** 
>Tabla orders  
  
Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/orders
Se puede implementar el orden mediante las siguentes maneras: orderBy=date, orderBy=total, orderBy=cant_products, por defecto ordena por id.
Se puede eleguir el orden: order=desc ó order=asc, por defecto ordena de forma asc.  
Se puede filtrar de las siguientes maneras: 
- filter_total = (total =)
- filter_cant_products=(cantidad =)
- filter_date = (fecha = "yyyy-mm-dd")
- filter_total_greater = (total >) 
- filter_total_minor =(total <)  
Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/orders/:id
Metodo DELETE: /trabajo-web2-Api-Chiclana-Giannaccini/api/orders/:id
Metodo PUT: /trabajo-web2-Api-Chiclana-Giannaccini/api/orders/:id
Metodo POST /trabajo-web2-Api-Chiclana-Giannaccini/api/orders  
Los campos que se pueden modificar o agregar son:
 {
    "id_product": ..,
    "cant_products": ..,
    "date": "yyyy-mm-dd"
}
  
**Nota:** 
>Tabla products  
  
Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/products
Se puede implementar el orden mediante las siguentes maneras: orderBy=name, orderBy=price, orderBy=id, por defecto ordena por id.
Se puede eleguir el orden: order=desc ó order=asc, por defecto ordena de forma asc.  
Se puede filtrar de las siguientes maneras:   
- name = (name =)   =>  aqui se tiene en cuenta que la palabra este contenida en el nombre  
- price= (price =)  
- description = (description = ) => aqui se tiene en cuenta que la palabra este contenida en la descripcion  
- img = (img = )  => aqui se tiene en cuenta que la palabra este contenida en la url de la imagen, tambien busca por null    
Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/products/:id  
Metodo DELETE: /trabajo-web2-Api-Chiclana-Giannaccini/api/products/:id  
Metodo PUT: /trabajo-web2-Api-Chiclana-Giannaccini/api/products/:id  
Metodo POST /trabajo-web2-Api-Chiclana-Giannaccini/api/products  
Los campos que se pueden modificar o agregar son: 
 {  
        "name": "...",  
        "price": ..,  
        "description": "..",  
        "image_product": ".."   (este campo puede no estar presente y se setea como null)  
}  



