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

            						<h4 class="font-size-18">All Channels</h4>

            						<ol class="breadcrumb mb-0">

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Live TV</a></li>

            							<li class="breadcrumb-item active">All Channels</li>

            						</ol>

            					</div>

            				</div>

            			</div>
<a href="<?= site_url('admin/import_channels') ?>" class="btn btn-primary">Importer des Chaînes</a>
<a href="<?= site_url('admin/converteur') ?>" class="btn btn-primary">Importer des Chaînes</a>
            			<!-- end page title -->


                        <div class="row">

                        	<div class="col-12">

                        		<div class="card">

                        			<div class="card-body">

                        				<table id="datatable" class="table table-striped"
                        					style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        					<thead>

                        						<tr>

                        							<th>#</th>

                        							<th>##</th>

                        							<th>Thumbnail</th>

                        							<th>Name</th>

                        							<th>Stream Type</th>

                        							<th>Url</th>

                        							<th>Status</th>

                        							<th>Featured</th>

                        						</tr>

                        					</thead>

                        				</table>



                        			</div>

                        		</div>

                        	</div> <!-- end col -->

                        </div> <!-- end row -->

            		</div> <!-- container-fluid -->

            	</div>
                 


            	<?php include("partials/footer_rights.php"); ?>


            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php include("partials/footer.php"); ?>

    <script>
        $('#datatable').dataTable({
            "order": [],
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('Admin_api/get_all_channel') ?>",
                "type":"GET",
            },
            "columns": [
                { "data": "1",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { "data": "2",
                    render: function(data) {
                        return '<div class="btn-group mr-1 mt-2"> <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options <i class="mdi mdi-chevron-down"></i></button> <div class="dropdown-menu" style=""> <a class="dropdown-item" onclick="Edit_Channel('+data+')" href="#">Edit Channel</a> <a class="dropdown-item" id="Delete" onclick="Delete_Data('+data+')" href="#">Delete</a> <div class="dropdown-divider"></div> <a class="dropdown-item" onclick="Notify(' +
                            data + ')">Send Push Notification</a> <a class="dropdown-item" onclick="telegramNotify(' +
                            data + ')">Send Telegram Notification</a> </div> </div>';
                    }
                },
                { "data": "3",
                   render: function(data) {
                    return '<img class="img-fluid" height="100" width="80" src='+data+' data-holder-rendered="true">';
                    }
                },
                { "data": "4" },
                { "data": "5" },
                { "data": "6",
                    render: function(data) {
                        var length = 55;
                        return data.length > length ? 
                        data.substring(0, length - 3) + "..." : 
                        data;
                    }
                },
                { "data": "7",
                    render: function(data) {
                       if(data == 0) {
                        return '<span class="badge bg-danger">UnPublished</span';
                       } else if(data == 1) {
                        return '<span class="badge bg-success">Published</span>';
                       }
                    }
                },
                { "data": "8",
                    render: function(data) {
                       if(data == 0) {
                        return '<i class="typcn typcn-times"></i>';
                       } else if(data == 1) {
                        return '<i class="typcn typcn-tick"></i>';
                       }
                    }
                }
            ]
            
        });

        function Delete_Data(ID) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, delete it!"
            }).then(function (result) {
                if (result.value) {
                    var jsonObjects = {
                        "channelID": ID
                    };
                    $.ajax({
                        type: 'POST',
                        url: "<?= site_url('Admin_api/delete_channel') ?>",
                        data: jsonObjects,
                        dataType: 'text',
                        success: function (response) {
                            if (response) {
                                swal.fire({
                                    title: 'Successful!',
                                    text: 'Channel Deleted Successfully!',
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#556ee6',
                                    cancelButtonColor: "#f46a6a"
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal.fire({
                                      title: 'Error',
                                      text: 'Something Went Wrong :(',
                                      icon: 'error'
                                }).then(function() {
                                    location.reload();
                                });
                            }
    
                        }
                    });
                }
            });
        }

        function Edit_Channel(ID) {
            window.location.assign("edit_channel/"+ID);
        }

        function Notify(ID) {
            alert("Under Devlopment!")
        }

        function telegramNotify(ID) {
            alert("Under Devlopment!")
        }
    </script>