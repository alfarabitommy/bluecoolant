@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('User Dashboard')}}
@endsection

@section('page-title')
    {{__('User Dashboard')}}
@endsection

@section('content')
    <section class="login-page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-11">
                    <div class="message-show margin-top-10">
                      <x-flash-msg/>
                      <x-error-msg->
                    </div>

                    <div class="user-dashboard-wrapper">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="mobile_nav">
                                <i class="fas fa-cogs"></i>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{__('Dashboard')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="packages-orders-tab" data-toggle="pill" href="#packages-orders" role="tab" aria-selected="false">{{__('Packages Orders')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="edit-profile-tab" data-toggle="pill" href="#edit-profile" role="tab"  aria-selected="false">{{__('Edit Profile')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-edit-password-tab" data-toggle="pill" href="#edit-password" role="tab"aria-selected="false">{{__('Change Password')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  href="{{ route('user.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="user-dashboard-card style-01 text-white">
                                            <div class="icon"><i class="fas fa-money-bill mr-2"></i></div>
                                           <div class="content" class="">
                                               <h4 class="title">{{__('Package Order')}}</h4>
                                               <span class="number">{{$total_orders}}</span>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="packages-orders" role="tabpanel" aria-labelledby="packages-orders-tab">
                          @if($total_orders > 0)
                          <div class="table-responsive">
                              <table class="table table-striped">
                                  <thead>
                                  <tr>
                                      <th scope="col">{{__('Package Order Info')}}</th>
                                      <th scope="col">{{__('Payment Status')}}</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($package_orders as $data)
                                      <tr>
                                          <td>
                                             <div class="user-dahsboard-order-info-wrap">
                                                 <h5 class="title">{{$data->package_name}}</h5>
                                                 <div class="div">
                                                     <small class="d-block"><strong>{{__('Order ID:')}}</strong> #{{$data->id}}</small>
                                                     <small class="d-block"><strong>{{__('Package Price:')}}</strong> {{amount_with_currency_symbol($data->package_price)}}</small>
                                                     <small class="d-block"><strong>{{__('Order Status:')}}</strong>
                                                         @if($data->status == 'pending')
                                                             <span class="alert alert-warning text-capitalize alert-sm alert-small">{{__($data->status)}}</span>
                                                         @elseif($data->status == 'cancel')
                                                             <span class="alert alert-danger text-capitalize alert-sm alert-small">{{__($data->status)}}</span>
                                                         @elseif($data->status == 'in_progress')
                                                             <span class="alert alert-info text-capitalize alert-sm alert-small">{{str_replace('_',' ',__($data->status))}}</span>
                                                         @else
                                                             <span class="alert alert-success text-capitalize alert-sm alert-small">{{__($data->status)}}</span>
                                                         @endif
                                                     </small>
                                                     <small class="d-block"><strong>{{__('Date:')}}</strong> {{date_format($data->created_at,'D m Y')}}</small>
                                                     @if($data->payment_status == 'complete')
                                                         <form action="{{route('frontend.package.invoice.generate')}}"  method="post">
                                                             @csrf
                                                             <input type="hidden" name="id" id="invoice_generate_order_field" value="{{$data->id}}">
                                                             <button class="btn btn-secondary btn-xs btn-small margin-top-10" type="submit"><i class="ti-download"></i> {{__('Invoice')}}</button>
                                                         </form>
                                                     @endif
                                                 </div>
                                             </div>
                                          </td>
                                          <td>
                                              @if($data->payment_status == 'pending' && $data->status != 'cancel')
                                                  <span class="alert alert-warning text-capitalize alert-sm alert-small">{{$data->payment_status}}</span>
                                                  <a href="{{route('frontend.order.confirm',$data->id)}}" class="btn btn-sm btn-success ">{{__('Pay Now')}}</a>
                                                  <form action="{{route('user.dashboard.package.order.cancel')}}" method="post">
                                                      @csrf
                                                      <input type="hidden" name="order_id" value="{{$data->id}}">
                                                      <button type="submit" class="small-btn btn-danger margin-top-10">{{__('Cancel')}}</button>
                                                  </form>
                                              @else
                                                  <span class="alert alert-success text-capitalize alert-sm alert-small" style="display: inline-block">{{$data->payment_status}}</span>
                                              @endif
                                              @if($data->payment_status == 'complete')
                                              <a href="{{route('frontend.order.view',$data->id)}}" class="btn btn-sm btn-info " target="_blank">{{__('View Order')}}</a>
                                              @endif
                                          </td>
                                      </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                          </div>
                          @else
                              <div class="alert alert-warning">{{__('No Order Found')}}</div>
                          @endif

                        </div>
                            <div class="tab-pane fade" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
                                <div class="dashboard-form-wrapper contact-form">
                                    <h2 class="title">{{__('Edit Profile')}}</h2>
                                    <form action="{{route('user.profile.update')}}"  class="contact-page-form style-01" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">{{__('Name')}}</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{$user_details->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{__('Email')}}</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$user_details->email}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">{{__('Phone')}}</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" value="{{$user_details->phone}}">
                                        </div>
                                        <div class="form-group">
                                           <label for="country">{{__('Country')}}</label>
                                            <select id="country" class="form-control" name="country">
                                                <option value="Afganistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bonaire">Bonaire</option>
                                                <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Canary Islands">Canary Islands</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Channel Islands">Channel Islands</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos Island">Cocos Island</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote DIvoire">Cote DIvoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Curaco">Curacao</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Ter">French Southern Ter</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Great Britain">Great Britain</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Hawaii">Hawaii</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="India">India</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea Sout">Korea South</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Midway Islands">Midway Islands</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Nambia">Nambia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                <option value="Nevis">Nevis</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau Island">Palau Island</option>
                                                <option value="Palestine">Palestine</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Phillipines">Philippines</option>
                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Barthelemy">St Barthelemy</option>
                                                <option value="St Eustatius">St Eustatius</option>
                                                <option value="St Helena">St Helena</option>
                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="St Maarten">St Maarten</option>
                                                <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                <option value="Saipan">Saipan</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="Samoa American">Samoa American</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Tahiti">Tahiti</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uraguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State">Vatican City State</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                <option value="Wake Island">Wake Island</option>
                                                <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="state">{{__('State')}}</label>
                                            <input type="text" class="form-control" id="state" name="state" value="{{$user_details->state}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="city">{{__('City')}}</label>
                                            <input type="text" class="form-control" id="city" name="city" value="{{$user_details->city}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="zipcode">{{__('Zipcode')}}</label>
                                            <input type="text" class="form-control" id="zipcode" name="zipcode" value="{{$user_details->zipcode}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">{{__('Address')}}</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{$user_details->address}}">
                                        </div>
                                        <div class="form-group btn-wrapper">
                                            <button class="boxed-btn btn-saas" type="submit">{{__('Save changes')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="edit-password" role="tabpanel" aria-labelledby="pills-edit-password-tab">
                                <div class="dashboard-form-wrapper">
                                    <h2 class="title">{{__('Change Password')}}</h2>
                                    <form action="{{route('user.password.change')}}" class="contact-page-form style-01"  method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="old_password">{{__('Old Password')}}</label>
                                            <input type="password" class="form-control" id="old_password" name="old_password"
                                                   placeholder="{{__('Old Password')}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">{{__('New Password')}}</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   placeholder="{{__('New Password')}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">{{__('Confirm Password')}}</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                   name="password_confirmation" placeholder="{{__('Confirm Password')}}">
                                        </div>
                                        <div class="form-group btn-wrapper">
                                            <button class="boxed-btn btn-saas" type="submit">{{__('Save changes')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            var selectdCountry = "{{$user_details->country}}";
            $('#country option[value="'+selectdCountry+'"]').attr('selected',true);

            $(document).on('click','.user-dashboard-wrapper > ul .mobile_nav',function (e){
               e.preventDefault();
                var el = $(this);

                el.parent().toggleClass('show');

            });

        });
    </script>
@endsection
