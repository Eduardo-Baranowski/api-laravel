<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Models\Noticia;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticiaController extends Controller
{
    public function store(NoticiaRequest $request) : JsonResponse{
        DB::beginTransaction();


        try {
            $noticia = Noticia::create([
                'title' => $request->title,
                'content_text' => $request->content_text,
                'id_user' => $user = Auth::user()->getAuthIdentifier()
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'noticia' => $noticia,
                'message' => 'Notícia cadastrada com sucesso!',
            ], 201);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Notícia não cadastrada!',
            ], 400);
        }
    }
}
