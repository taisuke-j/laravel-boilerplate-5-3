<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Category;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryRequest $request, $model)
    {
        $categories = Category::where(['type' => $model])->oldest('created_at')->paginate(20);
        $categories = count($categories) ? $categories : null;
        return view('category.index', compact('categories', 'model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRequest $request, $model)
    {
        return view('category.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {

        $model = $request->input('type');
        $this->validate($request, [
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories',
            'type' => 'required|in:product,post,page',
        ]);

        $category = new Category($request->all());
        $category->save();

        return redirect(sprintf('admin/%s/category/index', $model))->with([
            'message' => trans('category.flash_message.store'),
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $model = $category->type;
        return view('category.edit', compact('category', 'model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'type' => 'required|in:product,post,page',
        ]);

        $category->fill($request->all());
        $category->save();
        return redirect()->back()->with([
            'message' => trans('category.flash_message.update'),
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $model = $category->type;
        $category->delete();
        return redirect(sprintf('admin/%s/category/index', $model))->with([
            'message' => trans('category.flash_message.delete'),
            'status' => 'success'
        ]);
    }

}
