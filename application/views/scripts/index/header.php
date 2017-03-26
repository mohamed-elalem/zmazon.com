<header id="header">
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="/"><img src="<?= $this->baseUrl() ?>/img/home/logo.png" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									<?php if($language == "_ar"): ?>
                                                                                العربية
                                                                        <?php else: ?>
                                                                                English
                                                                            
                                                                        <?php endif; ?>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
                                                                    <li><a href="/index/toggle-language">
                                                                        <?php if($language == "_ar"): ?>
                                                                                English
                                                                        <?php else: ?>
                                                                                 العربية
                                                                            
                                                                        <?php endif; ?>
                                                                        </a></li>
								</ul>
							</div>
							
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
                                                                <li><a href="<?= $this->baseUrl() ?>"><i class="fa fa-star"></i> Home </a></li>
                                                            <?php if ($user && $user->privilege=="customerUser"): ?>
								<li><a href="<?= $this->baseUrl() ?>/customer-user/view-wish-list"><i class="fa fa-star"></i> Wishlist</a></li>
								<li><a href="<?= $this->baseUrl() ?>/customer-user/view-cart"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                                                            <?php endif; 
                                                            if($user): ?>
								<li><a href="<?= $this->baseUrl() ?>/user/logout"><i class="fa fa-lock"></i> Logout</a></li>
                                                            <?php else : ?>
                                                                <li><a href="<?= $this->baseUrl() ?>/user/login"><i class="fa fa-lock"></i> Login</a></li>
                                                            <?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
                                    <div class="col-sm-9">
                                        
                                    </div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
                                                    <form method="post" action="/index/search-products" name="search_form">
                                                        <input name="search_product" type="text" placeholder="Search"/>
                                                    </form>
                                                </div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->