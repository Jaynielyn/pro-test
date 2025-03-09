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
            <select class="select__short" name="area" id="area" onchange="this.form.submit()">
                <option value="all" {{ request('area') == 'all' ? 'selected' : '' }}>All area</option>
            </select>
        </div>

        <div class="search__inner">
            <select class="select__short" name="genre" id="genre" onchange="this.form.submit()">
                <option value="all" {{ request('genre') == 'all' ? 'selected' : '' }}>All genre</option>
            </select>
        </div>

        <div class="search__inner">
            <input class="select__short" type="search">
        </div>
    </form>
</div>