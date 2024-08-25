<!DOCTYPE html>
<html>

<head>
    <title>Quản lý sách</title>
    <style>
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
  background-color:  
 #f2f2f2;
}

.pagination {
  margin-top: 20px;
  text-align: center;
}

.pagination a {
  color: #333;
  text-decoration: none;
  padding: 5px 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.pagination a.active {
  background-color: #007bff;
  color: #fff;
}

.pagination a:hover {
  background-color: #007bff;
  color: #fff;
}
        </style>
</head>

<body>
    <h2>Danh sách tác phẩm</h2>

    @if (session('success'))
        <div class="alert alert-success" style="color: green;">
            {{ session('success') }}
        </div>
        <br>
    @endif

    <form method="get">
        <input type="text" name="search" placeholder="Tìm kiếm sách" value="{{ request('search') }}">
        <button type="submit">Tìm kiếm</button>
    </form>
    <hr>
    <table border="1">
        <tr>
            <th>
                <a href="?sort_by=id&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">ID</a>
            </th>
            <th>
                <a href="?sort_by=title&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">Tên</a>
            </th>
            <th>
                <a href="?sort_by=publish_year&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">Ngày xuất bản</a>
            </th>
            <th>
                <a href="?sort_by=quantity&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">Số lượng</a>
            </th>
            <th>
                <a href="?sort_by=book_id&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">Mã thể loại</a>
            </th>
            <th>
                <a href="?sort_by=author_id&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">Mã tác giả</a>
            </th>
            <th>
                <a href="?sort_by=publisher&sort_order={{ $sortOrder === 'asc' ? 'desc' : 'asc' }}">Nhà xuất bản</a>
            </th>
            <th>Chức năng sửa</th>
            <th>Chức năng xóa</th>
        </tr>
        @foreach ($book_properties as $book_property)
            {{-- {{ dd($book_property) }} --}}
            <tr>
                <td>{{ $book_property->id }}</td>
                <td>{{ $book_property->title }}</td>
                <td>{{ $book_property->publish_year }}</td>
                <td>{{ $book_property->quantity }}</td>
                <td>{{ $book_property->category_id }}</td>
                <td>{{ $book_property->author_id }}</td>
                <td>{{ $book_property->publisher }}</td>
                <td><a href="{{ route('book_properties.edit', $book_property->id) }}">Sửa</a></td>
                <td><a href="{{ route('book_properties.delete', $book_property) }}">Xoá</a></td>
            </tr>
        @endforeach
    </table>
    {{ $book_properties->links() }}
    <hr>

    <a href="{{ route('book_properties.create') }}">Thêm mới sách</a>

</body>

</html>
