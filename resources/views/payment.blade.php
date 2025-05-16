@extends('layouts.app-logged')

@section('content')

    <a href="{{ route('financas') }}" class="return-back-link"><- Voltar</a>
    <div class="payment-card">
    <div class="card">
        <div class="card-body text-center">
            <h2>Pagamento via PIX</h2>
            <h4 class="my-3">Valor: R$ {{ number_format($aluguel, 2, ',', '.') }}</h4>
            
                <div class="qr-code">
                    {!! $qrCode !!}
                </div>
                
                <div class="form-group">
                    <label for="pixCode">Código PIX:</label>
                    <textarea id="pixCode" class="pix-area" rows="4" readonly>{{ $codigoPix }}</textarea>
                    <button onclick="copyPixCode()" class="green-button payment-button">
                        Copiar Código
                    </button>
                </div>
                
                <div class="">
                    <p class="text-muted">Após pagar, envie o comprovante para confirmação</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyPixCode() {
            const copyText = document.getElementById("pixCode");
            copyText.select();
            document.execCommand("copy");
            alert("Código PIX copiado!");
        }
    </script>

@endsection