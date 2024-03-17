<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $model;
    public $filter = [];

    public function paginate(Request $request)
    {
        $limit = 10;
        if ($request->filled('limit') && is_numeric($request->limit) && $request->limit > 10) {
            $limit = $request->limit;
        }
        $model = new $this->model;
        $data = $model->query();
        if (count($this->filter) > 0) {
            foreach ($this->filter as $item) {
                $data->OrWhere($item, 'like', '%' . $request->input($item) . '%');
            }
        }
        return response()->json($data->paginate($limit));
    }

    public function handle_unauthorize(string $message = 'Unauthorize!')
    {
        return response()->json(['message' => $message], 403);
    }
}
