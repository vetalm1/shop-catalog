<?php

namespace App\Http\Controllers;

use App\Services\SyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Sync1sController extends Controller
{
    private SyncService $syncService;

    public function __construct(SyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * https://v8.1c.ru/tekhnologii/obmen-dannymi-i-integratsiya/standarty-i-formaty/protokol-obmena-s-saytom/
    */

    public function sync(Request $request)
    {
        $date = date('Y-m-d H:m:s');
        $mode = $request->get('mode');
        $type = $request->get('type');
        $filename = $request->get('filename');

        Log::channel('daily')->info('1-s sync request - ' . $date);

        if ($type === 'catalog') {
            return match ($mode) {
                'check-auth',
                'init' => $this->syncService->authInit($request),
                'file' => $this->syncService->loadFile($request),
                'import' => $this->syncService->isUpload($request),
                default => null,
            };
        }

        if ($type === 'sale') {
            return match ($mode) {
                'check-auth',
                'init' => $this->syncService->authInit($request),
                'query' => response($this->syncService->exportOrders()),
                'success' =>$this->syncService->markSuccess(),
                'file' => $this->syncService->loadFile($request),
                'import' => $this->syncService->isUpload($filename),
                default => null,
            };
        }
    }
}
