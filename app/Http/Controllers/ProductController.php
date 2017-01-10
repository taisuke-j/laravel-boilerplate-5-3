<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Category;
use App\Product;
use App\Asset;
use DateTime;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::oldest('created_at')->paginate(20);
        
        // More logics will be here when we support multiple categories
        if (count($products)) {
            $products->load('categories');
        } else {
            $products = null;
        }
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where(['type' => 'product'])->get();
        $status_list = trans('product.status');
        return view('product.create', compact('categories', 'status_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product($request->all());
        $product->save();

        // Saves category
        $category_id = $request->input('category');
        if ($category_id) {
            $product->categories()->attach($category_id);
        }

        return redirect()->action('ProductController@index')->with([
            'message' => trans('product.flash_message.store'),
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $status_list = trans('product.status');

        // Currently just allowing one category
        $categories = Category::where(['type' => 'product'])->get();
        if (count($product->categories()->get())) {
            $current_category = $product->categories()->first();
        } else {
            $current_category = null;
        }

        return view('product.edit', compact('product', 'categories', 'current_category', 'status_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        if ($request->input('category_id')) {
            $product->categories()->sync([$request->input('category')]);
        }

        return redirect()->back()->with([
            'message' => trans('product.flash_message.update'),
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->action('ProductController@index')->with([
            'message' => trans('product.flash_message.delete'),
            'status' => 'success'
        ]);
    }

    /**
     * Handle image upload from TinyMCE file browser window
     *
     * @param  Request $request
     * @return Response
     */
    public function uploadImage(Request $request)
    {

        $image = $request->file('image');
        $ext = $image->guessExtension();
        $filesize = $image->getClientSize();

        // Validates file extension and size
        if (($ext === 'gif' || $ext === 'jpg' || $ext === 'png') && $filesize < 2097152) {

            $filename = $image->getClientOriginalName();
            $no_ext = pathinfo($filename, PATHINFO_FILENAME);
            $image_folder = 'uploads/product/images/';
            $image_path = $image_folder.$filename;
            $image_dir = public_path($image_path);

            // If a file with the same name already exists, appends incrementing number at the end of the filename.
            if (file_exists($image_dir)) {

                $result = [];
                foreach (glob(sprintf('%s_*.%s', public_path($image_folder).$no_ext, $ext)) as $file) {
                    $result[] = $file;
                }
                $version = count($result) + 1;
                $version = $version > 9 ? (string) $version : '0'.$version;
                $filename = sprintf('%s_%s.%s', $no_ext, $version, $ext);
                $image_path = $image_folder.$filename;

            }

            // Saves the record of the file
            $asset = Asset::create([
                'type' => 'image',
                'path' => $image_path
            ]);

            // Saves the file
            $image = $image->move(public_path($image_folder), $filename);

            return ("
                <script>
                top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('/".$image_path."').closest('.mce-window').find('.mce-primary').click();
                </script>
            ");

        }
    }

}
