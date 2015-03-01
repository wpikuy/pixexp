<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\PixReq;
use App\PixPic;

class pixrequest extends Controller {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$reqs = PixReq::all();
		$maxPage = ceil($reqs->count() / 5);
		if ($maxPage == 0) $maxPage = 1;
		$validator = Validator::make ( Input::all (), [ 
				'page' => 'required|numeric|min:1|max:'.$maxPage
		] );
		
		if ($validator->fails()){
			return redirect('request?page=1');
		}
		
		$page = Input::get('page');
		$data = $reqs->forPage($page, 5);
		
		return view('request', [
				'page' => $page,
				'data' => $data->toArray()
		]);
	}
	
	public function delete() {
		$validator = Validator::make ( Input::all (), [ 
				'stop' => 'required|numeric|min:1' 
		] );
		
		if ($validator->fails ()) {
			return $validator->errors();
		}
		
		$stop = intval ( Input::get ( 'stop' ) );
		
		if (! PixReq::find ( intval($stop) )) {
			return 'no '.$stop;
		}
		
		if ($stop->state != 'wait'){
			return response('cant stop request whose state is not wait', 404);
		}
		
		$req = PixReq::find ( intval($stop) );
		
		$req->state = 'stopped';
		$req->save ();
		
		return redirect()->back();
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		//
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		//
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function show($id) {
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		//
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function update($id) {
		//
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function destroy($id) {
		//
	}
}
