@extends('layouts.app-admin')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
            <h1>Professores</h1>
            <div> 
                <a href="">
                    <button class="green-button">
                        Cadastrar Professor <i class="fa-solid fa-user-plus" style="color: #3a6604;"></i>
                    </button>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="border-collapse: collapse;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center align-middle">Nome</th>
                        <th class="text-center align-middle">Qtd. Alunos</th>
                        <th class="text-center align-middle">Qtd. Aulas</th>
                        <th class="text-center align-middle">Valor Aulas</th>
                        <th class="text-center align-middle">Valor das Salas</th>
                        <th class="text-center align-middle"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    @php
                        $qtdClasses = 0;
                        $qtdStudents = 0;
                        $totalValue = 0;
                        
                        foreach($managements as $item){
                            if($item->teacher_id == $teacher->id){
                                $qtdClasses += $item->quantity_classes;
                            }
                        }

                        foreach($students as $item){
                            if($item->teacher_id == $teacher->id){
                                $qtdStudents++;
                            }
                        }

                        foreach($managements as $item){
                            if($item->teacher_id == $teacher->id){
                                $totalValue += $item->total_value;
                            }
                        }

                        $rentValue = $qtdClasses * 20;

                    @endphp
                        <tr>
                            <td class="text-center align-middle">{{ $teacher->name }}</td>
                            <td class="text-center align-middle">{{ $qtdStudents }}</td>
                            <td class="text-center align-middle">{{ $qtdClasses }}</td>
                            <td class="text-center align-middle">R${{ number_format($totalValue ?? 0, '2', ',', '.') }}</td>
                            <td class="text-center align-middle">R${{ number_format($rentValue ?? 0, '2', ',', '.') }}</td>
                            <td class="text-center align-middle">
                                <form action="{{ route('admin-editar-professor', $teacher->id) }}">
                                    <button
                                        class="btn-link-style" 
                                        title="Editar"
                                        style="background: none; border: none; padding: 0; cursor: pointer;">                                       
                                        <img src="{{ asset('imgs/edit.png') }}" width="30" alt="Ícone editar">
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin-remover-professor', $teacher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-link-style" 
                                            title="Remover"
                                            onclick="return confirm('Tem certeza?')"
                                            style="background: none; border: none; padding: 0; cursor: pointer;">
                                        <img src="{{ asset('imgs/remove.png') }}" width="30" alt="Ícone remover">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Nenhum professor cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection