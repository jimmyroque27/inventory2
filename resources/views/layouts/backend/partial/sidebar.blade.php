<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('admin.dashboard') }}" class="brand-link">
		<img src="{{ asset('assets/backend/img/logo.png') }}" alt="Logo" class="brand-image"
		     style="opacity: .8">
		 <span class="brand-text font-weight-light">
			 <!-- <span style="display: inline-block; font-family: 'Times New Roman', Times, serif;  font-size: 14px; margin-top: -5px;">INNOVATIVE</span>
			 <span style="display: inline-block; font-family: 'Times New Roman', Times, serif;  font-size: 9px; margin-top: -5px;">TECHNOLOGY SOLUTIONS</span> -->
 			 <div style="display: inline-box; font-family: 'Times New Roman', Times, serif;  font-size: 14px; margin-top: -5px !important;">
				 INNOVATIVE
				 <div style="display: auto;  font-family: 'Times New Roman', Times, serif; font-size: 9px;   margin-bottom: -6px;">TECHNOLOGY SOLUTIONS </div>
			 </div>

 		</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('assets/backend/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">Alexander Pierce</a>
			</div>
		</div> -->

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->

			 	<!-- DASHBOARD -->

				@if(Auth::user()->can('Dashboard') || (Auth::user()->hasRole('admin')))
					<li class="nav-item has-treeview">
						<a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
							<i class="nav-icon fa fa-dashboard"></i>
							<p>
								Dashboard
							</p>
						</a>
					</li>
				@endif
				@if(Auth::user()->can('POS') || (Auth::user()->hasRole('admin')))
					<!-- POS -->
					<li class="nav-item has-treeview">
						<a href="{{ route('admin.pos.index') }}" class="nav-link {{ Request::is('admin/pos') ? 'active' : '' }}">
							<i class="nav-icon fa fa-shopping-bag"></i>
							<p>
								Point of Sales (POS)
							</p>
						</a>
					</li>
				@endif
				@if(Auth::user()->can('Order') || (Auth::user()->hasRole('admin')))
					<!-- ORDER -->
					<li class="nav-item has-treeview {{ Request::is('admin/order*','admin/receipt*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/order*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-pie-chart"></i>
							<p>
								Order
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.order.pending') }}" class="nav-link {{ Request::is('admin/order/pending') ? 'active' : '' }}">
									<i class="fa fa-star-half-o nav-icon"></i>
									<p>Pending Orders</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.order.approved') }}" class="nav-link {{ Request::is('admin/order/approved') ? 'active' : '' }}">
									<i class="fa fa-star nav-icon"></i>
									<p>Approved Orders</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.receipt.index') }}" class="nav-link {{ Request::is('admin/receipt*') ? 'active' : '' }}">
									<i class="fa fa-file-text nav-icon"></i>
									<p>Payment Receipt</p>
								</a>
							</li>
						</ul>
					</li>
				@endif
				@if(Auth::user()->can('Sales Report') || (Auth::user()->hasRole('admin')))
					<!-- SALES REPORT -->
					<li class="nav-item has-treeview {{ Request::is('admin/sales*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/sales*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-bar-chart"></i>
							<p>
								Sales Report
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.sales.today') }}" class="nav-link {{ Request::is('admin/sales/today') ? 'active' : '' }}">
									<i class="fa fa-star-o nav-icon"></i>
									<p>Today's Report</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.sales.monthly') }}" class="nav-link {{ Request::is('admin/sales-monthly*') ? 'active' : '' }}">
									<i class="fa fa-star-half-full nav-icon"></i>
									<p>Monthly Report</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.sales.total') }}" class="nav-link {{ Request::is('admin/sales-total') ? 'active' : '' }}">
									<i class="fa fa-star nav-icon"></i>
									<p>Total Sales</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.sales.summary.customer') }}" class="nav-link {{ Request::is('admin/sales-summary/customer') ? 'active' : '' }}">
									<i class="fa fa-spinner nav-icon"></i>
									<p>Sales Summary</p>
								</a>
							</li>
						</ul>
					</li>
				@endif
				@if(Auth::user()->can('Product') || (Auth::user()->hasRole('admin')))
					<!-- PRODUCTS -->
					<li class="nav-item has-treeview {{ Request::is('admin/product*','admin/category*','admin/size*','admin/color*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/product*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-qrcode"></i>
							<p>
								Product
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.product.create') }}" class="nav-link {{ Request::is('admin/product/create') ? 'active' : '' }}">
									<i class="fa fa-plus-square nav-icon"></i>
									<p>Add Product</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.product.index') }}" class="nav-link {{ Request::is('admin/product') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>Product List</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.category.index') }}" class="nav-link {{ Request::is('admin/category') ? 'active' : '' }}">
									<i class="fa fa-object-group nav-icon"></i>
									<p>Category List</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.product.size.index') }}" class="nav-link {{ Request::is('admin/size') ? 'active' : '' }}">
									<i class="fa fa-square nav-icon"></i>
									<p>Sizes List</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.product.color.index') }}" class="nav-link {{ Request::is('admin/color') ? 'active' : '' }}">
									<i class="fa fa-paint-brush nav-icon"></i>
									<p>Color List</p>
								</a>
							</li>





						</ul>
					</li>
				@endif
				<!--
								<li class="nav-item has-treeview {{ Request::is('admin/employee*') ? 'menu-open' : '' }}">
									<a href="#" class="nav-link {{ Request::is('admin/employee*') ? 'active' : '' }}">
										<i class="nav-icon fa fa-id-badge"></i>
										<p>
											Employee
											<i class="right fa fa-angle-left"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a href="{{ route('admin.employee.create') }}" class="nav-link {{ Request::is('admin/employee/create') ? 'active' : '' }}">
												<i class="fa fa-plus-square nav-icon"></i>
												<p>Add Employee</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="{{ route('admin.employee.index') }}" class="nav-link {{ Request::is('admin/employee') ? 'active' : '' }}">
												<i class="fa fa-list-alt nav-icon"></i>
												<p>All Employee</p>
											</a>
										</li>
									</ul>
								</li>
								<li class="nav-item has-treeview {{ Request::is('admin/attendance*') ? 'menu-open' : '' }}">
									<a href="#" class="nav-link {{ Request::is('admin/attendance*') ? 'active' : '' }}">
										<i class="nav-icon fa fa-calendar-times-o"></i>
										<p>
											Attendance (EMP)
											<i class="right fa fa-angle-left"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a href="{{ route('admin.attendance.create') }}" class="nav-link {{ Request::is('admin/attendance/create') ? 'active' : '' }}">
												<i class="fa fa-circle-o nav-icon"></i>
												<p>Take Attendance</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="{{ route('admin.attendance.index') }}" class="nav-link {{ Request::is('admin/attendance') ? 'active' : '' }}">
												<i class="fa fa-list-alt nav-icon"></i>
												<p>All Attendance</p>
											</a>
										</li>
									</ul>
								</li>
				 -->

				@if(Auth::user()->can('Customer') || (Auth::user()->hasRole('admin')))
					<!-- CUSTOMERS -->
					<li class="nav-item has-treeview {{ Request::is('admin/customer*','admin/receivables*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/customer*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-address-book-o"></i>
							<p>
								Customer
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.customer.create') }}" class="nav-link {{ Request::is('admin/customer/create') ? 'active' : '' }}">
									<i class="fa fa-plus-square nav-icon"></i>
									<p>Add Customer</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.customer.index') }}" class="nav-link {{ Request::is('admin/customer') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>All Customer</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.customer.receivables') }}" class="nav-link {{ Request::is('admin/receivables') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>Receivables</p>
								</a>
							</li>
						</ul>
					</li>
				@endif
				@if(Auth::user()->can('Supplier') || (Auth::user()->hasRole('admin')))
					<!-- SUPPLIERS -->
					<li class="nav-item has-treeview {{ Request::is('admin/supplier*','admin/payables*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/supplier*') ? 'active' : '' }}">
							<i class="right fa fa-list-alt nav-icon"></i>
							<p> Supplier
									<i class="right fa fa-angle-left"></i>
							</p>

						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.supplier.create') }}" class="nav-link {{ Request::is('admin/supplier/create') ? 'active' : '' }}">
									<i class="fa fa-plus-square nav-icon"></i>
									<p>Add Supplier</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.supplier.index') }}" class="nav-link {{ Request::is('admin/supplier') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>All Supplier</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.supplier.index_ap') }}" class="nav-link {{ Request::is('admin/payables') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>Payables</p>
								</a>
							</li>
						</ul>
					</li>
				@endif
				@if(Auth::user()->can('Purchases') || (Auth::user()->hasRole('admin')))
					<!-- PURCHASES -->
					<li class="nav-item has-treeview {{ Request::is('admin/purchase*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/purchase*') ? 'active' : '' }}">
							<i class="right fa fa-list-alt nav-icon"></i>
							<p> Purchases
									<i class="right fa fa-angle-left"></i>
							</p>

						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.purchase.create') }}" class="nav-link {{ Request::is('admin/purchase/create') ? 'active' : '' }}">
									<i class="fa fa-plus-square nav-icon"></i>
									<p>Add Purchases</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.purchase.index') }}" class="nav-link {{ Request::is('admin/purchase') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>All Purchases</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.payment.index') }}" class="nav-link {{ Request::is('admin/payment') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>Payment of Purchases</p>
								</a>
							</li>
						</ul>
					</li>

					<!-- Purchase REPORT -->
					<li class="nav-item has-treeview {{ Request::is('admin/receiving*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/receiving*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-bar-chart"></i>
							<p>
								Receiving Report
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.receiving.today') }}" class="nav-link {{ Request::is('admin/receiving/today') ? 'active' : '' }}">
									<i class="fa fa-star-o nav-icon"></i>
									<p>Today's Report</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.receiving.monthly') }}" class="nav-link {{ Request::is('admin/receiving-monthly*') ? 'active' : '' }}">
									<i class="fa fa-star-half-full nav-icon"></i>
									<p>Monthly Report</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.receiving.total') }}" class="nav-link {{ Request::is('admin/receiving-total') ? 'active' : '' }}">
									<i class="fa fa-star nav-icon"></i>
									<p>Total Purchases</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.receiving.summary.supplier') }}" class="nav-link {{ Request::is('admin/receiving-summary/supplier') ? 'active' : '' }}">
									<i class="fa fa-spinner nav-icon"></i>
									<p>Purchases Summary</p>
								</a>
							</li>
						</ul>
					</li>
				@endif
				<!--
					<li class="nav-item has-treeview {{ Request::is('admin/advanced_salary*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/advanced_salary*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-ticket nav-icon"></i>
						<p>
							Advanced Salary (EMP)
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.advanced_salary.create') }}" class="nav-link {{ Request::is('admin/advanced_salary/create') ? 'active' : '' }}">
								<i class="fa fa-plus-square nav-icon"></i>
								<p>Add Advanced Salary</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.advanced_salary.index') }}" class="nav-link {{ Request::is('admin/advanced_salary') ? 'active' : '' }}">
								<i class="fa fa-list-alt nav-icon"></i>
								<p>All Advanced Salary</p>
							</a>
						</li>
					</ul>
				</li>

					<li class="nav-item has-treeview {{ Request::is('admin/salary*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/salary*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-money"></i>
						<p>
							Salary (EMP)
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{ route('admin.salary.index') }}" class="nav-link {{ Request::is('admin/salary') ? 'active' : '' }}">
								<i class="fa fa-circle-o nav-icon"></i>
								<p>Pay Salary</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('admin.salary.create') }}" class="nav-link {{ Request::is('admin/salary/create') ? 'active' : '' }}">
								<i class="fa fa-list-alt nav-icon"></i>
								<p>All Paid Salary</p>
							</a>
						</li>
					</ul>
				</li>
				-->
				@if(Auth::user()->can('Expense') || (Auth::user()->hasRole('admin')))
					<li class="nav-item has-treeview {{ Request::is('admin/expense*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/expense*') ? 'active' : '' }}">
							<i class="nav-icon fa fa-minus-circle"></i>
							<p>
								Expense
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{ route('admin.expense.create') }}" class="nav-link {{ Request::is('admin/expense/create') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>Add Expense</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.expense.today') }}" class="nav-link {{ Request::is('admin/expense-today') ? 'active' : '' }}">
									<i class="fa fa-circle-o nav-icon"></i>
									<p>Today Expense</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.expense.month') }}" class="nav-link {{ Request::is('admin/expense-month*') ? 'active' : '' }}">
									<i class="fa fa-circle-o nav-icon"></i>
									<p>Monthly Expense</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.expense.yearly') }}" class="nav-link {{ Request::is('admin/expense-yearly*') ? 'active' : '' }}">
									<i class="fa fa-circle-o nav-icon"></i>
									<p>Yearly Expense</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.expense.index') }}" class="nav-link {{ Request::is('admin/expense') ? 'active' : '' }}">
									<i class="fa fa-list-alt nav-icon"></i>
									<p>All Expense</p>
								</a>
							</li>
						</ul>
					</li>
				@endif
				@if(Auth::user()->can('Settings') || (Auth::user()->hasRole('admin')))
					<li class="nav-header"><hr></li>
					<li class="nav-item has-treeview {{ Request::is('admin/setting*','admin/paymenttype*','admin/merchant*') ? 'menu-open' : '' }}">
						<a href="#" class="nav-link {{ Request::is('admin/setting') ? 'active' : '' }}">
							<i class="nav-icon fa fa-cogs"></i>
							<p>
								Settings
								<i class="right fa fa-angle-left"></i>
							</p>
						</a>

						<ul class="nav nav-treeview">
							@if((Auth::user()->hasRole('admin')))
								<li class="nav-item">
									<a href="{{ route('admin.setting.index') }}" class="nav-link {{ Request::is('admin/setting') ? 'active' : '' }}">
										<i class="nav-icon fa fa-cogs"></i>
										<p>
											Configuration
										</p>
									</a>
								</li>
							@endif
							<li class="nav-item">
								<a href="{{ route('admin.paymenttype.index') }}" class="nav-link {{ Request::is('admin/paymenttype') ? 'active' : '' }}">
									<i class="fa fa-money nav-icon"></i>
									<p>Payment Type</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('admin.merchant.index') }}" class="nav-link {{ Request::is('admin/merchant*') ? 'active' : '' }}">
									<i class="fa fa-bank nav-icon"></i>
									<p>Merchants</p>
								</a>
							</li>

						</ul>
					</li>
				@endif
	      @if(Auth::user()->hasRole('admin'))
					<li class="nav-item has-treeview {{ Request::is('admin/users*','admin/roles*') ? 'menu-open' : '' }}">
					<a href="#" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
						<i class="nav-icon fa fa-shield"></i>
						<p>Users Access<i class="right fa fa-angle-left"></i>  </p>

					</a>
					<ul class="nav nav-treeview">
	            <li class="nav-item">
								<a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
								<i class="nav-icon fa fa-users"></i>
								<p>Manage Users</p></a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{ Request::is('admin/roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
								<i class="nav-icon fa fa-universal-access"></i>
								<p>Manage Role</p></a>
							</li>
					</ul>
				</li>
				@endif

				<li class="nav-item">
					<a class="nav-link" href="{{ route('logout') }}"
					   onclick="event.preventDefault();
					   document.getElementById('logout-form').submit();">
						<i class="nav-icon fa fa-sign-out"></i> Logout
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
