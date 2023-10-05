<?php
    require '../../vendor/autoload.php';
    require '..\forms\log.php';
    require 'conn.php';
    

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $usertype = $_SESSION['account_type'];
    $proyecto = $_SESSION['proye']; 

    if($usertype === "admin"){
        $sql = "SELECT firstName, lastName, user, proyecto, equipo, horaEntrada, horaSalida, hextra, comentario, comentario2 FROM registros";
    }else{
        $sql = "SELECT firstName, lastName, user, proyecto, equipo, horaEntrada, horaSalida, hextra, comentario, comentario2 FROM registros WHERE proyecto = '$proyecto'";
    }
    
    $result = $conn->query($sql);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headings = array('Nombre', 'Apellidos', 'Usuario', 'Proyecto', 'Equipo', 'Hora Entrada', 'Hora Salida', 'Hextra', 'Comentario', 'Comentario2'); 

    $styleArray = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],  
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => '877C79', 
            ],
        ],
    ];
    
    $col = 1;
    foreach ($headings as $heading) {
        $sheet->setCellValueByColumnAndRow($col, 1, $heading);
        $sheet->getStyleByColumnAndRow($col, 1)->applyFromArray($styleArray);  // Aplicar estilos
        $col++;
    }

    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $col = 1;
        foreach ($data as $value) {
            $sheet->setCellValueByColumnAndRow($col, $row, $value);
            $col++;
        }
        $row++;
    }

    
    foreach (range(1, $row - 1) as $rowIndex) {
        $sheet->getRowDimension($rowIndex)->setRowHeight(-1);

        $columnas = range('A', 'J'); 

        foreach ($columnas as $columna) {
            $sheet->getColumnDimension($columna)->setAutoSize($columna);
        }
                
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