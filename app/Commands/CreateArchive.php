<?php


namespace App\Commands;

use App\Commands\Command;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Storage;
use Alchemy\Zippy\Zippy;

class CreateArchive extends Command implements SelfHandling, ShouldBeQueued {
	
	use InteractsWithQueue, SerializesModels;
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
	}
	
	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle() {

		if (!Storage::exists('archive.zip')){
			$zippy = Zippy::load();
			$zippy->create(storage_path().'/app/archive.zip', [
					'333.jpg' => storage_path().'/app/123.jpg'
			]);
		}
	}
}
