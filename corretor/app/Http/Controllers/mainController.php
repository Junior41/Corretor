<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\Palavra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ViewErrorBag;


class mainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $palavras;
    private $linhas;

    public function index()
    {
        return view("layout.index");
    }

    public function paginacao($inicio, $quantidade){
        $arquivo = Storage::get('public/Arvore Digital/correcao.txt');
        $palavra = "";
        $linha = "";
        $palavras = [];
        $linhas = [];
        $data = [];
        $indiceInicio = 0;
        $i = 0;

        // encontrando a posição inicial no arquivo
        while($indiceInicio < strlen($arquivo) && $i != $inicio * 2){
            $indiceInicio++;

            if($arquivo[$indiceInicio] == '*')
                $i++;
        }

        if($indiceInicio >= strlen($arquivo))
            return $data;

        if($inicio != 0)
            $indiceInicio++;

        // percorrendo o arquivo e separando as palavras e as linhas
        for($i = 0; $i < $quantidade; $i++){
            if($indiceInicio >= strlen($arquivo))
                break;

            while($arquivo[$indiceInicio] != '*'){
                $palavra .= $arquivo[$indiceInicio];
                $indiceInicio++;
            }
            array_push($palavras, $palavra);
            $indiceInicio++;
            while($arquivo[$indiceInicio] != '*'){
                $linha .= $arquivo[$indiceInicio];
                $indiceInicio++;
            }
            array_push($linhas, intval($linha));
            $palavra = "";
            $linha = "";
            $indiceInicio++;
        }

        array_push($data, $palavras);
        array_push($data, $linhas);

        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request){

        $request->file('arquivo')->storeAs("public/Arvore Digital", "corrigir.txt");

        // execultando o script em c
        shell_exec("cd storage; cd 'Arvore Digital'; make; ./arvoreTrie");

        $erro = Storage::get('public/Arvore Digital/porcentagemErro.txt');


        $porcentagemErro = floatval($erro);

        $data = mainController::paginacao(0, 50);

        return View('layout.index', compact('data', 'porcentagemErro'))->with('sucess', 'Correção finalizada com sucesso!');

    }

}
