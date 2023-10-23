<header>
   <div class="header-products">
       ПРОДУКТЫ
   </div>
    <div class="header-user-name">
        {{ auth()->user()->name }}
        <div class="dropdown-menu">
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
            </form>
        </div>
    </div>
</header>
