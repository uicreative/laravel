<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use log;

class DeployController extends Controller
{
  public function deploy(Request $request)
  {
     $githubPayload = $request->getContent();
     $githubHash = $request->header('X-Hub-Signature');

     $localToken = config('app_deploy_secret');
     $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

     
    
     

     if (hash_equals($githubHash, $localHash)) {
      Log::debug('in yay');
          $root_path = base_path();
          $process = new Process('cd ' . $root_path . '; ./deploy.sh');
          $process->run(function ($type, $buffer) {
              echo $buffer;
          });
     }
  }
}