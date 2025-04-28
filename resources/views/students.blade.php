@extends('layouts.app-logged')

@section('content')

    <div class="content-students-page">
        <div class="students-content">
            <h1>Meus Alunos</h1>
            <a href="{{ route('adicionar-aluno') }}"><button class="add-student-btn">Cadastrar aluno</button></a>
        </div>

    </div>



@endsection