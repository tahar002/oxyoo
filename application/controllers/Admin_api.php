<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Admin_api_model');
		$this->onLoad();
	}

    function onLoad() {
		if(!$this->session->userdata('currently_logged_in') || !$this->input->is_ajax_request()) {
			exit('No access allowed');
		}
    }

    public function genarateApiKey() {
		echo $this->Admin_api_model->genarateApiKey();
	}

	public function changeLanguage() {
		$lang = $_POST['lang'];
		if($lang == "english") {
			$this->Admin_api_model->changeLanguage('english');
		} else if($lang == "russian") {
			$this->Admin_api_model->changeLanguage('russian');
		}
	}

    function savePrivecyPolicy() {
		echo $this->Admin_api_model->savePrivecyPolicy($_POST['PrivecyPolicy']);
	}

	function saveterms_and_conditions() {
		echo $this->Admin_api_model->saveterms_and_conditions($_POST['TermsAndConditions']);
	}

	function deleteDB(){
		echo unlink(FCPATH . "backup/db/".$_POST['file']);
	}

	function createDbBackup() {
		$Today = date("Y-m-d_h-i-s");
		$name = $_POST['name'];
		$this->load->dbutil();
		$prefs = array(
			'format' => 'txt',
			'filename' => 'db.sql'
		);
		$backup = $this->dbutil->backup($prefs);
		if (!is_dir('backup/db/')) {
			mkdir('backup/db/', 0777, true);
		}
		echo write_file("backup/db/".$name."_".$Today.".sql", $backup);
	}

	function updateSliderConfig() {
		echo $this->Admin_api_model->updateSliderConfig($_POST['Slider_Type'], $_POST['movie_image_slider_max_visible'], $_POST['webseries_image_slider_max_visible']);
	}

	function addMovie() {
		echo $this->Admin_api_model->addMovie($_POST['TMDB_ID'], $_POST['name'], $_POST['description'], $_POST['genres'], $_POST['release_date'], $_POST['runtime'], $_POST['poster'], $_POST['banner'], $_POST['youtube_trailer'], $_POST['downloadable'], $_POST['type'], $_POST['status']);
	}

	function getAllMovie() {
		echo $this->Admin_api_model->getAllMovie();
	}

	function deleteMovie() {
		echo $this->Admin_api_model->deleteMovie($_POST['movieID']);
	}

	function initiateGenres() {
		echo $this->Admin_api_model->initiateGenres($_POST['GenreList']);
	}

	function updateMovie() {
		echo $this->Admin_api_model->updateMovie($_POST['movieID'], $_POST['name'], $_POST['description'], $_POST['genres'], $_POST['release_date'], $_POST['runtime'], $_POST['poster'], $_POST['banner'], $_POST['youtube_trailer'], $_POST['downloadable'], $_POST['type'], $_POST['status']);
	}

	function verify() {
		echo $this->Admin_api_model->verify($_POST['License_Code']);
	}

	function getNotificationContentList() {
		echo json_encode($this->Admin_api_model->getNotificationContentList($_GET['search'], $_GET['type']), JSON_UNESCAPED_SLASHES);
	}

	function getMovieByID() {
		echo json_encode($this->Admin_api_model->getMovieByID($_POST['movieID']), JSON_UNESCAPED_SLASHES);
	}

	function getWebSeriesByID() {
		echo json_encode($this->Admin_api_model->getWebSeriesByID($_POST['WebSeriesID']), JSON_UNESCAPED_SLASHES);
	}

	function add_cs() {
		echo $this->Admin_api_model->add_cs($_POST['add_cs_content_id'], $_POST['add_slider_type'], $_POST['add_cs_Title'], $_POST['add_cs_Banner'], $_POST['add_cs_URL'], $_POST['add_cs_Status']);
	}

	function delete_cs() {
		echo $this->Admin_api_model->delete_cs($_POST['ID']);
	}

	function get_cs_details() {
		echo json_encode($this->Admin_api_model->get_cs_details($_POST['ID']), JSON_UNESCAPED_SLASHES);;
	}

	function edit_cs() {
		echo $this->Admin_api_model->edit_cs($_POST['Edit_cs_id'], $_POST['Edit_cs_content_id'], $_POST['Edit_slider_type'], $_POST['Edit_cs_Title'], $_POST['Edit_cs_Banner'], $_POST['Edit_cs_URL'], $_POST['Edit_cs_Status']);
	}

	function get_all_report() {
		echo $this->Admin_api_model->get_all_report();
	}

	function delete_report() {
		echo $this->Admin_api_model->delete_report($_POST['report_id']);
	}

	function update_report_status() {
		echo $this->Admin_api_model->update_report_status($_POST['report_id'], $_POST['status']);
	}

	function get_all_request() {
		echo $this->Admin_api_model->get_all_request();
	}

	function delete_request() {
		echo $this->Admin_api_model->delete_request($_POST['request_id']);
	}

	function update_request_status() {
		echo $this->Admin_api_model->update_request_status($_POST['request_id'], $_POST['status']);
	}

	function get_all_users() {
		echo $this->Admin_api_model->get_all_users();
	}

	function add_user() {
		echo $this->Admin_api_model->add_user($_POST['add_modal_User_Name'], $_POST['Add_modal_Email'], md5($_POST['Add_modal_Password']));
	}

	function delete_user() {
		echo $this->Admin_api_model->delete_user($_POST['user_id']);
	}

	function get_user_Details() {
		echo json_encode($this->Admin_api_model->get_user_Details($_POST['userID']));
	}

	function update_user_data() {
		echo $this->Admin_api_model->update_user_data($_POST['Edit_modal_User_id'], $_POST['Edit_modal_User_Name'], $_POST['Edit_modal_Email']);
	}

	function save_telegram_data() {
		echo $this->Admin_api_model->save_telegram_data($_POST['telegram_bot_token'], $_POST['teligram_chat_id']);
	}

	function teligram() {
		echo $this->Admin_api_model->teligram($_POST['telegram_token'], $_POST['telegram_chat_id'], $_POST['Heading'], $_POST['Message'], $_POST['image']);
	}

	function update_sub_setting() {
		echo $this->Admin_api_model->update_sub_setting($_POST['razorpay_status_int'], $_POST['razorpay_key_id'], $_POST['razorpay_key_secret'], $_POST['paypal_status_int'], $_POST['paypal_clint_id'], $_POST['flutterwave_status'], $_POST['flutterwave_public_key'], $_POST['flutterwave_secret_key'], $_POST['flutterwave_encryption_key']);
	}

	function get_all_genres() {
		echo $this->Admin_api_model->get_all_genres();
	}

	function delete_genre() {
		echo $this->Admin_api_model->delete_genre($_POST['genreID']);
	}

	function add_genre() {
		echo $this->Admin_api_model->add_genre($_POST['modal_Genre_Name'], $_POST['modal_Genre_Icon'], $_POST['modal_Genre_Description'], $_POST['Genre_Featured'], $_POST['Genre_Status']);
	}

	function get_genre_details() {
		echo $this->Admin_api_model->get_genre_details($_POST['genreID']);
	}

	function update_genre_details() {
		echo $this->Admin_api_model->update_genre_details($_POST['Edit_modal_Genre_id'], $_POST['Edit_modal_Genre_Name'], $_POST['Edit_modal_Genre_Icon'], $_POST['Edit_modal_Genre_Description'], $_POST['Edit_Genre_Featured'], $_POST['Edit_Genre_Status']);
	}

	function get_all_subscriptions() {
		echo $this->Admin_api_model->get_all_subscriptions();
	}

	function create_sub_plan() {
		echo $this->Admin_api_model->create_sub_plan($_POST['modal_plan_name'], $_POST['modal_time'], $_POST['modal_ammount'], $_POST['modal_currency'], $_POST['modal_bg_image_url'], $_POST['f_Subscription_Type'], $_POST['Publish_toggle_int']);
	}

	function delete_sub_plan() {
		echo $this->Admin_api_model->delete_sub_plan($_POST['subscriptionID']);
	}

	function get_all_coupons() {
		echo $this->Admin_api_model->get_all_coupons();
	}

	function get_coupon_details() {
		echo json_encode($this->Admin_api_model->get_coupon_details($_POST['couponID']));
	}

	function create_coupon() {
		echo $this->Admin_api_model->create_coupon($_POST['Name'], $_POST['Coupon_Code'], $_POST['Time'], $_POST['Amount'], $_POST['Max_Use'], $_POST['Status_Count'], $_POST['f_Subscription_Type'], $_POST['add_expire_date']);
	}

	function delete_coupon() {
		echo $this->Admin_api_model->delete_coupon($_POST['couponID']);
	}

	function update_coupon_details() {
		echo $this->Admin_api_model->update_coupon_details($_POST['Edit_ID'], $_POST['Edit_Name'], $_POST['Edit_Coupon_Code'], $_POST['Edit_Time'], $_POST['Edit_Amount'], $_POST['Edit_Max_Use'], $_POST['Edit_Status_Count'], $_POST['f_Edit_Subscription_Type'], $_POST['expire_date']);
	}

	function save_onesignal_data() {
		echo $this->Admin_api_model->save_onesignal_data($_POST['Onesignal_Api_Key'], $_POST['Onesignal_Appid']);
	}

	function add_movie_links() {
		echo $this->Admin_api_model->add_movie_links($_POST['Movie_id'], $_POST['Label'], $_POST['Order'], $_POST['Quality'], $_POST['Size'], $_POST['Source'], $_POST['Url'], $_POST['Status'], $_POST['skip_available_Count'], $_POST['intro_start'], $_POST['intro_end'], $_POST['link_type'], $_POST['end_credits_marker'], $_POST['drm_uuid'], $_POST['drm_license_uri']);
	}

	function get_movie_link_details() {
		echo json_encode($this->Admin_api_model->get_movie_link_details($_POST['movie_play_link_ID']));
	}

	function update_movie_link_data() {
		echo $this->Admin_api_model->update_movie_link_data($_POST['ID'], $_POST['Label'], $_POST['Order'], $_POST['Quality'], $_POST['Size'], $_POST['Source'], $_POST['Url'], $_POST['Status'], $_POST['modal_skip_available_Count'], $_POST['modal_intro_start'], $_POST['modal_intro_end'], $_POST['link_type'], $_POST['end_credits_marker'], $_POST['drm_uuid_modal'], $_POST['drm_license_uri_modal']);
	}

	function delete_movie_link_api() {
		echo $this->Admin_api_model->delete_movie_link_api($_POST['movie_play_link_ID']);
	}

	function add_subtitle() {
		echo $this->Admin_api_model->add_subtitle($_POST['content_id'], $_POST['content_type'], $_POST['modal_add_Language'], $_POST['modal_add_Subtitle_url'], $_POST['modal_add_Mimetype'], $_POST['Status_int']);
	}

	function get_subtitle_details() {
		echo json_encode($this->Admin_api_model->get_subtitle_details($_POST['subtitleID']));
	}

	function update_subtitle() {
		echo $this->Admin_api_model->update_subtitle($_POST['edit_subtitle_id'], $_POST['modal_edit_Language'], $_POST['edit_subtitle_url'], $_POST['modal_edit_mimetype'], $_POST['Status']);
	}

	function delete_subtitle() {
		echo $this->Admin_api_model->delete_subtitle($_POST['subtitleID']);
	}

	function add_movie_download_links() {
		echo $this->Admin_api_model->add_movie_download_links($_POST['Movie_id'], $_POST['Label'], $_POST['Order'], $_POST['Quality'], $_POST['Size'], $_POST['Source'], $_POST['Url'], $_POST['download_type'], $_POST['Status']);
	}

	function get_movie_download_link_details() {
		echo json_encode($this->Admin_api_model->get_movie_download_link_details($_POST['movie_download_link_id']));
	}

	function update_movie_download_link_data() {
		echo $this->Admin_api_model->update_movie_download_link_data($_POST['ID'], $_POST['Label'], $_POST['Order'], $_POST['Quality'], $_POST['Size'], $_POST['Source'], $_POST['Url'], $_POST['Status'], $_POST['download_type']);
	}

	function delete_download_link() {
		echo $this->Admin_api_model->delete_download_link($_POST['movie_download_link_ID']);
	}

	function getUserData() {
		echo json_encode($this->Admin_api_model->getUserData($_POST['userEmail']));
	}

	function update_self_data() {
		echo $this->Admin_api_model->update_self_data($_POST['Edit_modal_User_id'], $_POST['Edit_modal_User_Name'], $_POST['Edit_modal_Email'], $_POST['Edit_modal_Password']);
	}

	function get_all_channel() {
		echo $this->Admin_api_model->get_all_channel();
	}

	function get_all_webseries() {
		echo $this->Admin_api_model->get_all_webseries();
	}

	function add_channel() {
		echo $this->Admin_api_model->add_channel($_POST['name'], $_POST['POSTER'], $_POST['Stream_Type'], $_POST['Stream_Link'], $_POST['status'], $_POST['Featured'], $_POST['type'], $_POST['user_agent'], $_POST['headers'], $_POST['drm_uuid'], $_POST['drm_license_uri']);
	}

	function delete_channel() {
		echo $this->Admin_api_model->delete_channel($_POST['channelID']);
	}

	function update_channel_data() {
		echo $this->Admin_api_model->update_channel_data($_POST['channelID'], $_POST['name'], $_POST['Stream_Type'], $_POST['Stream_Link'], $_POST['type'], $_POST['POSTER'], $_POST['Featured'], $_POST['status'], $_POST['user_agent'], $_POST['headers'], $_POST['drm_uuid'], $_POST['drm_license_uri']);
	}

	function add_web_series() {
		echo $this->Admin_api_model->add_web_series($_POST['TMDB_ID'], $_POST['name'], $_POST['description'], $_POST['genres'], $_POST['release_date'], $_POST['poster'], $_POST['banner'], $_POST['youtube_trailer'], $_POST['downloadable'], $_POST['type'], $_POST['status']);
	}

	function delete_web_series() {
		echo $this->Admin_api_model->delete_web_series($_POST['WebSeriesID']);
	}

	function Update_web_series() {
		echo $this->Admin_api_model->Update_web_series($_POST['WebSeriesID'], $_POST['name'], $_POST['description'], $_POST['genres'], $_POST['release_date'], $_POST['poster'], $_POST['banner'], $_POST['youtube_trailer'], $_POST['downloadable'], $_POST['type'], $_POST['status']);
	}

	function add_season() {
		echo $this->Admin_api_model->add_season($_POST['webseries_id'], $_POST['modal_Season_Name'], $_POST['modal_Order'], $_POST['Modal_Status']);
	}

	function delete_season() {
		echo $this->Admin_api_model->delete_season($_POST['WebSeriesID']);
	}

	function getSeasonData() {
		echo json_encode($this->Admin_api_model->getSeasonData($_POST['seasonID']));
	}

	function update_season() {
		echo $this->Admin_api_model->update_season($_POST['modal_season_id'], $_POST['edit_modal_Season_Name'], $_POST['edit_modal_Order'], $_POST['Modal_Status']);
	}

	function add_episode() {
		echo $this->Admin_api_model->add_episode($_POST['season_id'], $_POST['modal_Episodes_Name'], $_POST['modal_Thumbnail'], $_POST['modal_Order'], $_POST['modal_Source'], $_POST['modal_Url'], $_POST['modal_Description'], $_POST['Downloadable'], $_POST['Type'], $_POST['Status'], $_POST['add_modal_skip_available_Count'], $_POST['add_modal_intro_start'], $_POST['add_modal_intro_end'], $_POST['end_credits_marker'], $_POST['drm_uuid_addModal'], $_POST['drm_license_uri_addModal']);
	}

	function delete_episode() {
		echo $this->Admin_api_model->delete_episode($_POST['episoadID']);
	}

	function getEpisodeDetails() {
		echo json_encode($this->Admin_api_model->getEpisodeDetails($_POST['episoadID']), JSON_UNESCAPED_SLASHES);
	}

	function updateEpisode() {
		echo $this->Admin_api_model->updateEpisode($_POST['Edit_modal_videos_id'], $_POST['Edit_modal_Episodes_Name'], $_POST['Edit_modal_Thumbnail'], $_POST['Edit_modal_Order'], $_POST['Edit_modal_Source'], $_POST['Edit_modal_Url'], $_POST['Edit_modal_Description'], $_POST['Edit_Downloadable'], $_POST['Edit_Type'], $_POST['Edit_Status'], $_POST['edit_modal_skip_available_Count'], $_POST['edit_modal_intro_start'], $_POST['edit_modal_intro_end'], $_POST['end_credits_marker'], $_POST['drm_uuid_editModal'], $_POST['drm_license_uri_editModal']);
	}

	function add_episode_download_link() {
		echo $this->Admin_api_model->add_episode_download_link($_POST['EpisodeID'], $_POST['Label'], $_POST['Order'], $_POST['Quality'], $_POST['Size'], $_POST['Source'], $_POST['Url'], $_POST['download_type'], $_POST['Status']);
	}

	function delete_episode_download_link() {
		echo $this->Admin_api_model->delete_episode_download_link($_POST['episoadDownloadLinkID']);
	}

	function get_episoad_download_link_details() {
		echo json_encode($this->Admin_api_model->get_episoad_download_link_details($_POST['episoadDownloadLinkID']), JSON_UNESCAPED_SLASHES);
	}

	function update_episode_download_link_data() {
		echo $this->Admin_api_model->update_episode_download_link_data($_POST['episoadDownloadLinkID'], $_POST['Label'], $_POST['Order'], $_POST['Quality'], $_POST['Size'], $_POST['Source'], $_POST['Url'], $_POST['download_type'], $_POST['Status']);
	}

	function License_Setting() {
		echo $this->Admin_api_model->License_Setting($_POST['license_code']);
	}

	function ImportDbFile() {
		$upload_path = 'uploads/db/';

		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		} else {
			delete_files($upload_path, TRUE);
		}

		if(!empty($_FILES['file']['name'])){

			// Set preference
			$config['upload_path'] = $upload_path; 
			$config['allowed_types'] = '*';
			$config['max_size'] = '256000'; // max_size in kb
			$config['file_name'] = $_FILES['file']['name'];
	   
			//Load upload library
			$this->load->library('upload',$config); 
	   
			// File upload
			if($this->upload->do_upload('file')){
				echo $upload_path.$_FILES['file']['name'];
			}
		}
	}

	function processImportedDb() {
		echo $this->Admin_api_model->processImportedDb($_POST['fullPath']);
	}

	function get_tmdb_id() {
		echo $this->Admin_api_model->get_tmdb_id($_POST['Type'], $_POST['id']);
	}

	function customSplashUiCode() {
		$fp = fopen(APPPATH.'views/extras/splash.php', "w");
		fwrite($fp, $_POST['code']);
        fclose($fp);
		return true;
	}

	public function GenerateSecrateCronKey() {
		echo $this->Admin_api_model->GenerateSecrateCronKey();
	}

	public function CronStatus() {
		echo $this->Admin_api_model->CronStatus($_POST['cron_status']);
	}

	public function TruncateTables() {
		echo $this->Admin_api_model->TruncateTables($_POST['tables']);
	}

}