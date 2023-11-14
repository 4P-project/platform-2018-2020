<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Exception;
use Swaggest\JsonSchema\Schema;
use App\Models\Api\Documents\Queue;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($jsonRequest = json_decode(request()->getContent())) {
            try {
                $schema = Schema::import(json_decode(\App\Http\Schemas\JsonDocument::JSON_DOCUMENTS_SCHEMA));
                $schema->in($jsonRequest);

                $job          = new Queue;
                $job->user_id = auth()->user()->id;
                $job->data    = json_encode($jsonRequest);
                $job->status  = Queue::STATUS_NEW;
                $job->save();
                $request;
            } catch (Exception $e) {
                return response()->json(['error' => ['id' => 406, 'message' => $e->getMessage()]], 406);
            }
            return response()->json(['data' => ['id' => $job->id, 'message' => 'Success']], 202);
        }
        return response()->json(['error' => ['id' => 406, 'message' => 'Invalid JSON']], 406);
    }
}

