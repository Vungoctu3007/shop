

        <!-- Single Page Header End -->	

		<!-- SECTION -->
		<div class="section" style="margin-top: 50px;">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- ASIDE -->
					<div id="aside" class="col-md-3">
						<!-- aside Widget -->
						<div class="aside mb-4">
							<h3 class="aside-title mb-4">Danh mục</h3>
							<div class="checkbox-filter">
							<?php
								$i = 1;
								foreach($dataCategories as $category) {
									echo '<div class="form-check input-checkbox">';
									echo '<input class="form-check-input category-checkbox" type="checkbox" value="'.$category['category_id'].'" id="category-'.$i.'">';
									echo '<label class="form-check-label" for="category-'.$i.'">';
									echo '<span></span>';
									echo $category['category_name'];
									echo '</label>';
									echo '</div>';
									$i++;
								}
							?>
							</div>
						</div>
						<!-- /aside Widget -->

						<!-- aside Widget -->
						
						<div class="aside mb-4">
							<h3 class="aside-title mb-4">Khoảng giá</h3>
							<div class="range d-flex align-items-center">
								<input id="price-range-start" class="form-control p-1" type="text" style="width: 110px;">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="70" height="15"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/></svg>
								<input id="price-range-end" class="form-control p-1" type="text" style="width: 110px;">
							</div>
						</div>
						<!-- /aside Widget -->

						<div class="aside mb-4">
							<h3 class="aside-title mb-4">Tìm kiếm</h3>
							<div class="range d-flex align-items-center">
								<!-- store top filter -->
								<input type="text" class="form-control p-2 mb-5" id="name-search" placeholder="Nhập tên sản phẩm" style="width: 300px;">
								<!-- /store top filter -->
							</div>
						</div>
						<!-- /aside Widget -->
					</div>
					<!-- /ASIDE -->

					<!-- STORE -->
					<div id="store" class="col-md-9">


						<div class="row g-4 justify-content-center" id="show-product">
						</div>
						<!-- /store products -->
						<nav aria-label="..." >
							<ul id="store-pagination" class="pagination pagination-lg d-flex justify-content-center mt-5">

							</ul>
						</nav>
						<!-- store bottom filter -->

						<!-- /store bottom filter -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>	
		<!-- /SECTION -->
		<script>
			
		</script>