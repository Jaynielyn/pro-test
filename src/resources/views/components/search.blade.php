<div class="search__box">
    <form method="GET" action="{{ route('shops.index') }}" class="sort-form">
        <div class="search__inner">
            <label class="label" for="sort">並び替え: </label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
                <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>評価が高い順</option>
                <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>評価が低い順</option>
            </select>
        </div>

        <div class="search__inner">
            <label class="label" for="area">エリア:</label>
            <select name="area" id="area" onchange="this.form.submit()">
                <option value="all" {{ request('area') == 'all' ? 'selected' : '' }}>All area</option>
            </select>
        </div>

        <div class="search__inner">
            <label class="label" for="genre">ジャンル:</label>
            <select name="genre" id="genre" onchange="this.form.submit()">
                <option value="all" {{ request('genre') == 'all' ? 'selected' : '' }}>All genre</option>
            </select>
        </div>

        <div class="search__inner">
            <input type="search">
        </div>
    </form>
    <!-- 選択した情報を表示 -->
    @if(request('sort'))
    <div class="selected-info">
        <p>情報検索：{{ request('sort') == 'random' ? 'ランダム' : (request('sort') == 'high' ? '評価が高い順' : '評価が低い順') }}</p>
    </div>
    @endif
</div>