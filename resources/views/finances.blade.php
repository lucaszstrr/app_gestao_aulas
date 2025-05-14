@extends('layouts.app-logged')

@section('content')

    <div class="content-finances-page">
        <div class="finances-content">
            <h1>Cobranças</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="border-collapse: collapse;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center align-middle">Nome</th>
                        <th class="text-center align-middle">Responsável</th>
                        <th class="text-center align-middle">Qtd. Aulas</th>
                        <th class="text-center align-middle">Valor</th>
                        <th class="text-center align-middle">Mensagem Automática</th>                        
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $latestManagement = $student->managements()->latest()->first();

                            $paidStatus = $latestManagement ? $latestManagement->paid : false;

                            $responsible = $student->responsible();

                        @endphp
                        <tr class="{{ $paidStatus ? 'bg-success-light' : '' }}">
                            <td class="text-center align-middle">{{ $student->name }}</td>
                            <td class="text-center align-middle">{{ $student->responsible }}</td>
                            <td class="text-center align-middle">{{ $latestManagement->quantity_classes ?? 0 }}</td>
                            <td class="text-center align-middle">R$ {{ number_format($latestManagement->total_value ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center align-middle">
                                <a target="_blank" href="https://wa.me/55{{ $student->responsible_number }}?text=***Aluno:*** {{ $student->name }}%0A***Quantidade de aulas:*** {{ $latestManagement->quantity_classes ?? 0 }}%0A***Valor:*** R$ {{ number_format($latestManagement->total_value ?? 0, 2, ',', '.') }}">
                                    <button class="green-button">
                                        Enviar mensagem
                                    </button>
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Nenhum aluno cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="finances-content">
            <h1>Valor das salas</h1>
        </div>

        <div class="finances-container">
            <h3>{{ $greet }}, {{ $userLogged->name }}!</h3>
            @if($totalClasses == 0)
                <p class="finances-text">Você ainda não teve nenhuma aula!</p>

            @else
                <p class="finances-text">Até o momento, você teve {{ $totalClasses }} aulas!</p>
                <p class="finances-text">O valor das salas a ser pago é de: R${{ number_format($roomRental, 2, ',', '.') }}</p>
            @endif
        </div>
        
    </div>

@endsection