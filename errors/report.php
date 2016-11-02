<?php
require_once 'processor.php';

$processor = new Error_Processor();

if (isset($reportData) && is_array($reportData)) {
    $processor->saveReport($reportData);
}

$processor->processReport();
