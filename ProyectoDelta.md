# Proyecto Delta

¿Que es Delta? Delta es una pagina de distribución de articulos de segunda mano donde los usuarios pueden vender y comprar productos, asi como valorar a los distintos vendedores (usuarios) a los que compren.


## Funcionamiento basico

 ### ¿Quien puede comprar articulos?

    -Los usuarios registrados son los que podrán tanto *comprar* como *vender* productos
    -Los usuarios no registrados unicamente podran ver los articulos pero no comprarlos
    
    Esto quiere decir que todos los usuarios tienen acceso a gran parte de las vistas de la pagina
    menos a las reservadas de administración que seran exclusivas para los usuarios registrados

 ### Carrito

    - 1 Carrito pertenece a un usuario SIEMPRE, el carrito dejará de exisitir solo si el mismo usuario deja de existir (eliminación de cuenta)
    - Los usuarios no registrados podrán acceder al carrito y añadir articulos pero NO podrán proceder con el pago.

 ### Favoritos

    -UNICAMENTE los usuarios registrados podrán tener una lista de articulos favoritos.

 ### Comentarios
    
    -Los usuarios registrados podrán realizar comentarios sobre otros usuariós si y solo si el mismo ha comprado un articulo del vendedor a valorar
    -Los usuarios no registrados UNICAMENTE podrán ver comentarios
    -Si el usuario no ha comprado un articulo del vendedor a valorar, no podrá realizar comentarios

 
