<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class DatabaseBackupController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin', 'active']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $path = storage_path('app/backup');
            if (!file_exists($path)) {
                File::makeDirectory($path);
            }
            $data = [];
            $file = File::files($path);
            foreach ($file as $key => $file) {
                $data[] = [
                    'id'            => $key,
                    'name'          => basename($file),
                    'size'          => filesize($file),
                    'modified_at'   => filemtime($file),
                ];
            }
            return DataTables::of($data)->toJson();
        }
        return view('database.index');
    }

    public function store()
    {
        try {
            Artisan::call('database:backup');
            return response()->json([
                'data'      => [],
                'message'   => 'Success creating backup!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'data'      => [],
                'message'   => 'Error creating backup : ' . $th->getMessage(),
            ], 500);
        }
    }

    public function download(Request $request, string $file)
    {
        if (empty($file)) {
            abort(404);
        }
        $path = storage_path('app/backup/' . $file);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path);
    }

    public function destroy(Request $request, string $file)
    {
        if (empty($file)) {
            return response()->json([
                'message'   => 'File Not Found',
                'data'      => []
            ], 404);
        }
        $path = storage_path('app/backup/' . $file);
        if (!file_exists($path)) {
            return response()->json([
                'message'   => 'File Not Found',
                'data'      => []
            ], 404);
        }
        File::delete($path);
        return response()->json([
            'message'   => 'Backup File Deleted!',
            'data'      => []
        ]);
    }
}
