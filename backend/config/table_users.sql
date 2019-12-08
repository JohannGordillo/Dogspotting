/* Crea la tabla para almacenar usuarios en la Base de Datos. 
 *
 * Cada usuario tiene los siguientes campos:
 * --> id. Su identificación.
 * --> username. El nombre de usuario.
 * --> password. Su contraseña.
 */
CREATE TABLE `users` (
    /* La ID se incrementa conforme se agregan más usuarios a la BD. */
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `apikey` varchar(255) NOT NULL 
)