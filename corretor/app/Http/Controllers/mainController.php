<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
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

    public function index()
    {
        return view("layout.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function paginacao($inicio, $fim, $porcentagemErro){
        $palavras = array_slice($this->palavras, $inicio, $fim);
        return View('layout.index', compact('palavras', 'porcentagemErro'))->with('sucess', 'Correção finalizada com sucesso!');
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
        $arquivo = Storage::get('public/Arvore Digital/correcao.txt');

        $this->palavras = explode(" ", $arquivo);
        $contPalavras = $this->palavras[count($this->palavras) - 2];
        $contPalavrasIncorretas = $this->palavras[count($this->palavras) - 1];

        if($contPalavras != 0)
            $porcentagemErro = round(($contPalavrasIncorretas * 100) / $contPalavras, 2);
        else
            $porcentagemErro = 0;

        array_splice($this->palavras, count($this->palavras) - 2, 2);

        return mainController::paginacao(0, 100, $porcentagemErro);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
