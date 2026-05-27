<?php
namespace MiCatalogo;

class CSV_Handler {
    public function __construct() {
        add_action( 'wp_ajax_micatalogo_import_csv', [ $this, 'import_csv' ] );
        add_action( 'wp_ajax_micatalogo_export_csv', [ $this, 'export_csv' ] );
    }

    public function import_csv() {
        // check_ajax_referer
        // Leer $_FILES['csv_file']
        // Para cada fila: wp_insert_post() tipo producto, actualizar metas
        wp_send_json_success( [ 'message' => 'Importación completada (simulada)' ] );
    }

    public function export_csv() {
        // Consultar posts tipo producto
        // Generar CSV
        // Devolver URL de descarga o contenido crudo
        wp_send_json_success( [ 'message' => 'Exportación completada (simulada)' ] );
    }
}
