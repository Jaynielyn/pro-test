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
    <a class="header__link" href="/">Home</a>
    <form class="form" action="/logout" method="post">
      @csrf
      <button class="logout__button">Logout</button>
    </form>
    <a class="header__link" href="#">Mypage</a>
    @else
    <a class="header__link" href="/">Home</a>
    <a class="header__link" href="/register">Register</a>
    <a class="header__link" href="/login">Login</a>
    @endauth
  </div>
</div>

<script>
  function toggleMenu() {
    document.getElementById("menu").classList.toggle("active");
  }
</script>