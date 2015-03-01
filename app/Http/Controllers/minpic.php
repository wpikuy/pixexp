<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\PixPic;
use Imagine\Gd\Image;
use Imagine\Gd\Imagine;
use Illuminate\Support\Facades\Storage;
use Imagine\Image\Box;

class minpic extends Controller {

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
		$result = PixPic::find($id);
		
		// if db does not contain this id or picture file does not exist
		if (!$result || !Storage::exists($result->fileName)) {
			return response('id does not exist in database or picture file does not exist.', 404);
		}
		
		// image founded, resize image
		$imagine = new Imagine();
		$img = $imagine->load(Storage::get($result->fileName));
		$size = $img->getSize();
		$width = $size->getWidth();
		$height = $size->getHeight();
		$ratio = 1.0;
		if ($width > $height){
			$ratio = 150.0 / $width;
		}
		else{
			$ratio = 150.0 / $height;
		}
		$img->resize(new Box($width * $ratio, $height * $ratio));
		
		// return
		return response($img->get('png'))->header('Content-Type', 'image/webp');
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

}
