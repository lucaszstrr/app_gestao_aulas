@extends('layouts.app-logged')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
            <h1>Menu do professor</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="border-collapse: collapse;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center align-middle">Nome</th>
                        <th class="text-center align-middle">Ano</th>
                        <th class="text-center align-middle">Escola</th>
                        <th class="text-center align-middle">Valor da aula</th>
                        <th class="text-center align-middle">Presença</th>
                        <th class="text-center align-middle">Total</th>
                        <th class="text-center align-middle">Pago</th>
                        
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
                            <td class="text-center align-middle">{{ $student->school_year }}</td>
                            <td class="text-center align-middle">{{ $student->school }}</td>
                            <td class="text-center align-middle">R$ {{ number_format($student->class_value ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center align-middle">

                                <form method="POST" action="{{ route('quantidade-aulas', $student->id) }}">
                                @csrf
                                    <select class="input" name="quantity_classes" onchange="this.form.submit()">
                                        @for($i = 0; $i <= 12; $i++)
                                            <option value="{{ $i }}" 
                                                {{ $latestManagement && $latestManagement->quantity_classes == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </form>

                            </td>

                            <td class="text-center align-middle">R$ {{ number_format($latestManagement->total_value ?? 0, 2, ',', '.') }}</td>
                            
                            <td class="text-center align-middle">
                                <form method="POST" action="{{ route('pagamento-aluno', $student->id) }}">
                                    @csrf
                                    <select class="input" name="paid"  onchange="this.form.submit()" required>
                                        <option class="input-option" value="false" {{ !$paidStatus ? 'selected' : '' }}>Não</option>
                                        <option class="input-option" value="true" {{ $paidStatus ? 'selected' : '' }}>Sim</option>
                                    </select>
                                </form>
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
    </div>
    <footer class="footer">
        <h3>Total Bruto: R${{ number_format($totalValue ?? 0, 2, ',', '.') }}</h3>
        <h3>Valor das Salas: R${{ number_format($roomRental ?? 0, 2, ',', '.') }}</h3>
        <h3>Total Líquido: R${{ number_format($totalValue - $roomRental ?? 0, 2, ',', '.') }}</h3>
    </footer>
@endsection

