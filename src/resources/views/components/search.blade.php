<div class="search__box">
    <form method="GET" action="{{ route('shops.index') }}" class="sort-form">
        <div class="search__inner">
            <label class="label" for="sort">並び替え: </label>
            <select class="select__short" name="sort" id="sort" onchange="this.form.submit()">
                <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
                <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>評価が高い順</option>
                <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>評価が低い順</option>
            </select>
        </div>

        <div class="search__inner">
            <select class="select__short" name="region" id="region" onchange="this.form.submit()">
                <option value="all" {{ request('region') == 'all' ? 'selected' : '' }}>All area</option>
                <option value="東京都" {{ request('region') == '東京都' ? 'selected' : '' }}>東京都</option>
                <option value="大阪府" {{ request('region') == '大阪府' ? 'selected' : '' }}>大阪府</option>
                <option value="福岡県" {{ request('region') == '福岡県' ? 'selected' : '' }}>福岡県</option>
            </select>
        </div>

        <div class="search__inner">
            <select class="select__short" name="genre" id="genre" onchange="this.form.submit()">
                <option value="all" {{ request('genre') == 'all' ? 'selected' : '' }}>All genre</option>
                <option value="焼肉" {{ request('genre') == '焼肉' ? 'selected' : '' }}>焼肉</option>
                <option value="寿司" {{ request('genre') == '寿司' ? 'selected' : '' }}>寿司</option>
                <option value="居酒屋" {{ request('genre') == '居酒屋' ? 'selected' : '' }}>居酒屋</option>
                <option value="イタリアン" {{ request('genre') == 'イタリアン' ? 'selected' : '' }}>イタリアン</option>
                <option value="ラーメン" {{ request('genre') == 'ラーメン' ? 'selected' : '' }}>ラーメン</option>
            </select>
        </div>

        <div class="search__inner">
            <input class="select__short" type="search" name="name" value="{{ request('name') }}">
        </div>
    </form>
</div>