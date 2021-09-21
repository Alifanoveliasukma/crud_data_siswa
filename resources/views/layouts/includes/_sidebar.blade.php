<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="/dashboard" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
				@if(auth()->user()->role == 'admin')
				<li><a href="/siswa" class=""><i class="lnr lnr-user"></i> <span>Siswa</span></a></li>
				@endif

			</ul>
		</nav>
	</div>
</div>