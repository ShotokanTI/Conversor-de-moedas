@extends('layouts.app')


@section('content')
<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <div id="app">
        <?php $user = auth()->user(); ?>
        
        <apiform cotacaoshow="{{ route('cotacao.show',$user->email) }}" cotacaostore="{{ route('cotacao.store') }}"></apiform>

    </div>
</body>

</html>

@endsection