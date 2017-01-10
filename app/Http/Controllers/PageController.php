<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Category;
use App\Page;
use App\Asset;
use DateTime;

class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::oldest('created_at')->paginate(20);

        // More logics will be here when we support multiple categories
        if (count($pages)) {
            $pages->load('categories');
        } else {
            $pages = null;
        }
        return view('page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where(['type' => 'page'])->get();
        $status_list = trans('page.status');
        return view('page.create', compact('categories', 'status_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $user = $request->user();
        $page = new Page($request->all());
        $page->user_id = $user->id;
        $page->save();

        // Saves category
        $category_id = $request->input('category');
        if ($category_id) {
            $page->categories()->attach($category_id);
        }

        return redirect()->action('PageController@index')->with([
            'message' => trans('page.flash_message.store'),
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $status_list = trans('page.status');

        // Currently just allowing one category
        $categories = Category::where(['type' => 'page'])->get();
        if (count($page->categories()->get())) {
            $current_category = $page->categories()->first();
        } else {
            $current_category = null;
        }

        return view('page.edit', compact('page', 'categories', 'current_category', 'status_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $user = $request->user();
        $page->fill($request->all());
        $page->user_id = $user->id;
        $page->save();

        if ($request->input('category_id')) {
            $page->categories()->sync([$request->input('category')]);
        }

        return redirect()->back()->with([
            'message' => trans('page.flash_message.update'),
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->action('PageController@index')->with([
            'message' => trans('page.flash_message.delete'),
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
            $image_folder = 'uploads/page/images/';
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

    /**
     * Display Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('page.home');
    }

}
