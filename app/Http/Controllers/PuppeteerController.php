<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class PuppeteerController extends Controller
{
    public function search(Request $request)
    {
        // Validate the form data
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
        ]);
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        // Run the Puppeteer script
        try {
            $process = new Process(['node', public_path().'/puppeteer_script.js', $firstName, $lastName]);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        } catch (\Exception $error) {
            dd($error->getMessage());
        }

        // Process the output
        $result = json_decode($process->getOutput(), true);

        return view('results', ['result' => $result, 'firstName' => $firstName, 'lastName' => $lastName]);
    }

}
