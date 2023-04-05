<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\NewsupdRequest;
use App\Jobs\CommentJob;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = News::with('NewsComments')->paginate(10);
        if ($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $file = $request->file('images');

        $nama_file = time() . "_" . $file->getClientOriginalName();

        $tujuan_upload = 'data_file';
        $file->move($tujuan_upload, $nama_file);
        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'image' => $nama_file,
        ];
        $post = News::create($data);
        if ($post) return ApiFormatter::createApi(200, 'success insert data', $data);
        return ApiFormatter::createApi(500, 'failed insert data', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = News::with('NewsComments')->find($id);
        if ($data) {
            return ApiFormatter::createApi(200, 'success', $data);
        } else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(NewsupdRequest $request, $id)
    {
        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        $post = News::findOrFail($id);

        $file = $request->file('images');
        $tujuan_upload = 'data_file';
        // cek file
        if(!empty($file)){
            $image_path = public_path($tujuan_upload.'/'.$post->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }

            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move($tujuan_upload, $nama_file);
            $data['image'] = $nama_file;
        }

        $post->update($data);
        if ($post) return ApiFormatter::createApi(200, 'success update data', $data);
        return ApiFormatter::createApi(500, 'failed update data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = News::findOrFail($id);
        $post->delete();
        if ($post) return ApiFormatter::createApi(200, 'success delete data');
        return ApiFormatter::createApi(500, 'failed delete data');
    }

    public function comment(Request $request)
    {
        $data = [
            'comment' => $request->comment,
            'news_id' => $request->news_id,
            'user_id' => auth()->user()->id
        ];
        CommentJob::dispatch($data)->delay(now()->addSeconds(60));
        return ApiFormatter::createApi(200, 'Success create comment');
    }
}
