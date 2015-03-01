<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Storage;
use Alchemy\Zippy\Zippy;
use App\Commands\CreateArchive;
use Illuminate\Support\Facades\Queue;
use Carbon\Carbon;
use Symfony\Component\VarDumper\VarDumper;
use App\Http\Controllers\PixSession;
use App\Commands\DownloadImage;
use League\Url\Url;
use Sunra\PhpSimple\HtmlDomParser;
use App\PixReq;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class req extends Controller {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		
		$v = Validator::make(Input::all(), [
				'pid' => 'required|numeric'
		]);
		if ($v->fails()){
			return response($v->errors(), 400);
		}
		
		$pid = Input::get('pid');
		$session = PixSession::getRequestsSession();
		$dom = $this->getPidDom($pid, 'medium', $session);
		if (!$this->isManga($dom)){
			$this->enqueuePic($dom, $pid);
		}
		else {
			$this->enqueueManga($dom, $pid, $session);
		}
		PixSession::saveRequestsSession($session);
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
	
	// return the page that pid refers to.
	protected function getPidDom($pid, $type, \Requests_Session $session){
		// type : medium manga
		$url = 'http://www.pixiv.net/member_illust.php?mode='.$type.'&illust_id='.$pid;
		$urlObj = Url::createFromUrl($url);
		$session->url = $urlObj->getBaseUrl();
		$response = $session->get($urlObj->getRelativeUrl());
		if ($response->status_code != 200){
			throwException(new \Exception('cant load pid content'));
		}
		else{
			return HtmlDomParser::str_get_html($response->body);
		}
	}
	
	protected function isManga(\simple_html_dom $dom){
		return $dom->find('div[class=works_display]', 0)->first_child()->tag == 'a' ? true : false;
	}
	
	protected function enqueuePic(\simple_html_dom $dom, $pid){
		$refer = 'http://www.pixiv.net/member_illust.php?mode=medium&illust_id='.$pid;
		$path = $dom->find('div[class=wrapper]', 1)->last_child()->__get('data-src');
		$author = $dom->find('h1[class=user]', 0)->innerText();
		$title = $dom->find('div[class=ui-expander-target]', 0)->find('h1[class=title]', 0)->innerText();
		$request = new PixReq();
		$request->pid = $pid;
		$request->time = Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s');
		$request->state = 'wait';
		$request->save();
		Queue::push(new DownloadImage($request->id, $refer, $path, $pid, $author, $title));
		var_dump($path);
	}
	
	protected function enqueueManga(\simple_html_dom $dom, $pid, \Requests_Session $session){
		$mangaUrl = 'http://www.pixiv.net/member_illust.php?mode=manga&illust_id='.$pid;
		$refer = $mangaUrl;
		$author = $dom->find('h1[class=user]', 0)->innerText();
		$title = '';
		if ($dom->find('div[class=ui-expander-target]', 0)){
			$title = $dom->find('div[class=ui-expander-target]', 0)->find('h1[class=title]', 0)->innerText();
		}
		else {
			$title = $dom->find('section[class=work-info]', 0)->find('h1[class=title]', 0)->innerText();
		}
		
		$mangaDom = $this->getPidDom($pid, 'manga', $session);
		$items = $mangaDom->find('div[class=item-container]');
		
		for ($i = 0; $i < count($items); $i++){
			$path = $items[$i]->find('img', 0)->__get('data-src');
			$npid = $pid.'_'.$i;

			$request = new PixReq();
			$request->pid = $npid;
			$request->time = Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s');
			$request->state = 'wait';
			$request->save();

			Queue::push(new DownloadImage($request->id, $refer, $path, $npid, $author, $title));
		}
	}
}
