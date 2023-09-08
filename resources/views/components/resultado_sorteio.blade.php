@if (!empty($ultimoSorteio))
<div class="row text-white text-center">
    
    <div class="col-12 col-md-4 py-5 bg-primary">
        <h4>Número Sorteado</h4>
        <h2 class="mt-5">{{data_get($ultimoSorteio, 'id')}}</h2>
    </div>
    <div class="col-12 col-md-4 py-5 bg-secondary">
        <h4>Santo Sorteado</h4>
        <img src="images/santos/{{ data_get($ultimoSorteio, 'santo.imagem', '--') }}"
        class="img-fluid rounded" alt="" style="max-width:200px"/>
        <h2>{{data_get($ultimoSorteio, 'santo.nome')}}</h2>
    </div>

    <div class="col-12 col-md-4 py-5 bg-primary">
        <h4>Nome Ganhador(a)</h4>
        <h2 class="mt-5">{{data_get($ultimoSorteio, 'nome_convidado')}}</h2>
    </div>
</div>
@endif