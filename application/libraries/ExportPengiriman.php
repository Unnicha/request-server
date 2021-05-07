<?php defined('BASEPATH') OR exit('No direct script access allowed');

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    class ExportPengiriman {
        protected $ci;
		
        function __construct() {
			$this->ci =& get_instance();
            require_once APPPATH.'third_party/fpdf/fpdf.php';
        }
		
        public function exportExcel($data) {
			
			$spreadsheet = new Spreadsheet();
			$spreadsheet->getProperties()->setCreator('HRWConsulting');
			
			// Add some data
			$index = 1;
			foreach($data['klien'] as $k) {
				$this->newSheet($data, $spreadsheet, $k, $index);
				$index++;
			}
			$spreadsheet->removeSheetByIndex(0);
			$spreadsheet->setActiveSheetIndex(0);
			// Redirect output to a client’s web browser (Xlsx)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$data['filename'].'.xlsx"');
			header('Cache-Control: max-age=0');
			
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output');
			exit;
		}
		
		public function newSheet($data, $spreadsheet, $k, $index) {
			
			$sheet = $spreadsheet->createSheet();
			$sheet = $spreadsheet->setActiveSheetIndex($index)
			/*
				->setCellValue('A1', 'Klien')
				->setCellValue('B1', ' ')
				->setCellValue('A2', 'Masa')
				->setCellValue('B2', $data['bulan'])
				->setCellValue('A3', 'Tahun')
				->setCellValue('B3', $data['tahun'])
			*/
				->setCellValue('A1', 'No.')
				->setCellValue('B1', 'Jenis Data')
				->setCellValue('C1', 'Format Data')
				->setCellValue('D1', 'Status')
				->setCellValue('E1', 'Jenis Pengiriman')
				->setCellValue('F1', 'File')
				->setCellValue('G1', 'Tanggal Ambil')
				->setCellValue('H1', 'Tanggal Pengiriman')
				->setCellValue('I1', 'Keterangan');

			// Miscellaneous glyphs, UTF-8
			$i=2; $num=1;
			$permintaan = $data['permintaan'];
			foreach($permintaan[$k['id_klien']] as $o) {
				// Status Pengiriman
				if($o['id_pengiriman'] == null)
					$status = 'Belum Diterima';
				else
					$status = 'Sudah Diterima';
				// Jenis Pengiriman
				if($o['pembetulan'] == 0)
					$pembetulan = 'Pertama';
				else
					$pembetulan = 'Pembetulan '.$o['pembetulan'];

				$sheet = $spreadsheet->setActiveSheetIndex($index)
					->setCellValue('A'.$i, $num.'.')
					->setCellValue('B'.$i, $o['jenis_data'])
					->setCellValue('C'.$i, $o['format_data'])
					->setCellValue('D'.$i, $status)
					->setCellValue('E'.$i, $pembetulan)
					->setCellValue('F'.$i, $o['file'])
					->setCellValue('G'.$i, $o['tanggal_ambil'])
					->setCellValue('H'.$i, $o['tanggal_pengiriman'])
					->setCellValue('I'.$i, $o['keterangan2']);
				$i++; $num++;
			}
			
			$spreadsheet->getActiveSheet()->setTitle($k['nama_klien']);
			return $spreadsheet;
		}
		
		public function exportPdf($data) {
			
			$pdf = new FPDF();
			foreach($data['klien'] as $k) { 
				$this->newPdf($data, $pdf, $k);
			}
			$nama_doc = $data['filename'].'.pdf';
			$pdf->Output('I', "$nama_doc");
		}

		public function newPdf($data, $pdf, $k) {

			$now = date('d/m/Y H:i');
			$pdf->AddPage('L', 'A4'); 
			$pdf->SetMargins(15, 8); 
			$pdf->SetAutoPageBreak(true, 15);
			$pdf->SetFillColor(230,230,0);
			// start
			$pdf->SetFont('Arial', '', '8');
			$pdf->Cell(0, 5, ''.$now, 0, 1, 'R');
			$pdf->SetFont('Arial', 'B', '18');
			$pdf->Cell(0, 6, $data['judul'], 0, 1, 'C');
			$pdf->Ln(4); // spasi
			$pdf->SetFont('Arial', '', '12');
			$pdf->Cell(35, 6, 'Nama Klien', 0, 0);
			$pdf->Cell(150, 6, ': '.$k['nama_klien'], 0, 0);
			$pdf->Cell(50, 6, 'Masa   : '.$data['bulan'], 0, 1);
			$pdf->Cell(35, 6, 'Status Pekerjaan', 0, 0);
			$pdf->Cell(150, 6, ': '.$k['status_pekerjaan'], 0, 0);
			$pdf->Cell(50, 6, 'Tahun  : '.$data['tahun'], 0, 1);
			$pdf->Ln(1); // spasi
			// cek apakah ada data proses
			$permintaan = $data['permintaan'];
			if($permintaan[$k['id_user']] == null) {
				$pdf->SetFont('Arial', 'B', '12');
				$pdf->Cell(0, 8, 'Belum ada permintaan', 1, 1, 'C');
			} else {
				// header table
				$pdf->SetFont('Arial', 'B', '12');
				$pdf->Cell(10, 6, 'No.', 1, 0, 'C');
				$pdf->Cell(40, 6, 'Jenis Data', 1, 0, 'C');
				$pdf->Cell(30, 6, 'Format Data', 1, 0, 'C');
				$pdf->Cell(35, 6, 'Status', 1, 0, 'C');
				$pdf->Cell(30, 6, 'Pengiriman', 1, 0, 'C');
				$pdf->Cell(40, 6, 'File', 1, 0, 'C');
				$pdf->Cell(40, 6, 'Tanggal Ambil', 1, 0, 'C');
				$pdf->Cell(45, 6, 'Tanggal Pengiriman', 1, 1, 'C');
				$pdf->SetFont('Arial', '', '12');
				// isi table
				$no = 0;
				foreach($permintaan[$k['id_user']] as $p) {
					if($p['pembetulan'] > 0)
						$pembetulan = 'REV '.$p['pembetulan'];
					elseif($p['pembetulan'] == null)
						$pembetulan = '';
					else
						$pembetulan = 'Pertama';
					if($p['id_pengiriman'] == null)
						$status = 'Belum Diterima';
					else
						$status = 'Sudah Diterima';
					$pdf->Cell(10, 6, ''.++$no.'.', 1, 0, 'C');
					$pdf->Cell(40, 6, ''.$p['jenis_data'], 1, 0, 'C');
					$pdf->Cell(30, 6, ''.$p['format_data'], 1, 0, 'C');
					$pdf->Cell(35, 6, ''.$status, 1, 0, 'C');
					$pdf->Cell(30, 6, ''.$pembetulan, 1, 0, 'C');
					$pdf->Cell(40, 6, ''.$p['file'], 1, 0, 'C');
					$pdf->Cell(40, 6, ''.$p['tanggal_ambil'], 1, 0, 'C');
					$pdf->Cell(45, 6, ''.$p['tanggal_pengiriman'], 1, 1, 'C');
				}
			}
			return $pdf;
		}
		
		function durasi_cetak($mulai, $selesai = null) {
			$this->ci->load->library('proses_admin');
			$durasi = $this->ci->proses_admin->durasi($mulai, $selesai);
			return $durasi;
		}
	}
?>