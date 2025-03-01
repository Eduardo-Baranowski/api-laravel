<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Http\Requests\UserRequest;
use App\Models\Noticia;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticiaController extends Controller
{
    public function index() : JsonResponse{
        $noticias = Noticia::orderBy('id', 'ASC')->where('id_user', Auth::user()->getAuthIdentifier())->paginate(10);
        return response()->json([
            'status' => true,
            'noticias' => $noticias,
        ], 200);
    }
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

    public function show(Noticia $noticia) : JsonResponse{
        $noticias = User::orderBy('id', 'DESC')->paginate(2);
        return response()->json([
            'status' => true,
            'noticia' => $noticia,
        ], 200);
    }

    public function update(NoticiaRequest $request, Noticia $noticia) : JsonResponse{

        DB::beginTransaction();

        try{
            $noticia->update([
                'title' => $request->title,
                'content_text' => $request->content_text,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'noticia' => $noticia,
                'message' => 'Notícia editada com sucesso!',
            ], 200);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Notícia editada com sucesso!',
            ], 400);
        }
    }

    public function destroy(Noticia $noticia) : JsonResponse{
        try{
            $noticia->delete();

            return response()->json([
                'status' => true,
                'noticia' => $noticia,
                'message' => 'Notícia deletado com sucesso!',
            ], 200);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Notícia não apagado!',
            ], 400);
        }
    }
}
