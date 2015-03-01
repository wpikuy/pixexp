<?php


namespace App\Commands;

use App\Commands\Command;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use League\Url\Url;
use App\Http\Controllers\PixSession;
use Imagine\Gd\Imagine;
use App\PixPic;
use Carbon\Carbon;
use App\PixReq;
use Symfony\Component\VarDumper\VarDumper;

class DownloadImage extends Command implements ShouldBeQueued {
	
	use InteractsWithQueue, SerializesModels;
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	protected $requestId;
	protected $refer;
	protected $path;
	protected $pid;
	protected $author;
	protected $title;
	
	public function __construct($requestId, $refer, $path, $pid, $author, $title) {
		$this->requestId = $requestId;
		$this->refer = $refer;
		$this->path = $path;
		$this->pid = $pid;
		$this->author = $author;
		$this->title = $title;
	}
	
	public function handle() {
		$req = PixReq::find($this->requestId);
		if ($req->state != 'wait') return;
		$req->state = 'dling';
		$req->save();
		
		$url = Url::createFromUrl($this->path);
		$session = PixSession::getRequestsSession();
		$session->url = $url->getBaseUrl();
		
		set_time_limit(0);
		$session->options['timeout'] = 290;
		$session->headers['Referer'] = $this->refer;
		$session->headers['Accept'] = 'image/webp,*/*;q=0.8';
		$session->headers['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.3; WOW64)' 
				+ 'AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36';
		$response = $session->get($url->getRelativeUrl());
		$session->options['timeout'] = 10;
		set_time_limit(30);
		
		//$imagine = new Imagine();
		//$img = $imagine->load($response->body);
		
		$fileName = $this->pid.'.png';
		$path = storage_path('app/'.$fileName);
		
		file_put_contents($path, $response->body);
		
		//$img->save($path);
		
		$pixpic = new PixPic();
		$pixpic->completeTime = Carbon::now('Asia/Shanghai')->format('Y-m-d H:i:s');
		$pixpic->fileName = $fileName;
		$pixpic->pid = $this->pid;
		$pixpic->title = $this->title;
		$pixpic->author = $this->author;
		$pixpic->save();
		
		$req = PixReq::find($this->requestId);
		$req->state = 'done';
		$req->save();
	}
}
