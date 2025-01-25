<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman post
     */
    function index(Request $request) : View {
        $data['post_type'] = $request->query('type');
        // Jika terdapat query = page, tampilkan view page
        // Jika terdapat query = post atau tanpa query, tampilkan view post
        if ($data['post_type'] == 'page') {
            $data['pages'] = Post::where('web_id', Auth::user()->web_id)
                            ->where('type', 'page')
                            ->orderBy('created_at', 'desc')
                            ->get();
            return view('admin.page', $data);
        }

        $data['posts'] = Post::with('categories')
                ->where('web_id', Auth::user()->web_id)
                ->where('type', 'post')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin.post', $data);
    }

    /**
     * (POST)
     * Membuat post baru
     */
    function store(Request $request) : JsonResponse {
        // Buat post baru
        $post = Post::create([
            'web_id' => Auth::user()->web_id,
            'author' => Auth::user()->id,
            'type' => $request->type,
            'status' => 'draft'
        ]);
        // Jika gagal, kembali ke halaman post
        if (!$post) {
            return response([],500);
        }

        // Mendapatkan default category untuk post sesuai web_id
        $default_category = Category::select('id')
                            ->where('web_id',Auth::user()->web_id)
                            ->where('slug', 'uncategorized')
                            ->first();

        // Menambahkan title dan slug ke post baru
        $newPost = Post::find($post->id);
        $newPost->title = $request->type . '-' . $post->id;
        $newPost->slug = $request->type . '-' . $post->id;
        // Menambahkan default category ke post baru
        if ($request->type == 'post') {
            $newPost->categories()->attach([$default_category->id]);
        }

        if (!$newPost->save()) {
            return response([], 500);
        }

        return response()->json($newPost, 200);
    }

    /**
     * (GET)
     * Menampilkan halaman edit post
     */
    function edit($id) : View {
        $data['post'] = Post::findOrFail($id);
        $data['post_categories'] = $data['post']->categories;
        $data['type'] = $data['post']->type;
        $data['authors'] = User::select('id', 'display_name')
                            ->where('web_id', Auth::user()->web_id)
                            ->get();

        $data['categories'] = Category::where('web_id', Auth::user()->web_id)->get();
        return view('admin.edit-post', $data);
    }

    /**
     * (PUT)
     * Menyimpan perubahan pada post
     */
    function update(Request $request, $id) : JsonResponse {
        $post = Post::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Judul tidak boleh kosong!'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            $msg=[];
            foreach ($validator->errors()->getMessages() as $field => $message) {
                array_push($msg,[
                    'field' => $field,
                    'msg' => $message
                ]);
            }
            return response()->json([
                'alert' => 'danger',
                'msg' => $msg 
            ], 403);
        }
        
        // Lakukan update
        try {
            DB::transaction(function() use($post, $request){
                $title = $request->title;
                // Jika title berubah
                if ($post->title != $request->title) {
                    // Jika title sudah ada, tambahkan angka pada judul
                    $title = CustomHelpers::add_number_if_post_title_exist($post->id, $request->title);
                }

                $updateArray = [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'content' => $request->content,
                    'author' => $request->author,
                    'excerpt' => Str::excerpt($request->content,'',[
                        'radius'=> 30
                    ])
                ];
                
                // Jika tipe post
                if ($post->type == 'post' && $request->categories != null) {
                    // Melakukan update kategori post
                    $post->categories()->sync($request->categories);
                }
                $post->update($updateArray);
            });
        } catch (\Exception $e) {
            // Jika gagal update, kembalikan reponse alert danger dan pesannya
            return response()->json([
                'alert' => 'danger',
                'msg' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'alert' => 'success',
            'msg' => ucfirst($post->type).' berhasil disimpan!'
        ]);
    }

    /**
     * (PUT)
     * Publish post
     */
    function publish($id) : JsonResponse {
        $post = Post::findOrFail($id);
        $post->status = "publish";

        // Jika perubahan gagal disimpan, return response alert gagal
        if (!$post->save()) {
            return response()->json([
                'alert' => 'danger',
                'msg' => "Terjadi kesalahan! Coba beberapa saat lagi."
            ], 500);
        }

        return response()->json([
            'alert' => 'success',
            'msg' => ucfirst($post->type).' berhasil dipublish!'
        ]);
    }

    /**
     * (DELETE)
     * Menghapus post
     */
    function destroy($id) : RedirectResponse {
        $post = Post::findOrFail($id);
        $type = $post->type;
        try {
            DB::transaction(function() use($post){
                $post->categories()->detach();
                $post->delete();
            });
        } catch (\Exception $e) {
            return redirect()->intended('/cms-admin/post?type='.$type)->with('showAlert', ['type' => 'danger', 'msg' => 'Telah terjadi kesalahan! Coba beberapa saat lagi']);
        }
        
        return redirect()->intended('/cms-admin/post?type='.$type)->with('showAlert', ['type' => 'success', 'msg' => ucfirst($type).' telah dihapus!']);
    }
}
