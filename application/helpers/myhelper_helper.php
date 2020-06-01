<?php 

	function rupiah($val)
	{
		return number_format($val,0,",",".");
	}

	function datemysql($tanggal)
	{
		$data = explode('/',$tanggal);
		return $data[2].'-'.$data[1].'-'.$data[0];
	}

	function dateindo($tanggal)
	{
		$data = explode('-',$tanggal);
		return $data[2].'/'.$data[1].'/'.$data[0];
	}

	function monthkoma($bulan)
	{
		$data = explode('-',$bulan);
		return $data[0].','.($data[1]-1);
	}
	function dateformatkoma($tanggal)
	{
		$data = explode('-',$tanggal);
		return $data[0].','.($data[1]-1).','.$data[2];
	}
	
	function datemiring($tanggal)
	{
		$data = explode('-', $tanggal);
		return $data[2].'/'.$data[1].'/'.$data[0];
	}

	function bulanindo($bulan)
	{
		$data = explode('/', $bulan);
		return $data[1].'-'.$data[0];
	}

	function bulan_indo2($bln)
	{
		// FORMAT : 01/2019
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('/', $bln);
		
		return $bulan[ (int)$pecahkan[0] ] . ' ' . $pecahkan[1];
	}

	function bulan_indo3($bln)
	{
		// FORMAT : 01/2019
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $bln);
		
		return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

	function bulanindo_to_mysql($bulan){
		$bln = array (
			"Jan" => "01",
			"Feb" => "02",
			"Mar" => "03",
			"Apr" => "04",
			"Mei" => "05",
			"Jun" => "06",
			"Jul" => "07",
			"Ags" => "08",
			"Sep" => "09",
			"Okt" => "10",
			"Nov" => "11",
			"Des" => "12"
		);

		$pecahkan = explode(" ", $bulan);
		return $pecahkan[1]."-".$bln[$pecahkan[0]];
	}


	function tanggal_indo2($tanggal){
		// FOR FORMAT : d/m/Y
		// EX " 16/09/2019

		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
	);
	$pecahkan = explode('/', $tanggal);
	
	 return (int)$pecahkan[0].' '.$bulan[(int)$pecahkan[1] ] . ' ' . $pecahkan[2];		
	}

	function tanggal_indo($tanggal){
			// FOR FORMAT Y-m-d
			// EX : 2019-09-16

	    $bulan = array (
	        1 =>   'Januari',
	        'Februari',
	        'Maret',
	        'April',
	        'Mei',
	        'Juni',
	        'Juli',
	        'Agustus',
	        'September',
	        'Oktober',
	        'November',
	        'Desember'
	    );
	    $pecahkan = explode('-', $tanggal);
	    
	    // variabel pecahkan 0 = tahun
	    // variabel pecahkan 1 = bulan
	    // variabel pecahkan 2 = tanggal
	 
	     return $pecahkan[2].' '.$bulan[(int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

	function bulan_indo($tanggal){
		$bulan = array (
				1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}

	function getsetting()
	{
		$ci =& get_instance();
		$setting = $ci->db->get('setting')->row();
		return $setting;
	}

	function getuser()
	{
		$ci =& get_instance();
		$id = $ci->session->userdata('iduser');
		$user = $ci->db->get_where('users', array('id'=>$id))->row();
		return $user;
	}

	function check_is_login()
	{
		$ci =& get_instance();
		$is_login = $ci->session->userdata('is_login');
		if($is_login==null){
			redirect('auth/login');
		}
	}



	function is_admin()
	{
		$ci =& get_instance();
		$id = $ci->session->userdata('iduser');
		$user = $ci->db->get_where('users', array('id'=>$id))->row();
		if($user->level!='admin'){
			redirect('auth/blocked');
		}
	}


	// AUTONUNMBER
	// EX : TRX00001
	// EX : TR2508190001
	function getAutoNumber($table, $field, $pref, $length, $where=""){
		$ci = &get_instance();
		$query = "SELECT IFNULL(MAX(CONVERT(MID($field,".(strlen($pref)+1).",".($length-strlen($pref))."),UNSIGNED INTEGER)),0)+1 AS NOMOR 
			FROM $table WHERE LEFT ($field,".(strlen($pref)).")='$pref' $where";
			$result = $ci->db->query($query)->row();
			$zero="";
			$num=$length-strlen($pref)-strlen($result->NOMOR);
			
			for($i=0;$i<$num;$i++){
				$zero = $zero."0";
			}
		return $pref.$zero.$result->NOMOR;
	}

	function pecah_daterange($tanggal){
		$tgl = explode(" - ",$tanggal);
		$data = array(
			'start' => $tgl[0],
			'end' => $tgl[1]
		);
		return $data;
	}

	function btncolor($skin)
	{
		if($skin=='skin-blue'||$skin=='skin-blue-light'){
			return 'btn-primary';
		}elseif ($skin=='skin-black'||$skin=='skin-black-light') {
			return 'bg-navy';
		}
		elseif ($skin=='skin-red'||$skin=='skin-red-light') {
			return 'btn-danger';
		}
		elseif ($skin=='skin-green'||$skin=='skin-green-light') {
			return 'btn-success';
		}
		elseif ($skin=='skin-purple'||$skin=='skin-purple-light') {
			return 'bg-purple';
		}
		elseif ($skin=='skin-yellow'||$skin=='skin-yellow-light') {
			return 'btn-warning';
		}
		else{

		}
	}
