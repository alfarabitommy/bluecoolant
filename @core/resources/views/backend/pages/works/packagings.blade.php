@extends('backend.admin-master')
@section('site-title')
    {{__('Packaging Page')}}
@endsection

@section('style')
    @include('backend.partials.datatable.style')
    <style>
        .select-box-wrap select {
        height: 38px;
        border: none;
        position: relative;
        top: 2px;
        width: 150px;
        border: 1px solid #e2e2e2;
      }

      input[type="checkbox"]{
        height: 15px;
        width: 15px;
     }
    </style>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @include('components/error-msg')
            </div>
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Packagings')}}</h4>
                        <x-bulk-action/>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            <div class="tab-pane fade show active" role="tabpanel" >
                                <div class="table-wrap table-responsive">
                                <table class="table table-default">
                                    <thead>
                                        <th class="no-sort">
                                            <div class="mark-all-checkbox">
                                                <input type="checkbox" class="all-checkbox">
                                            </div>
                                        </th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Action')}}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($all_packaging as $data)
                                        <tr>
                                            <td>
                                            <x-bulk-checkbox :id="$data->id"/>
                                            </td>
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>

                                                <x-delete-alert :route="route('admin.work.delete.packaging',$data->id)"/>

                                                <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#packaging_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 packaging_edit_btn"
                                                       data-id="{{$data->id}}"
                                                       data-name="{{$data->name}}"
                                                    >
                                                        <i class="ti-pencil"></i>
                                                    </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Add New Packaging')}}</h4>
                        <form action="{{route('admin.work.store.packaging')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{__('Packaging Name')}}</label>
                                <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Packaging Name')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="packaging_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Packaging')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.work.update.packaging')}}"  method="post">
                    <input type="hidden" name="id" id="packaging_id">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_name">{{__('Packaging Name')}}</label>
                            <input type="text" class="form-control"  id="edit_name" name="name" placeholder="{{__('Packaging Name')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Change')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
  @include('backend.partials.datatable.script')
    <script>
        $(document).ready(function () {
            $(document).on('click','.packaging_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var modal = $('#packaging_edit_modal');
                modal.find('#packaging_id').val(id);
                modal.find('#edit_name').val(name);
            });
        });
    </script>

    <script>
    $(document).ready(function() {

        $(document).on('click','#bulk_delete_btn',function (e) {
            e.preventDefault();
            var bulkOption = $('#bulk_option').val();
            var allCheckbox =  $('.bulk-checkbox:checked');
            var allIds = [];
            allCheckbox.each(function(index,value){
                allIds.push($(this).val());
            });
            if(allIds != ''){
                $(this).text('Please Wait...');
                $.ajax({
                    'type' : "POST",
                    'url' : "{{route('admin.work.packaging.bulk.action')}}",
                    'data' : {
                        _token: "{{csrf_token()}}",
                        ids: allIds,
                        type: bulkOption
                    },
                    success:function (data) {
                        location.reload();
                    }
                });
            }

        });

        $('.all-checkbox').on('change',function (e) {
            e.preventDefault();
            var value = $('.all-checkbox').is(':checked');
            var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
            //have write code here fr
            if( value == true){
                allChek.prop('checked',true);
            }else{
                allChek.prop('checked',false);
            }
        });


    } );
</script>

@endsection
