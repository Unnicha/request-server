<?php defined('BASEPATH') OR exit('No direct script access allowed');

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	class ExportProses {
		protected $ci;
		
		function __construct() {
			$this->ci =& get_instance();
			$this->ci->load->library('session');
			require_once APPPATH.'third_party/fpdf/fpdf.php';
		}
		
		public function exportExcel($data) {
			$spreadsheet = new Spreadsheet();
			$spreadsheet->getProperties()->setCreator('HRWConsulting');
			
			// Add some data
			$index = 1;
			foreach($data['proses'] as $proses) {
				$this->newSheet($spreadsheet, $data, $proses, $index);
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
		
		public function newSheet($spreadsheet, $data, $proses, $index) {
			$this->ci->load->library('proses_admin');
			$sheet = $spreadsheet->createSheet();
			$sheet = $spreadsheet->setActiveSheetIndex($index)
					->setCellValue('A1', $data['judul'])
					->setCellValue('A2', 'Akuntan')
					->setCellValue('B2', $proses[0]['nama_akuntan'])
					->setCellValue('A3', 'Bulan')
					->setCellValue('B3', $data['masa']['bulan'])
					->setCellValue('A4', 'Tahun')
					->setCellValue('B4', $data['masa']['tahun'])
					->setCellValue('A4', 'Klien')
					->setCellValue('B4', $proses[0]['nama_klien']);
					
			if($proses) {
				$sheet = $spreadsheet->setActiveSheetIndex($index)
						->setCellValue('A6', 'No.')
						->setCellValue('B6', 'Tugas')
						->setCellValue('C6', 'Status')
						->setCellValue('D6', 'Mulai')
						->setCellValue('E6', 'Selesai')
						->setCellValue('F6', 'Durasi')
						->setCellValue('G6', 'Time Table');
				
				$i=7; $num=1;
				foreach($proses as $o) {
					if($o['tanggal_mulai'] == null) { // Status Pengiriman
						$status = 'Belum Diproses';
					} elseif($o['tanggal_selesai'] == null) {
						$status = 'Sedang Diproses';
					} else {
						$status = 'Selesai Diproses';
					}
					
					$dur = $this->ci->proses_admin->durasi($o['tanggal_mulai'], $o['tanggal_selesai']);
					if($o['temp_selesai']) {
						$dur1	= $this->ci->proses_admin->durasi($o['tanggal_mulai'], $o['temp_selesai']);
						$dur2	= $this->ci->proses_admin->durasi($o['temp_mulai'], $o['tanggal_selesai']);
						$dur	= $this->ci->proses_admin->addDurasi($dur1, $dur2);
					}
					$dur	= explode(' ', $dur);
					$jam	= ($dur[0] * 8) + $dur[1];
					$durasi	= $jam.' jam '. $dur[2].' min';
					
					$standar	= str_replace(' ', '_', strtolower($o['status_pekerjaan']));
					
					$sheet = $spreadsheet->setActiveSheetIndex($index)
						->setCellValue('A'.$i, $num.'.')
						->setCellValue('B'.$i, $o['nama_tugas'])
						->setCellValue('C'.$i, $status)
						->setCellValue('D'.$i, $o['tanggal_mulai'])
						->setCellValue('E'.$i, $o['tanggal_selesai'])
						->setCellValue('F'.$i, $durasi)
						->setCellValue('G'.$i, $standar.' jam');
					$i++; $num++;
				}
			} else {
				$sheet = $spreadsheet->setActiveSheetIndex($index)
						->setCellValue('A6', 'Tidak ada proses data');
			}
			
			$spreadsheet->getActiveSheet()->setTitle($proses[0]['nama_klien'])
										->mergeCells('A1:G1');
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
			$this->ci->load->model('Akses_model');
			$akses = $this->ci->Akses_model->getByKlien($k['id_klien'], $data['bulan'], $data['tahun']);
			foreach($akses as $a) {
				$akuntan[] = $a['nama'];
			}
			$pdf->AddPage('L', 'A4'); 
			$pdf->SetMargins(15, 8); 
			$pdf->SetAutoPageBreak(true, 15);
			$pdf->SetFillColor(230,230,0);
			// start
			$pdf->SetFont('Arial', '', '8');
			$pdf->Cell(0, 5, ''.$now, 0, 1, 'R');
			$pdf->SetFont('Arial', 'B', '16');
			$pdf->Cell(0, 8, strtoupper($data['judul']), 0, 1, 'C');
			$pdf->SetFont('Arial', 'B', '14');
			$pdf->Cell(0, 6, $data['subjudul'], 0, 1, 'C');
			$pdf->Cell(0, 4, '', 0, 1, 'C'); // spasi
			$pdf->SetFont('Arial', '', '12');
			$pdf->Cell(35, 6, 'Nama Klien', 0, 0);
			$pdf->Cell(150, 6, ': '.$k['nama_klien'], 0, 0);
			$pdf->Cell(50, 6, 'Masa  : '.$data['bulan'], 0, 1);
			$pdf->Cell(35, 6, 'Status Pekerjaan', 0, 0);
			$pdf->Cell(150, 6, ': '.$k['status_pekerjaan'], 0, 0);
			$pdf->Cell(50, 6, 'Tahun : '.$data['tahun'], 0, 1);
			$pdf->Cell(35, 6, 'Nama Akuntan', 0, 0);
			$pdf->Cell(150, 6, ': '.implode(", " , $akuntan), 0, 1);
			$pdf->Cell(0, 1, '', 0, 1, 'C'); // spasi
			// cek apakah ada data proses
			$status = $this->ci->session->userdata('status');
			if($status == 'belum')
			$this->pdfBelum($data, $pdf, $k);
			else
			$this->pdfSelesai($data, $pdf, $k);
			return $pdf;
		}

		public function pdfBelum($data, $pdf, $k) {
			$proses = $data['proses'];
			if($proses[$k['id_user']] == null) {
				$pdf->SetFont('Arial', 'B', '12');
				$pdf->Cell(0, 8, 'Belum ada pengiriman', 1, 1, 'C');
			} else {
				// header table
				$pdf->SetFont('Arial', 'B', '12');
				$pdf->Cell(10, 6, 'No.', 1, 0, 'C');
				$pdf->Cell(60, 6, 'Tugas', 1, 0, 'C');
				$pdf->Cell(50, 6, 'Data', 1, 0, 'C');
				$pdf->Cell(50, 6, 'Tanggal Pengiriman', 1, 0, 'C');
				$pdf->Cell(35, 6, 'Time Table', 1, 1, 'C');
				$pdf->SetFont('Arial', '', '12');
				// isi table
				$no = 0;
				foreach($proses[$k['id_klien']] as $p) {
					if($p['nama_klien'] == $k['nama_klien']) {
						if($p['pembetulan'] > 0)
							$pembetulan = $p['nama_tugas'].' REV '.$p['pembetulan'];
						else
							$pembetulan = $p['nama_tugas'];
						
						$pdf->Cell(10, 6, ''.++$no.'.', 1, 0, 'C');
						$pdf->Cell(60, 6, ''.$pembetulan, 1, 0);
						$pdf->Cell(50, 6, ''.$p['jenis_data'], 1, 0, 'C');
						$pdf->Cell(50, 6, ''.$p['tanggal_pengiriman'], 1, 0, 'C');
						$pdf->Cell(35, 6, ''.$p['lama_pengerjaan'].' jam', 1, 1, 'C');
					}
				}
			}
			return $pdf;
		}

		public function pdfSelesai($data, $pdf, $k) {
			$proses = $data['proses'];
			if($proses[$k['id_user']] == null) {
				$pdf->SetFont('Arial', 'B', '12');
				$pdf->Cell(0, 8, 'Belum ada proses', 1, 1, 'C');
			} else {
				// header table
				$pdf->SetFont('Arial', 'B', '12');
				$pdf->Cell(10, 6, 'No.', 1, 0, 'C');
				$pdf->Cell(60, 6, 'Tugas', 1, 0, 'C');
				$pdf->Cell(30, 6, 'Akuntan', 1, 0, 'C');
				$pdf->Cell(40, 6, 'Mulai', 1, 0, 'C');
				$pdf->Cell(40, 6, 'Selesai', 1, 0, 'C');
				$pdf->Cell(35, 6, 'Durasi', 1, 0, 'C');
				$pdf->Cell(35, 6, 'Time Table', 1, 1, 'C');
				$pdf->SetFont('Arial', '', '12');
				// isi table
				$no = 0;
				foreach($proses[$k['id_klien']] as $p) {
					if($p['nama_klien'] == $k['nama_klien']) {
						if($p['tanggal_mulai'] == null) {
							$durasi = '';
						} else {
							$durasi	= $this->durasi_cetak($p['tanggal_mulai'], $p['tanggal_selesai']);
						}
						
						if($p['pembetulan'] > 0)
							$pembetulan = $p['nama_tugas'].' REV '.$p['pembetulan'];
						else
							$pembetulan = $p['nama_tugas'];
						
						$pdf->Cell(10, 6, ''.++$no.'.', 1, 0, 'C');
						$pdf->Cell(60, 6, ''.$pembetulan, 1, 0);
						$pdf->Cell(30, 6, ''.$p['nama'], 1, 0, 'C');
						$pdf->Cell(40, 6, ''.$p['tanggal_mulai'], 1, 0, 'C');
						$pdf->Cell(40, 6, ''.$p['tanggal_selesai'], 1, 0, 'C');
						$pdf->Cell(35, 6, ''.$durasi, 1, 0, 'C');
						$pdf->Cell(35, 6, ''.$p['lama_pengerjaan'].' jam', 1, 1, 'C');
					}
				}
			}
			return $pdf;
		}
		
		function durasi($mulai, $selesai) {
			$this->ci->load->library('proses_admin');
			$durasi = $this->ci->proses_admin->durasi($mulai, $selesai);
			return $durasi;
		}
	}
?>