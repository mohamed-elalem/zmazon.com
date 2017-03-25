 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/img/admin.ico" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> <?= $userSession->user->userName ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="<?= $this->baseUrl() ?>/shop-user">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
         
        </li>
        <li class="treeview active">
          <a href="<?= $this->baseUrl() ?>/shop-user/list-all-products">
            <i class="fa fa-files-o"></i>
            <span>Products</span>
            <span class="pull-right-container">
            </span>
          </a>
         
        </li>
        <li>
          <a href="<?= $this->baseUrl() ?>/shop-user/list-current-sale/">
            <i class="fa fa-th"></i> <span>Sales</span>
          </a>
        </li>
        <li class="">
          <a href="<?= $this->baseUrl() ?>/shop-user/statistics">
            <i class="fa fa-laptop"></i>
            <span>Statistics</span>
            <span class="pull-right-container">
            </span>
          </a>        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>