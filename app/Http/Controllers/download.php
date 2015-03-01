<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\PixPic;
use Illuminate\Support\Facades\Crypt;
use Alchemy\Zippy\Zippy;
use Illuminate\Database\Schema\Blueprint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class download extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// if param exists
		if (!Input::exists('id')){
			return response('param "id" is needed.', 404);
		}

		$id = Input::get('id');
		$ids = explode('-', $id);
		
		foreach ($ids as $_id){
			$result = PixPic::find($_id);
			
			// if db does not contain this id or picture file does not exist
			if (!$result || !Storage::exists($result->fileName)) {
				return response('id does not exist in database or picture file does not exist.', 404);
			}
		}
		
		// convert ids to paths
		$paths = [];
		foreach ($ids as $_id){
			$pic = PixPic::find($_id);
			$paths[$pic->author.'_'.$pic->title.'_'.$pic->fileName] = storage_path('app/'.$pic->fileName);
		}
		
		// create zip file
		$zipName = $this->generateName().'.zip';
		$zipPath = storage_path('app/ziptmp/'.$zipName);
		$zippy = Zippy::load();
		$zippy->create($zipPath, $paths);
		
		return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	function generateName(){
		return (new \DateTime('now', new \DateTimeZone('PRC')))->format('YmdHis').$this->generate_password();
	}
	
	function generate_password( $length = 8 ) {
	    // 密码字符集，可任意添加你需要的字符
	    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	
	    $password = '';
	    for ( $i = 0; $i < $length; $i++ ) 
	    {
	        // 这里提供两种字符获取方式
	        // 第一种是使用 substr 截取$chars中的任意一位字符；
	        // 第二种是取字符数组 $chars 的任意元素
	        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
	    }
	
	    return $password;
	}

}
