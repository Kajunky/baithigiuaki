<!DOCTYPE html>
<html>

<head>
    <title>Xác nhận xóa</title>
    <style>
        h2 {
  text-align: center;
}

p {
  text-align: center;
  margin-bottom: 20px;
}

form {
  text-align: center;
}

button, a {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button {
  background-color: #f00;
  color: #fff;
}

a {
  color: #007bff;
}
    </style>
</head>

<body>
    <h2>Xác nhận xóa</h2>
    <p>Bạn có chắc chắn muốn xóa sách <strong>{{ $book_property->title }}</strong> chứ?</p>
    <form method="POST" action="{{ route('book_properties.destroy', $book_property) }}">
        @csrf
        @method('DELETE')
        <input hidden type="text" name="id" value={{ $book_property->id }}">
        <button type="submit">Xóa</button>
        <a href="{{ route('book_properties.index') }}">Hủy</a>
    </form>
</body>

</html>
