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
                        @endphp
                        <tr>
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
                                <select class="input" name="paid" required>
                                    <option class="input-option" value="no">Não</option>
                                    <option class="input-option" value="yes">Sim</option>
                                </select>
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
@endsection

