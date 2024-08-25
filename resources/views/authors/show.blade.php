<head>
    <title>Chi tiết tác giả</title>
<style>
  .author-details {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f5f5f5;
    border-radius: 5px;
  }

  .author-details h2 {
    margin: 5px 0;
    font-size: 1.2em;
    font-weight: bold;
  }

  .author-details p {
    margin: 5px 0;
  }
</style>
</head>

<div class="author-details">
    <h2>Mã tác giả: {{ $author->id }}</h2>
    <p>Tên tác giả: {{ $author->author_name }}</p>
    <p>Số tác phẩm: {{ $author->book_numbers }}</p>
  </div>
