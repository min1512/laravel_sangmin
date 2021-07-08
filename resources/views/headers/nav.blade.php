<ul>
	<li class="dropdown">
		<a href="/" class="dropbtn">Home</a>
	</li>
	<li class="dropdown">
		<a href="#" class="dropbtn">국가</a>
		<div class="dropdown-content">
				@foreach ($tests as $test)
                    <a href="#">{{ $test->country }}</a>
				@endforeach
		</div>
	</li>
	<li class="dropdown">
		<a href="#" class="dropbtn">작성자</a>
		<div class="dropdown-content">
				@foreach ($tests as $test)
                    <a href="#">{{ $test->writer}}</a>
				@endforeach
		</div>
	</li>
	<li class="dropdown">
		<a href="#" class="dropbtn">언어</a>
		<div class="dropdown-content">
				@foreach ($tests as $test)
                    <a href="#">{{ $test->language}}</a>
				@endforeach
		</div>
	</li>
    <li class="dropdown">
        <a href="/api/user/{{isset(Auth::user()->id)?Auth::user()->id:""}}" class="dropbtn">API TEST</a>
    </li>
	<li class="dropdown">
		<a href="/api/Naver_API" class="dropbtn">Naver_API</a>
	</li>
	<li class="dropdown">
		<a href="/date" class="dropbtn">달력</a>
	</li>

	@if(Auth::check())
	<li style="float:right;" class="dropdown">
		<a href='/success'>글쓰기 게시판</a>
	</li>
	@else
	@endif
	@if(!Auth::check())
	<li style="float:right;" class="dropdown">
			<a href="/login" class="dropbtn">회원가입</a>
	</li>
	@endif
	<li style="float:right;" class="dropdown">
			<a href="/list" class="dropbtn">회원 정보 페이지</a>
	</li>
	<li style="float:right;" class="dropdown">
		@if(Auth::check())
		<a class="dropbtn" onclick="check1()">{{Auth::user()->name}}</a>
		@else
		<a href="/login1">로그인</a>
		@endif
	</li>
</ul>
