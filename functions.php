<?php
function formatar_data_br($data) {
    if (empty($data)) return '';

    $timestamp = strtotime((string) $data);

    if ($timestamp === false) return htmlspecialchars($data);
    return date('d/m/Y', $timestamp);
}