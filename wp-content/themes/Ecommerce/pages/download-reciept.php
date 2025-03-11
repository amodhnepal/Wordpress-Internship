<?php
require_once ABSPATH . 'wp-load.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

// Ensure WooCommerce is active
if (!class_exists('WooCommerce')) {
    die('WooCommerce is not installed.');
}

// Get order ID from URL
$order_id = isset($_GET['generate_pdf']) ? intval($_GET['generate_pdf']) : 0;
$order = wc_get_order($order_id);

if (!$order) {
    die('Invalid order.');
}

// Generate PDF using DomPDF
require_once 'vendor/autoload.php'; // Use MPDF or DomPDF here

use Dompdf\Dompdf;
$dompdf = new Dompdf();
$html = '
    <h1>Order Receipt</h1>
    <p>Order Number: ' . $order->get_order_number() . '</p>
    <p>Order Date: ' . wc_format_datetime($order->get_date_created()) . '</p>
    <p>Total: ' . $order->get_formatted_order_total() . '</p>
    <h2>Items:</h2>
    <ul>';
foreach ($order->get_items() as $item) {
    $html .= '<li>' . esc_html($item->get_name()) . ' × ' . esc_html($item->get_quantity()) . '</li>';
}
$html .= '</ul>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('receipt.pdf', ['Attachment' => true]);

exit;
