@extends('layouts.app')

@section('conteudo')
    <div class="container">

        <div class="row justify-content-sm-center">
            <div class="col-md-11">
                <h2 class="tituloListagem">Requisições de Fichas Catalográficas</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-11">
                <table class="table table-borderless shadow table-hover mb-2" style="border-radius: 1rem; background-color: white; border: none" id="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="titleColumn" style="cursor:pointer">Autor</th>
                        <th scope="col" class="titleColumn text-center"
                            style="cursor:pointer">Tipo do Documento</th>
                        <th scope="col"  class="titleColumn text-center"
                            style="cursor:pointer">Data da Requisição</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Ação</th>
                        <th scope="col" class="text-center">Data de análise</th>

                    </tr>
                    </thead>
                    <tbody class="align-middle">
                    @foreach($requisicoesFichas as $requisicao)
                        @foreach($fichas as $ficha)
                            @if($ficha->id == $requisicao->ficha_catalografica_id)
                                <tr>
                                    <td scope="row">
                                        {{$requisicao->id}}
                                    </td>
                                    <td>
                                        {{$ficha->autor_nome}}
                                    </td>
                                    <td class="text-center">
                                        @if ($ficha->tipo_documento_id == 1)Monografia
                                        @elseif ($ficha->tipo_documento_id == 2)Tese
                                        @elseif ($ficha->tipo_documento_id == 3)TCC
                                        @elseif ($ficha->tipo_documento_id == 4)Produto Educacional
                                        @elseif ($ficha->tipo_documento_id == 5)Dissertação
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ date('d/m/Y H:i:s', strtotime($ficha->created_at)) }}
                                    </td>
                                    <td class="text-center">
                                        @if($requisicao->status == 'Concluido')<p style="color:#00650A; background-color: var(--confirmar); border-radius: 0.5rem">Concluido</p>
                                        @elseif($requisicao->status == 'Em andamento')<p style="color:#D07D00; background-color: #FBBC04; border-radius: 0.5rem">Em andamento</p>
                                        @elseif($requisicao->status == 'Rejeitado')<p style="color: #BE0303; background-color: var(--destaque); border-radius: 0.5rem;">Rejeitado</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('editar-ficha', $requisicao->id) }}"><i class="fa fa-file-text fa-sm" aria-hidden="true" size="10px"></i> Editar</a>
                                        @if($requisicao->status != 'Em andamento')
                                            <div class="btn-group-vertical">
                                                <a class="btn btn-light dropdown-toggle" data-toggle="modal" data-target="#exampleModal{{$requisicao->id}}">
                                                    <span class="fa fa-info-circle" title="Exibir explicação da rejeição"></span>
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal{{$requisicao->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Status da Analise</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if($requisicao->status == 'Concluido')
                                                                    <p style="margin-left: 3px">Requisição analisada e aprovada por: <Strong>{{\App\Models\User::where('id',\App\Models\Bibliotecario::where('id',$requisicao->bibliotecario_id)->first()->user_id)->first()->name}}</Strong></p>
                                                                @elseif($requisicao->status == 'Rejeitado' && $requisicao->bibliotecario_id != null)
                                                                    <p style="margin: 1rem">Requisição analisada e rejeitada por: <Strong>{{\App\Models\User::where('id',\App\Models\Bibliotecario::where('id',$requisicao->bibliotecario_id)->first()->user_id)->first()->name}}</Strong> <br></p>
                                                                    <p style="margin-left: 1rem">Motivo: <strong style="color: #4c110f">{{ $requisicao->anotacoes }}</strong></p>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($requisicao->status != 'Em andamento')
                                            {{ date('d/m/Y H:i:s', strtotime($requisicao->updated_at)) }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>

        $('#table').DataTable({
            searching: true,

            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Exibindo página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "zeroRecords": "Nenhum registro disponível",
                "search": "",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo",
                }
            },
            "dom": '<"top"f>rt<"bottom"p><"clear">',
            "order": [],
            "columnDefs": [{
                "targets": [5],
                "orderable": false
            }]
        });

        $('.dataTables_filter').addClass('here');
        $('.dataTables_filter').addClass('');
        $('.here').addClass('center');
        $('.here').removeClass('dataTables_filter');
        $('.table-hover').removeClass('dataTable');
        $('.here').find('input').addClass('search-input');
        $('.here').find('input').addClass('align-middle');
        $('.here').find('label').contents().unwrap();
        $('.here').find('input').wrap('<div class="col-md-12 my-3 py-1" style="background-color: #C2C2C2; border-radius: 1rem;"> <div class="col-md-7 my-2"> <div class="col-md-12 p-1 img-search" style="background-color: white; border-radius: 0.5rem;"> </div> </div> </div>');
        $('.img-search').prepend('<img src="{{asset('images/search.png')}}" width="25px">');

    </script>
@endsection
