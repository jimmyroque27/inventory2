@push('css')

@endpush

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="{{ url('') }}"  >
    		<img src="{{ asset('assets/frontend/img/logo4.png') }}"  height="50px"  alt="Logo"   >

      </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class=" "><a href="#">About Us</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Products <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Inventory Management System</a></li>
            <li><a href="#">Point Of Sales (POS)</a></li>
            <li><a href="#">Website/E-Commerse</a></li>
            <li><a href="#">Hotel Restaurant Management System</a></li>
            <li><a href="#">Rental System</a></li>
            <li><a href="#">Billing System</a></li>

          </ul>
        </li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>s -->
        <li><a href="#" onclick="document.getElementById('id01').style.display='block'"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>
