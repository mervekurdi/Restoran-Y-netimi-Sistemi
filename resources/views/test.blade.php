<h1>Categories 🍔</h1>

<ul>
@foreach($categories as $category)
    <li>
        <strong>{{ $category->name }}</strong>

        <ul>
            @foreach($category->menus as $menu)
                <li>{{ $menu->name }} — {{ $menu->price }} TL</li>
            @endforeach
        </ul>

        <form action="/menus" method="POST">
            @csrf

            <input type="text" name="name" placeholder="Add menu item">
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <button type="submit">Add</button>
        </form>
    </li>
@endforeach
</ul>