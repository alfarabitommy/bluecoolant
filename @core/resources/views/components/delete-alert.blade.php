<a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
   role="button"
   data-toggle="popover"
   data-trigger="focus"
   data-html="true"
   title=""
   data-content="
    <h6>Are you sure to delete this service item ?</h6>
    <form method='post' action='{{$route}}'>
    <input type='hidden' name='_token' value='{{csrf_token()}}'>
    <br>
    <input type='submit' class='btn btn-danger btn-sm' value='Yes, Delete'>
    </form>
    ">
    <i class="ti-trash"></i>
</a>
