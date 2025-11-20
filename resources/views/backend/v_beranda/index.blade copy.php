@extends('backend.v_layouts.app')

@section('content')
<h3>{{ $judul }}</h3>

<p>
    Selamat datang, <b>{{ Auth::user()->nama }}</b> 
    pada Aplikasi SIMASTOK dengan hak akses yang anda miliki sebagai 
    <b>
        @if (Auth::user()->role == 0)
            ADMIN
        @elseif (Auth::user()->role == 1)
            KARYAWAN
        @endif
    </b> 
    Ini adalah halaman utama dari aplikasi ini.
</p>
@endsection
