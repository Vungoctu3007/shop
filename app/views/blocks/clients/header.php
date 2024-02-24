<!-- HEADER -->
<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
					</ul>
					<?php
						if (isset($_SESSION['user_session']['user'])) {
							echo '<ul class="header-links pull-right">';
							echo '<li><a href="#"><i class="fa fa-user-o"></i>' . $_SESSION['user_session']['user']['name'] . '</a></li>';
                            echo '<li><a href="http://localhost/shop/signin/logout"><i class="fa fa-sign-out"></i> Logout</a></li>';
                            echo '</ul>';
						} else {
                            echo '<ul class="header-links pull-right">';
                            echo '<li><a href="http://localhost/shop/dang-nhap"><i class="fa fa-user-o"></i>signin/up</a></li>';
                            echo '</ul>';
                        }
					?>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="<?php echo _WEB_ROOT;?>/public/assets/clients/img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-7">
							
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-1">
							<div class="header-ctn">
								<!-- Cart -->
								<div class="dropdown">
									<a href="<?php echo _WEB_ROOT;?>/carts" class="dropdown-toggle" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<?php
											if (isset($_SESSION['user_session']['user'])) {
												echo '<div class="qty">'.$numOfProductInCart.'</div>';
											} else {
												echo '<div class="qty">0</div>';
											}
										?>
									</a>
								</div>
								<!-- /Cart -->

							</div>
						</div>
						<div class="col-md-1">
							<div class="header-ctn">
								<!-- Orders -->
								<div class="dropdown">
									<a href="<?php echo _WEB_ROOT;?>/order" class="dropdown-toggle" aria-expanded="true">
									<i class="fa-solid fa-clipboard"></i>
										<span>Your Orders</span>
									</a>
								</div>
								<!-- Orders -->

							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">News</a></li>
						<li><a href="#">About us</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->
