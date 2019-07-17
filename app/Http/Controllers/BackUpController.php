<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class BackUpController extends Controller
{
    protected $process;

    public function dbBackup()
    {
        $path = 'db-backup';
        if (!is_dir($path)) {
          @mkdir($path, 0777, true);
        }

        $database = env('DB_DATABASE');

        $filename = $database .'_'. \Carbon\Carbon::now()->format('Y-m-d');
        $command = "mysqldump -u " . env('DB_USERNAME') ." -p" . env('DB_PASSWORD') . " -h " . env('DB_HOST') . " " . $database . " > ". $path.'/'.$filename;
        $this->process = new Process($command);
        $this->process->mustRun();

        return back()->with('success', 'Database "'.env('DB_DATABASE').'" backup created Successfully!');
    }
}
