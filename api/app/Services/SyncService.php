<?php

namespace App\Services;

use App\Jobs\SyncProductsJob;
use App\Jobs\SyncStockJob;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SyncService
{
    public function authInit($request): Response|Application|ResponseFactory
    {
        $cookieName = config('session.cookie');
        $csrf = csrf_token();
        $date = date('Y-m-d H:m:s');

        $sessionID = Session::getId();
        $cookieValue = $request->cookie($cookieName);


        /* any code ... */

        Session::put('session_id', $sessionID);

        return response("success\n$cookieName\n$cookieValue\nsessid=$sessionID\n$csrf\n$date")
            ->header("Content-Type", "text/plane; charset=UTF-8");
    }

    public function loadFile($request): Response|Application|ResponseFactory
    {
        $filename = $request->get('filename');

        /* any code ... */

        $file_content = $request->getContent();

        Storage::disk('storage')->put('/sync/' . $filename, $file_content);
        return $this->import($filename);

    }

    public function import($filename, $import = true): Response|Application|ResponseFactory
    {
        $date = date('Y-m-d H:m:s');

        if (Storage::disk('storage')->exists('/sync/' . $filename)) {

            /* any code ... */

            if ($import) {
                switch ($filename) {
                    case 'import0_1.json':
                        SyncProductsJob::dispatch()->delay(3);
                        break;
                    case 'offers0_1.json':
                        SyncStockJob::dispatch()->delay(3);
                        break;
                    default:
                        break;
                }
            }

            return response("success\n")->header("Content-Type", "text/plane; charset=UTF-8");

        } else {
            \Log::channel('daily')->info('file: ' . $filename . ' - not upload (' . $date . ')');
            return response("failure\n");
        }
    }

    public function isUpload($filename): Response|Application|ResponseFactory
    {
        if (Storage::disk('storage')->exists('/sync/' . $filename)) {
            return response("success\n")->header("Content-Type", "text/plane; charset=UTF-8");
        } else {
            return response("failure\n");
        }
    }

    public function markSuccess(): void
    {
        /* any code ... */
    }

    public function exportOrders()
    {
        /* any code ...*/
        return null;
    }
}
