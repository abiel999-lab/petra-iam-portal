@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="col-sm-8 mt-3 mb-2" style="margin-left: auto; margin-right: auto;">
        <form action="#" method="GET">
            <div class="input-group input-group-md">
                <input class="form-control form-control-lg" type="search" id="search-input" placeholder="Cari Aplikasi">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="flexgrid">
    @foreach($sections as $section)
        <div class="mb-3 container" style="text-align: left;">
            <h1 class="col-lg-5" style="text-align: left; font-weight: 550; color: #1E3258; border-bottom: 3px #f8ad3d solid;">
                {{ $section['title'] }}
            </h1>
        </div>

        <div class="container">
            @foreach($section['items'] as $item)
                <a class="thing" href="{{ $item['url'] }}">
                    <i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}
                </a>
            @endforeach
        </div>
    @endforeach
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const appLinks = document.querySelectorAll(".thing");

    searchInput.addEventListener("keyup", function() {
        const keyword = this.value.toLowerCase().trim();

        appLinks.forEach(link => {
            const text = link.textContent.toLowerCase().trim();
            link.style.display = text.includes(keyword) ? "" : "none";
        });
    });
});
</script>
@endsection
