<form method="GET" action="{{ route('feed.export') }}">
    <input type="number" name="revenue_min" placeholder="Min Revenue">
    <input type="number" name="roas_min" placeholder="Min ROAS">
    <select name="trending">
        <option value="">All Products</option>
        <option value="1">Only Trending Products</option>
    </select>
    <button type="submit">Generate Feed</button>
</form>
