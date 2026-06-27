<form action="{{ route('home.save') }}" method="POST">
    @csrf
    <input type="text" name="first_name">

    <button type="submit">Save</button>
</form>
