<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\PixPic;
use Illuminate\Support\Facades\Validator;

class picadmin extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pics = PixPic::all();
		$maxPage = ceil($pics->count() / 12);
		
		if ($maxPage == 0){
			$maxPage = 1;
		}
		
		$validator = Validator::make(Input::all(), [
				'page' => 'required|numeric|min:1|max:'.$maxPage
		]);
		
		if ($validator->fails()){
			return redirect('picadmin?page='.'1');
		}
		
		$page = Input::get('page');
		
		$pagedata = $pics->forPage($page, 12);
		$datas = [];
		foreach ($pagedata->all() as $pic){
			$datas[] = [
					'info' => $pic->title,
					'id' => $pic->id
			];
		}
		
		$data = [
				'piccount' => count($datas),
				'picdata' => $datas,
				'page' => $page
		];
		
		return view('picadmin', $data);
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
