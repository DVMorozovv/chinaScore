@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="card-alert card gradient-45deg-red-pink">
            <div class="card-content white-text">
                <p>
                    <i class="material-icons">error</i> Warning : {{ $error }}</p>
            </div>
            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endforeach
@endif
@if (session('success'))
    <div class="card-alert card gradient-45deg-green-teal">
        <div class="card-content white-text">
            <p>
                <i class="material-icons">check</i> Success : {{ session('success') }}</p>
        </div>
        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
