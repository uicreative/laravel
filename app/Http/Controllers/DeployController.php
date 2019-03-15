<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Log;

class DeployController extends Controller
{
  public function deploy(Request $request)
  {
     $githubPayload = $request->getContent();
     $githubHash = $request->header('X-Hub-Signature');

     $localToken = config('app_deploy_secret');
     $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

     Log::debug($localHash);
     Log::debug($githubHash);
     

     //if (hash_equals($githubHash, $localHash)) {
      
          $root_path = base_path();
          $process = new Process('cd ' . $root_path . '; ./deploy.sh');
          $process->run(function ($type, $buffer) {
              echo $buffer;
          });
     //}
  }
}