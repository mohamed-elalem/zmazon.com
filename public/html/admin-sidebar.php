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
          <a href="<?= $this->baseUrl() ?>/admin">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
         
        </li>
        <li class="treeview active">
          <a href="<?= $this->baseUrl() ?>/admin/manage-categories">
            <i class="fa fa-files-o"></i>
            <span>Categories</span>
            <span class="pull-right-container">
            </span>
          </a>
         
        </li>
        <li>
          <a href="<?= $this->baseUrl() ?>/admin/manage-users/">
            <i class="fa fa-th"></i> <span>Users</span>
          </a>
        </li>
        <li class="">
          <a href="<?= $this->baseUrl() ?>/admin/list-orders">
            <i class="fa fa-laptop"></i>
            <span>Orders</span>
            <span class="pull-right-container">
            </span>
          </a>
          
        <li class="">
          <a href="<?= $this->baseUrl() ?>/admin/add-category">
            <i class="fa fa-edit"></i> <span>Add Category</span>
            <span class="pull-right-container">
            </span>
          </a>
          
        </li>
        <li class="">
          <a href="<?= $this->baseUrl() ?>/admin/contact-developers/">
            <i class="fa fa-table"></i> <span>Contact Developers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>