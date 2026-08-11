<?php

declare(strict_types=1);

use Dompdf\Dompdf;
use Dompdf\Options;
use League\CommonMark\GithubFlavoredMarkdownConverter;

require dirname(__DIR__).'/vendor/autoload.php';

$root = dirname(__DIR__);
$outputDirectory = $root.'/docs/generated';
$stylesheet = file_get_contents($root.'/docs/manual.css');

if ($stylesheet === false) {
    throw new RuntimeException('No se pudo leer docs/manual.css.');
}
$converter = new GithubFlavoredMarkdownConverter([
    'html_input' => 'allow',
    'allow_unsafe_links' => false,
]);

if (! is_dir($outputDirectory) && ! mkdir($outputDirectory, 0755, true) && ! is_dir($outputDirectory)) {
    throw new RuntimeException('No se pudo crear docs/generated.');
}

foreach (['inicio-rapido', 'manual-de-usuario'] as $document) {
    $markdownPath = $root.'/docs/'.$document.'.md';
    $html = '<!doctype html><html lang="es"><head><meta charset="utf-8"><title>Entia CMS</title><style>'.$stylesheet.'</style>';
    $html .= '</head><body>'.$converter->convert(file_get_contents($markdownPath))->getContent().'</body></html>';

    $options = new Options;
    $options->setDefaultFont('DejaVu Sans');
    $options->setIsRemoteEnabled(false);

    $pdf = new Dompdf($options);
    $pdf->loadHtml($html, 'UTF-8');
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    if ($pdf->getCanvas()->get_page_count() < 1) {
        throw new RuntimeException("El documento {$document} no genero paginas.");
    }

    file_put_contents($outputDirectory.'/'.$document.'.pdf', $pdf->output());
    fwrite(STDOUT, "Generado: docs/generated/{$document}.pdf\n");
}
