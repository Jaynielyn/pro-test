<div class="header__left">
  <div class="menu-btn" onclick="toggleMenu()">
    <div class="menu__btn-1"></div>
    <div class="menu__btn-2"></div>
    <div class="menu__btn-3"></div>
  </div>
  <h1 class="ttl">Rese</h1>
</div>

<div class="menu" id="menu">
  <img class="xmark" src="{{ asset('img/xmark.svg') }}" onclick="toggleMenu()">
  <div class="menu__inner">
    @auth
    <a href="/">Home</a>
    <form class="form" action="/logout" method="post">
      @csrf
      <button class="header-nav__button">Logout</button>
    </form>
    <a href="#">Mypage</a>
    @else
    <a href="/">Home</a>
    <a href="/register">Register</a>
    <a href="/login">Login</a>
    @endauth
  </div>
</div>

<script>
  function toggleMenu() {
    document.getElementById("menu").classList.toggle("active");
  }
</script>