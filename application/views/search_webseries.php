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

            						<h4 class="font-size-18">Search & Import</h4>

            						<ol class="breadcrumb mb-0">

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Import</a></li>

            							<li class="breadcrumb-item active">Search & Import Web Series</li>

            						</ol>

            					</div>

            				</div>

            			</div>

            			<!-- end page title -->


                        <div class="form" action="" method="post">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="card card-body">

                                        <h3 class="card-title mt-0">Search Web Series (<a
                                                href="https://www.themoviedb.org/tv" target="_blank">TMDB ID</a>)</h3>

                                        <hr>

                                        <div class="form-group">
                                            <input required="" class="form-control col-md-12" id="search_keyword"
                                                type="text" spellcheck="false"></input>
                                            <p><small>Search Web Series by Title.</small></p>
                                            <br>
                                            <h3 class="card-title mt-0">Settings</h3>

                                            <hr>
                                            <div class="col-md-12 row">
                        						<div class="form-group col-md-4">
                        							<label>Free/Premium</label>
                        							<select class="form-control form-select mb-3" id="Free_Premium">
                                                        <option>Default</option>
                                                        <option>Free</option>
                                                        <option>Premium</option>
                        							</select>
                        						</div>
                                                
                        						<div class="form-group col-md-2">
                        							<label>Enable Download</label>
                        							<div>
                        								<input type="checkbox" id="Enable_Download" switch="bool" />
                        								<label for="Enable_Download" data-on-label=""
                        									data-off-label=""></label>
                        							</div>
                        						</div>

                        						<div class="form-group col-md-4">
                        							<label>Publish</label>
                        							<div>
                        								<input type="checkbox" id="Publish_toggle" switch="bool"
                        									checked />
                        								<label for="Publish_toggle" data-on-label=""
                        									data-off-label=""></label>
                        							</div>
                        						</div>
                        					</div>
                                            <div class="form-group mb-3 row justify-content-end">
                        						<div class="col-md-1">
                        							<button class="btn btn-primary dropdown-toggle waves-effect waves-light"
                        								onclick="Search()" id="create_btn" type="submit" aria-haspopup="true"
                        								aria-expanded="false">
                        								<i class="fas fa-plus mr-2"></i> Search
                        							</button>
                        						</div>
                        					</div>
                                        </div>

                                    </div>

                                    <div class="card card-body" id="import_log" hidden>

                                        <h3 class="card-title mt-0">Import Log</h3>
                                        <br>
                                        <table id="series_datatable" class="table table-striped"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>

                                                <tr>

                                                    <th>#</th>

                                                    <th>##</th>

                                                    <th>Thumbnail</th>

                                                    <th>Name</th>

                                                    <th>Description</th>

                                                </tr>

                                            </thead>

                                        </table>
                                    </div>

                                </div>

                            </div>

                        </div>

            			

            		</div> <!-- container-fluid -->

            	</div>


            	<?php include("partials/footer_rights.php"); ?>


            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php include("partials/footer.php"); ?>

    <script>
        var code = "<?php echo $config->license_code ?>";
        if("<?php echo $config->tmdb_language; ?>" == "") {
            var tmdb_language = "en-US";
        } else {
            var tmdb_language = "<?php echo $config->tmdb_language; ?>";
        }
        
        var datatable = $('#series_datatable').dataTable({
            "order": [],
            "ordering": false,
            "paging": false,
            "info": false,
            "filter": false,
            "pageLength": 100,
            "destroy": true
        });

        var list_count = 1;

        function Search() {
            var search_keyword = document.getElementById("search_keyword").value;
            if(search_keyword != "") {
                var keyword = document.getElementById("search_keyword").value;
                fetch_webseries_ids(keyword.trim());
    
            } else {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "2000",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                
                toastr.warning("Please Add Search Keyword to Fetch Contents!");
            }
        }

        function fetch_webseries_ids(keyword) {
            Swal.fire({
                title: 'Please Wait',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                onOpen: ()=>{
                    Swal.showLoading();
                    if (keyword != '') {
                    $.ajax({
                        type: 'GET',
                        url: "https://cloud.team-dooo.com/Dooo/TMDB/index.php?code="+ code +"&filter=search&type=tv&query="+ keyword +"&language=" + tmdb_language,
                        dataType: 'json',
                        success: function (response) {
                            Swal.close();
                            if(response != false && response.results != "") {
                                $('#series_datatable').DataTable().clear().draw();
                                document.getElementById("import_log").hidden=false
                                for (var data of response.results) {
                                    fetch_series(data.id);
                                }
                            } else {
                                $('#series_datatable').DataTable().clear().draw();
                                document.getElementById("import_log").hidden=true
                                toastr.options = {
                                    "closeButton": false,
                                    "newestOnTop": true,
                                    "progressBar": false,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "2000",
                                    "timeOut": "2000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }; 
                                toastr.error("No Data Found!");
                            }
                        },
                        error: function (jq, status, message) {
                           
                        }
                    });
    
                } else {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "2000",
                        "timeOut": "2000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    
                    toastr.warning("Please Add Search Keyword to Fetch Contents!");
                }
                },
                onClose: ()=>{
                    
                }
            });
        }

        function fetch_series(IMDB_ID) {
            if (IMDB_ID != '') {
                    $.ajax({
                        type: 'GET',
                        url: "https://cloud.team-dooo.com/Dooo/TMDB/?code="+ code +"&filter=single&type=tv&id=" + IMDB_ID +"&id_type=TMDB&language=" + tmdb_language,
                        dataType: 'json',
                        beforeSend: function () {
                            $("#import_btn").html('Fetching...');
                        },
                        success: function (response) {
                            if(response != false) {
                                var TMDB_ID = response.id;
                                var NAME = response.name;
                                var DESCRIPTION = response.overview;
                                var GENRES = response.genres;
                                var RELEASE_DATE = response.first_air_date;
        
        
        
                                var THUMBNAIL = "https://www.themoviedb.org/t/p/original" + response.poster_path;
                                var Poster = "https://www.themoviedb.org/t/p/original" + response.backdrop_path;
        
                                if (!TMDB_ID == "") {
        
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
                                        "GENRE_list": GENRE_list
                                    };
                                    $.ajax({
                                        type: 'POST',
                                        url: "dashboard_api/initiate_genres.php",
                                        contentType: 'application/json',
                                        data: JSON.stringify(jsonObjects3),
                                        dataType: 'json',
                                        success: function (response3) {
                                            if(response3 != "") {
                                                /*$("#genres").select2({
                                                    data: response3
                                                })
                                                var genre_arr = [];
                                                response3.forEach((element, index, array) => {
                                                    genre_arr.push(element.id);
                                                });
                                                $("#genres").val(genre_arr).trigger("change");*/
                                            }
                                        }
                                    });
        
                                    $.ajax({
                                        type: 'GET',
                                        url: "https://api.themoviedb.org/3/tv/" + IMDB_ID +
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
                                                    }
                                                }
                                            }
                                            $('#series_datatable').DataTable().row.add([
                                                list_count, getEditButton(TMDB_ID), getThumbnail(THUMBNAIL), NAME, DESCRIPTION.substring(0,100)
                                            ]).draw();
                                            list_count++;
                                        }
        
                                    });
                                }
                            }
                        },
                        error: function (jq, status, message) {
                            
                        }
                    });
    
                } else {
                    alert('Please input TMDB ID');
                }
        }
    
    
    
        function getEditButton(TMDB_ID) {
           return "<div id=" + TMDB_ID + "><button class='btn btn-primary dropdown-toggle waves-effect waves-light' onclick='add_webseries(" + TMDB_ID + ")' type='submit' aria-haspopup='true' aria-expanded='false'> <i class='fas fa-file-import'></i> &nbsp; Import </button></div>";
        }
    
    
        function getThumbnail(data) {
            return '<img class="img-fluid" height="100" width="80" src='+ data +' data-holder-rendered="true">';
        }
    
        function initStatus(data) {
            if(data == 0) {
                return '<span class="badge badge-danger">UnPublished</span';
            } else if(data == 1) {
                return '<span class="badge badge-success">Published</span>';
            }
        }

        function add_webseries(IMDB_ID) {
            if (IMDB_ID != '') {
                    $.ajax({
                        type: 'GET',
                        url: "https://cloud.team-dooo.com/Dooo/TMDB/?code="+ code +"&filter=single&type=tv&id=" + IMDB_ID +"&id_type=TMDB&language=" + tmdb_language,
                        dataType: 'json',
                        beforeSend: function () {
                            $("#import_btn").html('Fetching...');
                        },
                        success: function (response) {
                            if(response != false) {
                                var TMDB_ID = response.id;
                                var NAME = response.name;
                                var DESCRIPTION = response.overview;
                                var GENRES = response.genres;
                                var RELEASE_DATE = response.first_air_date;
        
        
        
                                var THUMBNAIL = "https://www.themoviedb.org/t/p/original" + response.poster_path;
                                var Poster = "https://www.themoviedb.org/t/p/original" + response.backdrop_path;
        
                                if (!TMDB_ID == "") {
        
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
                                        "GENRE_list": GENRE_list
                                    };
                                    $.ajax({
                                        type: 'POST',
                                        url: "dashboard_api/initiate_genres.php",
                                        contentType: 'application/json',
                                        data: JSON.stringify(jsonObjects3),
                                        dataType: 'json',
                                        success: function (response3) {
                                            if(response3 != "") {
                                                /*$("#genres").select2({
                                                    data: response3
                                                })
                                                var genre_arr = [];
                                                response3.forEach((element, index, array) => {
                                                    genre_arr.push(element.id);
                                                });
                                                $("#genres").val(genre_arr).trigger("change");*/
                                            }
                                        }
                                    });
        
                                    $.ajax({
                                        type: 'GET',
                                        url: "https://api.themoviedb.org/3/tv/" + IMDB_ID +
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
                                                    }
                                                }
                                            }
                                            m_add_series(TMDB_ID, NAME, DESCRIPTION, GENRE_list, RELEASE_DATE, THUMBNAIL, Poster, trailler_youtube_source);
                                        }
        
                                    });
                                }
                            }
                        },
                        error: function (jq, status, message) {
                            
                        }
                    });
    
                } else {
                    alert('Please input TMDB ID');
                }
        }
    
        function m_add_series(TMDB_ID,Name,DESCRIPTION,GENRES,RELEASE_DATE,THUMBNAIL,POSTER,trailler_youtube_source) {
            var Free_Premium = document.getElementById("Free_Premium").value;
                if (Free_Premium == "Default") {
                    var Free_Premium_Count = 0;
    
                } else if (Free_Premium == "Free") {
                    var Free_Premium_Count = 1;
    
                } else if (Free_Premium == "Premium") {
                    var Free_Premium_Count = 2;
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
    
                var jsonObjects = {
                    "TMDB_ID": TMDB_ID,
                    "name": Name,
                    "description": DESCRIPTION,
                    "genres": GENRES,
                    "release_date": RELEASE_DATE,
                    "poster": THUMBNAIL,
                    "banner": POSTER,
                    "youtube_trailer": trailler_youtube_source,
                    "downloadable": Enable_Download_Count,
                    "type": Free_Premium_Count,
                    "status": Publish_toggle_Count
                };
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('Admin_api/add_web_series') ?>',
                    data: jsonObjects,
                    dataType: 'text',
                    success: function (response3) {
                        if (response3 != "") {
                            $('#'+TMDB_ID).html(
                                "<div id=" + TMDB_ID + "><button class='btn btn-success dropdown-toggle waves-effect waves-light' onclick='addedWarning()' type='submit' aria-haspopup='true' aria-expanded='false'> <i class='dripicons-checkmark'></i> &nbsp; Added </button></div>"
                            );
    
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": true,
                                "progressBar": false,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "2000",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr.success("WebSeries Added Successfully!");
                        }
                    }
                });
        }

        function addedWarning() {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "2000",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.warning("Webseries Already Added!");
        }

        

    </script>