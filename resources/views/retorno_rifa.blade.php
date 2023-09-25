@include('components.head')

@include('components.navbar')

<div class="container-fluid  bg-primary">

    <div class="row justify-content-center align-items-center text-white" style="height:900px; width: 100%;">
        <div class="confirmacao-texto-final text-center col-xl-6 col-lg-8 col-md-10 col-12">
            @if ($sucesso)
                <h1>Agradecemos desde já o seu presente!!!</h1>
                <h2>Enviamos um email de confirmação para você! Se não o encontrar tente buscar na caixa de span!</h2>
                <h3 class="my-5"> Esperamos você no chá drive-thru da Dulce</h3>
            @else
                <h1>Infelizmente ocorreu um problema ao fazer o cadastro da sua rifa!</h1>
                <h2>Tente Novamente. Se não conseguir, entre em contato conosco para entendermos o que pode ter
                    acontecido</h2>
                <h3 class="my-5"> Mesmo assim esperamos você no chá drive-thru da Dulce</h3>
            @endif
            <h4>Dia 10 de Junho de 2023, das 14:00 as 18:00</h4>
                <h4>Endereço: Rua Tília, 60, Jardim Das Flores, Osasco</h4>
                <h4>CEP: 06120-080</h4>

                <a class="btn btn-xl btn-outline-light mt-5" href="/#page-top">
                    <i class="fas fa-arrow-left"> me-2</i>
                    Voltar para o inicio
                </a>
        </div>
    </div>
</div>

@include('components.footer')
