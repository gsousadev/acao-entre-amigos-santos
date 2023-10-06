@include('components.head')

@include('components.navbar')

<header class="masthead bg-primary text-white text-center">
    <div class="container-fluid m-0 px-1 py-5 d-flex align-items-center flex-column bg-white">
        <img class="w-50 mx-auto" src="images/logo_radio.png" alt="..."/>
    </div>
</header>

<section class="page-section mb-0 bg-primary text-white" id="como-sera">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase">Como será?</h2>
        <!-- Icon Divider-->
        <div class="divider-custom  divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- About Section Content-->
                <div class="row justify-content-center my-5">

                    <div class="col-12 col-lg-6 align-self-center">
                        <p class="lh-lg fs-4">
                            A "Ação entre Amigos" tem como objetivo arrecadar fundos para a manutenção e reparos da
                            rádio. O valor de cada nome será de <strong>R$ 30,00 , </strong> dando direito de concorrer aos dois prêmios.
                        </p>
                        <p class="lh-lg fs-4">
                            Ao adquirir um nome você contribui com a obra
                            de evangelização da diocese, realizada por meio da Rádio Católica de Osasco.
                        </p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <img class="w-100 mx-auto rounded" src="images/computador_radio.jpg"/>
                    </div>
                    <div class="col-12 mt-5 text-center">
                        <p class="lh-lg h1 bg-white text-primary">O sorteio será no dia 03 de novembro, ao meio-dia, no "Terço das Lágrimas de Nossa Senhora"</p>
                    </div>
                </div>
            </div>
        </div>
</section>

<section class="page-section mb-0" id="premios">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary">Prêmios</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>

        <!-- About Section Content-->
        <div class="row justify-content-center  my-5">
            <div class="col-lg-6">
                <img class="w-100 mx-auto rounded" src="images/premio_1.jpeg" alt="..."/>
            </div>
            <div class="col-lg-6 align-self-center">
                <h3 class="my-3">1° Prêmio</h3>
                <p class="fs-5">
                    1 imagem fac-simile de Nossa Senhora Aparecida (35cm aproximadamente)
                </p>
            </div>

        </div>

        <div class="row justify-content-center my-5">
            <div class="col-lg-6 order-2 order-lg-1 align-self-center">
                <h3 class="my-3">2° Prêmio</h3>
                <p class="fs-5">
                    1 quadro de São Francisco de Assis pintado à mão (120cm X 90 cm)
                </p>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 mt-5 mt-lg-0">
                <img class="w-100 mx-auto rounded" src="images/premio_2.jpeg" alt="..."/>
            </div>
        </div>
    </div>

</section>

<section class="page-section mb-0 bg-primary text-white" id="como-participar">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-white text-uppercase text-secondary">Como participar</h2>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>

        <!-- About Section Content-->
        <div class="row justify-content-center  my-5">

            <div class="col-lg-10  align-self-center text-center">

                <h3 class="passo-titulo"> Passo 1 </h3>
                <p class="passo-texto">

                    Escolha o santo que preferir disponível na lista. Na escolha de um nome você já está
                    concorrendo aos dois prêmios. </p>
                <h3 class="passo-titulo"> Passo 2 </h3>
                <p class="passo-texto">
                    Nos informe seu nome e seu número de celular (de preferência whatsapp), para que
                    possamos entrar em contado com você caso seja o grande premiado.</p>
                <h3 class="passo-titulo"> Passo 3 </h3>
                <p class="passo-texto">Confirme as informações para o sorteio e efetue o pagamento, através do QRCode ou chave PIX.</p>
                <p class="passo-texto text-danger p-3 m bg-white"><strong>Importante: Envie o comprovante de
                        pagamento para o whatsapp (11) 94005-3900</strong> </p>
                <div class="mt-4">
                    <a class="btn btn-xl btn-outline-light" href="#comprar">
                        <i class="fas fa-arrow-down"> me-2</i>
                        Escolher o Santo
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="page-section mb-0" id="comprar">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase">Comprar</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        @if (!empty($bilheteDosSantos) && isset($sorteios) && !empty($sorteios) && $sorteios->isEmpty())
            <!-- About Section Content-->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="row justify-content-center pb-5 passo-bilhete-santos" id="passo-1-bilhete-santos">
                        <div class="col-12 align-self-center">
                            <h3 class="my-5">
                                Passo 1: Escolha um nome de Santo
                            </h3>
                        </div>
                        @foreach ($bilheteDosSantos as $santo)
                            <div class="col-6 col-md-4 col-lg-3 col-xl-2 justify-content-center mb-3">
                                <div id="santo_{{ data_get($santo, 'slug') }}"
                                     data-santo-id={{ data_get($santo, 'slug') }}
                                    data-santo-nome={{ str_replace(' ', '_', data_get($santo, 'nome')) }}
                                    @if (data_get($santo, 'escolhido')) class='box-santo text-center escolhido
                                '>
                                @else
                                    class='box-santo text-center livre'>
                                @endif
                                <img src="images/santos/{{ data_get($santo, 'imagem', '--') }}"
                                     class="img-fluid rounded" alt=""/>
                                <div class="text-center h5">
                                    {{ data_get($santo, 'nome', '--') }}
                                </div>
                            </div>
                    </div>
                    @endforeach
                </div>
                <div class="row justify-content-center pb-5  d-none passo-bilhete-santos" id="passo-2-bilhete-santos">
                    <div class="col-12 align-self-center">
                        <h3 class="my-5">
                            Passo 2: Informe seu nome e telefone
                        </h3>
                    </div>
                    <div class="col-12">
                        <div class="form-group ">
                            <label for="nome-convidado">Informe seu nome</label>
                            <input name="nome_convidado" type="text" id="nome-convidado"
                                   class="form-control dados-convidado">
                        </div>
                        <div class="form-group mt-3">
                            <label for="telefone-convidado">Informe o seu whatsapp</label>
                            <input name="telefone_convidado" typé="text" id="telefone-convidado"
                                   class="form-control dados-convidado telefone-mask">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center pb-5 d-none passo-bilhete-santos" id="passo-3-bilhete-santos">
                    <div class="col-12 align-self-center">
                        <h3 class="my-5">
                            Passo 3: Confirme as Informações
                        </h3>
                        <h5 class="text-danger"> OBS: Não esqueça de finalizar sua compra no botão "Finalizar Compra"!</h5>
                    </div>

                    <div class="row justify-content-center align-items-center" id="confirmacao-texto-dinheiro">
                        <div class="col-12 col-lg-6">
                            <h2 class="mb-5"> Dados de Pagamento</h2>
                            <h4> Page via PIX através do QRCode:</h4>

                            <p class="text-danger"><strong>Importante: Envie o comprovante de
                                pagamento para o whatsapp (11) 94005-3900</strong></p>

                        </div>
                        <div class="col-12 col-lg-6">
                            <img class="img-fluid" src="images/qrcode_pix.png"/>
                        </div>
                    </div>

                    <div class="col-12">

                        <table class="table" id="confirmacao-informacoes">
                            <tr id='linha-santo'>
                                <td class='key'>Santo escolhido</td>
                                <td class='value'></td>
                            </tr>
                            <tr id='linha-nome-convidado'>
                                <td class='key'>Seu nome</td>
                                <td class='value'></td>
                            </tr>
                            <tr id='linha-telefone-convidado'>
                                <td class='key'>Seu telefone</td>
                                <td class='value telefone-mask'></td>
                            </tr>
                        </table>

                    </div>
                </div>

                <div class="row justify-content-between pb-5" id="botoes-bilhete">
                    <div class="col-12 d-flex justify-content-center">
                        <button type="button" id="botao-passo-anterior"
                                class="btn bg-dark text-white d-none w-50 mt-3 mx-1">
                            Passo anterior
                        </button>
                        <button type="button" id="botao-proximo-passo"
                                class="btn bg-dark text-white d-block w-50 mt-3 mx-1">
                            Proximo Passo
                        </button>

                        <button type="button" id="botao-enviar-informacoes"
                                class="btn bg-primary text-white d-none w-50 mt-3 mx-1">
                            Finalizar Compra
                        </button>
                    </div>
                </div>

                <form method="POST" action="/bilhete" id="formulario_bilhete">
                    @csrf
                    <input id="santo_escolhido" name="santo_escolhido" type="hidden"/>
                    <input id="nome_convidado" name="nome_convidado" type="hidden"/>
                    <input id="telefone_convidado" name="telefone_convidado" type="hidden"/>
                </form>

            </div>
        @elseif(isset($sorteios) && !empty($sorteios) && $sorteios->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="my-5 text-center">
                        SORTEIO FINALIZADO
                    </h3>

                    @include('components.resultado_sorteio')
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="my-5 text-center">
                        Em Breve
                    </h3>
                </div>
            </div>
        @endif
    </div>
    </div>
</section>

@include('components.footer')
