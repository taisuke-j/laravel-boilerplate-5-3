<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Category;
use App\Post;
use App\Asset;
use DateTime;

class PostController extends Controller
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
        $posts = Post::oldest('created_at')->paginate(20);

        // More logics will be here when we support multiple categories
        if (count($posts)) {
            $posts->load('categories');
        } else {
            $posts = null;
        }
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where(['type' => 'post'])->get();
        $status_list = trans('post.status');
        return view('post.create', compact('categories', 'status_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $user = $request->user();
        $post = new Post($request->all());
        $post->user_id = $user->id;
        $post->save();

        // Saves category
        $category_id = $request->input('category');
        if ($category_id) {
            $post->categories()->attach($category_id);
        }

        return redirect()->action('PostController@index')->with([
            'message' => trans('post.flash_message.store'),
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $status_list = trans('post.status');

        // Currently just allowing one category
        $categories = Category::where(['type' => 'post'])->get();
        if (count($post->categories()->get())) {
            $current_category = $post->categories()->first();
        } else {
            $current_category = null;
        }

        return view('post.edit', compact('post', 'categories', 'current_category', 'status_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $user = $request->user();
        $post->fill($request->all());
        $post->user_id = $user->id;
        $post->save();

        if ($request->input('category_id')) {
            $post->categories()->sync([$request->input('category')]);
        }

        return redirect()->back()->with([
            'message' => trans('post.flash_message.update'),
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->action('PostController@index')->with([
            'message' => trans('post.flash_message.delete'),
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
            $image_folder = 'uploads/post/images/';
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
