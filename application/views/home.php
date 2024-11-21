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
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title"><?php echo lang('dashboard'); ?></h6>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Welcome to Dooo Dashboard</li>
                                    </ol>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-end d-none d-md-block">
                                      <button class="btn btn-primary" type="button" id="dropdownMenuButton" onclick="window.location.href='<?= site_url('update') ?>'">
                                        <i class="ion ion-md-git-compare me-2"></i> Update
                                        <?php
                                        if($remoteConfig != "") {
                                          if($config->Dashboard_Version != $remoteConfig->version) { 
                                            echo '<span class="badge rounded-pill bg-warning">1</span>';
                                          }
                                        } 
                                        ?>
                                      </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-start mini-stat-img me-4">
                                                <img src="assets/images/services-icon/01.png" alt="">
                                            </div>
                                            <h5 class="font-size-16 text-uppercase text-white-50">Total Movie</h5>
                                            <h4 class="fw-medium font-size-24"><?php echo $contentDetails->Total_Movie ?> <i
                                                    class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-end">
                                                <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-start mini-stat-img me-4">
                                                <img src="assets/images/services-icon/02.png" alt="">
                                            </div>
                                            <h5 class="font-size-16 text-uppercase text-white-50">UnPublished Movie</h5>
                                            <h4 class="fw-medium font-size-24"><?php echo $contentDetails->Total_Unpublished_Movie ?> <i
                                                    class="mdi mdi-arrow-down text-danger ms-2"></i></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-end">
                                                <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-start mini-stat-img me-4">
                                                <img src="assets/images/services-icon/03.png" alt="">
                                            </div>
                                            <h5 class="font-size-16 text-uppercase text-white-50">Total Series</h5>
                                            <h4 class="fw-medium font-size-24"><?php echo $contentDetails->Total_WebSeries ?> <i
                                                    class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-end">
                                                <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-start mini-stat-img me-4">
                                                <img src="assets/images/services-icon/04.png" alt="">
                                            </div>
                                            <h5 class="font-size-16 text-uppercase text-white-50">UnPublished
                        						Series</h5>
                                            <h4 class="fw-medium font-size-24"><?php echo $contentDetails->Total_Unpublished_WebSeries ?> <i
                                                    class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-end">
                                                <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Since last month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">

                        	<div class="col-xl-3">
                        		<div class="card">
                        			<div class="card-body">
                        				<h4 class="card-title mb-4">Todays Content Report</h4>

                        				<div class="cleafix">
                        					<p class="float-start"><i class="mdi mdi-calendar mr-1 text-primary"></i>
                        						<?php echo date('M d', time())." (Total View)"; ?></p>
                        					<h5 class="font-18 text-end">
                        						<?php echo $contentDetails->todaysMoviesView+$contentDetails->todaysWebSeriesView; ?></h5>
                        				</div>

                        				<div id="ct-donut" class="ct-chart wid"></div>

                        				<div class="mt-1">
                        					<table class="table mb-0">
                        						<tbody>
                        							<tr>
                        								<td><span class="badge bg-primary">Movies</span></td>
                        								<td>Views</td>
                        								<td class="text-right"><?php echo $contentDetails->todaysMoviesView; ?></td>
                        							</tr>
                        							<tr>
                        								<td><span class="badge bg-success">Web Series</span></td>
                        								<td>Views</td>
                        								<td class="text-right"><?php echo $contentDetails->todaysWebSeriesView; ?></td>
                        							</tr>
                        						</tbody>
                        					</table>
                        				</div>
                        			</div>
                        		</div>

                        	</div>

                        	<div class="col-xl-9">
                        		<div class="card">
                        			<div class="card-body">

                        				<h4 class="card-title mb-4">User Report</h4>

                        				<div class="row justify-content-center">
                        					<div class="col-sm-4">
                        						<div class="text-center">
                        							<h5 class="mb-0 font-size-20">
                        								<?php echo $contentDetails->Total_device; ?></h5>
                        							<p class="text-muted">Total User</p>
                        						</div>
                        					</div>
                        					<div class="col-sm-4">
                        						<div class="text-center">
                        							<h5 class="mb-0 font-size-20">
                        								<?php echo $contentDetails->Total_user; ?></h5>
                        							<p class="text-muted">Registered User</p>
                        						</div>
                        					</div>
                        					<div class="col-sm-4">
                        						<div class="text-center">
                        							<h5 class="mb-0 font-size-20">
                        								<?php if($contentDetails->Total_device-$contentDetails->Total_user < 0) { echo "0"; } else { echo $contentDetails->Total_device-$contentDetails->Total_user; } ?>
                        							</h5>
                        							<p class="text-muted">Non Registered user</p>
                        						</div>
                        					</div>
                        				</div>


                        				<div id="pie-chart" style="height:300px;"></div>

                        			</div>
                        		</div>
                        	</div> <!-- end col -->
                        </div> <!-- end row -->

                        <div class="row">
                        	<div class="col-xl-12">
                        		<div class="card">
                        			<div class="card-body">
                        				<h4 class="card-title mb-4">Most viewed Today</h4>
                        				<div class="table-responsive">
                        					<table class="table table-hover table-centered table-nowrap mb-0">
                        						<thead>
                        							<tr>
                        								<th scope="col">#</th>
                        								<th scope="col">Name</th>
                        								<th scope="col">View</th>
                        								<th scope="col">Type</th>
                        								<th scope="col">Edit</th>
                        							</tr>
                        						</thead>
                        						<tbody>
                                      <?php 
                                      $decodedMostViewedToday = json_decode($mostViewedToday);
                                      foreach($decodedMostViewedToday as $item) {
                                        ?>
                                        <tr>
                                        <th scope="row"><?php echo $item->_I; ?></th>
                        								<th scope="row"><?php echo $item->name; ?></th>
                        								<th scope="row"><?php echo $item->_V; ?></th>
                        								<th scope="row"><span class="badge bg-primary"><?php echo $item->c_type; ?></span></th>
                        								<td>
                        									<div>
                        										<a href="edit_movie?id=<?php echo $item->id; ?>"
                        											class="btn btn-primary btn-sm">Edit</a>
                        									</div>
                        								</td>
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
                        </div>

                        <div class="row">

                        	<div class="col-xl-6">
                        		<div class="card">
                        			<div class="card-body">
                        				<h4 class="card-title mb-4">Most Popular Movies</h4>
                        				<div class="table-responsive">
                        					<table class="table table-hover table-centered table-nowrap mb-0">
                        						<thead>
                        							<tr>
                        								<th scope="col">#</th>
                        								<th scope="col">Name</th>
                        								<th scope="col">View</th>
                        								<th scope="col">Edit</th>
                        							</tr>
                        						</thead>
                        						<tbody>
                                    <?php 
                                      $decodedMostPopularMovies = json_decode($MostPopularMovies);
                                      foreach($decodedMostPopularMovies as $item) {
                                        ?>
                                        <tr>
                        							  	<th scope="row"><?php echo $item->M_I; ?></th>
                        							  	<th scope="row"><?php echo $item->name; ?></th>
                        							  	<th scope="row"><?php echo $item->T_M_V; ?></th>
                        							  	<td>
                        							  		<div>
                        							  			<a href="editMovie/<?php echo $item->id; ?>"
                        							  				class="btn btn-primary btn-sm">Edit</a>
                        							  		</div>
                        							  	</td>
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

                        	<div class="col-xl-6">
                        		<div class="card">
                        			<div class="card-body">
                        				<h4 class="card-title mb-4">Most Popular WebSeries</h4>
                        				<div class="table-responsive">
                        					<table class="table table-hover table-centered table-nowrap mb-0">
                        						<thead>
                        							<tr>
                        								<th scope="col">#</th>
                        								<th scope="col">Name</th>
                        								<th scope="col">View</th>
                        								<th scope="col">Edit</th>
                        							</tr>
                        						</thead>
                        						<tbody>
                                    <?php 
                                      $decodedMostPopularWebSeries = json_decode($MostPopularWebSeries);
                                      foreach($decodedMostPopularWebSeries as $item) {
                                        ?>
                                        <tr>
                        								<th scope="row"><?php echo $item->S_I; ?></th>
                        								<th scope="row"><?php echo $item->name; ?></th>
                        								<th scope="row"><?php echo $item->T_S_V; ?></th>
                        								<td>
                        									<div>
                        										<a href="edit_web_series.php?id=<?php echo $item->id; ?>"
                        											class="btn btn-primary btn-sm">Edit</a>
                        									</div>
                        								</td>
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
                        </div>


                        <div class="row">

                        	<div class="col-xl-12">
                        		<div class="card">
                        			<div class="card-body">
                        				<h4 class="card-title mb-4">New users</h4>
                        				<div class="table-responsive">
                        					<table class="table table-hover table-centered table-nowrap mb-0">
                        						<thead>
                        							<tr>
                        								<th>#</th>
                        								<th>Full Name</th>
                        								<th>Email</th>
                        								<th>Role</th>
                        								<th>Subscription</th>
                        							</tr>
                        						</thead>
                        						<tbody>
                                    <?php 
                                      $decodedNewUsers = json_decode($NewUsers);
                                      foreach($decodedNewUsers as $item) {
                                        ?>
                                        <tr>
                        								<th scope="row"><?php echo $item->M_I; ?></th>
                        								<th scope="row"><?php echo $item->name; ?></th>
                        								<th scope="row"><?php echo $item->email; ?></th>

                        								<?php
                                                            $f_role = "";
                                                                if ($item->role == 0) {
                                                                    $f_role = 'User';
                                                                } else if ($item->role == 1) {
                                                                    $f_role = 'Admin';
                                                                } else if ($item->role == 2) {
                                                                    $f_role = 'SubAdmin';
                                                                } else if ($item->role == 3) {
                                                                    $f_role = 'Editor';
                                                                } else if ($item->role == 4) {
                                                                    $f_role = 'Editor';
                                                                }
                                                            ?>
                        								<th scope="row"><?php echo $f_role; ?></th>

                        								<th scope="row"><?php echo $item->active_subscription; ?></th>
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
                        </div>

                        <!-- LicenseModal -->
            <div class="modal fade" id="PanelUpdateModal" tabindex="-1" aria-labelledby="PanelUpdateModallLabel"
              aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header border-bottom-0">

                  </div>
                  <div class="modal-body">
                    <div class="text-center mb-4">
                      <div class="avatar-md mx-auto mb-4">
                        <div class="avatar-title rounded-circle h1">
                          <i class="on ion-md-cloud-download"></i>
                        </div>
                      </div>

                      <div class="row justify-content-center">
                        <div class="col-xl-10">
                          <h4 class="text-primary">Time To Update !</h4>
                          <p class="text-muted font-size-14 mb-4">This Version of Dooo is out of date.</p>

                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            				<button type="button" onclick="window.location.href='<?= site_url('update') ?>'" class="btn btn-primary">Update
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
                <!-- End Page-content -->

                <?php include("partials/footer_rights.php"); ?>
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        


        <?php include("partials/footer.php"); ?>

        <script>
        $(function() {
          if(<?php echo $PanelUpdateDialog; ?> == "1") {
            $('#PanelUpdateModal').modal('show');
          }
        });
        </script>
        <script>
            if(<?php echo $contentDetails->todaysMoviesView; ?> == "0" && <?php echo $contentDetails->todaysWebSeriesView; ?> == "0") {
                var chart = new Chartist.Pie('.ct-chart', {
                  series: ["1"],
                  labels: [1]
                }, {
                  donut: true,
                  showLabel: false
                });   
            } else {
                var chart = new Chartist.Pie('.ct-chart', {
                  series: [<?php echo $contentDetails->todaysMoviesView; ?>, <?php echo $contentDetails->todaysWebSeriesView; ?>],
                  labels: [1, 2]
                }, {
                  donut: true,
                  showLabel: false,
                  plugins: [
                    Chartist.plugins.tooltip()
                  ]
                }); 
            }

            chart.on('draw', function(data) {
              if(data.type === 'slice') {
                // Get the total path length in order to use for dash array animation
                var pathLength = data.element._node.getTotalLength();
            
                // Set a dasharray that matches the path length as prerequisite to animate dashoffset
                data.element.attr({
                  'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                });
            
                var animationDefinition = {
                  'stroke-dashoffset': {
                    id: 'anim' + data.index,
                    dur: 1000,
                    from: -pathLength + 'px',
                    to:  '0px',
                    easing: Chartist.Svg.Easing.easeOutQuint,
                    fill: 'freeze'
                  }
                };
            
                if(data.index !== 0) {
                  animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                }
            
                data.element.attr({
                  'stroke-dashoffset': -pathLength + 'px'
                });
    
                data.element.animate(animationDefinition, false);
              }
            });



            var myChart = echarts.init(document.getElementById('pie-chart'));
            option = {
              title: {
                text: '',
                subtext: '',
                left: 'center'
              },
              tooltip: {
                trigger: 'item'
              },
              legend: {
                orient: 'vertical',
                left: 'left',
                textStyle: {
                    color : "#B9B8CE"
                }
              },
              series: [
                {
                    name: '',
                  type: 'pie',
                  radius: ['40%', '70%'],
                  avoidLabelOverlap: false,
                  itemStyle: {
                    borderRadius: 10,
                    borderColor: '#fff',
                    borderWidth: 0
                  },
                  label: {
                    show: false,
                    position: 'center'
                  },
                  emphasis: {
                    label: {
                      show: true,
                      fontSize: '40',
                      fontWeight: 'bold'
                    }
                  },
                  labelLine: {
                    show: false
                  },
                  data: [
                    { value: <?php echo $contentDetails->Total_user; ?>, name: 'Registered User' },
                    { value: <?php if($contentDetails->Total_device-$contentDetails->Total_user < 0) { echo "0"; } else { echo $contentDetails->Total_device-$contentDetails->Total_user; } ?>, name: 'Non Registered user' }
                  ]
                }
              ]
            };
            myChart.setOption(option);
            
        </script>