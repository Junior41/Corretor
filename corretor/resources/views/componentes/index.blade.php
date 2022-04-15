<div>
    <center>
        <h2>Correção</h2>
        <h5>Porcentagem de erro: {{$porcentagemErro}}%</h5>
        <div class="card-box table-responsive" id = "content">

            <table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Palavras</th>
                    <th scope="col">Linha</th>
                </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($palavras) - 1; $i += 2)
                        <tr>
                            <th scope="row">{{$i/2}}</th>
                            <td>{{$palavras[$i]}}</td>
                            <td>{{$palavras[$i+1]}}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

        </div>
    </center>
</div>