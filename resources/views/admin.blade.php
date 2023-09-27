@include('components.head')

<div class="row justify-content-center fixed-top">
    <div class="col-12 col-lg-10 text-center">
        <nav class="navbar navbar-expand navbar-light bg-light" id="navbar-admin">
            <ul class="nav navbar-nav d-flex">
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn btn-primary text-white " href="#pagina-admin">Bilhetes</a>
                </li>
                <li class="nav-item h5 me-3">
                    <a class="nav-link btn  btn-primary text-white" href="#sorteio-bilhete">Sorteio</a>
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
        <div class="col-12 col-lg-10" id="bilhetes">
            <h1> Bilhetes Vendidos</h1>
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
                            <th>Telefone do Convidado</th>
                            <th>Bilhete Validado</th>
                            <th>Nome do Santo</th>
                            <th>Número do Santo</th>
                            <th>Data da Venda</th>
                            <th colspan="3">Ações</th>
                        </tr>

                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($bilhetes as $bilhete)
                            <tr>
                                <td scope="row">{{ data_get($bilhete, 'id', '-') }}</td>
                                <td>{{ data_get($bilhete, 'nome_convidado', '-') }}</td>
                                <td class="telefone-mask">{{ data_get($bilhete, 'telefone_convidado', '-') }}</td>
                                <td>{{ data_get($bilhete, 'validada') ? 'SIM' : 'NÃO' }}
                                </td>
                                <td>{{ data_get($bilhete, 'santo.nome', '-') }}</td>
                                <td>{{ data_get($bilhete, 'santo.id', '-') }}</td>
                                <td>{{ data_get($bilhete, 'created_at', '-') }}</td>
                                <td>
                                    <form action="/bilhete/validar" method="post">
                                        @csrf
                                        <input type="hidden" name="bilhete" value="{{ data_get($bilhete, 'id') }}">
                                        <button type="submit" class="btn btn-success">Validar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/bilhete/invalidar" method="post">
                                        @csrf
                                        <input type="hidden" name="bilhete" value="{{ data_get($bilhete, 'id') }}">
                                        <button type="submit" class="btn btn-warning">Invalidar</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="/bilhete/deletar" method="post">
                                        @csrf
                                        <input type="hidden" name="bilhete" value="{{ data_get($bilhete, 'id') }}">
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

    <div class="row justify-content-center my-5 pb-5" id="sorteio-bilhete">
        <div class="col-12 col-md-10 text-center">
            <h1 class="py-2">Sorteio</h1>

            @if (isset($sorteios) && !empty($sorteios) && $sorteios->isEmpty())
                <form action="/sorteio/sortear" method="post">
                    @csrf
                    <input type="number" class="w-25 p-3 my-3" min=1 name="quantidade_numeros_sorteio"
                        id="quantidade_numeros_sorteio" placeholder="Quantidade de Números para Sorteio" />

                    <button type="submit" class="btn btn-primary w-25 py-3 my-3"><span
                            class='h3'>SORTEAR</span></button>
                </form>
            @elseif(isset($sorteios) && !empty($sorteios) && $sorteios->isNotEmpty())
                <form action="/sorteio/limpar" method="post">
                    @csrf
                    <button type="submit" class="btn btn-dark w-100 py-3 my-3"><span class='h3'>LIMPAR SORTEIO</span></button>
                </form>
            @else
                Erro em modulo de sorteio
            @endif

            @include('components.resultado_sorteio')
        </div>

    </div>
    <div class="row justify-content-center my-5 pb-5" id="logs">
        <div class="col-12 col-md-10">
            <h1 class="py-2">Logs de Erro</h1>
            <div class="table-responsive" style="max-height: 500px">
                <table
                    class="table table-striped
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
