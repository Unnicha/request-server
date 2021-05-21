<?php defined('BASEPATH') OR exit('No direct script access allowed');
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    class Sendmail {
        
        protected $CI;
    
    	function __construct() { 
    	    
    	    $this->CI =& get_instance();
            
            require APPPATH.'third_party/phpmailer/src/Exception.php';
            require APPPATH.'third_party/phpmailer/src/PHPMailer.php';
            require APPPATH.'third_party/phpmailer/src/SMTP.php';
    	}
    	
    	function main() {
    	    
    	    //echo "Berhasil masuk index.<br>";
    	    $this->cek_akuntansi();
    	    $this->cek_perpajakan();
    	    $this->cek_lainnya();
    	}
    	
    	function cek_akuntansi() {
    	    
    	    $this->CI->load->model('M_Permintaan_akuntansi');
            $this->CI->load->model('M_Pengiriman_akuntansi');
            
    	    //echo "Berhasil masuk cek akuntansi.<br>";
    	    $permintaan_akuntansi   = $this->CI->M_Permintaan_akuntansi->getAllPermintaan();
    	    $pengiriman_akuntansi   = $this->CI->M_Pengiriman_akuntansi->getAllPengiriman();
    	    
    	    foreach($pengiriman_akuntansi as $b) {
    	        foreach($permintaan_akuntansi as $a => $val) {
    	            if($val['id_permintaan'] == $b['id_permintaan'])
    	            unset($permintaan_akuntansi[$a]);
    	        }
    	    }
    	    
    	    foreach($permintaan_akuntansi as $a) {
    	        if($a['notifikasi'] == null) {
        	        $nama_klien = $a['nama_klien'];
        	        $email_perusahaan = $a['email'];
        	        $email_pimpinan = $a['email_pimpinan'];
        	        $email_counterpart = $a['email_counterpart'];
        	        
        	        $tanggal_permintaan = date_create($a['tanggal_permintaan']);
        	        $tanggal_sekarang = date_create(date("d-m-Y H:i"));
        	        $diff = date_diff($tanggal_permintaan,$tanggal_sekarang);
        	        $selisih = $diff->format("%a");
        	        
        	        if($selisih >= 7) {
        	            $this->sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart);
        	            
        	            $id_permintaan = $a['id_permintaan'];
        	            $q = "UPDATE permintaan_akuntansi SET notifikasi='dikirim' WHERE id_permintaan='$id_permintaan'";
        	            $this->CI->db->query($q);
        	        }
    	        } 
    	    }
    	}
    	
    	function cek_perpajakan() {
    	    
            $this->CI->load->model('M_Permintaan_perpajakan');
            $this->CI->load->model('M_Pengiriman_perpajakan');
            
    	    //echo "Berhasil masuk cek perpajakan.<br>";
    	    $permintaan_perpajakan   = $this->CI->M_Permintaan_perpajakan->getAllPermintaan();
    	    $pengiriman_perpajakan   = $this->CI->M_Pengiriman_perpajakan->getAllPengiriman();
    	    
    	    foreach($pengiriman_perpajakan as $b) {
    	        foreach($permintaan_perpajakan as $a => $val) {
    	            if($val['id_permintaan'] == $b['id_permintaan'])
    	            unset($permintaan_perpajakan[$a]);
    	        }
    	    }
    	    
    	    foreach($permintaan_perpajakan as $a) {
    	        if($a['notifikasi'] == null) {
        	        $nama_klien = $a['nama_klien'];
        	        $email_perusahaan = $a['email'];
        	        $email_pimpinan = $a['email_pimpinan'];
        	        $email_counterpart = $a['email_counterpart'];
        	        
        	        $tanggal_permintaan = date_create($a['tanggal_permintaan']);
        	        $tanggal_sekarang = date_create(date("d-m-Y H:i"));
        	        $diff = date_diff($tanggal_permintaan,$tanggal_sekarang);
        	        $selisih = $diff->format("%a");
        	        
        	        if($selisih >= 7) {
        	            $this->sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart);
        	            
        	            $id_permintaan = $a['id_permintaan'];
        	            $q = "UPDATE permintaan_perpajakan SET notifikasi='dikirim' WHERE id_permintaan='$id_permintaan'";
        	            $this->CI->db->query($q);
        	        }
    	        } 
    	    }
    	}
    	
    	function cek_lainnya() {
    	    
            $this->CI->load->model('M_Permintaan_lainnya');
            $this->CI->load->model('M_Pengiriman_lainnya');
            
    	    //echo "Berhasil masuk cek lainnya.<br>";
    	    $permintaan_lainnya   = $this->CI->M_Permintaan_lainnya->getAllPermintaan();
    	    $pengiriman_lainnya   = $this->CI->M_Pengiriman_lainnya->getAllPengiriman();
    	    
    	    foreach($pengiriman_lainnya as $b) {
    	        foreach($permintaan_lainnya as $a => $val) {
    	            if($val['id_permintaan'] == $b['id_permintaan'])
    	            unset($permintaan_lainnya[$a]);
    	        }
    	    }

    	    foreach($permintaan_lainnya as $a) {
    	        if($a['notifikasi'] == null) {
        	        $nama_klien = $a['nama_klien'];
        	        $email_perusahaan = $a['email'];
        	        $email_pimpinan = $a['email_pimpinan'];
        	        $email_counterpart = $a['email_counterpart'];
        	        
        	        $tanggal_permintaan = date_create($a['tanggal_permintaan']);
        	        $tanggal_sekarang = date_create(date("d-m-Y H:i"));
        	        $diff = date_diff($tanggal_permintaan,$tanggal_sekarang);
        	        $selisih = $diff->format("%a");
        	        
        	        if($selisih >= 7) {
        	            $this->sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart);
        	            
        	            $id_permintaan = $a['id_permintaan'];
        	            $q = "UPDATE permintaan_lainnya SET notifikasi='dikirim' WHERE id_permintaan='$id_permintaan'";
        	            $this->CI->db->query($q);
        	        }
    	        } 
    	    }
    	}
    	
    	function sendMail($nama_klien, $email_perusahaan, $email_pimpinan, $email_counterpart) {
			
			//echo "Berhasil masuk sendMail. ";
			$mail = new PHPMailer(true);
			try {
                //Server settings
                //$mail->SMTPDebug  = SMTP::DEBUG_SERVER; // Enable verbose debug output
                $mail->isSMTP(); // Send using SMTP
                $mail->Host       = 'data.hrwconsulting.id'; // Set the SMTP server to send through
                $mail->SMTPAuth   = true; // Enable SMTP authentication
                $mail->Username   = 'admin@data.hrwconsulting.id'; // SMTP username
                $mail->Password   = 'requestdata'; // SMTP password
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                //$mail->Port       = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->Port       = 465;
            
                //Sender & reply to
                $mail->setFrom('admin@data.hrwconsulting.id', 'Data HRWConsulting'); // Name is optional
                $mail->addReplyTo('admin@data.hrwconsulting.id', 'Data HRWConsulting');
                
                //Recipients
                $mail->addAddress($email_perusahaan); // Add a recipient
                //$mail->addAddress('ellen@example.com');
                $mail->addCC($email_pimpinan);
                $mail->addCC($email_counterpart);
                //$mail->addBCC('bcc@example.com');
            
                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
            
                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Permintaan Data Bulanan';
                $mail->Body    = 
                    'Kepada<br>
                    '.$nama_klien.'<br>
                    Di Tempat<br><br>
                    
					Anda memiliki beberapa Permintaan Data Bulanan yang belum dipenuhi. Harap segera melengkapi permintaan data dengan mengirimkannya melalui website <b>Request Data Hirwan dan Rekan</b> yang dapat diakses <a href="data.hrwconsulting.id"><b>disini.</b></a>
                    <br><br>
                    
                    Best Regards,<br>
                    <b>Hirwan Tjahjadi & Rekan</b><br>
                    Jl. Krekot Bunder IV No. 47B, Jakarta Pusat<br>
                    P +62-21 3511027<br>';
                $mail->AltBody = '
					Anda memiliki beberapa Permintaan Data Bulanan yang belum dipenuhi. Harap segera melengkapi permintaan data dengan mengirimkannya melalui website Request Data Hirwan dan Rekan yang dapat diakses <a href="data.hrwconsulting.id"><b>disini.</b></a>
					
					Best Regards 
					Hirwan Tjahjadi & Rekan';
            
                $mail->send();
                //echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
            }
        }

		public function resetPassword($user, $link) {
			$mail = new PHPMailer(true);
			try {
				$mail->isSMTP(); // Send using SMTP
                $mail->Host			= 'data.hrwconsulting.id'; // Set the SMTP server to send through
                $mail->SMTPAuth		= true; // Enable SMTP authentication
                $mail->Username		= 'admin@data.hrwconsulting.id'; // SMTP username
                $mail->Password		= 'requestdata'; // SMTP password
				$mail->SMTPSecure	= PHPMailer::ENCRYPTION_SMTPS;
				$mail->Port			= 465;
				
				//Sender & reply to
                $mail->setFrom('admin@data.hrwconsulting.id');
                $mail->addReplyTo('admin@data.hrwconsulting.id');
                
                //Recipients
                $mail->addAddress($user['email']); // Add a recipient
				
				// Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject	= 'Reset Password';
                $mail->Body		= 
                    'Seseorang telah melakukan permintaan Reset Password pada akun '.$user['nama'].'. Jika itu bukan Anda, silahkan abaikan pesan ini. Jika benar Anda, silahkan ikuti tautan dibawah ini untuk memperbarui kata sandi Anda.<br><br> 
					'.$link.'<br><br> 
                    Best Regards,<br>
                    <b>Hirwan Tjahjadi & Rekan</b><br>
                    Jl. Krekot Bunder IV No. 47B, Jakarta Pusat<br>
                    P +62-21 3511027<br>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				$mail->send();
				return true;
            } catch (Exception $e) {
                return "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
            }
		}
    }
?>