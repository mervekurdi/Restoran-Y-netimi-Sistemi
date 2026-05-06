<h1>Edit Category ✏️</h1>

<form action="/categories/{{ $category->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $category->name }}">
    <button type="submit">Update</button>
</form>