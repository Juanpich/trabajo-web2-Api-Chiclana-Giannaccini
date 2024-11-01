# **Participantes:**
-Maria Jose Giannaccini
-Juan Pablo Chiclana Urraco
![DIAGRAMA](imagen_tablas.png)  

# Descripcion:
Elegimos realizar una pagina de pedidos en un local de comidas rapidas. Va a constar inicialmente de dos tablas: una llamada product, la cual contiene un id de tipo primary, auto incremental; un name, de tipo varchar; un price y una description del producto.
Y una segunda tabla llamada orders, que se relaciona con la tabla producto a traves de su clave foranea id_product. Tambien cuenta con su id de tipo primary auto incremental; una cant_products; un total, que va a definir el total a pagar y una date, de tipo date. 

# Pautas para el despliegue de la web:
- Tener instalado xampp y encendido Apache y MySQL.
- Clonar el repositorio en la carpeta xampp/htdocs.
- Crear la base de datos con el nombre pedidos_today (las tablas se crean automaticamente por la implementacion del auto Deploy), o se puede importar la base de datos completa desde phpMyAdmin, el archivo llamado db/pedidos_today.sql 
- Luego en el browser, ingresar al localhost y dirigirse a la carpeta donde se guardo el repositorio, y de esta forma la pagina se carga y se visualiza.
- Para poder realizar las modificaciones en las tablas se debe iniciar sesion, para ello el usuario registrado es:
usuario: webadmin
contraseña: admin
# A continuacion quedan cargados los endpoint para las diferentes tablas
**Nota:** 
>Tabla reviews

Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/reviews 
Se puede implementar el orden mediante las siguentes maneras: orderBy=score, orderBy=name, orderBy=id_product, por defecto ordena por id.
Se puede eleguir el orden: order=desc ó order=asc, por defecto ordena de forma asc.

**Nota:** 
>Tabla orders

Metodo GET: /trabajo-web2-Api-Chiclana-Giannaccini/api/orders
Se puede implementar el orden mediante las siguentes maneras: orderBy=date, orderBy=total, orderBy=cant_products, por defecto ordena por id.
Se puede eleguir el orden: order=desc ó order=asc, por defecto ordena de forma asc.
Se puede filtrar de las siguientes maneras: 
-filter_total = (total =)
-filter_cant_products=(cantidad =)
-filter_date = (fecha = "yyyy-mm-dd")
-filter_total_greater = (total >) 
-filter_total_minor =(total <)
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

# endpoint   
**Nota:**   
>/trabajo-web2-Api-Chiclana-Giannaccini/api/reviews?orderBy=score  
> Ej filtrar por dos campos: http://localhost/.../api/reviews?filter_reply=gracias&filter_name=juan  

Filtros: orderBy = ordena;  
         filter_name = filtra por nombre;  
         filter_score = filtra por puntaje;  
         filter_word = filtra por palabra en las reseñas;  
         filter_reply = filtra por palabra en la las respuestas;

