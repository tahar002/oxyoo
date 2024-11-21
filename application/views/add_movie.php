<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

    <head>
    
        <meta charset="utf-8">
        <title>Dashboard | Dooo - Movie & Web Series Portal App</title>

        <?php include("partials/header.php"); ?>
    
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <?php include("partials/topbar.php"); ?>

            
            <?php include("partials/sidebar.php"); ?>
            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                	<div class="container-fluid">

                		<!-- start page title -->
                		<div class="row align-items-center">
                			<div class="col-sm-6">
                				<div class="page-title-box">
                					<h4 class="font-size-18">Add Movie</h4>
                					<ol class="breadcrumb mb-0">
                						<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>
                						<li class="breadcrumb-item"><a href="javascript: void(0);">Movies</a></li>
                						<li class="breadcrumb-item active">Add Movie</li>
                					</ol>
                				</div>
                			</div>
                		</div>
                		<!-- end page title -->
                		<div class="row justify-content-center">
                			<div class="col-lg-6">

                				<div class="alert alert-info bg-info text-white border-0" role="alert">
                					Import Contents From TMDB
                				</div>
                			</div>

                		</div>
                		<div class="row justify-content-center">
                            <div class="col-lg-1">
                                <select class="form-control form-select" id="contentDataSourceType">
                                    <option selected>TMDB</option>
                                    <option>IMDB</option>
                                </select>
                            </div>
                			<div class="col-lg-5">
                                <div class="input-group" data-target-input="nearest">
                                    <input class="form-control" id="imdb_id" type="text"
                                        placeholder="Enter TMDB ID. Ex: 101010" value="" id="example-text-input">

                                    <button type="submit" onclick="Load_Movie_Data()" id="import_btn"
                                        class="btn btn-primary waves-effect waves-light"> Fetch </button>

                                </div>
                            </div>

                		</div>
                		<div class="row justify-content-center">
                			<div class="col-lg-6">
                				<h6>
                                    <p> Get IMDB or IMDB ID from here: <a href="https://www.themoviedb.org/movie/"
                        				target="_blank">TheMovieDB.org</a> or <a href="https://www.imdb.com/"
                        				target="_blank">Imdb.com</a> </p>
                				</h6>
                			</div>

                		</div>

                		<div class="row justify-content-center">
                			<div class="col-lg-6">
                				<div id="result" class="m-t-15"></div>
                			</div>

                		</div>


                		<br>

                		<div class="form">
                			<div class="row">
                				<div class="col-lg-6">
                					<div class="card card-body">
                						<h3 class="card-title mt-0">Movie Info</h3>
                						<hr>

                                        <input type="hidden" id="contentID" name="contentID" value="0">

                						<div class="mb-3">
                							<label>Title</label>
                							<input class="form-control" type="text" value="" id="title">
                						</div>

                						<div class="mb-3">
                							<label>Description</label>
                							<div class="summernote" id="description"></div>
                						</div>

                						<div class="mb-3">
                							<label>Genres</label>
                							<!--<input class="form-control" type="text" value="" id="genres">-->
                							<select class="select2 form-control select2-multiple" id="genres"
                								multiple="multiple" multiple data-placeholder="Choose ..."></select>
                						</div>

                						<div class="mb-3">
                							<label>Release Date</label>
                							<div class="input-group date" data-target-input="nearest">
                								<input type="text" id="release_date"
                									class="form-control datetimepicker-input"
                									data-target="#release_date" placeholder="YYYY-MM-DD" />
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                							</div>
                						</div>

                						<div class="mb-3">
                							<label>Runtime</label>
                							<input class="form-control" type="text" value="" id="runtime">
                						</div>

                						<div class="mb-3">
                							<label>Trailer URL(YouTube Only)</label>
											<div class="input-group date" data-target-input="nearest">
											    <input class="form-control" type="text" value=""
                								    id="trailler_youtube_source">
                                                <div class="input-group-text"><i class="fa fa-play"></i></div>
                							</div>
                						</div>
                					</div>
                				</div>
                				<div class="col-lg-6">
                					<div class="card card-body">
                						<h3 class="card-title mt-0">Additional Info</h3>
                						<hr>

                						<div class="mb-3">
                							<label>Thumbnail</label>
                							<div class="row justify-content-center">
                								<img class="img-fluid" id="thumb_image"
                									style="padding: 0.20rem; background-color: #FFF; border: 1px solid #dee2e6; border-radius: 0.25rem; max-width: 150px; height: auto;"
                									width="150" src="<?php echo base_url('assets/images/dooo_thumbnail_placeholder.png'); ?>"
                									data-holder-rendered="true">
                							</div>
                							<br>
                                            <div class="row justify-content-center">
                								<div class="col-lg-10">
                									<div class="input-group" data-target-input="nearest">

                                                    <input class="form-control" id="Thumbnail_URL" type="text"
                										placeholder="Image URL (Best Fit = 500 x 750)" value=""
                										id="example-text-input">

                										<button type="submit" onclick="SET_Thumbnail()" id="import_btn"
                											class="btn btn-primary waves-effect waves-light"> SET
                										</button>
                									</div>
                								</div>
											</div>
                						</div>

                						<div class="mb-3">
                							<label>Poster</label>
                							<div class="row justify-content-center">
                								<img class="img-fluid" id="poster_image"
                									style="padding: 0.20rem; background-color: #FFF; border: 1px solid #dee2e6; border-radius: 0.25rem; max-width: 350px; height: auto;"
                									width="350" src="<?php echo base_url('assets/images/Dooo_poster_placeholder.png'); ?>"
                									data-holder-rendered="true">
                							</div>
                							<br>
                                            <div class="row justify-content-center">
                								<div class="col-lg-10">
                									<div class="input-group" data-target-input="nearest">

                                                    <input class="form-control" id="Poster_URL" type="text"
                										placeholder="Image URL (Best Fit = 2048 x 1152)" value=""
                										id="example-text-input">

                										<button type="submit" onclick="SET_Poster()" id="import_btn"
                											class="btn btn-primary waves-effect waves-light"> SET
                										</button>
                									</div>
                								</div>
											</div>
                						</div>

                						<div class="mb-3">
                							<label>Free/Premium</label>
                							<select class="form-control form-select" id="Free_Premium">
                								<option>Free</option>
                								<option>Premium</option>
                							</select>
                						</div>

                						<div class="mb-3">
                							<label>Enable Download</label>
                							<div>
                								<input type="checkbox" id="Enable_Download" switch="bool" checked />
                								<label for="Enable_Download" data-on-label="" data-off-label=""></label>
                							</div>
                						</div>

                						<div class="mb-3">
                							<label>Publish</label>
                							<div>
                								<input type="checkbox" id="Publish_toggle" switch="bool" checked />
                								<label for="Publish_toggle" data-on-label="" data-off-label=""></label>
                							</div>
                						</div>

                						<div class="mb-3">
                							<div class="col-md-12 row justify-content-end">
                								<button class="btn btn-primary waves-effect waves-light col-md-4"
                									id="create_btn" type="submit" onclick="addMovie()">
                									<i class="fas fa-plus mr-2"></i> Create
                								</button>
                							</div>
                						</div>
                					</div>
                				</div>

                			</div>
                		</div>

                	</div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <?php include("partials/footer_rights.php"); ?>
                

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php include("partials/footer.php"); ?>

        <script>
            var code = "<?php echo $config->license_code; ?>";
            if("<?php echo $config->tmdb_language; ?>" == "") {
                var tmdb_language = "en-US";
            } else {
                var tmdb_language = "<?php echo $config->tmdb_language; ?>";
            }


            $(document).ready(function() {
                $('.summernote').summernote({
                    height: 250
                });
    
                $('#release_date').datetimepicker({
                    format: 'yyyy-MM-DD',
                    allowInputToggle: true,
                    todayHighlight: true
                });
    
                $("#genres").select2({
                    data: <?php echo $selectGenre; ?>
                });
            });

            function SET_Thumbnail() {
                var Thumbnail_URL = document.getElementById("Thumbnail_URL").value;
                $('#thumb_image').attr('src', Thumbnail_URL);
            }
    
            function SET_Poster() {
                var Poster = document.getElementById("Poster_URL").value;
                $('#poster_image').attr('src', Poster);
            }
            
            function Load_Movie_Data() {
                var contentDataSourceType = document.getElementById("contentDataSourceType").value;
                if(contentDataSourceType == "TMDB") {
                    var IMDB_ID = document.getElementById("imdb_id").value;
                    initMoviesData(IMDB_ID);
                } else if(contentDataSourceType == "IMDB") {
                    var TMDB_ID = document.getElementById("imdb_id").value;
                    $.ajax({
                        type: 'GET',
                        url: "https://api.themoviedb.org/3/find/" + TMDB_ID +
                            "?api_key=1bfdbff05c2698dc917dd28c08d41096&external_source=imdb_id",
                        dataType: 'json',
                        success: function (response20) {
                           if(response20 != false) {
                                var IMDB_ID = response20.movie_results[0].id;
                                initMoviesData(IMDB_ID);
                            }
                        }
                    });
                }
		    }

            function initMoviesData(IMDB_ID) {
                $("#contentID").val(IMDB_ID);
                if (IMDB_ID != '') {
					Swal.fire({
                        title: 'Please Wait',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: ()=>{
                            Swal.showLoading();
                        },
                        onClose: ()=>{
                            
                        }
                    });
                    $.ajax({
                        type: 'GET',
                        url: "https://cloud.team-dooo.com/Dooo/TMDB/?code="+ "<?php echo $config->license_code; ?>" +"&filter=single&type=movie&id=" + IMDB_ID +"&id_type=TMDB&language=" + "<?php echo $config->tmdb_language; ?>",
                        dataType: 'json',
                        beforeSend: function () {
                            $("#import_btn").html('Fetching...');
                        },
                        success: function (response) {
                            if(response != false) {
                                var TMDB_ID = response.id;
                                var NAME = response.title;
                                var DESCRIPTION = response.overview;
                                var GENRES = response.genres;
                                var RELEASE_DATE = response.release_date;
                                var RUNTIME = response.runtime;
        
                                var THUMBNAIL = response.poster_path;
                                var Poster = response.backdrop_path;
        
                                if (!TMDB_ID == "") {
                                    $("#title").val(NAME);
                                    $('#description').summernote('editor.insertText', DESCRIPTION);
                                    $('#release_date').data("datetimepicker").date(new Date(RELEASE_DATE));
                                    $("#runtime").val(RUNTIME + "min");
        
                                    $('#thumb_image').attr('src', "https://www.themoviedb.org/t/p/original" +
                                        THUMBNAIL);
                                    $('#poster_image').attr('src', "https://www.themoviedb.org/t/p/original" +
                                        Poster);
        
                                    var GENRES_json_obj = "";
                                    for (var GENRE_Json_Content of GENRES) {
                                        if (GENRES_json_obj == "") {
                                            GENRES_json_obj = GENRE_Json_Content.name + ", ";
                                        } else {
                                            GENRES_json_obj = GENRES_json_obj + GENRE_Json_Content.name + ", ";
                                        }
                                    }
                                    var GENRE_list = GENRES_json_obj.slice(0, -2);
                                    
                                    var jsonObjects3 = {
                                        "GenreList": GENRE_list
                                    };
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?= site_url('Admin_api/initiateGenres') ?>',
                                        data: jsonObjects3,
                                        dataType: 'json',
                                        success: function (response3) {
                                            if(response3 != "") {
                                                $("#genres").select2({
                                                    data: response3
                                                })
                                                var genre_arr = [];
                                                response3.forEach((element, index, array) => {
                                                    genre_arr.push(element.id);
                                                });
                                                $("#genres").val(genre_arr).trigger("change");
                                            }
                                        }
                                    });
        
                                    $.ajax({
                                        type: 'GET',
                                        url: "https://api.themoviedb.org/3/movie/" + IMDB_ID +
                                            "/videos?api_key=1bfdbff05c2698dc917dd28c08d41096",
                                        dataType: 'json',
                                        success: function (response2) {
                                            var Video_Data_Json = response2.results;
                                            for (var Video_Json_Content of Video_Data_Json) {
                                                if (Video_Json_Content.type == "Trailer") {
                                                    if (Video_Json_Content.site == "YouTube") {
                                                        var trailler_youtube_source =
                                                            "https://www.youtube.com/watch?v=" +
                                                            Video_Json_Content.key;
                                                        $("#trailler_youtube_source").val(
                                                            trailler_youtube_source);
                                                    }
                                                }
                                            }
        
                                        }
        
                                    });
        
        
                                    $('#result').html(
                                        '<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>Data <strong>imported</strong> successfully.</div>'
                                    );
                                    $('#import_btn').html('Fetch');
                                }
                            } else {
                                $('#result').html(
                                    '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>No data found in <strong>database</strong>.</div>'
                                );
                                $('#import_btn').html('Fetch');
                            }
							Swal.close();
                        },
                        error: function (jq, status, message) {
                            $('#result').html(
                                '<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>No data found in <strong>database</strong>.</div>'
                            );
                            $('#import_btn').html('Fetch');
							Swal.close();
                        }
                    });

                } else {
                    alert('Please input TMDB ID');
                }
            }

			function addMovie() {
				Swal.fire({
                    title: 'Please Wait',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: ()=>{
                        Swal.showLoading();
                    },
                    onClose: ()=>{
                        
                    }
                });

                if (document.getElementById("contentID").value == "0") {
                    var contentID = 0;
                } else {
                    var contentID = document.getElementById("contentID").value;
                }
                var Name = document.getElementById("title").value;
                var DESCRIPTION = jQuery($(".summernote").summernote("code")).text();
                var GENRES = $('#genres').select2('data');
                var RELEASE_DATE = document.getElementById('release_date').value;
                var RUNTIME = document.getElementById("runtime").value;
                var THUMBNAIL = document.getElementById("thumb_image").src;
                var POSTER = document.getElementById("poster_image").src;
                var trailler_youtube_source = document.getElementById("trailler_youtube_source").value;
                var Free_Premium = document.getElementById("Free_Premium").value;
                if (Free_Premium == "Free") {
                    var Free_Premium_Count = 0;
    
                } else if (Free_Premium == "Premium") {
                    var Free_Premium_Count = 1;
                }
    
                if ($('#Enable_Download').is(':checked')) {
                    var Enable_Download_Count = 1;
                } else {
                    var Enable_Download_Count = 0;
                }
    
                if ($('#Publish_toggle').is(':checked')) {
                    var Publish_toggle_Count = 1;
                } else {
                    var Publish_toggle_Count = 0;
                }
    
                var add_Movie_genre = "";
                GENRES.forEach((element, index, array) => {
                    if(add_Movie_genre == "") {
                        add_Movie_genre = element.text;
                    } else {
                        add_Movie_genre = add_Movie_genre+","+element.text;
                    }
                });
    
                var jsonObjects = {
                    "TMDB_ID": contentID,
                    "name": Name,
                    "description": DESCRIPTION,
                    "genres": add_Movie_genre,
                    "release_date": RELEASE_DATE,
                    "runtime": RUNTIME,
                    "poster": THUMBNAIL,
                    "banner": POSTER,
                    "youtube_trailer": trailler_youtube_source,
                    "downloadable": Enable_Download_Count,
                    "type": Free_Premium_Count,
                    "status": Publish_toggle_Count
                };
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('Admin_api/addMovie') ?>',
                    data: jsonObjects,
                    dataType: 'text',
                    success: function (response) {
						Swal.close();
                        if (response != "") {
                            swal.fire({
                                title: 'Successful!',
                                text: 'Movie Added Successfully!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#556ee6',
                                cancelButtonColor: "#f46a6a"
                            }).then(function () {
                                window.location.assign("<?php echo base_url(); ?>manage_movie_links/" + response);
                            });
                        }
                    }
                });
            }
            
        </script>