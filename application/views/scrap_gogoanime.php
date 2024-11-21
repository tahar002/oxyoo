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

            						<h4 class="font-size-18">Api Setting</h4>

            						<ol class="breadcrumb mb-0">

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Scrap</a></li>

            							<li class="breadcrumb-item active">GogoAnime</li>

            						</ol>

            					</div>

            				</div>

            			</div>

            			<!-- end page title -->

                        <div class="form" action="" method="post">

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="card card-body">

                                        <h3 class="card-title mt-0">Search Anime (<a
                                                href="https://gogoanime.run/" target="_blank">GogoAnime</a>)</h3>

                                        <hr>

                                        <div class="form-group">
                                            <input required="" class="form-control col-md-12" id="search_keyword"
                                                type="text" spellcheck="false"></input>
                                            <p><small>Search Anime by Title or URL.</small></p>
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

        function validURL(str) {
          var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
          return !!pattern.test(str);
        }

        function Search() {
            var search_keyword = document.getElementById("search_keyword").value;
            if(search_keyword != "") {
                var keyword = document.getElementById("search_keyword").value;
                if(validURL(keyword)) {
                    var gogoanimeUrl = keyword.trim();
                    var animeID = new URL(gogoanimeUrl).pathname.split("/")[1].split("-episode")[0];

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
                                url: "https://gogoanime.team-dooo.com/anime-details/"+animeID,
                                dataType: 'json',
                                success: function (response) {
                                    Swal.close();
                                    if(response != false) {
                                        $('#series_datatable').DataTable().clear().draw();
                                        document.getElementById("import_log").hidden=false;
                                        $('#series_datatable').DataTable().row.add([
                                                list_count, getEditButton(animeID), getThumbnail(response.animeImg), response.animeTitle, response.synopsis.substring(0,100)
                                            ]).draw();
                                            list_count++;
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

                } else {
                    var gogoanimeKeyword = keyword.trim().replace(/\s+/g, '-').toLowerCase();

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
                                url: "https://gogoanime.team-dooo.com/search?keyw="+gogoanimeKeyword,
                                dataType: 'json',
                                success: function (response) {
                                    Swal.close();
                                    if(response != false) {
                                        $('#series_datatable').DataTable().clear().draw();
                                        document.getElementById("import_log").hidden=false;
                                        for (var data of response) {
                                            $('#series_datatable').DataTable().row.add([
                                                list_count, getEditButton(data.animeId), getThumbnail(data.animeImg), data.animeTitle, data.status
                                            ]).draw();
                                            list_count++;
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

        function getEditButton(animeId) {
           return "<div id=" + animeId + "><button class='btn btn-primary dropdown-toggle waves-effect waves-light' onclick='addAnime(\""+ animeId + "\")' type='submit' aria-haspopup='true' aria-expanded='false'> <i class='fas fa-file-import'></i> &nbsp; Import </button></div>";
        }

        function getThumbnail(data) {
            return '<img class="img-fluid" height="100" width="80" src='+ data +' data-holder-rendered="true">';
        }

        function addAnime(animeId) {
                    Swal.fire({
                        title: 'Please Wait',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: ()=>{
                            Swal.showLoading();
                            $.ajax({
                                type: 'GET',
                                url: "https://gogoanime.team-dooo.com/anime-details/"+animeId,
                                dataType: 'json',
                                success: function (response) {
                                    Swal.close();
                                    if(response != false) {
                                        var GENRES_json_obj = "";
                                        for (var GENRE_Json_Content of response.genres) {
                                            if (GENRES_json_obj == "") {
                                                GENRES_json_obj = GENRE_Json_Content + ", ";
                                            } else {
                                                GENRES_json_obj = GENRES_json_obj + GENRE_Json_Content + ", ";
                                            }
                                        }
                                        var GENRE_list = GENRES_json_obj.slice(0, -2);


                                        import_series(0, response.animeTitle, response.synopsis, GENRE_list, response.releasedDate+"-00-00", response.animeImg, response.animeImg, "", response);
                                    }
                                },
                                error: function (jq, status, message) {
                                   
                                }
                            });
                        },
                        onClose: ()=>{
                            
                        }
                    });
        }

        function import_series(TMDB_ID,Name,DESCRIPTION,GENRES,RELEASE_DATE,THUMBNAIL,POSTER,trailler_youtube_source, totalResponse) {
            Swal.fire({
                        title: 'Please Wait',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: ()=>{
                            Swal.showLoading();
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
                                        Swal.close();
                                        Add_season(response3, "Season 1", 1, totalResponse);
                                    }
                                }
                            });
                        },
                        onClose: ()=>{
                            
                        }
                    });
        }

        function Add_season(WebSeriesID, modal_Season_Name, modal_Order, totalResponse) {
            Swal.fire({
                        title: 'Please Wait',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        onOpen: ()=>{
                            Swal.showLoading();
                            var Modal_Status = "1";
                            var jsonObjects = {
                                "webseries_id": WebSeriesID,
                                "modal_Season_Name": modal_Season_Name,
                                "modal_Order": modal_Order,
                                "Modal_Status": Modal_Status
                            };
                            $.ajax({
                                type: 'POST',
                                url: '<?= site_url('Admin_api/add_season') ?>',
                                data: jsonObjects,
                                dataType: 'text',
                                success: function (response) {
                                    if (response != "") {
                
                                        var episodesItemCount = 0;
                                        for (var episodesItem of totalResponse.episodesList) {
                                            if(episodesItemCount == totalResponse.totalEpisodes) {
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
                                            toastr.success("Anime Added Successfully!");
                                                break;
                                            } else {
                                                Add_Episode(response, episodesItem.episodeId, "", episodesItem.episodeNum, "GogoAnime", episodesItem.episodeUrl,
                                                             episodesItem.episodeNum, "No", "Free", "Publish");
                                                episodesItemCount++;
                                            }
                                        }
                                    } else {
                                        swal.fire({
                                            title: 'Error',
                                            text: 'Something Went Wrong :(',
                                            icon: 'error'
                                        }).then(function () {
                                            location.reload();
                                        });
                                    }
                                    Swal.close();
                                }
                            });
                        },
                        onClose: ()=>{
                            
                        }
                    });
        }

        function Add_Episode(seasonID, modal_Episodes_Name, modal_Thumbnail, modal_Order, modal_Source, modal_Url, modal_Description,
        modal_Downloadable, modal_Type, modal_Status) {
    
            if (modal_Downloadable == "No") {
                var Downloadable = "0";
            } else if (modal_Downloadable == "Yes") {
                var Downloadable = "1";
            }
    
            if (modal_Type == "Free") {
                var Type = "0";
            } else if (modal_Type == "Premium") {
                var Type = "1";
            }
    
            if (modal_Status == "Publish") {
                var Status = "1";
            } else if (modal_Status == "Unpublish") {
                var Status = "0";
            }
    
            var add_modal_skip_available_Count = 0;
            var add_modal_intro_start = 0;
            var add_modal_intro_end = 0;
    
            var jsonObjects = {
                "season_id": seasonID,
                "modal_Episodes_Name": modal_Episodes_Name,
                "modal_Thumbnail": modal_Thumbnail,
                "modal_Order": modal_Order,
                "modal_Source": modal_Source,
                "modal_Url": modal_Url,
                "modal_Description": modal_Description,
                "Downloadable": Downloadable,
                "Type": Type,
                "Status": Status,
                "add_modal_skip_available_Count": add_modal_skip_available_Count,
                "add_modal_intro_start": add_modal_intro_start,
                "add_modal_intro_end": add_modal_intro_end,
                "end_credits_marker": '0',
                "drm_uuid_addModal": "",
                "drm_license_uri_addModal": ""
            };
            $.ajax({
                type: 'POST',
                url: '<?= site_url('Admin_api/add_episode') ?>',
                data: jsonObjects,
                dataType: 'text',
                success: function (response2) {
                    //
                }
            });
        }
    </script>