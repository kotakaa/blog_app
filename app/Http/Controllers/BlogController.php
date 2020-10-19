<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    /**
     * ブログ一覧を表示する
     * @return view
     */
    public function showList()
    {
        // dbからデータを全て受け取る
        $blogs = Blog::all();
        return view('blog.list', ['blogs' => $blogs]);
    }

    /**
     * ブログ詳細を表示する
     * @param int $id
     * @return view
     */
    // routeから渡ってきたidを引数にしている
    public function showDetail($id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }
        return view('blog.detail', ['blog' => $blog]);
    }

    /**
     * ブログ登録画面を表示する
     * @return view
     */
    public function showCreate()
    {
        return view('blog.form');
    }

    /**
     * ブログ登録する
     * @return view
     */
    public function exeStore(BlogRequest $request)
    {
        $input = $request->all();
        \DB::beginTransaction();
        try{
            Blog::create($input);
            \DB::commit();
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログを登録しました。');
        return redirect(route('blogs'));
    }

    /**
     * ブログの編集画面を表示する
     * @param int $id
     * @return view
     */
    // routeから渡ってきたidを引数にしている
    public function showEdit($id)
    {
        $blog = Blog::find($id);
        if(is_null($blog)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }
        return view('blog.edit', ['blog' => $blog]);
    }

    /**
     * ブログ更新する
     * @return view
     */
    public function exeUpdate(BlogRequest $request)
    {
        $input = $request->all();
        \DB::beginTransaction();
        try{
            $blog = Blog::find($input['id']);
            $blog->fill([
                'title' => $input['title'],
                'content' => $input['content']
            ]);
            $blog->save();
            \DB::commit();
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500);
        }
        \Session::flash('err_msg', 'ブログを更新しました。');
        return redirect(route('blogs'));
    }


    /**
     * ブログの編集画面を表示する
     * @param int $id
     * @return view
     */
    // routeから渡ってきたidを引数にしている
    public function exeDelete($id)
    {
        if(empty($id)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        try{
            Blog::destroy($id);
        }catch(\Throwable $e){
            abort(500);
        }
        $blog = Blog::destroy($id);
        \Session::flash('err_msg', '削除しました。');
        return redirect(route('blogs'));
    }
}
