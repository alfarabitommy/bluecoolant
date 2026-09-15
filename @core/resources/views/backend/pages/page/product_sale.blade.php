@extends('layouts.backend.main')
@section('title','Sale Product')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xs-6 col-sm-10 col-lg-10">
              <div class="card">
                  <div class="card-header bg-primary">
                    <h4 class="text-white">Sale Product : <span class="text-warning">{{ $product->product_name }}</span>
                    <a class="btn btn-warning btn-sm text-dark" href="{{ route('product.index') }}" style="float:right;">All Product</a>
                    </h4>
                  </div>
                  <div class="card-body card-block">
                  <div class="row">
                    <div class="bg-dark px-2 py-2 my-2 col-md-4">
                      <h6 class="text-white">Part Number : <span class="text-warning">{{ $product->part_number }}</span> </h6>
                      <h6 class="text-white">Product Name : <span class="text-warning">{{ $product->product_name }}</h6>
                      <h6 class="text-white">Available Quantity : <span class="text-warning">{{ $product->quantity }} Pcs.</h6>
                      <h6 class="text-white">Selling Price : <span class="text-warning">{{ $product->selling_price }} Tk. (Per pc)</span> </h6>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                      <span>Photo : </span>
                      <img src="{{ url('storage/product/'.$product->photo) }}" height="80">
                    </div>
                  </div>
                    <form action="{{ route('sale.store',$product->id) }}" method="post">
                      @csrf
                      <div class="row">

                        <div class="form-group col-md-4 mt-2">
                            <label class=" form-control-label">Billing Date :</label>
                              <div class="input-group">
                              <input type="date" class="form-control" name="billing_date" required>
                              <input type="hidden" name="product_id" value="{{ $product->id }}">
                              </div>
                        </div>

                        <div class="form-group col-md-4 mt-2">
                            <label class=" form-control-label">Bill Number :</label>
                              <div class="input-group">
                              <input type="text" class="form-control" name="bill_no" required>
                              </div>
                        </div>

                      <div class="form-group col-md-4">
                          <label class=" form-control-label"> Select Customer :
                            <a class="btn btn-primary btn-sm text-white"data-toggle="modal"
                             data-target="#AddCustomer" href="#">Add Customer</a>
                          </label>
                            <div class="input-group">
                              <select class="form-control" name="customer_id" required>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                              </select>
                            </div>
                      </div>

                      <div class="form-group col-md-4 bg-dark pb-2">
                          <label class=" form-control-label text-white">Demand Quantity :</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="demand_quantity" required id="demand_quantity">
                            </div>
                      </div>
                      <div class="form-group col-md-4 bg-success pb-2">
                          <label class=" form-control-label text-white">Paying Amount :</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="paying_amount" required id="paying_amount">
                            </div>
                      </div>

                      <div class="form-group col-md-4 bg-dark pb-2">
                          <label class=" form-control-label text-white">Discount :</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="discount" id="discount">
                            </div>
                      </div>


                      <div class="form-group col-md-4 bg-danger pb-2">
                          <label class=" form-control-label text-white">Due :</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="due" id="due">
                            </div>
                      </div>

                      <div class="form-group col-md-4 bg-success pb-2">
                          <label class=" form-control-label text-white">Total Bill Amount :</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="total_bill_amount" id="total_bill_amount">
                            <input type="hidden" value="{{ $product->selling_price }}" id="selling_price">
                          </div>
                      </div>

                      <div class="form-group col-md-4 bg-dark pb-2">
                          <label class=" form-control-label text-white">Total Bill After Discount :</label>
                            <div class="input-group">
                            <input type="text" class="form-control" name="total_bill_after_discount" id="total_bill_after_discount">
                          </div>
                      </div>

                    </div>
                  </div>
                  <div class="card-footer bg-primary">
                    <button type="submit" class="btn btn-success btn-sm" style="float:right;">Submit</button>
                  </div>
              </div>
            </form>
          </div>
      </div>
      </div>
@endsection

@push('js')
  <script>
    $(document).ready(function(){
      //All Calculation Events
      $('#demand_quantity').keyup(function(){
        var demand_quantity =  $(this).val();
        var selling_price = $('#selling_price').val();
        var total_calculation = demand_quantity * selling_price;
        $('#total_bill_amount').val(total_calculation);
        $('#due').val(total_calculation);

        var paying_amount =  $('#paying_amount').val();
        var due =  $('#due').val();
        var total_bill_amount = $('#total_bill_amount').val();
        var due_calculation = total_bill_amount - paying_amount;
        $('#due').val(due_calculation);
      })

        $('#paying_amount').keyup(function(){
          var paying_amount =  $(this).val();
          var due =  $('#due').val();
          var total_bill_amount = $('#total_bill_amount').val();
          var due_calculation = total_bill_amount - paying_amount;
          $('#due').val(due_calculation);
        })

        $('#due').keyup(function(){
          var due =  $(this).val();
          var paying_amount =  $('#paying_amount').val();
          var total_bill_amount = $('#total_bill_amount').val();
          var due_calculation = total_bill_amount - paying_amount;
          $('#due').val(due_calculation);
        })

        $('#discount').keyup(function(){
          var discount =  $(this).val();
          var total_bill_amount = $('#total_bill_amount').val();
          var discount_calculation = total_bill_amount - discount;
          $('#due').val('');
          $('#total_bill_after_discount').val(discount_calculation);
        })

    })

  </script>
@endpush
