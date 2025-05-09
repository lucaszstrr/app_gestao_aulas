@extends('layouts.app-logged')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
            <h1>Meus Alunos</h1>
            <a href="{{ route('adicionar-aluno') }}"><button class="add-student-btn">Cadastrar aluno</button></a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="border-collapse: collapse;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center align-middle">Nome</th>
                        <th class="text-center align-middle">Responsável</th>
                        <th class="text-center align-middle">Ano</th>
                        <th class="text-center align-middle">Escola</th>
                        <th class="text-center align-middle">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="text-center align-middle">{{ $student->name }}</td>
                            <td class="text-center align-middle">{{ $student->responsible }}</td>
                            <td class="text-center align-middle">{{ $student->school_year }}</td>
                            <td class="text-center align-middle">{{ $student->school }}</td>
                            <td class="text-center align-middle">

                                <form action="{{ route('editar-aluno', $student->id) }}">
                                    <button
                                        class="btn-link-style" 
                                        title="Editar"
                                        style="background: none; border: none; padding: 0; cursor: pointer;">                                       
                                        <img src="{{ asset('imgs/edit.png') }}" width="30" alt="Ícone editar">
                                    </button>
                                </form>
                                
                                <form action="{{ route('remover-aluno', $student->id) }}" method="POST" class="d-inline">
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
                            <td colspan="5" class="text-center py-4">Nenhum aluno cadastrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        

    </div>



@endsection