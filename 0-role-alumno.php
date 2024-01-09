<?php
/**
 * Plugin Name: 000 Creador role Alumno
 * Plugin URI: https://webyblog.es/
 * Description: Crea y gestiona un rol de usuario 'alumno' con capacidades definidas dentro del plugin. Actualmente solo tiene la capacidad de lectura que es la misma que la del role suscriptor. Al activar el plugin se crea el role alumno con la capacidad de lectura, luego puedes borrarlo o desactivarlo.
 * Version: 09-01-2024
 * Author: Juan Luis Martel
 * Author URI: https://webyblog.es/
 * License: GPL2
 */

// Evita la ejecución directa del script
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// Codigo para añadir enlace de Ayuda en el plugin que muestra el fichero ayuda.html
add_filter('plugin_action_links', 'jlmr_agregar_enlace_ayuda_role_alumno', 10, 2);

function jlmr_agregar_enlace_ayuda_role_alumno($links, $file) {
    // Obtenemos el 'basename' del archivo actual
    $plugin_basename = plugin_basename(__FILE__);

    // Comprobamos si estamos en el plugin correcto antes de agregar el enlace
    if ($file == $plugin_basename) {
        // Construimos la URL del archivo de ayuda
        $ayuda_url = plugins_url('ayuda.html', __FILE__);

        // Añadimos el nuevo enlace de ayuda al array de enlaces
        $enlace_ayuda = '<a  rel="noopener noreferrer nofollow" href="' . esc_url($ayuda_url) . '" target="_blank">Ayuda</a>';
        array_push($links, $enlace_ayuda);
    }

    return $links;
}



/**
 * Función para crear o actualizar el rol de alumno
 */
function jlmr_create_or_update_alumno_role() {
	// Define las capacidades del rol de alumno
	$capabilities = array(
		'read'         => true,  // Ejemplo de capacidad, permite leer posts
		// Aquí puedes añadir más capacidades según lo necesites
		// Si añades una capacidad y luego la quieres quitar, lo que debes de hacer es ponerla en false
	);

	// Verifica si el rol alumno ya existe
	if ( $role = get_role( 'alumno' ) ) {
		// Actualiza las capacidades del rol existente
		foreach ( $capabilities as $cap => $grant ) {
			$role->add_cap( $cap, $grant );
		}
	} else {
		// Crea el nuevo rol de alumno
		add_role( 'alumno', 'Alumno', $capabilities );
	}
}

// Hook para ejecutar la función al activar el plugin
register_activation_hook( __FILE__, 'jlmr_create_or_update_alumno_role' );
