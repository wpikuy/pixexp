<?php namespace App\Handlers\Commands;

use App\Commands\DownloadImage;

use Illuminate\Queue\InteractsWithQueue;

class DownloadImageHandler {

	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the command.
	 *
	 * @param  DownloadImage  $command
	 * @return void
	 */
	public function handle(DownloadImage $command)
	{
		$command->handle();
	}

}
