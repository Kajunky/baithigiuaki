<head>
    <title>Danh sách tác giả</title>
    <style>
      .author {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f5f5f5;
        border-radius: 5px;
      }

      .author h2 {
        margin: 5px 0;
        font-size: 1.2em;
        font-weight: bold;
      }

      .author p {
        margin: 5px 0;
      }

      .author a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
      }

      .author a:hover {
        color: #007bff;
      }
    </style>
  </head>
  <body>
    @foreach ($authors as $author)
      <div class="author">
        <h2>Mã tác giả: {{ $author->id }}</h2>
        <p>Tên tác giả: {{ $author->author_name }}</p>
        <p>Số tác phẩm: {{ $author->book_numbers }}</p>
        <a href="{{ route('authors.show', $author) }}">Xem chi tiết</a>
      </div>
      <hr>
    @endforeach
  </body>
