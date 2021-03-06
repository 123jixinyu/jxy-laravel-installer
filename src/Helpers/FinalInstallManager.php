<?php

namespace RachidLaasri\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class FinalInstallManager
{
    /**
     * Run final commands.
     *
     * @return collection
     */
    public function runFinal()
    {
        $outputLog = new BufferedOutput;

        $this->generateKey($outputLog);
        $this->publishVendorAssets($outputLog);

        return $outputLog->fetch();
    }

    /**
     * Generate New Application Key.
     *
     * @param collection $outputLog
     * @return collection
     */
    private  function generateKey($outputLog)
    {
        try{
            Artisan::call('key:generate', ["--force"=> true], $outputLog);
        }
        catch(Exception $e){
            return $this->response($e->getMessage());
        }

        return $outputLog;
    }

    /**
     * Publish vendor assets.
     *
     * @param collection $outputLog
     * @return collection
     */
    private  function publishVendorAssets($outputLog)
    {
        try{
            Artisan::call('vendor:publish', ['--all' => true], $outputLog);
        }
        catch(Exception $e){
            return $this->response($e->getMessage());
        }

        return $outputLog;
    }

    /**
     * Return a formatted error messages.
     *
     * @param $message
     * @param string $status
     * @param collection $outputLog
     * @return array
     */
    private function response($message, $status = 'danger', $outputLog=[])
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog
        ];
    }
}
