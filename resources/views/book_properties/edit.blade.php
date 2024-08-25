<!DOCTYPE html>
<html>

<head>
    <title>Cập nhật sách</title>
    <style>
form {
  width: 500px;
  margin: 0 auto;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

input[type="text"],
input[type="date"],
input[type="number"],
select {
  width: 100%;
  padding: 5px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

input[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

.error {
  color: red;
  font-size: 0.8em;
}
    </style>
</head>

<body>
    <h2>Cập nhật sách</h2>

    @if (session('success'))
        <div class="alert alert-success" style="color: green;">
            {{ session('success') }}
        </div>
        <br>
    @endif

    <form method="post" action="{{ route('book_properties.update', $book_property->id) }}">
        @csrf
        @method('PUT')
        <input hidden type="text" name="id" value={{ $book_property->id }}">
        <table>
            <tr>
                <td>Tên sách:</td>
                <td><input type="text" name="title" value="{{ $book_property->title }}"></td>
                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </tr>
            <tr>
                <td>Thời gian phát hành:</td>
                <td><input type="date" name="public_year" value="{{ $book_property->public_year }}"></td>
                @error('public_year')
                    <span class="error">{{ $message }}</span>
                @enderror
            </tr>
            <tr>
                <td>Mã tác giả:</td>
                <td>
                    <select name="author_id">
                        @foreach ($authors as $author_id)
                            <option value="{{ $author_id->id }}"
                                {{ $book_property->author_id == $author_id->id ? 'selected' : '' }}>
                                {{ $author_id->id }}
                            </option>
                        @endforeach
                    </select>
                </td>
                @error('author_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </tr>
            <tr>
                <td>Mã thể loại sách:</td>
                <td>
                    <select name="category_id">
                        @foreach ($book_categories as $book_category)
                            <option value="{{ $book_category->id }}"
                                {{ $book_property->category_id == $book_category->id ? 'selected' : '' }}>
                                {{ $book_category->id }}
                            </option>
                        @endforeach
                    </select>
                </td>
                @error('category_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </tr>
            <tr>
                <td>Nhà xuất bản:</td>
                <td>
                    <select name="publisher">
                        <option value="Phương Bắc" {{ $book_property->publisher == 'Phương Nam' ? 'selected' : '' }}>Phương Nam</option>
                        <option value="Phương Bắc" {{ $book_property->publisher == 'Phương Bắc' ? 'selected' : '' }}>Phương Bắc</option>
                    </select>
                </td>
                @error('publisher')
                    <span class="error">{{ $message }}</span>
                @enderror
            </tr>
            <tr>
                <td>Số lượng:</td>
                <td><input type="number" name="quantity" value="{{ $book_property->quantity }}"></td>
                @error('quantity')
                    <span class="error">{{ $message }}</span>
                @enderror
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Cập nhật"></td>
            </tr>
        </table>
    </form>
</body>

</html>
