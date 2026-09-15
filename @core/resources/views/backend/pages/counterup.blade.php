@extends('backend.admin-master')
@section('site-title')
    {{__('Counterup Item')}}
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
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Conterup Items')}}</h4>
                        <x-bulk-action/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_counterup as $key => $countu)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_counterup as $key => $counterup)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                  <div class="table-wrap table-responsive">
                                    <table class="table table-default">
                                        <thead>
                                          <th class="no-sort">
                                           <div class="mark-all-checkbox">
                                               <input type="checkbox" class="all-checkbox">
                                           </div>
                                        </th>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Icon')}}</th>
                                        <th>{{__('Number')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Extra Text')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($counterup as $data)
                                            <tr>
                                              <td>
                                                <x-bulk-checkbox :id="$data->id"/>
                                              </td>
                                                <td>{{$data->id}}</td>
                                                <td><i class="{{$data->icon}}"></i></td>
                                                <td>{{$data->number}}</td>
                                                <td>{{$data->title}}</td>
                                                <td>{{$data->extra_text}}</td>
                                                <td>
                                                  <x-delete-alert :route="route('admin.counterup.delete',$data->id)"/>

                                                    <a href="#"
                                                       data-toggle="modal"
                                                       data-target="#counterup_item_edit_modal"
                                                       class="btn btn-lg btn-primary btn-sm mb-3 mr-1 counterup_edit_btn"
                                                       data-id="{{$data->id}}"
                                                       data-action="{{route('admin.counterup.update')}}"
                                                       data-title="{{$data->title}}"
                                                       data-number="{{$data->number}}"
                                                       data-lang="{{$data->lang}}"
                                                       data-icon="{{$data->icon}}"
                                                       data-extra="{{$data->extra_text}}"
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
                                @php $b++; @endphp
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('New Counterup')}}</h4>
                        <form action="{{route('admin.counterup')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="language"><h6><strong>{{__('Languages')}}</strong></h6></label>
                                <select name="lang" id="language" class="form-control"style="height:42px;">
                                    @foreach($all_language as $data)
                                        <option value="{{$data->slug}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                                <small>{{__("select language for make this text multilingual")}}</small>
                            </div>
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  id="title"  name="title" placeholder="{{__('Title')}}">
                            </div>
                            <div class="form-group">
                                <label for="icon" class="d-block">{{__('Icon')}}</label>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary iconpicker-component">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </button>
                                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                            data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu"></div>
                                </div>
                                <input type="hidden" class="form-control"  id="icon" value="fas fa-exclamation-triangle" name="icon">
                            </div>
                            <div class="form-group">
                                <label for="number">{{__('Number')}}</label>
                                <input type="text" class="form-control"  id="number"  name="number" placeholder="{{__('Number')}}">
                            </div>
                            <div class="form-group">
                                <label for="extra_text">{{__('Extra Text')}}</label>
                                <input type="text" class="form-control"  id="extra_text"  name="extra_text" placeholder="{{__('Extra Text')}}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add  New Counterup')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="counterup_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Counterup Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="#" id="counterup_edit_modal_form"  method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="counterup_id" value="">
                        <div class="form-group">
                            <label for="edi_language"><h6><strong>{{__('Languages')}}</strong></h6></label>
                            <select name="lang" id="edit_language" class="form-control"style="height:42px;">
                                @foreach($all_language as $data)
                                    <option value="{{$data->slug}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                            <small>{{__("select language for make this text multilingual")}}</small>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title" name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_icon" class="d-block">{{__('Icon')}}</label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary iconpicker-component">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                        data-selected="fas fa-exclamation-triangle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                            <input type="hidden" class="form-control"  id="edit_icon" value="fas fa-exclamation-triangle" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="edit_number">{{__('Number')}}</label>
                            <input type="text" class="form-control"  id="edit_number"  name="number" placeholder="{{__('Number')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_extra_text">{{__('Extra Text')}}</label>
                            <input type="text" class="form-control"  id="edit_extra_text"  name="extra_text" placeholder="{{__('Extra Text')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click','.counterup_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var number = el.data('number');
                var action = el.data('action');
                var icon = el.data('icon');
                var extra = el.data('extra');
                var form = $('#counterup_edit_modal_form');
                form.attr('action',action);
                form.find('#counterup_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_icon').val(icon);
                form.find('#edit_number').val(number);
                form.find('#edit_extra_text').val(extra);
                form.find('#edit_language option[value='+el.data("lang")+']').attr('selected',true);//lang
                form.find('.iconpicker-component i').attr('class',icon);
                form.find('.iconpicker-element').attr('data-selected',icon);
            });

            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function (e) {
                var selectedIcon = e.iconpickerValue;
                $(this).parent().parent().children('input').val(selectedIcon);
            });

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
                        'url' : "{{route('admin.counterup.bulk.action')}}",
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
        });
    </script>

    @include('backend.partials.datatable.script')
@endsection
