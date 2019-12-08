/* Crea la tabla para almacenar perros en la Base de Datos. 
 *
 * Cada perro tiene los siguientes campos:
 * --> id. La ID de la tabla.
 * --> name. La raza del perro.
 * --> imagen. El link con la imagen del perro.
 * --> likes. El número de likes del perro.
 */
CREATE TABLE `dogs` (
    /* La ID se incrementa conforme se agregan más perros a la BD. */
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `name` varchar(255) NOT NULL,
    `imagen` varchar(255) NOT NULL,
    `likes` varchar(255) NOT NULL 
)