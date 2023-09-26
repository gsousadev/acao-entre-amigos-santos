@include('components.head')

@include('components.navbar')

<div class="container-fluid  bg-primary">

    <div class="row justify-content-center align-items-center text-white" style="height:900px; width: 100%;">
        <div class="confirmacao-texto-final text-center col-xl-6 col-lg-8 col-md-10 col-12">
            @if ($sucesso)
                <h1>Agradecemos desde já sua participação!</h1>
                <h2>Enviamos um email de confirmação para você! Se não o encontrar tente buscar na caixa de span!</h2>
            @else
                <h1>Infelizmente ocorreu um problema ao fazer a compra do seu bilhete!</h1>
                <h2>Tente Novamente. Se não conseguir, entre em contato conosco para entendermos o que pode ter
                    acontecido</h2>
            @endif
                <a class="btn btn-xl btn-outline-light mt-5" href="/#page-top">
                    <i class="fas fa-arrow-left"> me-2</i>
                    Voltar para o inicio
                </a>
        </div>
    </div>
</div>

@include('components.footer')
