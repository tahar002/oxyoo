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

            						<h4 class="font-size-18">Manage Movie Download Links</h4>

            						<ol class="breadcrumb mb-0">

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Movies</a></li>

            							<li class="breadcrumb-item active">Manage Movie Download Links</li>

            						</ol>

            					</div>

            				</div>

            			</div>

            			<!-- end page title -->


                        <div class="row">
                        	<div class="col-md-12">
                        		<div class="card card-body">
                        			<div class="panel-heading">
                        				<h3 class="panel-title">Add Download links (<?php echo $movieData->name; ?>)</h3>

                        			</div>

                        			<hr>

                        			<div class="panel-body">
                        				<input type="hidden" name="videos_id" value="615">
                        				<div class="form-group mb-3"> <label
                        						class="control-label">Name</label>&nbsp;&nbsp;<input id="Label"
                        						type="text" name="label" class="form-control" placeholder="Name#1"
                        						required=""> </div>

                        				<div class="form-group mb-3"> <label class="control-label">Order</label> <input
                        						id="Order" type="number" name="order" class="form-control"
                        						placeholder="0 to 9999" required=""> </div>

                        				<div class="form-group mb-3"> <label
                        						class="control-label">Quality</label>&nbsp;&nbsp;<input id="Quality"
                        						type="text" name="label" class="form-control" placeholder="1080p"
                        						required=""> </div>

                        				<div class="form-group mb-3"> <label
                        						class="control-label">Size</label>&nbsp;&nbsp;<input id="Size"
                        						type="text" name="label" class="form-control" placeholder="1.0GB"
                        						required=""> </div>

                        				<div class="form-group mb-3"> <label class="control-label">Source</label> 
                                            <select id="addSource" class="form-control" name="source">
                                                <?php include("partials/source/download_source.php"); ?>
                                            </select>
                                        </div>
                        				<div class="form-group mb-3" id="url-input"> <label class="control-label">Url</label>
                        					<input id="Url" type="text" name="url" id="url-input-field" value=""
                        						class="form-control"
                        						placeholder="https://server-1.com/movies/Avengers.mp4" required="">
                        				</div>

                        				<div class="form-group mb-3"> <label class="control-label">Download type</label>
                        					<select id="download_type" class="form-control" name="source"
                        						id="selected-source">
                        						<option value="Internal" selected="">Internal</option>
                        						<option value="External">External</option>
                        					</select></div>

                        				<div class="form-group mb-3"> <label class="control-label">Status</label> <select
                        						id="Status" class="form-control" name="source" id="selected-source">
                        						<option value="Publish" selected="">Publish</option>
                        						<option value="Unpublish">Unpublish</option>
                        					</select><br> </div>


                        				<div class="form-group mb-3 row justify-content-end"> 
                                            <div class="col-md-1"> <button
                        						onclick="add_download_links()"
                        						class="btn btn-sm btn-primary waves-effect" type="submit"> <span
                        							class="btn-label"><i class="fa fa-plus"></i></span>Add
                        					</button> </div>
                                        </div>
                        			</div>


                        			<div class="panel-heading">
                        				<h3 class="panel-title">Download Link List</h3>

                        			</div>
                        			<br>
                        			<div>

                        				<table id="datatable" class="table table-striped"
                        					style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        					<thead>

                        						<tr>

                        							<th>#</th>

                                                    <th>Action</th>

                        							<th>Source</th>

                        							<th>Order</th>

                        							<th>Name</th>

                        							<th>Quality</th>

                        							<th>Size</th>

                        							<th>Url</th>

                        							<th>Type</th>

                        							<th>Status</th>

                        						</tr>

                        					</thead>





                        					<tbody>
                        						<?php
                                                    $int_table_id = 1;
                                                    foreach ($movieDownloadLinks as $row) {
                                                        ?>
                                                         <tr>
                                                             <th><?php echo($int_table_id); ?></th>

                                                             <td>
                                                    
                                                                 <div class="btn-group mr-1 mt-2">
                                                                     <?php $Row_ID = $row->id; ?>
                                                    
                                                                     <button type="button"
                                                                         class="btn btn-secondary dropdown-toggle"
                                                                         data-bs-toggle="dropdown" aria-haspopup="true"
                                                                         aria-expanded="false">Options <i
                                                                             class="mdi mdi-chevron-down"></i></button>
                                                    
                                                                     <div class="dropdown-menu" style="">
                                                    
                                                                         <a class="dropdown-item"
                                                                             onclick="Load_Link_Data(<?php echo($Row_ID); ?>)"
                                                                             data-bs-toggle="modal"
                                                                             data-bs-target="#Movie_Link_Edit_Modal">Edit
                                                                             Link</a>
                                                    
                                                                         <a class="dropdown-item" id="Delete"
                                                                             onclick="Delete_DownloadLink(<?php echo($Row_ID); ?>)">Delete</a>
                                                    
                                                                     </div>
                                                    
                                                                 </div>
                                                    
                                                             </td>

                                                             <td><?php echo stripslashes($row->type); ?></td>
                                                             <td><?php echo stripslashes($row->link_order); ?></td>
                                                             <td><?php echo stripslashes($row->name); ?></td>
                                                             <td><?php echo stripslashes($row->quality); ?></td>
                                                             <td><?php echo stripslashes($row->size); ?></td>
                                                             <td><?php echo wordwrap($row->url,60,"<br>\n",TRUE); ?></td>
                                                             <td><?php echo stripslashes($row->download_type); ?></td>
                                                    
                                                             <?php
                                                     if($row->status == 0) {
                                                         ?>
                                                             <td><span class="badge bg-danger">UnPublished</span></td>
                                                             <?php
                                                     }
                                                     if($row->status == 1) {
                                                         ?>
                                                             <td><span class="badge bg-success">Published</span></td>
                                                             <?php
                                                     }
                                                    
                                                     ?>
                                                    
                                                    
                                                    
                                                             <?php ++$int_table_id ?>
                                                         </tr>
                                                         <?php
                                                       }
                                                ?>
                        					</tbody>

                        				</table>

                        			</div>

                        		</div>
                        	</div>
                        </div>
            			

            		</div> <!-- container-fluid -->

            	</div>

                <!-- Modal -->
                <div class="modal fade" id="Movie_Link_Edit_Modal" tabindex="-1" role="dialog"
                	aria-labelledby="Movie_Link_Edit_Modal_Lebel" aria-hidden="true">
                	<div class="modal-dialog" role="document">
                		<div class="modal-content">
                			<div class="modal-header">
                				<h5 class="modal-title" id="Movie_Link_Edit_Modal_Lebel">Edit Link</h5>
                				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                				</button>
                			</div>
                			<div class="modal-body">
                				<div class="panel-body">
                					<input type="hidden" id="modal_videos_id" name="modal_videos_id" value="000">
                					<div class="form-group mb-3"> <label class="control-label">Name</label>&nbsp;&nbsp;<input
                							id="modal_Label" type="text" name="label" class="form-control"
                							placeholder="Name#1" required=""> </div>

                					<div class="form-group mb-3"> <label class="control-label">Order</label> <input
                							id="modal_Order" type="number" name="order" class="form-control"
                							placeholder="0 to 9999" required=""> </div>

                					<div class="form-group mb-3"> <label
                							class="control-label">Quality</label>&nbsp;&nbsp;<input id="modal_Quality"
                							type="text" name="label" class="form-control" placeholder="1080p"
                							required=""> </div>

                					<div class="form-group mb-3"> <label class="control-label">Size</label>&nbsp;&nbsp;<input
                							id="modal_Size" type="text" name="label" class="form-control"
                							placeholder="1.0GB" required=""> </div>

                					<div class="form-group mb-3"> <label class="control-label">Source</label> 
                                        <select id="editSource" class="form-control" name="source">
                                            <?php include("partials/source/download_source.php"); ?>
                                        </select>
                                    </div>

                					<div class="form-group mb-3" id="url-input"> <label class="control-label">Url</label>
                						<input id="modal_Url" type="text" name="url" value="" class="form-control"
                							placeholder="https://server-1.com/movies/Avengers.mp4" required="">
                					</div>

                					<div class="form-group mb-3"> <label class="control-label">Download type</label> <select
                							id="modal_download_type" class="form-control" name="modal_download_type"
                							id="selected-source">
                							<option value="Internal" selected="">Internal</option>
                							<option value="External">External</option>
                						</select></div>

                					<div class="form-group mb-3"> <label class="control-label">Status</label> <select
                							id="modal_Status" class="form-control" name="source">
                							<option value="Publish" selected="">Publish</option>
                							<option value="Unpublish">Unpublish</option>
                						</select><br> </div>
                				</div>
                			</div>
                			<div class="modal-footer">
                				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                				<button type="button" onclick="Update_Link_Data()" class="btn btn-primary">Save
                					changes</button>
                			</div>
                		</div>
                	</div>
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
            "paging": false,
            "info": false,
            "filter": false,
            "pageLength": 100
        });

        function add_download_links() {
            var Label = document.getElementById("Label").value;
            var Order = document.getElementById("Order").value;
            var Quality = document.getElementById("Quality").value;
            var Size = document.getElementById("Size").value;
            var Source = document.getElementById("addSource").value;
            var Url = document.getElementById("Url").value;
            var download_type = document.getElementById("download_type").value;
    
    
            var Status_Txt = document.getElementById("Status").value;
            if (Status_Txt == "Publish") {
                var Status = "1";
            } else if (Status_Txt == "Unpublish") {
                var Status = "0";
            }
    
            var jsonObjects = {
                Movie_id: "<?php echo $movieID; ?>",
                Label: Label,
                Order: Order,
                Quality: Quality,
                Size: Size,
                Source: Source,
                Url: Url,
                download_type: download_type,
                Status: Status
            };
            $.ajax({
                type: 'POST',
                url: '<?= site_url('Admin_api/add_movie_download_links') ?>',
                data: jsonObjects,
                dataType: 'text',
                success: function (response) {
                    if (response != "") {
                        swal.fire({
                            title: 'Successful!',
                            text: 'Download Link Added Successfully!',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#556ee6',
                            cancelButtonColor: "#f46a6a"
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        swal.fire({
                            title: 'Error',
                            text: 'Something Went Wrong :(',
                            icon: 'error'
                        }).then(function () {
                            location.reload();
                        });
                    }
                }
            });
        }

		function Load_Link_Data(ID) {
            var jsonObjects = {
                movie_download_link_id: ID
            };
            $.ajax({
                type: 'POST',
                url: '<?= site_url('Admin_api/get_movie_download_link_details') ?>',
                data: jsonObjects,
                dataType: 'json',
                success: function (response4) {
                    var id = response4.id;
                    var Label = response4.name;
                    var Order = response4.link_order;
                    var Quality = response4.quality;
                    var Size = response4.size;
                    var Source = response4.type;
                    var Url = response4.url;
                    var Status = response4.status;
                    var download_type = response4.download_type;
    
                    if (!id == "") {
                        $("#modal_videos_id").val(id);
                        $("#modal_Label").val(Label);
                        $("#modal_Order").val(Order);
                        $("#modal_Quality").val(Quality);
                        $("#modal_Size").val(Size);
                        $("#editSource").val(Source);
                        $("#modal_Url").val(Url);
                        $("#modal_download_type").val(download_type);
    
                        if (Status == "1") {
                            $("#modal_Status").val("Publish");
                        } else if (Status == "0") {
                            $("#modal_Status").val("Unpublish");
                        }
                    }
                }
            });
        }

		function Update_Link_Data() {
            var modal_videos_id = document.getElementById("modal_videos_id").value;
            var Label = document.getElementById("modal_Label").value;
            var Order = document.getElementById("modal_Order").value;
            var Quality = document.getElementById("modal_Quality").value;
            var Size = document.getElementById("modal_Size").value;
            var Source = document.getElementById("editSource").value;
            var Url = document.getElementById("modal_Url").value;
            var download_type = document.getElementById("modal_download_type").value;
    
    
            var Status_Txt = document.getElementById("modal_Status").value;
            if (Status_Txt == "Publish") {
                var Status = "1";
            } else if (Status_Txt == "Unpublish") {
                var Status = "0";
            }
    
            var jsonObjects = {
                ID: modal_videos_id,
                Label: Label,
                Order: Order,
                Quality: Quality,
                Size: Size,
                Source: Source,
                Url: Url,
                download_type: download_type,
                Status: Status
    
            };
            $.ajax({
                type: 'POST',
                url: '<?= site_url('Admin_api/update_movie_download_link_data') ?>',
                data: jsonObjects,
                dataType: 'text',
                success: function (response5) {
                    if (response5) {
                        swal.fire({
                            title: 'Successful!',
                            text: 'Download Link Updated Successfully!',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#556ee6',
                            cancelButtonColor: "#f46a6a"
                        }).then(function () {
                            location.reload();
                        });
                    } else {
						swal.fire({
                            title: 'Error',
                            text: 'Something Went Wrong :(',
                            icon: 'error'
                        }).then(function () {
                            location.reload();
                        });
                    }
                }
            });
        }

		function Delete_DownloadLink(ID) {
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
                        movie_download_link_ID: ID
                    };
                    $.ajax({
                        type: 'POST',
                        url: '<?= site_url('Admin_api/delete_download_link') ?>',
                        data: jsonObjects,
                        dataType: 'text',
                        success: function (response) {
                            if (response) {
                                swal.fire({
                                    title: 'Successful!',
                                    text: 'Download Link Deleted Successfully!',
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#556ee6',
                                    cancelButtonColor: "#f46a6a"
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                swal.fire({
                                    title: 'Error',
                                    text: 'Something Went Wrong :(',
                                    icon: 'error'
                                }).then(function () {
                                    location.reload();
                                });
                            }
    
                        }
                    });
                }
            });
        }

    </script>