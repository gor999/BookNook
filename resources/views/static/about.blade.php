@extends('layouts.main')

@section('content')
<div class="about-container">
    <div class="about-card">
        <h1>📚 Մեր մասին</h1>
        
        <div class="about-description">
            <p>{{ $description ?? 'Բարի գալուստ BookNook: Մենք առաջարկում ենք լավագույն տեսականին ձեր ընթերցանության համար:' }}</p>
        </div>

        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">1000+</span>
                <span class="stat-label">Գրքեր</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">500+</span>
                <span class="stat-label">Հաճախորդներ</span>
            </div>
        </div>
    </div>
</div>
@endsection