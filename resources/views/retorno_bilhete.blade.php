@include('components.head')

@include('components.navbar')

<div class="container-fluid  bg-primary">

    <div class="row justify-content-center align-items-center text-white" style="height:900px; width: 100%;">
        <div class="confirmacao-texto-final text-center col-xl-6 col-lg-8 col-md-10 col-12">
            @if ($sucesso)
                <h1 class="mb-5">Agradecemos desde já sua participação!</h1>
                <h3 class="mb-5">Tire um "print" ou uma foto das informações abaixo! Elas servem para comprovar sua compra</h3>
                <p><strong>Nome do Participante: </strong> {{$bilhete->nome_convidado}} </p>
                <p><strong>Telefone do Participante: </strong> <span class="telefone-mask">{{$bilhete->telefone_convidado}}</span> </p>
                <p><strong>Santo Escolhido: </strong> {{$santo->nome}} </p>
                <p><strong>Data: </strong> {{$bilhete->created_at}} </p>
                <p class="text-danger p-3 bg-white mt-3"><strong>Importante: Envie o comprovante de
                    pagamento para o whatsapp (11) 94005-3900</strong> </p>
            @else
                <h1>Infelizmente ocorreu um problema ao fazer a compra do seu bilhete!</h1>
                <h2>Tente Novamente. Se não conseguir, entre em contato conosco no telefone (11) 94005-3900 para entendermos o que pode ter acontecido</h2>
            @endif
                <a class="btn btn-xl btn-outline-light mt-5" href="/#page-top">
                    <i class="fas fa-arrow-left"> me-2</i>
                    Voltar para o inicio
                </a>
        </div>
    </div>
</div>

@include('components.footer')
