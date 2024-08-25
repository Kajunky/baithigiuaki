<?php

namespace App\Http\Controllers;

use App\Models\BookCategories;
use App\Models\BookProperty;
use App\Models\Authors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookPropertyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');

        $book_properties = BookProperty::search($search)
        ->orderBy($sortBy, $sortOrder)
        ->simplePaginate(5);

        return view('book_properties.index', compact('book_properties', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        $book_properties = BookProperty::all();
        $authors = Authors::all();
        $book_categories = BookCategories::all();
        return view('book_properties.create', compact('book_properties','book_categories' , 'authors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'publish_year' => 'required|date',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:book_categories,id',
            'publisher' => 'required|in:Phương Nam,Phương Bắc',
            'quantity' => 'required|int',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $book_property = BookProperty::create($request->all());

        return redirect()->route('book_properties.index')->with('success', 'Sách đã thêm vào thành công');

    }

    public function edit(Request $request)
    {
        $book_property = BookProperty::find($request->id);
        $authors = Authors::all();
        $book_categories = BookCategories::all();
        return view('book_properties.edit', compact('book_property', 'authors', 'book_categories'));
    }

    public function update(Request $request, BookProperty $book_property)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required|string|max:100',
            'publish_year' => 'required|date',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:book_categories,id',
            'publisher' => 'required|in:phuongbac,phuongnam',
            'quantity' => 'required|int',
        ]);

        if ($validator->fails()) {

            echo "validator fails";
        }

        $book_property->where('id', intval($request->id))->update([
            'title' => $request->title,
            'publish_year' => Carbon::parse($request->publish_year)->format('y-m-d'),
            'author_id' => intval($request->author_id),
            'category_id' => intval($request->category_id),
            'publisher' => $request->publisher,
            'quantity' => $request->quantity,
        ]);
        return redirect()->route('book_properties.index')->with('success', 'Thông tin sách đã được cập nhật');
    }

    public function delete(BookProperty $book_property)
    {
        return view('book_properties.delete', compact('book_property'));
    }

    public function destroy(BookProperty $book_property)
    {
        $book_property->delete();
        return redirect()->route('book_properties.index')->with('success', 'Sách đã được xóa thành công');
    }
}
