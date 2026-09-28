<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title') · SkillNest Organizer</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@yield('head')
</head>
<body>
<main style="margin:auto;width:min(460px,92vw);padding:24px 0">
    <div class="logo" style="justify-content:center;margin-bottom:16px"><img src="{{ asset('images/logo.png') }}" alt="SkillNest"><span>SkillNest<small>Portal Organizer</small></span></div>
    <section class="card">@yield('content')</section>
</main>
@if (session('ok'))<div class="toast" role="status">{{ session('ok') }}</div>@endif
@if (session('err'))<div class="toast bad" role="alert">{{ session('err') }}</div>@endif
<script>document.querySelectorAll('.toast').forEach(t => setTimeout(() => t.remove(), 5000));</script>
</body>
</html>