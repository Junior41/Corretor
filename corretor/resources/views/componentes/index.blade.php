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
                    @for($i = 0; $i < count($palavras); $i++)
                        <tr>
                            <th scope="row">{{$i + 1}}</th>
                            <td>{{$palavras[$i]}}</td>
                            <td>{{$linhas[$i]}}</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

        </div>
    </center>
</div>

<script>
  $(document).ready(function() {
    $("#content").scroll(function() {
      //fazer algo aqui

      if ($(this).scrollTop() + $(this).height() >= $(this).get(0).scrollHeight - 500) {

        var th = $("#content table tbody tr th");
        var quant = th[th.length-1].textContent;

        $.ajax({
          type: "get",
          url: "/paginacao/"+ quant +"/50/{{$porcentagemErro}}",
          success: function(data) {
            for(i = 0; i < data[0].length; i++){
                $("#content table tbody").append("<tr><th scope='row'>" + (parseInt(quant) + i + 1) + "</th></br>" +
                                            "<td>" + data[0][i] + "</td></br>" +
                                            "<td>" + data[1][i] + "</td></tr>");
            }
        },
          error: function() {
              console.log("Houve um erro:")
          }
        });
      }
    });
  });
</script>