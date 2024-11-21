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

                					<h4 class="font-size-18">Privacy Policy</h4>

                					<ol class="breadcrumb mb-0">

                						<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>

                						<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>

                						<li class="breadcrumb-item active">Privacy Policy</li>

                					</ol>

                				</div>

                			</div>

                		</div>

                		<!-- end page title -->

                		<div class="form">

                			<div class="row">

                				<div class="col-md-12">

                					<div class="card card-body">

                						<h3 class="card-title mt-0">Privacy Policy</h3>

                						<hr>

                						<div class="summernote" id="summernote"><?php echo $privacy_policy; ?></div>



                						</br>
                						<div class="col-md-12 row justify-content-end">
                							<button class="btn btn-primary waves-effect waves-light col-md-2" id="submit" name="submit"
											onclick="save()">
                								<i class="mdi mdi-content-save-all"></i> Save
                							</button>
                						</div>

                					</div>
                                    <div class="card card-body">

                						<h3 class="card-title mt-0">Settings</h3>

                						<hr>

                						<div class="form-group row mb-3">
                                                <label class="col-sm-3 control-label"><strong>Web View URL</strong></label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <input type="text" id="webview_url" name="webview_url"
                                                            class="form-control" required=""
                                                            value="<?php echo base_url(); ?>privacy_policy/webview" disabled="">
                                                        <span class="input-group-text waves-effect waves-light"
                                                            id="option-date"
                                                            onclick="copyToClipboard('webview_url')">Copy</span>
                                                        <a class="btn btn-primary" id="gsk" href="<?php echo base_url(); ?>privacy_policy/webview" target="_blank">
                                                            View</a>
                                                    </div>
                                                </div>
                                            </div>

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
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 250
            });
        });

		function save() {
			var PrivecyPolicy = $('#summernote').summernote('code');
			$.ajax({
                  url: '<?= site_url('Admin_api/savePrivecyPolicy') ?>',
                  type: 'POST',
				  data : { PrivecyPolicy : PrivecyPolicy },
                  dataType:'text',
                    success: function(result){
						if(result) {
							swal.fire({
                                title: 'Successful!',
                                text: 'Privecy Policy Updated successfully!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#556ee6',
                                cancelButtonColor: "#f46a6a"
                            }).then(function () {
                                location.reload();
                            });
						}
                    }
                });
		}

        function copyToClipboard(element) {
            document.getElementById(element).disabled = false;
            var copyText = document.getElementById(element);
            copyText.focus();
            copyText.select();
            try {
              var successful = document.execCommand('copy');
              var msg = successful ? 'successful' : 'unsuccessful';
                swal.fire({
                    title: 'Copied!',
                    html: copyText.value,
                    icon: 'success'
                });
            } catch (err) {
                swal.fire({
                    title: 'Error',
                    text: 'Something Went Wrong :(',
                    icon: 'error'
                }).then(function () {
                    location.reload();
                });
            }
            document.getElementById(element).disabled = true;
        }
    </script>