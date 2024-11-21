<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->onLoad();
	}

    function onLoad() {
		if(!$this->session->userdata('currently_logged_in') || !$this->input->is_ajax_request()) {
			exit('No access allowed');
		}
    }

    function getConfig() {
		$query = $this->db->get('config');
		return $query->row();
	}

	function remoteConfig() {
		$config = $this->getConfig();
		$arrContextOptions=stream_context_create(array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ));
		return json_decode(file_get_contents("https://cloud.team-dooo.com/Dooo/api/getConfig.php?code=$config->license_code", false, $arrContextOptions));
	}

	function getFilename($header) {
		if (preg_match('/filename="(.+?)"/', $header, $matches)) {
			return $matches[1];
		}
		if (preg_match('/filename=([^; ]+)/', $header, $matches)) {
			return rawurldecode($matches[1]);
		}
		throw new Exception(__FUNCTION__ .": Filename not found");
	}

	function hashDirectory($directory){
		if (! is_dir($directory)){ return false; }
	
		$files = array();
		$dir = dir($directory);
	
		while (false !== ($file = $dir->read())){
			if ($file != '.' and $file != '..') {
				if (is_dir($directory . '/' . $file)) { $files[] = $this->hashDirectory($directory . '/' . $file); }
				else { $files[] = md5_file($directory . '/' . $file); }
			}
		}
	
		$dir->close();
	
		return md5(implode('', $files));
	}

	function folderCopy($source, $dest, $permissions = 0755){
        $sourceHash = $this->hashDirectory($source);
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }
    
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }
    
        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }
    
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
    
            // Deep copy directories
            if($sourceHash != $this->hashDirectory($source."/".$entry)){
				$this->folderCopy("$source/$entry", "$dest/$entry", $permissions);
            }
        }
    
        // Clean up
        $dir->close();
        return true;
    }

	function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}
		if (!is_dir($dir)) {
			return unlink($dir);
		}
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}
			if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
				return false;
			}
		}
		return rmdir($dir);
	}

	function update() {
		ini_set('max_execution_time', 300);
		
		$arrContextOptions=stream_context_create(array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ));

		$Config = $this->getConfig();
		$remoteConfig = $this->remoteConfig();
		$update_url = $remoteConfig->update_url."code=".$Config->license_code;

		$headers = get_headers($update_url,1,$arrContextOptions);
        if(is_array($headers['Content-Disposition'])){
            $cd = $headers['Content-Disposition'][1];
        }else{
            $cd = $headers['Content-Disposition'];
        }

		$update_dir = 'uploads/update/';
		$update_file = $update_dir.$this->getFilename($cd);
		$update_file_dir = $update_dir.pathinfo($this->getFilename($cd), PATHINFO_FILENAME);

		if (!is_dir($update_dir)) {
			mkdir($update_dir, 0777, true);
		} else {
			delete_files($update_dir, true);
		}

		$data = file_get_contents ($update_url, false, $arrContextOptions);
		write_file($update_file, $data);

		if(md5_file($update_file) == $remoteConfig->update_hash) {
			$zip = new ZipArchive;
 
            if ($zip->open($update_file) === TRUE) {
				if($remoteConfig->update_password != "") {
					$zip->setPassword(base64_decode($remoteConfig->update_password));
				}
                $zip->extractTo(FCPATH.$update_file_dir);
                $zip->close();
				unlink($update_file);


				// update database
				if (file_exists($update_file_dir.'/database.sql')){
					$host           =     $this->db->hostname;
                    $dbuser         =     $this->db->username;
                    $dbpassword     =     $this->db->password;
                    $dbname         =     $this->db->database;
            
                    $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);
            
                    if (!mysqli_connect_errno()) {
                        $sql = file_get_contents($update_file_dir.'/database.sql');
            
                        $mysqli->multi_query($sql);
                        do {
                            
                        } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
                        $mysqli->close();
				    }
				}


				// get json_content    
				if (file_exists($update_file_dir.'/config.json')){
					$str = file_get_contents($update_file_dir.'/config.json');
				    $converted_json = json_decode($str, true);
				}
				

				// process php file
				if (file_exists($update_file_dir.'/update.php')){
					require $update_file_dir.'/update.php';
				}
				

				if (file_exists($update_file_dir.'/config.json')){
				    // Create directorie if not exist
				    if (!empty($converted_json['directories'])) {
				    	foreach ($converted_json['directories'] as $dir) {
				    		if (!is_dir($dir['title']))
				    			mkdir($dir['title'], 0777, true);
				    	}
				    }
					// copy folder if not exist or replace existing folder
				    if (!empty($converted_json['folders'])) {
				    	foreach ($converted_json['folders'] as $folders):
				    		// copy/replace file
				    		$this->folderCopy($folders['from_dir'], $folders['to_dir']);
				    		$this->deleteDirectory($folders['from_dir']);
				    	endforeach;
				    }
				    // copy file if not exist or replace existing file
				    if (!empty($converted_json['files'])) {
				    	foreach ($converted_json['files'] as $files):
				    		// copy/replace file
				    		copy($files['from_dir'], $files['to_dir']);
				    		unlink($files['from_dir']);
				    	endforeach;
				    }
				}

				if (is_dir($update_dir)) {
					delete_files($update_dir, true);
				}

				// redirect after Completed
				echo "Updated Successfully";
            }
		} else {
			delete_files($update_dir, true);
			echo "Invalid File";
		}
	}
}