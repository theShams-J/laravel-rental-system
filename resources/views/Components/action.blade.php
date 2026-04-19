@props([
    'view' => null, 
    'edit' => null, 
    'delete' => null
])

<div class="d-flex align-items-center gap-0">
    @if($view)
        <a href="{{ url($view) }}" class="btn btn-info btn-sm d-flex align-items-center justify-content-center" style="height: 31px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
            View
        </a>
    @endif

    @if($edit)
        <a href="{{ url($edit) }}" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="height: 31px; border-radius: 0;">
            Edit
        </a>
    @endif

    @if($delete)
        <form action="{{ url($delete) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="height: 31px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                Delete
            </button>
        </form>
    @endif
</div>