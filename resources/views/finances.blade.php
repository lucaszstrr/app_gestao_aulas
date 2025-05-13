@extends('layouts.app-logged')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
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
                        @endphp
                        <tr class="{{ $paidStatus ? 'bg-success-light' : '' }}">
                            <td class="text-center align-middle">{{ $student->name }}</td>
                            <td class="text-center align-middle">{{ $student->responsible }}</td>
                            <td class="text-center align-middle">{{ $latestManagement->quantity_classes }}</td>
                            <td class="text-center align-middle">R$ {{ number_format($latestManagement->total_value ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center align-middle"></td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Nenhum aluno cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection