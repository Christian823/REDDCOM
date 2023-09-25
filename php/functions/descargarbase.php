<?php
    require '../../vendor/autoload.php';
    require 'conn.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $sql = "SELECT firstName, lastName, user, proyecto, equipo, horaEntrada, horaSalida, hextra, comentario, comentario2 FROM user";
    $result = $conn->query($sql);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Encabezados
    $headings = array('First Name', 'Last Name', 'User', 'Proyecto', 'Equipo', 'Hora Entrada', 'Hora Salida', 'Hextra', 'Comentario', 'Comentario2');
    $col = 1;
    foreach ($headings as $heading) {
        $sheet->setCellValueByColumnAndRow($col, 1, $heading);
        $col++;
    }

    $row = 2; // Comenzar desde la fila 2 para los datos
    while ($data = $result->fetch_assoc()) {
        $col = 1;
        foreach ($data as $value) {
            $sheet->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        $row++;
    }

    // Autoajuste de altura de fila
    foreach (range(1, $row - 1) as $rowIndex) {
        $sheet->getRowDimension($rowIndex)->setRowHeight(-1); // Autoajuste de altura
    }

    $writer = new Xlsx($spreadsheet);
    $filename = "registros.xlsx";
    $writer->save($filename);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    readfile($filename);
    unlink($filename);

    $conn->close();
?>
