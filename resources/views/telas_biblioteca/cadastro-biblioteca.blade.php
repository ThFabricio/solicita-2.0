@extends('layouts.app')


@section('conteudo')

<div class="container-fluid background-blue" style="min-height:110vh">
  <div class="row justify-content-center">
    <div class="col-sm-3">
      <div class="card card-cadastro card-cadastro-servidor">
        <div class="card-body">

          <div class="row justify-content-center">
            <h2>Cadastrar Biblioteca</h2>
          </div>
          <form action="{{  route('criar-biblioteca')  }}" method="POST">
            @csrf
              <div class="row justify-content-center">
                  <div class="col-sm-12">
                      <label for="nome" class="field a-field a-field_a3 page__field ">
                          <input id="nome" type="name"
                                 class="form-control @error('nome') is-invalid @enderror field__input a-field__input"
                                 name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus
                                 placeholder="Nome Completo">

                          <span class="a-field__label-wrap">
                        <span class="a-field__label">Nome</span>
                    </span>
                      </label>
                      @error('name')
                      <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                    <strong>{{ $message }}</strong>
                    </span>
                      @enderror
                  </div>
              </div>

              <select name="unidade" id="unidade" class="browser-default custom-select">

                  <option value="" disable selected hidden>Selecionar biblioteca</option>
                  @foreach($unidades as $unidade)
                      <option value="{{$unidade->id}}">{{$unidade->nome}}</option>
                  @endforeach

                  @error('unidades')
                  <span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
                                    <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
              </select>

            <!-- Botões -->
            <div class="form-group row justify-content-center" style="margin-top:60px">
                <div class="col-sm-6">
                <a class="btn btn-secondary btn-cadastro-primary" href="{{  route('listar-biblioteca')}}" >Voltar</a>
                </div>

                <div class="col-sm-6">
                    <button type="submit" class="btn lmts-primary btn-cadastro-primary">
                        {{ __('Cadastrar') }}
                    </button>
                </div>

            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>


@endsection
