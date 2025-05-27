@extends('layouts.app-logged')

@section('content')

    <div class="content-finances-page">
        <div class="finances-content">
            <h1>Cobranças</h1>
        </div>
        @error('invalid-pix')
            <p class="pix-field-error"><i class="fa-regular fa-circle-question" style="color: #ff0000;"></i> Você deve ter ao menos uma aula com o aluno para gerar o PIX </p>
        @enderror
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="border-collapse: collapse;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center align-middle">Nome</th>
                        <th class="text-center align-middle">Responsável</th>
                        <th class="text-center align-middle">Qtd. Aulas</th>
                        <th class="text-center align-middle">Valor</th>
                        <th class="text-center align-middle">Mensagem Automática</th>
                        <th class="text-center align-middle">Gerar Código PIX</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $latestManagement = $student->managements()->latest()->first();

                            $paidStatus = $latestManagement ? $latestManagement->paid : false;

                            $studentUpperName = strtoupper($student->name);

                            $responsibleName = ucfirst(explode(' ', $student->responsible)[0]);

                            $meses = [
                                1 => 'Janeiro',
                                2 => 'Fevereiro',
                                3 => 'Março',
                                4 => 'Abril',
                                5 => 'Maio',
                                6 => 'Junho',
                                7 => 'Julho',
                                8 => 'Agosto',
                                9 => 'Setembro',
                                10 => 'Outubro',
                                11 => 'Novembro',
                                12 => 'Dezembro'
                            ];

                            $mes = date('n');

                            $mes_atual = $meses[$mes];

                            $message = "https://wa.me/55".$student->responsible_number."?text="
                                        . $greet ."%2C%20".$responsibleName."!%0A"
                                        . "Em%20".$mes_atual."%2C%20foram%20realizadas%20"
                                        . $latestManagement->quantity_classes."%20aulas%20com%20".$student->name.".%0A"
                                        . "Valor%3A%20R%24%20".number_format($latestManagement->total_value ?? 0, 2, ',', '.')."%0A"
                                        . "Chave%20PIX%20%3A%20".$userLogged['pix-key']."%0A"
                                        . "Qualquer%20d%C3%BAvida%2C%20fico%20%C3%A0%20disposi%C3%A7%C3%A3o.%0A"
                                        . "Prof.%20".$firstName;

                        @endphp
                        <tr class="{{ $paidStatus ? 'bg-success-light' : '' }}">
                            <td class="text-center align-middle">{{ $student->name }}</td>
                            <td class="text-center align-middle">{{ $student->responsible }}</td>
                            <td class="text-center align-middle">{{ $latestManagement->quantity_classes ?? 0 }}</td>
                            <td class="text-center align-middle">R${{ number_format($latestManagement->total_value ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center align-middle">
                                <a target="_blank" href="{{ $message }}">      
                                    <button class="green-button">
                                        Enviar mensagem <i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('gerar-codigo-pix-responsavel', $student->id) }}">
                                    <button class="green-button">
                                        Gerar PIX <i class="fa-solid fa-qrcode" style="color: #113800;"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Nenhum aluno cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="finances-content">
            <h1>Valor das salas</h1>
        </div>

        <div class="finances-container">
            <h3>{{ $greet }}, {{ $firstName }}!</h3>
            @if($totalClasses == 0)
                <p class="finances-text">Você ainda não teve nenhuma aula!</p>
            @else
                @if($totalClasses == 1)
                    <p class="finances-text">Até o momento, você teve {{ $totalClasses }} aula!</p>
                    <p class="finances-text">O valor das salas a ser pago é de: R${{ number_format($roomRental, 2, ',', '.') }}</p>
                    <a href="{{ route('gerar-codigo-pix') }}">
                        <button class="green-button">Pagar com código PIX <i class="fa-solid fa-qrcode" style="color: #113800;"></i></button>
                    </a>
                @else
                <p class="finances-text">Até o momento, você teve {{ $totalClasses }} aulas!</p>
                <p class="finances-text">O valor das salas a ser pago é de: R${{ number_format($roomRental, 2, ',', '.') }}</p>
                <a href="{{ route('gerar-codigo-pix') }}">
                    <button class="green-button">Pagar com código PIX <i class="fa-solid fa-qrcode" style="color: #113800;"></i></button>
                </a>
                @endif
            @endif
        </div>
    </div>

@endsection