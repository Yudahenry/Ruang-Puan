@extends($peran === 'konselor' ? 'layouts.konselor' : 'layouts.pengguna')

@section('pengguna-content')
    @include('konsultasi._chat-isi')
@endsection

@section('konselor-content')
    @include('konsultasi._chat-isi')
@endsection
