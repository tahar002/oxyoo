<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/RestController.php');
use chriskacerguis\RestServer\RestController;

require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

class Android_api extends RestController {
    function __construct()
    {
        parent::__construct();
        $this->load->model('RestApi/Android/Android_api_model');
        $this->load->model('Password_reset_model');
    }

    function AppConfig() {
        $this->db->where('id', 1);
        $q = $this->db->get('config');
        $g = $q->result_array();
        $data = array_shift($g);
        return $data;
    }

    public function appConfig_get() {
        $JWTkey = $this->AppConfig()['api_key'];
        $token['config'] = $this->AppConfig();
        $date = new DateTime();
        $token['iat'] = $date->getTimestamp();
        $token['exp'] = $date->getTimestamp() + 60*60*5;
        $output['token'] = JWT::encode($token,$JWTkey );
        $this->set_response($output, RestController::HTTP_OK);
    }

    public function dmVyaWZ5_get() {
        $license_code = $this->AppConfig()['license_code'];
        $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://cloud.team-dooo.com/Dooo/verify/?code=$license_code",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
              ),
            ));
            
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                echo "false";
            } else {
                echo $response;
            }
    }

    public function authentication_post() {
        $decoded = base64_decode($this->post('encoded'));
        list($Request_Type) = explode(":",$decoded);
        if($Request_Type == "login") {
          list($Type,$Email,$Password) = explode(":",$decoded);
        } else if($Request_Type == "signup") {
            list($Type,$Username,$Email,$Password) = explode(":",$decoded);
        }

        $device_id = $this->post('device');

        if($Type == "login") {
            $userLogin = $this->Android_api_model->login($Email, $Password);
            if ($userLogin != false) {  
                $Today = date_create(date("Y-m-d"));
                   $User_ID = $userLogin['id'];
                    $subscription_remaining = 0;
                    $exp = date_create($userLogin['subscription_exp']);
                    $diff=date_diff($Today,$exp);
                    if($diff->format('%R') == "+") {
                        $subscription_remaining = $diff->format('%a');
                    } else if($diff->format('%R') == "-") {
                        $subscription_remaining = 0;

                        $this->db->set('active_subscription', "Free");
                        $this->db->set('subscription_type', "0");
                        $this->db->set('time', "0");
                        $this->db->set('amount', "0");
                        $this->db->set('subscription_start', "0000-00-00");
                        $this->db->set('subscription_exp', "0000-00-00");
                        $this->db->where('id', $User_ID);
                        $this->db->update('user_db');

                        if($userLogin['active_subscription'] != "Free" || $userLogin['subscription_type'] != 0 || $userLogin['time'] != 0 || $userLogin['amount'] != 0 || $userLogin['subscription_start'] != "0000-00-00" || $userLogin['subscription_exp'] !="0000-00-00") {
                            $this->db->set('name', $userLogin['name']);
                            $this->db->set('amount', $userLogin['amount']);
                            $this->db->set('time', $userLogin['time']);
                            $this->db->set('subscription_start', $userLogin['subscription_start']);
                            $this->db->set('subscription_exp', $userLogin['subscription_exp']);
                            $this->db->set('user_id', $User_ID);
                            $this->db->insert('subscription_log');
                        }
                    }

                $userLogin = $this->Android_api_model->login($Email, $Password);
                $this->Android_api_model->update_device_id($device_id, $User_ID);
                $output = array("Status"=>"Successful", "ID"=>$userLogin['id'], "Name"=>$userLogin['name'], "Email"=>$userLogin['email'], "Password"=>$userLogin['password'], "Role"=>$userLogin['role'], "active_subscription"=>$userLogin['active_subscription'], "subscription_type"=>$userLogin['subscription_type'], "subscription_exp"=>$userLogin['subscription_exp'], "subscription_remaining"=>$subscription_remaining);
                $this->set_response($output, RestController::HTTP_OK);
            } else {
                $output['Status'] = "Invalid Credential";
                $this->set_response($output, RestController::HTTP_OK);
            }  
        }else if($Type == "signup") {
            if($this->Android_api_model->checkIfDisposableEmail($Email)) {
                $output['Status'] = "Disposable Emails are not allowed";
                $this->set_response($output, RestController::HTTP_OK);
            } else {
                if($this->Android_api_model->signup($Username, $Email, $Password)) {
                    $userLogin = $this->Android_api_model->login($Email, $Password);
                    $this->Android_api_model->update_device_id($device_id, $userLogin['id']);
                    $output = array("Status"=>"Successful", "ID"=>$userLogin['id'], "Name"=>$userLogin['name'], "Email"=>$userLogin['email'], "Password"=>$userLogin['password'], "Role"=>$userLogin['role'], "active_subscription"=>$userLogin['active_subscription'], "subscription_type"=>$userLogin['subscription_type'], "subscription_exp"=>$userLogin['subscription_exp']);
                    $this->set_response($output, RestController::HTTP_OK);
                } else {
                    $output['Status'] = "Email Already Regestered";
                    $this->set_response($output, RestController::HTTP_OK);
                }
            }
        }else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    public function getCustomImageSlider_get() {
        $CustomImageSliderData = $this->Android_api_model->getCustomImageSlider();
        if($CustomImageSliderData != "") {
            $this->set_response($CustomImageSliderData, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
        
    }

    public function getMovieImageSlider_get() {
        $MovieImageSliderData = $this->Android_api_model->getMovieImageSlider();
        if($MovieImageSliderData != "") {
            $this->set_response($MovieImageSliderData, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getWebSeriesImageSlider_get() {
        $WebSeriesImageSliderData = $this->Android_api_model->getWebSeriesImageSlider();
        if($WebSeriesImageSliderData != "") {
            $this->set_response($WebSeriesImageSliderData, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getFeaturedLiveTV_get() {
        $FeaturedLiveTV = $this->Android_api_model->getFeaturedLiveTV();
        if($FeaturedLiveTV != "") {
            $this->set_response($FeaturedLiveTV, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getAllLiveTV_get() {
        $AllLiveTV = $this->Android_api_model->getAllLiveTV();
        if($AllLiveTV != "") {
            $this->set_response($AllLiveTV, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function searchLiveTV_post() {
        $SearchLiveTV = $this->Android_api_model->searchLiveTV($this->post('search'), $this->post('onlypremium'));
        if($SearchLiveTV != "") {
            $this->set_response($SearchLiveTV, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getRandMovies_get() {
        $RandMovies = $this->Android_api_model->getRandMovies();
        if($RandMovies != "") {
            $this->set_response($RandMovies, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getRandWebSeries_get() {
        $RandWebSeries = $this->Android_api_model->getRandWebSeries();
        if($RandWebSeries != "") {
            $this->set_response($RandWebSeries, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getMovieDetails_get($movieID) {
        $MovieDetails = $this->Android_api_model->getMovieDetails($movieID);
        if($MovieDetails != "") {
            $this->set_response($MovieDetails, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getWebSeriesDetails_get($seriesID) {
        $WebSeriesDetails = $this->Android_api_model->getWebSeriesDetails($seriesID);
        if($WebSeriesDetails != "") {
            $this->set_response($WebSeriesDetails, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getLiveTVDetails_get($ID) {
        $LiveTVDetails = $this->Android_api_model->getLiveTVDetails($ID);
        if($LiveTVDetails != "") {
            $this->set_response($LiveTVDetails, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getRecentContentList_get($type) {
        if($type == "Movies") {
            $RecentMovieList = $this->Android_api_model->getRecentMovieList();
            if($RecentMovieList != "") {
                $this->set_response($RecentMovieList, RestController::HTTP_OK);
            } else {
                echo "No Data Avaliable";
            }
        } else if ($type == "WebSeries") {
            $RecentWebSeriesList = $this->Android_api_model->getRecentWebSeriesList();
            if($RecentWebSeriesList != "") {
                $this->set_response($RecentWebSeriesList, RestController::HTTP_OK);
            } else {
                echo "No Data Avaliable";
            }
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getMostWatched_get($type, $limit) {
        if($type == "Movies") {
            $MostWatchedMovies = $this->Android_api_model->getMostWatchedMovies($limit);
            if($MostWatchedMovies != "") {
                $this->set_response($MostWatchedMovies, RestController::HTTP_OK);
            } else {
                echo "No Data Avaliable";
            }
        } else if ($type == "WebSeries") {
            $MostWatchedWebSeries = $this->Android_api_model->getMostWatchedWebSeries($limit);
            if($MostWatchedWebSeries != "") {
                $this->set_response($MostWatchedWebSeries, RestController::HTTP_OK);
            } else {
                echo "No Data Avaliable";
            }
        } else {
            echo "No Data Avaliable";
        }
    }

    public function beacauseYouWatched_get($type, $userID, $limit) {
        if($type == "Movies") {
            $beacauseYouWatchedMovie = $this->Android_api_model->beacauseYouWatchedMovie($userID, $limit);
            if($beacauseYouWatchedMovie != "") {
                $this->set_response($beacauseYouWatchedMovie, RestController::HTTP_OK);
            } else {
                echo "No Data Avaliable";
            }
        } else if ($type == "WebSeries") {
            $beacauseYouWatchedWebSeries = $this->Android_api_model->beacauseYouWatchedWebSeries($userID, $limit);
            if($beacauseYouWatchedWebSeries != "") {
                $this->set_response($beacauseYouWatchedWebSeries, RestController::HTTP_OK);
            } else {
                echo "No Data Avaliable";
            }
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getAllMovies_get($page = 0) {
        $allMovies = $this->Android_api_model->getAllMovies($page);
        if($allMovies != "") {
            $this->set_response($allMovies, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getAllWebSeries_get($page = 0) {
        $allWebSeries = $this->Android_api_model->getAllWebSeries($page);
        if($allWebSeries != "") {
            $this->set_response($allWebSeries, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getComments_get($content_id, $content_type) {
        $Comments = $this->Android_api_model->getComments($content_id, $content_type);
        if($Comments != "") {
            $this->set_response($Comments, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function addComments_post() {
        $CommentID = $this->Android_api_model->addComments();
        if($CommentID != "") {
            $this->set_response($CommentID, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getSeasons_get($WebSeriesID) {
        $Seasons = $this->Android_api_model->getSeasons($WebSeriesID);
        if($Seasons != "") {
            $this->set_response($Seasons, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getSeasonDetails_post() {
        $SeasonDetails = $this->Android_api_model->getSeasonDetails($this->post('WebSeriesID'), $this->post('seasonName'));
        if($SeasonDetails != "") {
            $this->set_response($SeasonDetails, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }
    
    public function getEpisodes_get($seasonID) {
        $Episodes = $this->Android_api_model->getEpisodes($seasonID);
        if($Episodes != "") {
            $this->set_response($Episodes, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getRelatedWebseries_post($id, $limit) {
        $RelatedWebseries = $this->Android_api_model->getRelatedWebseries($id, $this->post('genres'), $limit);
        if($RelatedWebseries != "") {
            $this->set_response($RelatedWebseries, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getRelatedMovies_post($id, $limit) {
        $RelatedMovies = $this->Android_api_model->getRelatedMovies($id, $this->post('genres'), $limit);
        if($RelatedMovies != "") {
            $this->set_response($RelatedMovies, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function favourite_get($TYPE, $USER_ID, $CONTENT_TYPE, $CONTENT_ID) {
        if($TYPE == "SET") {
            echo $this->Android_api_model->setFavourite($USER_ID, $CONTENT_TYPE, $CONTENT_ID);
        } else if($TYPE == "SEARCH") {
            echo $this->Android_api_model->getFavourite($USER_ID, $CONTENT_TYPE, $CONTENT_ID);
        } else if($TYPE == "REMOVE") {
            echo $this->Android_api_model->removeFavourite($USER_ID, $CONTENT_TYPE, $CONTENT_ID);
        }
    }

    public function getFavouriteList_get($USER_ID) {
        $FavouriteList = $this->Android_api_model->getFavouriteList($USER_ID);
        if($FavouriteList != "") {
            $this->set_response($FavouriteList, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function createReport_post() {
        $Report = $this->Android_api_model->createReport($this->post('user_id'), $this->post('title'), $this->post('description'), $this->post('report_type'));
        if($Report != "") {
            $this->set_response($Report, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getMovieDownloadLinks_get($MovieID) {
        $MovieDownloadLinks = $this->Android_api_model->getMovieDownloadLinks($MovieID);
        if($MovieDownloadLinks != "") {
            $this->set_response($MovieDownloadLinks, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getMoviePlayLinks_get($MovieID) {
        $MoviePlayLinks = $this->Android_api_model->getMoviePlayLinks($MovieID);
        if($MoviePlayLinks != "") {
            $this->set_response($MoviePlayLinks, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getGenreList_get() {
        $GenreList = $this->Android_api_model->getGenreList();
        if($GenreList != "") {
            $this->set_response($GenreList, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getContentsReletedToGenre_get($search) {
        $ContentsReletedToGenre = $this->Android_api_model->getContentsReletedToGenre($search);
        if($ContentsReletedToGenre != "") {
            $this->set_response($ContentsReletedToGenre, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getLiveTvReletedToGenre_get($search) {
        $ContentsReletedToGenre = $this->Android_api_model->getLiveTvReletedToGenre($search);
        if($ContentsReletedToGenre != "") {
            $this->set_response($ContentsReletedToGenre, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getFeaturedGenre_get() {
        $FeaturedGenre = $this->Android_api_model->getFeaturedGenre();
        if($FeaturedGenre != "") {
            $this->set_response($FeaturedGenre, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getLiveTvGenre_get() {
        $FeaturedGenre = $this->Android_api_model->getLiveTvGenre();
        if($FeaturedGenre != "") {
            $this->set_response($FeaturedGenre, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function addRequest_post() {
        $Request = $this->Android_api_model->addRequest($this->post('user_id'), $this->post('title'), $this->post('description'), $this->post('type'), $this->post('status'));
        if($Request != "") {
            $this->set_response($Request, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function searchContent_get($search, $onlypremium) {
        $searchContent = $this->Android_api_model->searchContent($search, $onlypremium);
        if($searchContent != "") {
            $this->set_response($searchContent, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getSubscriptionLog_get($userID) {
        $SubscriptionLog = $this->Android_api_model->getSubscriptionLog($userID);
        if($SubscriptionLog != "") {
            $this->set_response($SubscriptionLog, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getSubscriptionPlans_get() {
        $SubscriptionPlans = $this->Android_api_model->getSubscriptionPlans();
        if($SubscriptionPlans != "") {
            $this->set_response($SubscriptionPlans, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getSubscriptionDetails_get($ID) {
        $SubscriptionDetails = $this->Android_api_model->getSubscriptionDetails($ID);
        if($SubscriptionDetails != "") {
            $this->set_response($SubscriptionDetails, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function redeemCoupon_post() {
        echo $this->Android_api_model->redeemCoupon($this->post('couponCode'), $this->post('C_User_ID'));
    }

    public function registerDevice_post() {
        $registerDevice = $this->Android_api_model->registerDevice($this->post('device'));
        $this->set_response($registerDevice, RestController::HTTP_OK);
    }

    public function updateAccount_post() {
        echo $this->Android_api_model->updateAccount($this->post('UserID'), $this->post('UserName'), $this->post('Email'), $this->post('Password'));
    }

    public function passwordResetMail_post() {
        $this->Password_reset_model->password_reset_mail($_POST['mail']);
	}

    public function passwordResetCheckCode_post() {
        $this->Password_reset_model->checkCode($_POST['code']);
	}

    public function passwordResetPassword_post() {
        $this->Password_reset_model->password_reset($_POST['code'], $_POST['pass']);
	}

    public function addviewlog_post() {
        echo $this->Android_api_model->addviewlog($_POST['user_id'], $_POST['content_id'], $_POST['content_type']);
    }

    public function addwatchlog_post() {
        echo $this->Android_api_model->addwatchlog($_POST['user_id'], $_POST['content_id'], $_POST['content_type']);
    }

    public function getsubtitle_post($content_id, $ct) {
        $subtitles = $this->Android_api_model->getsubtitle($content_id, $ct);
        if($subtitles != "") {
            $this->set_response($subtitles, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getcontentidfromurl_post($main_content_id, $ct) {
        $contentid = $this->Android_api_model->getcontentidfromurl($main_content_id, $_POST['url'], $ct);
        if($contentid != "") {
            $this->set_response($contentid, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }
    public function getEpisodeDownloadLinks_get($episode_id) {
        $EpisodeDownloadLinks = $this->Android_api_model->getEpisodeDownloadLinks($episode_id);
        if($EpisodeDownloadLinks != "") {
            $this->set_response($EpisodeDownloadLinks, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }
    public function dXBncmFkZQ_post() {
        $dXBncmFkZQ = $this->Android_api_model->dXBncmFkZQ($_POST["User_ID"], $_POST["name"], $_POST["subscription_type"], $_POST["time"], $_POST["amount"]);
        if($dXBncmFkZQ) {
            echo "Account Upgraded Succefully";
        } else {
            echo "No Data Avaliable";
        }
    }

    public function sufflePlay_get() {
        $sufflePlay = $this->Android_api_model->sufflePlay();
        if($sufflePlay != "") {
            $this->set_response($sufflePlay, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getAllUpcomingContents_get($page = 0) {
        $allMovies = $this->Android_api_model->getAllUpcomingContents($page);
        if($allMovies != "") {
            $this->set_response($allMovies, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function otpVerifyMail_post() {
        $this->Android_api_model->otpVerifyMail($_POST['mail'], $_POST['type']);
	}

    public function verifyOTP_post() {
        $this->Android_api_model->verifyOTP($_POST['code']);
	}

    public function check_device_get($userID) {
        $userLogin = $this->Android_api_model->getuser($userID);
        $Today = date_create(date("Y-m-d"));
                   $User_ID = $userLogin->id;
                    $subscription_remaining = 0;
                    $exp = date_create($userLogin->subscription_exp);
                    $diff=date_diff($Today,$exp);
                    if($diff->format('%R') == "+") {
                        $subscription_remaining = $diff->format('%a');
                    } else if($diff->format('%R') == "-") {
                        $subscription_remaining = 0;

                        $this->db->set('active_subscription', "Free");
                        $this->db->set('subscription_type', "0");
                        $this->db->set('time', "0");
                        $this->db->set('amount', "0");
                        $this->db->set('subscription_start', "0000-00-00");
                        $this->db->set('subscription_exp', "0000-00-00");
                        $this->db->where('id', $User_ID);
                        $this->db->update('user_db');

                        if($userLogin->active_subscription != "Free" || $userLogin->subscription_type != 0 || $userLogin->time != 0 || $userLogin->amount != 0 || $userLogin->subscription_start != "0000-00-00" || $userLogin->subscription_exp !="0000-00-00") {
                            $this->db->set('name', $userLogin->name);
                            $this->db->set('amount', $userLogin->amount);
                            $this->db->set('time', $userLogin->time);
                            $this->db->set('subscription_start', $userLogin->subscription_start);
                            $this->db->set('subscription_exp', $userLogin->subscription_exp);
                            $this->db->set('user_id', $User_ID);
                            $this->db->insert('subscription_log');
                        }
                    }

        $userLogin = $this->Android_api_model->getuser($userID);
        $output = array("Status"=>"successful", "ID"=>$userLogin->id, "Name"=>$userLogin->name, "Email"=>$userLogin->email, "Password"=>$userLogin->password, "Role"=>$userLogin->role, "active_subscription"=>$userLogin->active_subscription, "subscription_type"=>$userLogin->subscription_type, "subscription_exp"=>$userLogin->subscription_exp, "subscription_remaining"=>$subscription_remaining, "device_id"=>$userLogin->device_id);
        $this->set_response($output, RestController::HTTP_OK);
    }

    public function custom_payment_type_get() {
        $custom_payment_type = $this->Android_api_model->custom_payment_type();
        if($custom_payment_type != "") {
            $this->set_response($custom_payment_type, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function custom_payment_request_post() {
        echo $this->Android_api_model->custom_payment_request($_POST['user_id'], $_POST['payment_type'], $_POST['payment_details'], $_POST['subscription_name'], $_POST['subscription_type'], $_POST['subscription_time'], $_POST['subscription_amount'], $_POST['subscription_currency'], $_POST['uploaded_image']);
    }

    public function getTrending_get() {
        $MostWatched = $this->Android_api_model->getTrending();
        if($MostWatched != "") {
            $this->set_response($MostWatched, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }

    public function getMostSearched_get() {
        $MostWatched = $this->Android_api_model->getMostSearched();
        if($MostWatched != "") {
            $this->set_response($MostWatched, RestController::HTTP_OK);
        } else {
            echo "No Data Avaliable";
        }
    }
}