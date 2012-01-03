<?php
require 'vendor/.composer/autoload.php';

use Seine\Parser\DOM\DOMFactory;
use Seine\Configuration;

$factory = new DOMFactory();

$actual_file = __DIR__ . '/_files/actual_valid.xml';
$fp = fopen($actual_file, 'w');

$book = $factory->getBook();
$writer = $factory->getWriterFactory()->getOfficeXML2003StreamWriter($fp);
$book->setWriter($writer);

$sheet = $book->newSheet('more1');
for($i = 0; $i < 10; $i++) {
    $sheet->addRow($factory->getRow(array(
        'cell1',
        'cell"2 - açaí - açaí',
        'cell</Cell>3',
        'cell4'
    )));
}

$sheet = $book->newSheet('mor"e2');
$style = $book->newStyle()->setFontBold(true);
$sheet->addRow($factory->getRow(array('head1', 'head2', 'head3', 'head4'))->setStyle($style));
for($i = 0; $i < 10; $i++) {
    $sheet->addRow($factory->getRow(array(
        'cell1',
        'ceæøåll2',
        rand(100, 10000),
        'cell4'
    )));
}
$book->close();
fclose($fp);

$actual = file_get_contents($actual_file);