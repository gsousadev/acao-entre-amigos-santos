@include('components.head')

<div class="row justify-content-center fixed-top">
    <div class="col-12 col-lg-10 text-center">
        <nav class="navbar navbar-expand navbar-light bg-light" id="navbar-admin">
            <ul class="nav navbar-nav d-flex">
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn btn-primary text-white " href="#pagina-admin">Rifas</a>
                </li>
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn btn-primary text-white " href="#mensagens">Mensagens</a>
                </li>
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn  btn-primary text-white" href="#sorteio-rifa">Sorteio</a>
                </li>
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn btn-primary text-white " href="/">Ir para o Site</a>
                </li>
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn btn-dark text-white " href="/logout">Sair</a>
                </li>
            </ul>
        </nav>
    </div>
    @if (session('mensagem_alerta'))
        <div class="row justify-content-center">
            <div
                class="col-12 col-lg-10 text-center 
            
            @switch(data_get(session('mensagem_alerta'),'tipo'))
                @case('danger')
                    bg-danger
                @break
                @case('warning')
                    bg-warning
                @break

                @case('success')
                    bg-success
                @break
                @default
                    bg-dark
            @endswitch
            
            ">
                <h2 class="text-white py-2 m-0"> {{ data_get(session('mensagem_alerta'), 'mensagem') }} </h2>
            </div>
        </div>
    @endif
</div>
<div class="container-fluid" id="pagina-admin">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10" id="rifas">
            <h1> RIFAS </h1>
            <div class="table-responsive rounded">
                <table
                    class="table table-striped
                table-hover	
                table-borderless
                align-middle
                table-primary
                text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Nome do Convidado</th>
                            <th>Email do Convidado</th>
                            <th>Telefone do Convidado</th>
                            <th>Tipo de Presente</th>
                            <th>Valor em Dinheiro</th>
                            <th>Tamanho da Fralda</th>
                            <th>Validada</th>
                            <th>Nome do Santo</th>
                            <th>Número do Santo</th>
                            <th>Data da Venda</th>
                            <th colspan="4">Ações</th>
                        </tr>

                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($rifas as $rifa)
                            <tr>
                                <td scope="row">{{ data_get($rifa, 'id', '-') }}</td>
                                <td>{{ data_get($rifa, 'nome_convidado', '-') }}</td>
                                <td>{{ data_get($rifa, 'email_convidado', '-') }}</td>
                                <td>{{ data_get($rifa, 'telefone_convidado', '-') }}</td>
                                <td>{{ data_get($rifa, 'tipo_presente', '-') }}</td>
                                <td>{{ data_get($rifa, 'valor_dinheiro', '-') }}</td>
                                <td>{{ strtoupper(data_get($rifa, 'tamanho_fralda', '-')) }}</td>
                                <td>{{ data_get($rifa, 'validada') ? 'SIM' : 'NÃO' }}
                                </td>
                                <td>{{ data_get($rifa, 'santo.nome', '-') }}</td>
                                <td>{{ data_get($rifa, 'santo.id', '-') }}</td>
                                <td>{{ data_get($rifa, 'created_at', '-') }}</td>
                                <td>
                                    <form action="/rifa/validar" method="post">
                                        @csrf
                                        <input type="hidden" name="rifa" value="{{ data_get($rifa, 'id') }}">
                                        <button type="submit" class="btn btn-success">Validar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/rifa/invalidar" method="post">
                                        @csrf
                                        <input type="hidden" name="rifa" value="{{ data_get($rifa, 'id') }}">
                                        <button type="submit" class="btn btn-warning">Invalidar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/rifa/deletar" method="post">
                                        @csrf
                                        <input type="hidden" name="rifa" value="{{ data_get($rifa, 'id') }}">
                                        <button type="submit" class="btn btn-danger">Deletar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/rifa/reenviar-email" method="post">
                                        @csrf
                                        <input type="hidden" name="rifa" value="{{ data_get($rifa, 'id') }}">
                                        <button type="submit" class="btn btn-dark">Reenviar Email</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row justify-content-center ">
        <div class="col-12 col-lg-10" id="mensagens">
            <h1>Mensagens</h1>
            <div class="table-responsive rounded">
                <table
                    class="table table-striped
                table-hover	
                table-borderless
                align-middle
                table-primary
                text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Nome</th>
                            <th>Mensagem</th>
                            <th>Validada</th>
                            <th>Data Envio</th>
                            <th colspan="3">Ações</th>
                        </tr>

                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($mensagens as $mensagem)
                            <tr>
                                <td scope="row">{{ data_get($mensagem, 'id', '-') }}</td>
                                <td>{{ data_get($mensagem, 'nome', '-') }}</td>
                                <td>{{ data_get($mensagem, 'mensagem', '-') }}</td>
                                <td>{{ data_get($mensagem, 'validada') ? 'SIM' : 'NÃO' }}</td>
                                <td>{{ data_get($mensagem, 'created_at', '-') }}</td>
                                <td>
                                    <form action="/mensagem/validar" method="post">
                                        @csrf
                                        <input type="hidden" name="mensagem" value="{{ data_get($mensagem, 'id') }}">
                                        <button type="submit" class="btn btn-success">Validar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/mensagem/invalidar" method="post">
                                        @csrf
                                        <input type="hidden" name="mensagem" value="{{ data_get($mensagem, 'id') }}">
                                        <button type="submit" class="btn btn-warning">Invalidar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/mensagem/deletar" method="post">
                                        @csrf
                                        <input type="hidden" name="mensagem" value="{{ data_get($mensagem, 'id') }}">
                                        <button type="submit" class="btn btn-danger">Deletar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <div class="row justify-content-center my-5 pb-5" id="sorteio-rifa">
        <div class="col-12 col-md-10 text-center">
            <h1 class="py-2">Sorteio da Rifa dos Santos</h1>

            <form action="/rifa/sortear" method="post">
                @csrf
                <button type="submit" class="btn btn-primary w-100 py-3 my-3"><span
                        class='h3'>SORTEAR</span></button>
            </form>
            @if (!empty($ultimoSorteio))
                <form action="/sorteio/limpar" method="post">
                    @csrf
                    <button type="submit" class="btn btn-dark w-100 py-3 my-3"><span class='h3'>LIMPAR
                            SORTEIOS</span></button>
                </form>
            @endif

            @include('components.resultado_sorteio')
        </div>

    </div>
        <div class="row justify-content-center my-5 pb-5" id="logs">
            <div class="col-12 col-md-10">
                <h1 class="py-2">Logs de Erro</h1>
                <div class="table-responsive" style="max-height: 500px">
                    <table class="table table-striped
                    table-hover	
                    table-borderless
                    align-middle
                    table-primary">
                        @if (!empty($logs))
                            @foreach ($logs as $log)
                                <tr>
                                    <td scope="row"> {{ $log }} </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    </body>

    </html>
