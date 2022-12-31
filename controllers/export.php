<?php

//koneksi 
$host = mysqli_connect("localhost","root","","wgoptical");

if(!$host){
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}

require '../controllers/vendor/autoload.php';

//library
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// style header tabel
$style_col = [
    'font' => ['bold' => true],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], 
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], 
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] 
    ]
];

//style isi tabel
$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER 
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], 
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], 
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] 
    ]
];
$sheet->setCellValue('A1', "Data Pengeluaran"); 
$sheet->mergeCells('A1:F1'); 
$sheet->getStyle('A1')->getFont()->setBold(true); 
$sheet->getStyle('A1')->getFont()->setSize(15);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);  

// Header tabel
$sheet->setCellValue('A3', "No"); 
$sheet->setCellValue('B3', "Kode Transaksi"); 
$sheet->setCellValue('C3', "Tanggal"); 
$sheet->setCellValue('D3', "Admin"); 
$sheet->setCellValue('E3', "Keterangan"); 
$sheet->setCellValue('F3', "Total"); 
// Apply style header 
$sheet->getStyle('A3')->applyFromArray($style_col);
$sheet->getStyle('B3')->applyFromArray($style_col);
$sheet->getStyle('C3')->applyFromArray($style_col);
$sheet->getStyle('D3')->applyFromArray($style_col);
$sheet->getStyle('E3')->applyFromArray($style_col);
$sheet->getStyle('F3')->applyFromArray($style_col);

$sql = mysqli_query($host, "SELECT * FROM tr_pengeluaran");
$no = 1;
$row = 13; 

// data dari db
while ($data = mysqli_fetch_array($sql)) { 
    $sheet->setCellValue('A' . $row, $no);
    $sheet->setCellValue('B' . $row, $data['kode_tr_pengeluaran']);
    $sheet->setCellValue('C' . $row, $data['tanggal']);
    $sheet->setCellValue('D' . $row, $data['id_pegawai']);
    $sheet->setCellValue('E' . $row, $data['keterangan']);
    $sheet->setCellValue('F' . $row, $data['total_harga']);

    // Apply style row 
    $sheet->getStyle('A' . $row)->applyFromArray($style_row);
    $sheet->getStyle('B' . $row)->applyFromArray($style_row);
    $sheet->getStyle('C' . $row)->applyFromArray($style_row);
    $sheet->getStyle('D' . $row)->applyFromArray($style_row);
    $sheet->getStyle('E' . $row)->applyFromArray($style_row);
    $sheet->getStyle('F' . $row)->applyFromArray($style_row);
    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 
    $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 
    $no++; 
    $row++; 
}
// Set width kolom
$sheet->getColumnDimension('A')->setWidth(5); 
$sheet->getColumnDimension('B')->setWidth(15); 
$sheet->getColumnDimension('C')->setWidth(40); 
$sheet->getColumnDimension('D')->setWidth(20); 
$sheet->getColumnDimension('E')->setWidth(15); 
$sheet->getColumnDimension('F')->setWidth(30); 
// Set title
$sheet->setTitle("Data Pengeluaran");
// proses export
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// Set nama file excel 
header('Content-Disposition: attachment; filename="Data Pengeluaran.xls"');
header('Cache-Control: max-age=0');
$writer = new Xls($spreadsheet);
$writer->save('php://output');
?>e