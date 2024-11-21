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

            						<h4 class="font-size-18">Subscription Setting</h4>

            						<ol class="breadcrumb mb-0">

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Dooo</a></li>

            							<li class="breadcrumb-item"><a href="javascript: void(0);">Subscription Setting</a></li>

            							<li class="breadcrumb-item active">Payment Gateways</li>

            						</ol>

            					</div>

            				</div>

            			</div>

            			<!-- end page title -->


                        <div class="form" method="post">

                        	<div class="row">

                        		<div class="col-md-12">

                        			<div class="card card-body">
                        			    <div class="tab-pane active" id="rest_api" role="tabpanel">
                        			        <h3 class="card-title mt-0">Razorpay</h3>
                        			        <hr>
                        			        <div class="form-group row mb-3">
                        			            <label class="control-label col-sm-3 ">Enable Razorpay</label>
                        			            <div class="col-sm-6">
                        			                <input type="checkbox" id="razorpay_status" switch="bool">
                        			                <label for="razorpay_status" data-on-label="" data-off-label=""></label>
                        			            </div>
                        			        </div>
                        			        <div class="form-group row mb-3">
                        			            <label class="col-sm-3 control-label">Razorpay key id</label>
                        			            <div class="col-sm-6">
                        			                <input type="text" name="razorpay_key_id" id="razorpay_key_id" placeholder=""
                        			                    class="form-control" required=""
                        			                    value="<?php echo $config->razorpay_key_id ?>">
                        			            </div>
                        			        </div>
                        			        <div class="form-group row mb-3">
                        			            <label class="col-sm-3 control-label">Razorpay key secret</label>
                        			            <div class="col-sm-6">
                        			                <input type="text" name="razorpay_key_secret" id="razorpay_key_secret"
                        			                    placeholder="" class="form-control" required=""
                        			                    value="<?php echo $config->razorpay_key_secret ?>">
                        			            </div>
                        			        </div>


                        			        <h3 class="card-title mt-0">Paypal</h3>
                        			        <hr>
                        			        <div class="form-group row mb-3">
                        			            <label class="control-label col-sm-3 ">Enable Paypal</label>
                        			            <div class="col-sm-6">
                        			                <input type="checkbox" id="paypal_status" switch="bool">
                        			                <label for="paypal_status" data-on-label="" data-off-label=""></label>
                        			            </div>
                        			        </div>
                        			        <div class="form-group row mb-3">
                        			            <label class="col-sm-3 control-label">Paypal Clint ID</label>
                        			            <div class="col-sm-6">
                        			                <input type="text" name="paypal_clint_id" id="paypal_clint_id" placeholder=""
                        			                    class="form-control" required=""
                        			                    value="<?php echo $config->paypal_clint_id ?>">
                        			            </div>
                        			        </div>





                                            <h3 class="card-title mt-0">Flutterwave</h3>
                        			        <hr>
                        			        <div class="form-group row mb-3">
                        			            <label class="control-label col-sm-3 ">Enable Flutterwave</label>
                        			            <div class="col-sm-6">
                        			                <input type="checkbox" id="flutterwave_status" switch="bool">
                        			                <label for="flutterwave_status" data-on-label="" data-off-label=""></label>
                        			            </div>
                        			        </div>
                        			        <div class="form-group row mb-3">
                        			            <label class="col-sm-3 control-label">Flutterwave Public Key</label>
                        			            <div class="col-sm-6">
                        			                <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" placeholder=""
                        			                    class="form-control" required=""
                        			                    value="<?php echo $config->flutterwave_public_key ?>">
                        			            </div>
                        			        </div>
                        			        <div class="form-group row mb-3">
                        			            <label class="col-sm-3 control-label">Flutterwave Secret Key</label>
                        			            <div class="col-sm-6">
                        			                <input type="text" name="flutterwave_secret_key" id="flutterwave_secret_key"
                        			                    placeholder="" class="form-control" required=""
                        			                    value="<?php echo $config->flutterwave_secret_key ?>">
                        			            </div>
                        			        </div>
                                            <div class="form-group row mb-3">
                        			            <label class="col-sm-3 control-label">Flutterwave Encryption Key</label>
                        			            <div class="col-sm-6">
                        			                <input type="text" name="flutterwave_encryption_key" id="flutterwave_encryption_key"
                        			                    placeholder="" class="form-control" required=""
                        			                    value="<?php echo $config->flutterwave_encryption_key ?>">
                        			            </div>
                        			        </div>





                        			        <div class="form-group mb-3">

                        			            <div class="col-md-12 row justify-content-end">

                        			                <button
                        			                    class="btn btn-primary dropdown-toggle waves-effect waves-light col-md-2"
                        			                    onclick="Save_Subscription_Setting_Data()" id="create_btn" type="submit"
                        			                    aria-haspopup="true" aria-expanded="false">

                        			                    <i class="mdi mdi-content-save-all"></i> SAVE

                        			                </button>

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
        $( document ).ready(function() {
            if ('<?php echo $config->razorpay_status; ?>' == 1) {
                document.getElementById("razorpay_status").checked = true;
            } else {
                document.getElementById("razorpay_status").checked = false;
			}

            if ('<?php echo $config->paypal_status; ?>' == 1) {
                document.getElementById("paypal_status").checked = true;
            } else {
                document.getElementById("paypal_status").checked = false;
			}

            if ('<?php echo $config->flutterwave_status; ?>' == 1) {
                document.getElementById("flutterwave_status").checked = true;
            } else {
                document.getElementById("flutterwave_status").checked = false;
			}
        });

        function Save_Subscription_Setting_Data() {
            if ($('#razorpay_status').is(':checked')) {
                var razorpay_status_int = 1;
            } else {
                var razorpay_status_int = 0;
            }
            var razorpay_key_id = document.getElementById("razorpay_key_id").value;
            var razorpay_key_secret = document.getElementById("razorpay_key_secret").value;
            if ($('#paypal_status').is(':checked')) {
                var paypal_status_int = 1;
            } else {
                var paypal_status_int = 0;
            }
            var paypal_clint_id = document.getElementById("paypal_clint_id").value;
            if ($('#flutterwave_status').is(':checked')) {
                var flutterwave_status = 1;
            } else {
                var flutterwave_status = 0;
            }
            var flutterwave_public_key = document.getElementById("flutterwave_public_key").value;
            var flutterwave_secret_key = document.getElementById("flutterwave_secret_key").value;
            var flutterwave_encryption_key = document.getElementById("flutterwave_encryption_key").value;
            var jsonObjects = {
                razorpay_status_int: razorpay_status_int,
                razorpay_key_id: razorpay_key_id,
                razorpay_key_secret: razorpay_key_secret,
                paypal_status_int: paypal_status_int,
                paypal_clint_id: paypal_clint_id,
                flutterwave_status: flutterwave_status,
                flutterwave_public_key: flutterwave_public_key,
                flutterwave_secret_key: flutterwave_secret_key,
                flutterwave_encryption_key: flutterwave_encryption_key
            };

            $.ajax({
                type: 'POST',
                url: '<?= site_url('Admin_api/update_sub_setting') ?>',
                data: jsonObjects,
                dataType: 'text',
                success: function (response) {
                    if (response) {
                        swal.fire({
                            title: 'Successful!',
                            text: 'Payment Gateways Updated successfully!',
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
    </script>