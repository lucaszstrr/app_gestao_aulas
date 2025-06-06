@extends('layouts.app-logged')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
            <h1>Menu do professor</h1>
            @if (session('reseted-classes'))
                <p class="success-message"><i class="fa-solid fa-check" style="color: #3a6604;"></i> Todas as presenças foram resetadas com sucesso!</p>
            @endif
            <div>
                <a href="{{ route('gerar-planilha') }}">
                    <button class="green-button">
                        Exportar para Excel <i class="fa-solid fa-table" style="color: #3a6604;"></i>
                    </button>
                </a>
            </div>
            
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
                        <th class="text-center align-middle">Anotações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $latestManagement = $student->managements()->latest()->first();

                            $paidStatus = $latestManagement ? $latestManagement->paid : false;

                            if($student->school_year == 'fundamental 1'){
                                $school_year = "Fundamental 1";
                            }elseif($student->school_year == 'fundamental 2'){
                                $school_year = "Fundamental 2";
                            }elseif($student->school_year == 'ensino médio'){
                                $school_year = "Ensino Médio";
                            }elseif($student->school_year == 'ensino superior'){
                                $school_year = "Ensino Superior";
                            }

                        @endphp
                        <tr class="{{ $paidStatus ? 'bg-success-light' : '' }}">
                            <td class="text-center align-middle">{{ $student->name }}</td>
                            <td class="text-center align-middle">{{ $school_year }}</td>
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

                            <td class="text-center align-middle">
                                <form method="POST" action="{{ route('anotacao-aluno', $student->id) }}">
                                    @csrf
                                    @method('POST')
                                    <input class="input" name="description" placeholder="Faça suas anotações aqui" type="text" value="{{ $latestManagement->description }}">
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

        <div class="options-container">
            <a href="{{ route('resetar-presenca') }}">
                <form method="PUT" action="{{ route('resetar-presenca') }}">
                    @csrf
                    @method('PUT')
                    <button onclick="return confirm('Essa ação irá resetar todas as presenças dos alunos')">
                        Resetar Presenças
                    </button>
                </form>
            </a>

            <a href="{{ route('resetar-pago') }}">
                <form method="POST" action="{{ route('resetar-pago') }}">
                    @csrf
                    @method('PUT')
                    <button onclick="return confirm('Essa ação irá resetar todos os status')">
                        Resetar Status Pago
                    </button>
                </form>
            </a>

            <a href="{{ route('resetar-anotacoes') }}">
                <form method="POST" action="{{ route('resetar-anotacoes') }}">
                    @csrf
                    @method('PUT')
                    <button onclick="return confirm('Essa ação irá resetar todas as anotações')">
                        Resetar Anotações
                    </button>
                </form>
            </a>
        </div>
        
                
    </div>
    <footer class="footer">
        <h3>Total Bruto: R${{ number_format($totalValue ?? 0, 2, ',', '.') }}</h3>
        <h3>Valor das Salas: R${{ number_format($roomRental ?? 0, 2, ',', '.') }}</h3>
        <h3>Total Líquido: R${{ number_format($totalValue - $roomRental ?? 0, 2, ',', '.') }}</h3>
    </footer>
@endsection

