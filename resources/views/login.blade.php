@include('components.head')

<div class="row justify-content-center align-items-center vh-100">
    <div class="col-10 col-lg-4">
        <form action="/login" method="post">
            @csrf
            <div class="mb-3">
              <input type="password" class="form-control" name="senha" id="senha" aria-describedby="senha" placeholder="Senha">
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        @if(session('mensagem'))
            <p class="text-danger fs-5">{{session('mensagem')}}</p>
        @endif
    </div>

</body>
</html>
