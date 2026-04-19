@props(['title' => null])

<div class='card'>
       <div class='card-header d-flex justify-content-between'>

            <h6 class="mb-0 fw-bolder fs-2">{{$title}}</h6>

       </div>

        <div class='card-body'>
         {{ $slot }}
       </div>
</div>