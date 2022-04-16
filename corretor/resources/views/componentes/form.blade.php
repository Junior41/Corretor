<div>
    <form action="/" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlFile1">Escolha o arquivo no formato txt</label>
            <input required name = "arquivo" class="form-control" type="file" id="formFile">
            <div class = "btn">
                <button type="submit" class="btn btn-outline-dark">Corrigir</button>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            @endif

        </div>

    </form>
</div>
