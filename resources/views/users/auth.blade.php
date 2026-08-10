@extends('layouts.main')
@section('body')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Вход в систему</h3>
                
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email адрес</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="test@test.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required value="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Войти
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>   
@endsection