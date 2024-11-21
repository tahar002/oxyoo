#
# TABLE STRUCTURE FOR: ci_sessions
#

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: comments
#

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `content_type` int(11) NOT NULL COMMENT '1=Movie, 2=WebSeries',
  `comment` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: config
#

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `api_key` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `license_code` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `login_mandatory` int(11) NOT NULL COMMENT '0=No, 1=Yes',
  `maintenance` int(11) NOT NULL COMMENT '0=No, 1=Yes',
  `image_slider_type` int(11) NOT NULL COMMENT '0=Movie, 1=Web Series, 2=Custom, 3=Disable',
  `movie_image_slider_max_visible` int(11) NOT NULL DEFAULT 5,
  `webseries_image_slider_max_visible` int(11) NOT NULL DEFAULT 5,
  `onesignal_api_key` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `onesignal_appid` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `ad_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=No Ads, 1 =AdMob, 2=Startapp, 3=Facebook, 4=AdColony, 5=UnityAds, 6=CustomAds',
  `Admob_Publisher_ID` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Admob_APP_ID` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `adMob_Native` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `adMob_Banner` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `adMob_Interstitial` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `StartApp_App_ID` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `facebook_app_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `facebook_banner_ads_placement_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `facebook_interstitial_ads_placement_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Latest_APK_Version_Name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Latest_APK_Version_Code` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `APK_File_URL` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Whats_new_on_latest_APK` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Update_Skipable` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `Update_Type` int(11) NOT NULL DEFAULT 0 COMMENT '0=In App, 1 = External Brawser, 2 = Playstore',
  `googleplayAppUpdateType` int(11) NOT NULL DEFAULT 0 COMMENT '0 = FLEXIBLE, 1 = IMMEDIATE',
  `Contact_Email` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `SMTP_Host` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `SMTP_Username` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `SMTP_Password` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `SMTP_Port` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Dashboard_Version` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `shuffle_contents` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `Home_Rand_Max_Movie_Show` int(11) NOT NULL DEFAULT 0,
  `Home_Rand_Max_Series_Show` int(11) NOT NULL DEFAULT 0,
  `Home_Recent_Max_Movie_Show` int(11) NOT NULL DEFAULT 0,
  `Home_Recent_Max_Series_Show` int(11) NOT NULL DEFAULT 0,
  `Show_Message` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `message_animation_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Message_Title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Message` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `all_live_tv_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=Free, 2=Paid',
  `all_movies_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=Free, 2=Paid',
  `all_series_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=Free, 2=Paid',
  `LiveTV_Visiable_in_Home` int(11) NOT NULL DEFAULT 1 COMMENT '0=No, 1=Yes',
  `TermsAndConditions` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `PrivecyPolicy` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `tmdb_language` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `admin_panel_language` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `genre_visible_in_home` int(11) NOT NULL DEFAULT 1 COMMENT '0=No, 1=Yes',
  `AdColony_app_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `AdColony_banner_zone_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `AdColony_interstitial_zone_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `unity_game_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `unity_banner_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `unity_interstitial_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `custom_banner_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `custom_banner_click_url_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=nothing 1=External Brawser 2=Internal Brawser',
  `custom_banner_click_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `custom_interstitial_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `custom_interstitial_click_url_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=nothing 1=External Brawser 2=Internal Brawser',
  `custom_interstitial_click_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `applovin_sdk_key` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `applovin_apiKey` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `applovin_Banner_ID` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `applovin_Interstitial_ID` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `ironSource_app_key` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `movie_comments` int(11) NOT NULL COMMENT '0=Off, 1=On',
  `webseries_comments` int(11) NOT NULL COMMENT '0=Off, 1=On',
  `google_login` int(11) NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `onscreen_effect` int(11) NOT NULL COMMENT '0=Nothing, 1=Snow',
  `razorpay_status` int(11) NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `razorpay_key_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `razorpay_key_secret` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `paypal_status` int(11) NOT NULL COMMENT '0=Disabled, 1=Enabled',
  `paypal_clint_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `content_item_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=v2',
  `live_tv_content_item_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=v2',
  `webSeriesEpisodeitemType` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=v2',
  `telegram_token` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `telegram_chat_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `splash_screen_type` int(11) NOT NULL DEFAULT 0 COMMENT '	0=Default, 1=Image, 2=Lottie, 3=Custom',
  `splash_bg_color` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `splash_image_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `splash_lottie_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: coupon
#

DROP TABLE IF EXISTS `coupon`;

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `coupon_code` text NOT NULL,
  `time` int(11) NOT NULL COMMENT 'Days',
  `amount` int(11) NOT NULL,
  `subscription_type` int(11) NOT NULL DEFAULT 0 COMMENT '1=Remove Ads, 2=Play Premium, 3=Download Premium	',
  `status` int(11) NOT NULL COMMENT '0=Expired, 1=Valid',
  `max_use` int(11) NOT NULL DEFAULT 1,
  `used` int(11) NOT NULL DEFAULT 0,
  `used_by` text NOT NULL DEFAULT '',
  `expire_date` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: devices
#

DROP TABLE IF EXISTS `devices`;

CREATE TABLE `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: devices_log
#

DROP TABLE IF EXISTS `devices_log`;

CREATE TABLE `devices_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `open_date` text NOT NULL,
  `open_time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=853 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: episode_download_links
#

DROP TABLE IF EXISTS `episode_download_links`;

CREATE TABLE `episode_download_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `size` text NOT NULL,
  `quality` text NOT NULL,
  `link_order` int(11) NOT NULL,
  `episode_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `type` text NOT NULL,
  `download_type` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: favourite
#

DROP TABLE IF EXISTS `favourite`;

CREATE TABLE `favourite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `content_type` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: genres
#

DROP TABLE IF EXISTS `genres`;

CREATE TABLE `genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `icon` text NOT NULL,
  `description` longtext NOT NULL,
  `featured` int(11) NOT NULL COMMENT '0=NotFeatured, 1=Featured',
  `status` int(11) NOT NULL COMMENT '	0=NotPublished, 1=Published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: image_slider
#

DROP TABLE IF EXISTS `image_slider`;

CREATE TABLE `image_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `banner` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `content_type` int(11) NOT NULL COMMENT '0=Movie,1=WebSeries,2=WebView,3=External Browser',
  `content_id` int(11) NOT NULL,
  `url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '	0=UnPublished, 1=Published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: live_tv_channels
#

DROP TABLE IF EXISTS `live_tv_channels`;

CREATE TABLE `live_tv_channels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `banner` text NOT NULL,
  `stream_type` text NOT NULL,
  `url` text NOT NULL,
  `content_type` int(11) NOT NULL DEFAULT 3 COMMENT '	1=Movie, 2=WebSeries, 3=LiveTV',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '	0=NotPremium, 1=Premium',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=No, 1=Yes',
  `featured` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `user_agent` text NOT NULL,
  `headers` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: live_tv_genres
#

DROP TABLE IF EXISTS `live_tv_genres`;

CREATE TABLE `live_tv_genres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `icon` text NOT NULL,
  `featured` int(11) NOT NULL COMMENT '0=NotFeatured, 1=Featured',
  `status` int(11) NOT NULL COMMENT '0=NotPublished, 1=Published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: mail_token_details
#

DROP TABLE IF EXISTS `mail_token_details`;

CREATE TABLE `mail_token_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `mail` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: movie_download_links
#

DROP TABLE IF EXISTS `movie_download_links`;

CREATE TABLE `movie_download_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `size` text NOT NULL,
  `quality` text NOT NULL,
  `link_order` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `type` text NOT NULL,
  `download_type` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=Not Released, 1=Released',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: movie_play_links
#

DROP TABLE IF EXISTS `movie_play_links`;

CREATE TABLE `movie_play_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `size` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `quality` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_order` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=Not Released, 1=Released',
  `skip_available` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `intro_start` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `intro_end` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `end_credits_marker` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_type` int(11) NOT NULL COMMENT '0=NotPremium, 1=Premium',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: movies
#

DROP TABLE IF EXISTS `movies`;

CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TMDB_ID` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `genres` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `release_date` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `runtime` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `poster` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `banner` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `youtube_trailer` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `downloadable` int(11) NOT NULL COMMENT '0=Not Downloadable, 1=Downloadable',
  `type` int(11) NOT NULL COMMENT '0=NotPremium, 1=Premium',
  `status` int(11) NOT NULL COMMENT '0=UnPublished, 1=Published',
  `content_type` int(11) NOT NULL DEFAULT 1 COMMENT '1=Movie, 2=WebSeries',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: report
#

DROP TABLE IF EXISTS `report`;

CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `report_type` int(11) NOT NULL COMMENT '0=Custom, 1=Movie, 2=Web Series, 3=Live TV',
  `status` int(11) NOT NULL COMMENT '0=Pending, 1=Solved, 2=Canceled',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: request
#

DROP TABLE IF EXISTS `request`;

CREATE TABLE `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` longtext NOT NULL,
  `type` int(11) NOT NULL COMMENT '0=Custom, 1=Movie, 2=Web Series, 3=Live TV',
  `status` int(11) NOT NULL COMMENT '0=Pending, 1=Accepted, 2=Rejected',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: subscription
#

DROP TABLE IF EXISTS `subscription`;

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `time` int(11) NOT NULL COMMENT 'Days',
  `amount` int(11) NOT NULL,
  `currency` int(11) NOT NULL COMMENT '0=INR,1=USD',
  `background` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `subscription_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=Remove Ads, 2=Play Premium, 3=Download Premium',
  `status` int(11) NOT NULL COMMENT '0=UnPublished, 1=Published',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: subscription_log
#

DROP TABLE IF EXISTS `subscription_log`;

CREATE TABLE `subscription_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `amount` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `subscription_start` date NOT NULL,
  `subscription_exp` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: subtitles
#

DROP TABLE IF EXISTS `subtitles`;

CREATE TABLE `subtitles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `content_type` int(11) NOT NULL COMMENT '1=Movie, 2=WebSeries',
  `language` text NOT NULL,
  `subtitle_url` text NOT NULL,
  `mime_type` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: user_db
#

DROP TABLE IF EXISTS `user_db`;

CREATE TABLE `user_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0 COMMENT '0=User, 1=Admin, 2=SubAdmin, 3=Manager, 4=Editor',
  `active_subscription` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `subscription_type` int(11) NOT NULL DEFAULT 0 COMMENT '0=Default, 1=Remove Ads, 2=Play Premium, 3=Download Premium',
  `time` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `subscription_start` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `subscription_exp` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: view_log
#

DROP TABLE IF EXISTS `view_log`;

CREATE TABLE `view_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `content_id` int(11) NOT NULL,
  `content_type` int(11) NOT NULL COMMENT '1=Movie, 2=WebSeries',
  `date` text NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: watch_log
#

DROP TABLE IF EXISTS `watch_log`;

CREATE TABLE `watch_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` text NOT NULL,
  `content_id` int(11) NOT NULL,
  `content_type` int(11) NOT NULL COMMENT '1=Movie, 2=WebSeries',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4;

#
# TABLE STRUCTURE FOR: web_series
#

DROP TABLE IF EXISTS `web_series`;

CREATE TABLE `web_series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TMDB_ID` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `genres` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `release_date` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `poster` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `banner` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `youtube_trailer` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `downloadable` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `content_type` int(11) NOT NULL DEFAULT 2 COMMENT '1=Movie, 2=WebSeries',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: web_series_episoade
#

DROP TABLE IF EXISTS `web_series_episoade`;

CREATE TABLE `web_series_episoade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Episoade_Name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `episoade_image` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `episoade_description` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `episoade_order` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `downloadable` int(11) NOT NULL COMMENT '0=No, 1=Yes',
  `type` int(11) NOT NULL COMMENT '0=NotPremium, 1=Premium',
  `status` int(11) NOT NULL COMMENT '0=Not Released, 1=Released',
  `source` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `skip_available` int(11) NOT NULL DEFAULT 0 COMMENT '0=No, 1=Yes',
  `intro_start` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `intro_end` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `end_credits_marker` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

#
# TABLE STRUCTURE FOR: web_series_seasons
#

DROP TABLE IF EXISTS `web_series_seasons`;

CREATE TABLE `web_series_seasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Session_Name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `season_order` int(11) NOT NULL,
  `web_series_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=Not Released, 1=Released',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;