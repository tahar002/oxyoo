<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Android_api_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function AppConfig() {
        $this->db->where('id', 1);
        $q = $this->db->get('config');
        $g = $q->result_array();
        $data = array_shift($g);
        return $data;
    }

	function login($email, $password) {
        $this->db->where('email', $email);  
        $this->db->where('password', $password);  
        $query = $this->db->get('user_db');  
  
        if ($query->num_rows() == 1) {  
            $g = $query->result_array();
            $data = array_shift($g);
            return $data;
        } else {
            return false;  
        }  
	}

	function checkIfDisposableEmail($email) {
		$mailDomain = explode ("@", $email)[1];
		$this->db->where('emails', $mailDomain);
        $query = $this->db->get('disposable_emails'); 
		if ($query->num_rows() > 0) {
			return true;
		} else {
        	return false;
        }
	}

	function signup($name, $email, $password) {
		$this->db->where('email', $email);
        $query = $this->db->get('user_db');  
 
        if (!$query->num_rows() > 0)  
        { 
        	$data = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
				'active_subscription' => 'Free',
                'subscription_start' => '0000-00-00',
                'subscription_exp' => '0000-00-00'
            );

            if ($this->db->insert('user_db', $data))  
            {  
                return true;  
            } else {  
                return false;  
            } 
        } else {
        	return false;
        }
	}

	function getCustomImageSlider() {
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('image_slider');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
        
	}

	function getMovieImageSlider() {
		$this->db->limit($this->AppConfig()['movie_image_slider_max_visible']);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('movies');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getWebSeriesImageSlider() {
		$this->db->limit($this->AppConfig()['webseries_image_slider_max_visible']);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('web_series');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getFeaturedLiveTV() {
		$this->db->where('featured', '1');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('live_tv_channels');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getAllLiveTV() {
		$query = $this->db->get('live_tv_channels');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function searchLiveTV($search_term, $includePremium) {
		if(strlen($search_term) > 2) {
			$this->db->order_by('id', 'DESC');
			if($includePremium == 0) {
				$this->db->where('type', '0');
			} else if($includePremium == 1) {
				//$this->db->where('type', '1');
			}
			$json =array(); 
			$this->db->like('name',$search_term);
			$query  =   $this->db->get('live_tv_channels');
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$json[] = $row;
				}
				if(json_encode($json) != "[]") {
					return $json;
				}
			}
		}
	}

	function getRandMovies() {
		$this->db->limit($this->AppConfig()['Home_Rand_Max_Movie_Show']);
		$this->db->order_by('id', 'RANDOM');
		$query = $this->db->get('movies');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getRandWebSeries() {
		$this->db->limit($this->AppConfig()['Home_Rand_Max_Series_Show']);
		$this->db->order_by('id', 'RANDOM');
		$query = $this->db->get('web_series');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getMovieDetails($movieID) {
		$this->db->where('id', $movieID);
        $q = $this->db->get('movies');
		if ($q->num_rows() > 0) {
			$g = $q->result_array();
            $data = array_shift($g);
            return $data;
	    }
        
	}

	function getWebSeriesDetails($seriesID) {
		$this->db->where('id', $seriesID);
        $q = $this->db->get('web_series');
		if ($q->num_rows() > 0) {
			$g = $q->result_array();
            $data = array_shift($g);
            return $data;
	    }
	}

	function getLiveTVDetails($ID) {
		$this->db->where('id', $ID);
        $q = $this->db->get('live_tv_channels');
		if ($q->num_rows() > 0) {
			$g = $q->result_array();
            $data = array_shift($g);
            return $data;
	    }
	}

	function getRecentMovieList() {
		$this->db->limit($this->AppConfig()['Home_Recent_Max_Movie_Show']);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('movies');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
    }

	function getRecentWebSeriesList() {
		$this->db->limit($this->AppConfig()['Home_Recent_Max_Series_Show']);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('web_series');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
    }


	function getMostWatchedMovies($limit) {
        $json =array();
        $query = $this->db->select('*,count(content_id) as max')
            ->like('content_type', 1, 'none')
            ->group_by('content_id')
            ->order_by('max DESC')
            ->get('view_log', $limit);
			
		foreach ($query->result() as $row) {
			$movieDetails = $this->getMovieDetails($row->content_id);
			if($movieDetails != "") {
				$json[] = $movieDetails;
			}
		}

        if(json_encode($json) != "[]") {
			return $json;
		}

	}

	function getMostWatchedWebSeries($limit) {
		$json =array();
        $query = $this->db->select('*,count(content_id) as max')
		    ->like('content_type', 2, 'none')
		    ->group_by('content_id')
		    ->order_by('max DESC')
		    ->get('view_log', $limit);
			
			foreach ($query->result() as $row) {
				$webSeriesDetails = $this->getWebSeriesDetails($row->content_id);
				if($webSeriesDetails != "") {
					$json[] = $webSeriesDetails;
				}
			}

        if(json_encode($json) != "[]") {
			return $json;
		}
	}

	function beacauseYouWatchedMovie($userID, $limit) {
		$this->db->where('user_id', $userID);
		$this->db->where('content_type', '1');
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('watch_log');
		$g = $query->result_array();
        $data = array_shift($g);
        if($data != "") {
            $lastWatchedContentIDWatchedByUser = $data['content_id'];
            if($this->getMovieDetails($lastWatchedContentIDWatchedByUser) != "") {
                $lastWatchedMovieGenres = $this->getMovieDetails($lastWatchedContentIDWatchedByUser)['genres'];
    
		        $single_MovieGenres = explode(',', $lastWatchedMovieGenres);
		        foreach ($single_MovieGenres as $value) {
		            $this->db->limit($limit);
		            $this->db->like('genres', $value);
		            $this->db->order_by('id', 'DESC');
		            $query = $this->db->get('movies');
		            if ($query->num_rows() > 0) {
		            	foreach ($query->result() as $row) {
		            		$json[] = $row;
		            	}
		            	return $json;
	                }
	            }
            }
        }
        
		
	}

	function beacauseYouWatchedWebSeries($userID, $limit) {
		$this->db->where('user_id', $userID);
		$this->db->where('content_type', '2');
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('watch_log');
		$g = $query->result_array();
        $data = array_shift($g);
        if($data != "") {
            $lastWatchedContentIDWatchedByUser = $data['content_id'];
            if($this->getWebSeriesDetails($lastWatchedContentIDWatchedByUser) != "") {
                $lastWatchedMovieGenres = $this->getWebSeriesDetails($lastWatchedContentIDWatchedByUser)['genres'];
    
		        $single_MovieGenres = explode(',', $lastWatchedMovieGenres);
		        foreach ($single_MovieGenres as $value) {
		            $this->db->limit($limit);
		            $this->db->like('genres', $value);
		            $this->db->order_by('id', 'DESC');
		            $query = $this->db->get('web_series');
		            if ($query->num_rows() > 0) {
		            	foreach ($query->result() as $row) {
		            		$json[] = $row;
		            	}
		            	return $json;
	                }
	            }
            }
        }
        
		
	}

	function getAllMovies($page = 0) {
		if($page > 0) {
			$page_num = filter_var($page, FILTER_VALIDATE_INT,[
                'options' => [
                    'default' => 1,
                    'min_range' => 1
                ]
            ]); 
			$page_limit = 20;
			$page_offset = $page_limit * ($page_num - 1);
			$json =array();

			$this->db->limit($page_limit, $page_offset);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('movies');
		    if ($query->num_rows() > 0) {
		    	foreach ($query->result() as $row) {
		    		$json[] = $row;
		    	}
		    	return $json;
	        }

		} else {
			$this->db->order_by('id', 'DESC');
		    $query = $this->db->get('movies');
		    if ($query->num_rows() > 0) {
		    	foreach ($query->result() as $row) {
		    		$json[] = $row;
		    	}
		    	return $json;
	        }
		}
	}

	function getAllWebSeries($page = 0) {
		if($page > 0) {
			$page_num = filter_var($page, FILTER_VALIDATE_INT,[
                'options' => [
                    'default' => 1,
                    'min_range' => 1
                ]
            ]); 
			$page_limit = 20;
			$page_offset = $page_limit * ($page_num - 1);
			$json =array();

			$this->db->limit($page_limit, $page_offset);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('web_series');
		    if ($query->num_rows() > 0) {
		    	foreach ($query->result() as $row) {
		    		$json[] = $row;
		    	}
		    	return $json;
	        }

		} else {
			$this->db->order_by('id', 'DESC');
		    $query = $this->db->get('web_series');
		    if ($query->num_rows() > 0) {
		    	foreach ($query->result() as $row) {
		    		$json[] = $row;
		    	}
		    	return $json;
	        }
		}
	}

	function getComments($content_id, $content_type) {
		$json =array();
		$this->db->where('content_id', $content_id);
		$this->db->where('content_type', $content_type);
		$query = $this->db->get('comments');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->db->where('id', $row->user_id);
		        $query2 = $this->db->get('user_db');
				foreach ($query2->result() as $row2) {
					$json[] = array("userID"=>$row2->id, "userName"=>$row2->name, "comment"=>$row->comment);
				}
			}
			return $json;
		}
	}

	function addComments() {
		$user_id = $_POST["user_id"];
        $content_id = $_POST["content_id"];
        $content_type = $_POST["content_type"];
        $comment = $_POST["comment"];

		$data = array(
			'user_id' => $user_id,
			'content_id' => $content_id,
			'content_type' => $content_type,
			'comment' => $comment
	    );
	    $this->db->insert('comments', $data);
		return $this->db->insert_id();
	}

	function getSeasons($WebSeriesID) {
		$this->db->order_by('season_order', 'ASC');
		$this->db->where('web_series_id', $WebSeriesID);
		$query = $this->db->get('web_series_seasons');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
		}
	}

	function getSeasonDetails($WebSeriesID, $seasonName) {
		$this->db->where('Session_Name', $seasonName);
		$this->db->where('web_series_id', $WebSeriesID);
		$query = $this->db->get('web_series_seasons');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json = $row;
			}
			return $json;
		}
	}

	function getEpisodes($seasonID) {
		$this->db->order_by('episoade_order', 'ASC');
		$this->db->where('season_id', $seasonID);
		$query = $this->db->get('web_series_episoade');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
		}
	}

	function getRelatedWebseries($id, $genres, $limit) {
		$genres_single = explode(',', $genres);
		$json =array();

		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('web_series');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if($row->id != $id) {
					if(count($json) < $limit) {
						foreach ($genres_single as $value) {
							$genre = trim($value);
					
						   if (stripos($row->genres, $genre) !== false) {
								if(json_encode($json) != "[]") {
									$stat = false;
									foreach ($json as $item) {
										if ($item->id == $row->id) {
											$stat = true;
										}
									}
									if($stat == false) {
										$json[] = $row;
									}
								} else {
								  $json[] = $row; 
								}
									 
							}
						}
					}
				}
			}
			if(json_encode($json) != "[]") {
				return $json;
			}
		}
	}

	function getRelatedMovies($id, $genres, $limit) {
		$genres_single = explode(',', $genres);
		$json =array();

		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('movies');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if($row->id != $id) {
					if(count($json) < $limit) {
						foreach ($genres_single as $value) {
							$genre = trim($value);
					
						   if (stripos($row->genres, $genre) !== false) {
								if(json_encode($json) != "[]") {
									$stat = false;
									foreach ($json as $item) {
										if ($item->id == $row->id) {
											$stat = true;
										}
									}
									if($stat == false) {
										$json[] = $row;
									}
								} else {
								  $json[] = $row; 
								}
									 
							}
						}
					}
				}
			}
			if(json_encode($json) != "[]") {
				return $json;
			}
		}
	}

	function setFavourite($USER_ID, $CONTENT_TYPE, $CONTENT_ID) {
		$data = array(
			'user_id' => $USER_ID,
			'content_type' => $CONTENT_TYPE,
			'content_id' => $CONTENT_ID
	    );
	    $this->db->insert('favourite', $data);
		return "New favourite created successfully";
	}

	function getFavourite($USER_ID, $CONTENT_TYPE, $CONTENT_ID) {
		$this->db->where('user_id', $USER_ID);
		$this->db->where('content_type', $CONTENT_TYPE);
		$this->db->where('content_id', $CONTENT_ID);
		$query = $this->db->get('favourite');
		if ($query->num_rows() > 0) {
			return "Record Found";
		}
	}

	function removeFavourite($USER_ID, $CONTENT_TYPE, $CONTENT_ID) {
		$this->db->where('user_id', $USER_ID);
		$this->db->where('content_type', $CONTENT_TYPE);
		$this->db->where('content_id', $CONTENT_ID);
        $this->db->delete('favourite');
		return "Favourite successfully Removed";
	}

	function getFavouriteList($USER_ID) {
		$this->db->order_by('id', 'DESC');
		$this->db->where('user_id', $USER_ID);
		$query = $this->db->get('favourite');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
    }

	function createReport($user_id, $title, $description, $report_type) {
		$data = array(
			'user_id' => $user_id,
			'title' => $title,
			'description' => $description,
			'report_type' => $report_type,
			'status' => '0'
	    );
	    $report = $this->db->insert('report', $data);
		if($report) {
			return true;
		} else {
			return false;
		}
	}

	function getMovieDownloadLinks($MovieID) {
		$this->db->order_by('link_order', 'ASC');
		$this->db->where('movie_id', $MovieID);
		$this->db->where('status', '1');
		$query = $this->db->get('movie_download_links');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
    }

	function getMoviePlayLinks($MovieID) {
		$config = $this->AppConfig();
		
		$this->db->order_by('link_order', 'ASC');
		$this->db->where('movie_id', $MovieID);
		$this->db->where('status', '1');
		$query = $this->db->get('movie_play_links');
		

		$movieDefaultStreamLinkType = $config["movieDefaultStreamLinkType"];
		$movieDefaultStreamLinkStatus = $config["movieDefaultStreamLinkStatus"];

		if($movieDefaultStreamLinkStatus) {
			$moviDetails = $this->getMovieDetails($MovieID);
			try{
				$details = json_decode(@file_get_contents("https://autostream.team-dooo.com/api/get_source/movie?id=".$moviDetails['TMDB_ID']));
			} catch (Exception $e) {}
			if($details != "") {
				$json[] = array("id"=>0, "name"=>$moviDetails['name'], "size"=>"Adaptive", "quality"=>"Multiquality", "link_order"=>"-100", "movie_id"=>$MovieID, "url"=>$details->data->sources[0]->file, "type"=>"M3u8", "status"=>"1", "skip_available"=>"0", "intro_start"=>"0", "intro_end"=>"0", "end_credits_marker"=>"0", "link_type"=>$movieDefaultStreamLinkType, "drm_uuid"=>"", "drm_license_uri"=>"");
			}
		}
		


		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    } else {
			if($movieDefaultStreamLinkStatus && isset($json)) {
				return $json;
			}
		}
    }

	function getGenreList() {
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('genres');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
    }

	function getContentsReletedToGenre($search) {
		$json =array();
		$search = urldecode($search);

		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('movies');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (stripos($row->genres, $search) !== false) {
					$json[] = $row;
				}
			}
	    }

		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('web_series');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (stripos($row->genres, $search) !== false) {
					$json[] = $row;
				}
			}
	    }

		if(json_encode($json) != "[]") {
			return $json;
		}
	}

	function getLiveTvReletedToGenre($search) {
		$json =array();
		$search = urldecode($search);

		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('live_tv_channels');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (stripos($row->genres, $search) !== false) {
					$json[] = $row;
				}
			}
	    }

		if(json_encode($json) != "[]") {
			return $json;
		}
	}

	function getFeaturedGenre() {
		$this->db->order_by('id', 'DESC');
		$this->db->where('featured', '1');
		$this->db->where('status', '1');
		$query = $this->db->get('genres');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getLiveTvGenre() {
		$this->db->order_by('id', 'DESC');
		$this->db->where('status', '1');
		$query = $this->db->get('live_tv_genres');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function addRequest($user_id, $title, $description, $type, $status) {
		$data = array(
			'user_id' => $user_id,
			'title' => $title,
			'description' => $description,
			'type' => $type,
			'status' => $status
	    );
	    $this->db->insert('request', $data);
		return $this->db->insert_id();
	}

	function searchContent($search_term, $includePremium) {
		if(strlen($search_term) > 2) {
			$this->load->helper('date');

			$json =array();
			$search_term = urldecode($search_term);
	
			$this->db->order_by('id', 'DESC');
			
			if($includePremium == 0) {
				$this->db->where('type', '0');
			} else if ($includePremium == 1) {
				//$this->db->where('type', '1');
			}
	
			$this->db->like('name',$search_term);
			$this->db->or_like('description', $search_term);
			$this->db->or_like('genres', $search_term);
			$query  =   $this->db->get('movies');
			$moviesFound = $query->num_rows();
			if ($moviesFound > 0) {
				foreach ($query->result() as $row) {
					$json[] = $row;
				}
			}
	
			$this->db->order_by('id', 'DESC');
			if($includePremium == 0) {
				$this->db->where('type', '0');
			} else if ($includePremium == 1) {
				//$this->db->where('type', '1');
			}
			$this->db->like('name',$search_term);
			$this->db->or_like('description', $search_term);
			$this->db->or_like('genres', $search_term);
			$query  =   $this->db->get('web_series');
			$webSeriesFound = $query->num_rows();
			if ($webSeriesFound > 0) {
				foreach ($query->result() as $row) {
					$json[] = $row;
				}
			}
	
			if(strlen($search_term) > 3) {
				$this->db->set('search_text', $search_term);
				$this->db->set('movies_found', $moviesFound);
				$this->db->set('web_series_found', $webSeriesFound);
				$this->db->set('timestamp', now('Asia/Kolkata'));
				$this->db->insert('search_list');
			}
	
			if(json_encode($json) != "[]") {
				return $json;
			}
		}
	}

	function getSubscriptionLog($userID) {
		$this->db->order_by('id', 'ASC');
		$this->db->where('user_id', $userID);
		$query = $this->db->get('subscription_log');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getSubscriptionPlans() {
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('subscription');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getSubscriptionDetails($ID) {
		$this->db->where('id', $ID);
		$query = $this->db->get('subscription');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json = $row;
			}
			return $json;
	    }
	}

	function redeemCoupon($couponCode, $C_User_ID) {
        $Today = date("Y-m-d");
		$this->db->where('coupon_code', $couponCode);
		$query = $this->db->get('coupon');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if($row->coupon_code == $couponCode) {
					if($row->status == 1) {
						$diff=date_diff(date_create(date("Y-m-d")),date_create($row->expire_date));
						if($diff->format('%R') == "+") {

							if($row->max_use == 0) {
								$this->db->where('id', $C_User_ID);
								$query = $this->db->get('user_db');
								if ($query->num_rows() > 0) {
									foreach ($query->result() as $userRow) {
										if($userRow->subscription_type == 0) {
											$used = $row->used + 1;
											$id = $row->id;
				
											if($row->used_by == "") {
												$User_ID = $C_User_ID;
											} else {
											   $User_ID = $row->used_by.','.$C_User_ID;
											}
				
											$this->db->set('used', $used);
											$this->db->set('used_by', $User_ID);
                                            $this->db->where('id', $id);
                                            $this->db->update('coupon');
				
											$exp_Date = date('Y-m-d', strtotime($Today . " + " . $row->time . " day"));
				
											$this->db->set('active_subscription', $row->name);
											$this->db->set('subscription_type', $row->subscription_type);
											$this->db->set('time', $row->time);
											$this->db->set('amount', $row->amount);
											$this->db->set('subscription_start', $Today);
											$this->db->set('subscription_exp', $exp_Date);
                                            $this->db->where('id', $C_User_ID);
                                            $this->db->update('user_db');
				
											return "Coupan Successfully Redeemed";
										} else {
											return "User Already Have Subscription";
										}
									}
								}
							} else {
								if($row->max_use > $row->used) {
									$this->db->where('id', $C_User_ID);
									$query = $this->db->get('user_db');
									if ($query->num_rows() > 0) {
										foreach ($query->result() as $userRow) {
											if($userRow->subscription_type == 0) {
			
												$used = $row->used + 1;
												$id = $row->id;
				 
												if($row->used_by == "") {
												   $User_ID = $C_User_ID;
												} else {
												   $User_ID = $row->used_by.','.$C_User_ID;
												}
				
												$this->db->set('used', $used);
												$this->db->set('used_by', $User_ID);
                                                $this->db->where('id', $id);
                                                $this->db->update('coupon');
				
												$exp_Date = date('Y-m-d', strtotime($Today . " + " . $row->time . " day"));
				
												$this->db->set('active_subscription', $row->name);
												$this->db->set('subscription_type', $row->subscription_type);
												$this->db->set('time', $row->time);
												$this->db->set('amount', $row->amount);
												$this->db->set('subscription_start', $Today);
												$this->db->set('subscription_exp', $exp_Date);
                                                $this->db->where('id', $C_User_ID);
                                                $this->db->update('user_db');
				
												return "Coupan Successfully Redeemed";
											} else {
												return "User Already Have Subscription";
											}
										}
									}
			
								} else {
									return "Coupan Used";
								}
							}

						} else if($diff->format('%R') == "-") {
							$this->db->set('status', '0');
                            $this->db->where('id', $row->id);
                            $this->db->update('coupon');
							return "Coupan Expired";
						}
					} else {
						return "Coupan Expired";
					}
				} else {
					return "invalid Coupan";
				}
			}
	    } else {
			return "invalid Coupan";
		}
	}

	function registerDevice($device) {
		$date = date('m-d-Y', time());
        $time = date('h:i:s a', time());

		$this->db->where('device', $device);
		$query = $this->db->get('devices');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $Row) {
			    $device_id = $Row->id;
			}
		} else {
			$data = array(
				'device' => $device
			);
			$this->db->insert('devices', $data);
			$device_id = $this->db->insert_id();
		}

		$data2 = array(
			'device_id' => $device_id,
			'open_date' => $date,
			'open_time' => $time
		);
		$this->db->insert('devices_log', $data2);
		return $this->db->insert_id();
	}

	function updateAccount($UserID, $UserName, $Email, $Password) {
		$this->db->where('id', $UserID);
		$query = $this->db->get('user_db');
		foreach($query->result() as $UData) {
			$UserData = $UData;
		}

		if($Password == $UserData->password) {
			$this->db->set('name', $UserName);
			$this->db->set('email', $Email);
			$this->db->where('id', $UserData->id);
			$this->db->update('user_db');
			return "Account Updated Successfully";
		} else {
			return "Wrong Password";
		}
	}

	function addviewlog($user_id, $content_id, $content_type) {
		$date = date('m-d-Y', time());
        $time = date('h:i:s a', time());
		$data = array(
			'user_id' => $user_id,
			'content_id' => $content_id,
			'content_type' => $content_type,
			'date' => $date,
			'time' => $time
		);
		$this->db->insert('view_log', $data);
		return $this->db->insert_id();
	}

	function addwatchlog($user_id, $content_id, $content_type) {
		$data = array(
			'user_id' => $user_id,
			'content_id' => $content_id,
			'content_type' => $content_type
		);
		$this->db->insert('watch_log', $data);
		return $this->db->insert_id();
	}

	function getsubtitle($content_id, $ct) {
		$this->db->where('content_id', $content_id);
		$this->db->where('content_type', $ct);
		$this->db->where('status', '1');
		$query = $this->db->get('subtitles');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function getcontentidfromurl($main_content_id, $content_url, $ct) {
		if($ct == 1) {
			$this->db->where('movie_id', $main_content_id);
			$this->db->where('status', '1');
			$this->db->where('url', $content_url);
			$q = $this->db->get('movie_play_links');
			$g = $q->result_array();
			$data = array_shift($g);
			return $data;
		} else if($ct == 2) {
			$this->db->where('content_id', $main_content_id);
			$this->db->where('status', '1');
			$this->db->where('content_type', $ct);
			$q = $this->db->get('web_series_episoade');
			$g = $q->result_array();
			$data = array_shift($g);
			return $data;
		}
	}

	function getEpisodeDownloadLinks($episode_id) {
		$this->db->where('episode_id', $episode_id);
		$this->db->where('status', '1');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('episode_download_links');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function dXBncmFkZQ($User_ID, $name, $subscription_type, $time, $amount) {
		date_default_timezone_set("Asia/Kolkata");
		$Today = date("Y-m-d");
		$exp_Date = date('Y-m-d', strtotime($Today . " + " . $time . " day"));

		$this->db->set('active_subscription', $name);
		$this->db->set('subscription_type', $subscription_type);
		$this->db->set('time', $time);
		$this->db->set('amount', $amount);
		$this->db->set('subscription_start', $Today);
		$this->db->set('subscription_exp', $exp_Date);
        $this->db->where('id', $User_ID);
        $this->db->update('user_db');
		return ($this->db->affected_rows() > 0);
    }

	function sufflePlay() {
		$contentArrey = array("movies", "web_series");
		$this->db->limit(1);
		$this->db->order_by('id', 'RANDOM');
		$query = $this->db->get($contentArrey[array_rand($contentArrey, 1)]);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json = $row;
			}
			return $json;
	    }
    }

	function getAllUpcomingContents($page = 0) {
		if($page > 0) {
			$page_num = filter_var($page, FILTER_VALIDATE_INT,[
                'options' => [
                    'default' => 1,
                    'min_range' => 1
                ]
            ]); 
			$page_limit = 20;
			$page_offset = $page_limit * ($page_num - 1);
			$json =array();

			$this->db->limit($page_limit, $page_offset);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('upcoming_contents');
		    if ($query->num_rows() > 0) {
		    	foreach ($query->result() as $row) {
		    		$json[] = $row;
		    	}
		    	return $json;
	        }

		} else {
			$this->db->order_by('id', 'DESC');
		    $query = $this->db->get('upcoming_contents');
		    if ($query->num_rows() > 0) {
		    	foreach ($query->result() as $row) {
		    		$json[] = $row;
		    	}
		    	return $json;
	        }
		}
	}

	function otpVerifyMail($mail, $type) {
		$d=strtotime("now");
	    $Current_DT =  date("Y-m-d h:i:s", $d);
	    $Current_DT_encoded = base64_encode($Current_DT);

		if($type == "login") {
			$this->db->where('email', $mail);
			$num_rows = $this->db->get('user_db')->num_rows();
		} else {
			$num_rows = 1;
		}
		

	    $code = rand(1000, 9999);

	    if($num_rows > 0) {
	    	$this->db->set('code', $code);
	    	  $this->db->set('token', $Current_DT_encoded);
	    	$this->db->set('mail', $mail);
	    	$this->db->set('type', 'Password Reset');
	    	$this->db->insert('mail_token_details');
	    	if($this->db->insert_id() == "") {
	    		echo "Something Went Wrong!";
	    	} else {
	    		$config = $this->db->get('config')->row();
    
	    		$mailConfig= array(
	    			'protocol' =>'smtp',
	    			'smtp_host' => $config->SMTP_Host,
	    			'smtp_port' => $config->SMTP_Port,
	    			'smtp_user' => $config->SMTP_Username,
	    			'smtp_pass' => $config->SMTP_Password,
	    			'charset' => 'iso-8859-1',
	    			'mailtype' => 'html',
	    			'wordwrap' => TRUE
	    		);
	    		$body= "<!doctype html>
	    		<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
	    		
	    		<head>
	    		  <title>
	    		  </title>
	    		  <!--[if !mso]><!-->
	    		  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
	    		  <!--<![endif]-->
	    		  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
	    		  <meta name='viewport' content='width=device-width, initial-scale=1'>
	    		  <style type='text/css'>
	    			#outlook a {
	    			  padding: 0;
	    			}
	    		
	    			body {
	    			  margin: 0;
	    			  padding: 0;
	    			  -webkit-text-size-adjust: 100%;
	    			  -ms-text-size-adjust: 100%;
	    			}
	    		
	    			table,
	    			td {
	    			  border-collapse: collapse;
	    			  mso-table-lspace: 0pt;
	    			  mso-table-rspace: 0pt;
	    			}
	    		
	    			img {
	    			  border: 0;
	    			  height: auto;
	    			  line-height: 100%;
	    			  outline: none;
	    			  text-decoration: none;
	    			  -ms-interpolation-mode: bicubic;
	    			}
	    		
	    			p {
	    			  display: block;
	    			  margin: 13px 0;
	    			}
	    		  </style>
	    		  <!--[if mso]>
	    				<noscript>
	    				<xml>
	    				<o:OfficeDocumentSettings>
	    				  <o:AllowPNG/>
	    				  <o:PixelsPerInch>96</o:PixelsPerInch>
	    				</o:OfficeDocumentSettings>
	    				</xml>
	    				</noscript>
	    				<![endif]-->
	    		  <!--[if lte mso 11]>
	    				<style type='text/css'>
	    				  .mj-outlook-group-fix { width:100% !important; }
	    				</style>
	    				<![endif]-->
	    		  <!--[if !mso]><!-->
	    		  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700' rel='stylesheet' type='text/css'>
	    		  <style type='text/css'>
	    			@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700);
	    		  </style>
	    		  <!--<![endif]-->
	    		  <style type='text/css'>
	    			@media only screen and (min-width:480px) {
	    			  .mj-column-per-100 {
	    				width: 100% !important;
	    				max-width: 100%;
	    			  }
	    			}
	    		  </style>
	    		  <style media='screen and (min-width:480px)'>
	    			.moz-text-html .mj-column-per-100 {
	    			  width: 100% !important;
	    			  max-width: 100%;
	    			}
	    		  </style>
	    		  <style type='text/css'>
	    			@media only screen and (max-width:480px) {
	    			  table.mj-full-width-mobile {
	    				width: 100% !important;
	    			  }
	    		
	    			  td.mj-full-width-mobile {
	    				width: auto !important;
	    			  }
	    			}
	    		  </style>
	    		</head>
	    		
	    		<body style='word-spacing:normal;background-color:#fafbfc;'>
	    		  <div style='background-color:#fafbfc;'>
	    			<!--[if mso | IE]><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
	    			<div style='margin:0px auto;max-width:600px;'>
	    			  <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='width:100%;'>
	    				<tbody>
	    				  <tr>
	    					<td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;'>
	    					  <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:middle;width:600px;' ><![endif]-->
	    					  <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;'>
	    						<table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:middle;' width='100%'>
	    						  <tbody>
	    							<tr>
	    							  <td align='center' style='font-size:0px;padding:25px;word-break:break-word;'>
	    								<table border='0' cellpadding='0' cellspacing='0' role='presentation' style='border-collapse:collapse;border-spacing:0px;'>
	    								  <tbody>
	    									<tr>
	    									  <td style='width:125px;'>
	    									  <div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;line-height:1;text-align:center;color:#000000;'>".strtoupper($config->name)."</div>
	    									  </td>
	    									</tr>
	    								  </tbody>
	    								</table>
	    							  </td>
	    							</tr>
	    						  </tbody>
	    						</table>
	    					  </div>
	    					  <!--[if mso | IE]></td></tr></table><![endif]-->
	    					</td>
	    				  </tr>
	    				</tbody>
	    			  </table>
	    			</div>
	    			<!--[if mso | IE]></td></tr></table><table align='center' border='0' cellpadding='0' cellspacing='0' class='' style='width:600px;' width='600' bgcolor='#ffffff' ><tr><td style='line-height:0px;font-size:0px;mso-line-height-rule:exactly;'><![endif]-->
	    			<div style='background:#ffffff;background-color:#ffffff;margin:0px auto;max-width:600px;'>
	    			  <table align='center' border='0' cellpadding='0' cellspacing='0' role='presentation' style='background:#ffffff;background-color:#ffffff;width:100%;'>
	    				<tbody>
	    				  <tr>
	    					<td style='direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;'>
	    					  <!--[if mso | IE]><table role='presentation' border='0' cellpadding='0' cellspacing='0'><tr><td class='' style='vertical-align:middle;width:600px;' ><![endif]-->
	    					  <div class='mj-column-per-100 mj-outlook-group-fix' style='font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;'>
	    						<table border='0' cellpadding='0' cellspacing='0' role='presentation' style='vertical-align:middle;' width='100%'>
	    						  <tbody>
	    							<tr>
	    							  <td align='center' style='font-size:0px;padding:10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
	    								<div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'><span>Hello,</span></div>
	    							  </td>
	    							</tr>
	    							<tr>
	    							  <td align='center' style='font-size:0px;padding:10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
	    								<div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'>Please use the verification code below To Verify Your Account on ".$config->name.":</div>
	    							  </td>
	    							</tr>
	    							<tr>
	    							  <td align='center' style='font-size:0px;padding:10px 25px;word-break:break-word;'>
	    								<div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;line-height:1;text-align:center;color:#000000;'>".$code."</div>
	    							  </td>
	    							</tr>
	    							<tr>
	    							  <td align='center' style='font-size:0px;padding:10px 25px;padding-right:16px;padding-left:25px;word-break:break-word;'>
	    								<div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'>If you didn't request this, you can ignore this email or let us know.</div>
	    							  </td>
	    							</tr>
	    							<tr>
	    							  <td align='center' style='font-size:0px;padding:10px 25px;padding-right:25px;padding-left:25px;word-break:break-word;'>
	    								<div style='font-family:open Sans Helvetica, Arial, sans-serif;font-size:16px;line-height:1;text-align:center;color:#000000;'>Thanks! <br />Team ".$config->name."</div>
	    							  </td>
	    							</tr>
	    						  </tbody>
	    						</table>
	    					  </div>
	    					  <!--[if mso | IE]></td></tr></table><![endif]-->
	    					</td>
	    				  </tr>
	    				</tbody>
	    			  </table>
	    			</div>
	    			<!--[if mso | IE]></td></tr></table><![endif]-->
	    		  </div>
	    		</body>
	    		
	    		</html>";
	    		
	    		$this->load->library('email',$mailConfig);
	    		$this->email->set_newline("\r\n");
	    
	    		$this->email->from($config->SMTP_Username,'');
	    		$this->email->to($mail);
	    		$this->email->subject('OTP VERIFICATION');
	    		$this->email->message($body);
	    
	    		if($this->email->send()) {
	    			echo "OTP has been sent";
	    		} else {
	    			echo "Something Went Wrong!";
	    		}
	    		
	    	}
	    } else {
	    	echo 'Email Not Registered';
	    }

	
    }

	function verifyOTP($code) {
        $this->db->where('code', $code);
        $mail_token_rows = $this->db->get('mail_token_details')->num_rows();
        if($mail_token_rows > 0) {
            $this->db->where('code', $code);
            $mail_token = $this->db->get('mail_token_details')->row();
            $Tkn_Time =  base64_decode($mail_token->token);
            $d=strtotime("now");
            $Current_DT =  date("Y-m-d h:i:s", $d);
            $to_time = strtotime($Current_DT);
            $from_time = strtotime($Tkn_Time);
            $Diff = ($to_time - $from_time) / 60;
            if($Diff>5) {
                echo "Expired";
            } else {
                if($mail_token->status == 0) {
                    $this->db->set('status', 1);
                    $this->db->where('code', $code);
                    $this->db->update('mail_token_details');
    
                    $_SESSION['code'] = $mail_token->code;
                    echo "valid Code";
                } else {
                    echo 'Used Code';
                }
            }

        } else {
			echo 'Invalid Request';
		}
    }

	function update_device_id($device_id, $user_id) {
		$this->db->set('device_id', $device_id);
        $this->db->where('id', $user_id);
        $this->db->update('user_db');
	}

	function getuser($user_id) {
		$this->db->where('id', $user_id);
		return $this->db->get('user_db')->row();
	}

	function custom_payment_type() {
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('custom_payment_type');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$json[] = $row;
			}
			return $json;
	    }
	}

	function custom_payment_request($user_id, $payment_type, $payment_details, $subscription_name, $subscription_type, $subscription_time, $subscription_amount, $subscription_currency, $uploaded_image) {
		$this->load->helper('string');
		
		$target_dir="./uploads/images/payment_requests/";
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777, true);
        }

		$img = imagecreatefromstring(base64_decode($uploaded_image)); 
		$img_name = random_string('alnum', 16).'.png';
        if($img != false) { 
           imagepng($img, './uploads/images/payment_requests/'.$img_name); 
        }

		$data = array(
			'user_id' => $user_id,
			'payment_type' => $payment_type,
			'payment_details' => $payment_details,
			'subscription_name' => $subscription_name,
			'subscription_type' => $subscription_type,
			'subscription_time' => $subscription_time,
			'subscription_amount' => $subscription_amount,
			'subscription_currency' => $subscription_currency,
			'uploaded_image' => $img_name
		);
		$this->db->insert('custom_payment_requests', $data);
		return $this->db->insert_id();
	}

	function getTrending() {
		$json =array();
        $query = $this->db->select('*,count(content_id) as max')
            ->group_by('content_id')
            ->order_by('max DESC')
            ->get('view_log', 10);
			
		foreach ($query->result() as $row) {

			if($row->content_type==1) {
				$movieDetails = $this->getMovieDetails($row->content_id);
				if($movieDetails != "" && $movieDetails["status"]==1) {
					$json[] = $movieDetails;
				}

			} else if($row->content_type==2) {
				$webSeriesDetails = $this->getWebSeriesDetails($row->content_id);
				if($webSeriesDetails != "" && $webSeriesDetails["status"]==1) {
					$json[] = $webSeriesDetails;
				}
			}
		}

        if(json_encode($json) != "[]") {
			return $json;
		}
	}

	function getMostSearched() {
		$json =array();
        $query = $this->db->select('*,count(search_text) as max')
            ->group_by('search_text')
            ->order_by('max DESC')
            ->get('search_list', 25);
			
		foreach ($query->result() as $row) {
	
			$search_term = $row->search_text;

			$this->db->order_by('id', 'DESC');
			$this->db->like('name',$search_term);
			$this->db->or_like('description', $search_term);
			$this->db->or_like('genres', $search_term);
			$query  =   $this->db->get('movies');
			$moviesFound = $query->num_rows();
			if ($moviesFound > 0) {
				foreach ($query->result() as $row) {
					$json[] = $row;
				}
			}
	
			$this->db->order_by('id', 'DESC');
			$this->db->like('name',$search_term);
			$this->db->or_like('description', $search_term);
			$this->db->or_like('genres', $search_term);
			$query  =   $this->db->get('web_series');
			$webSeriesFound = $query->num_rows();
			if ($webSeriesFound > 0) {
				foreach ($query->result() as $row) {
					$json[] = $row;
				}
			}
		}

        if(json_encode($json) != "[]") {
			return array_slice(array_values(array_unique( $json, SORT_REGULAR )), 0, 10);
		}
	}
}