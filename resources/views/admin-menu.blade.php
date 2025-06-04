@extends('layouts.app-admin')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
            <h1>Menu Administrador</h1>
            <div> 
                <a href="{{ route('gerar-planilha-admin') }}">
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
                        <th class="text-center align-middle">Professor</th>
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

                            if($paidStatus == 1){
                                $paid = "Sim";
                            }else{
                                $paid = "Não";
                            }
                            
                            foreach($teachers as $person){
                                if($person->id == $student->teacher_id){
                                    $teacher = $person;
                                }
                            }

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
                            <td class="text-center align-middle">{{ $teacher->name }}</td>
                            <td class="text-center align-middle">{{ $school_year }}</td>
                            <td class="text-center align-middle">{{ $student->school }}</td>
                            <td class="text-center align-middle">R$ {{ number_format($student->class_value ?? 0, 2, ',', '.') }}</td>
                            <td class="text-center align-middle">{{ $latestManagement->quantity_classes ?? 0 }}</td>
                            <td class="text-center align-middle">R$ {{ number_format($latestManagement->total_value ?? 0, 2, ',', '.') }}</td>   
                            <td class="text-center align-middle">{{ $paid }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Nenhum aluno cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection