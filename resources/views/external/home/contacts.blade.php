@extends(isset($admin_side) ? 'layouts.main' : 'layouts.external.app')

@section('styles')
    @if (isset($admin_side))
        <link rel="stylesheet" href="{{ asset('css/main.css') }}?d51">
    @endif
@endsection


@section(isset($admin_side) ? 'content' : 'body')
    <style>
        .alert {
            margin-top: 20px;
        }

    

        label {
            font-weight: 500;
        }

        /* .input-group-box label{
            margin: 10px 0;
        } */

        .select2-container--default .select2-selection--multiple {
            border-color: #ced4da !important;
        }

        .form-group .form-equal-inputs {
            flex: 1;
        }

        .form-group .form-equal-inputs:first-child {
            margin-right: 6px;
        }

        .target-img-display-container {
            --img-border: 2px solid lightblue;
        }

        .img-display-wrapper {
            position: relative;
            width: 180px;
            height: 180px;
            padding: 2px;
            border: var(--img-border);
            border-radius: 50%;
        }

        .img-display-wrapper::before {
            content: "";
            border: var(--img-border);
            position: absolute;
            inset: 0px;
            border-radius: 50%;
            margin: -2px;

            transition: transform 100ms;
        }

        .img-display-wrapper:hover::before {
            transform: scale(1.02);
        }

        .img-display-holder {
            width: 100%;
            height: 100%;
        }

        .img-display-tag {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .input_span {
            position: absolute;
            right: 30px;
            top: 104px;
            color: red;

        }

        .hide {
            display: none;
        }






        #flexSwitchCheckDefault {
            transform: scale(1.5);
        }

        @media screen and (max-width: 767px) {
            .mmb {
                margin-bottom: 15px;
            }

            .comment_light {
                display: block !important;
            }

            .comment_input {
                width: 100% !important;
            }

            .with_light {
                margin: 18px 0px 18px 9px !important;
            }
        }
    </style>
    @php
        $item_name = old('name');
        $item_phone_number = old('phone_number');
        $item_email = old('email');
        $item_message = old('message');
    @endphp
    @if (session('success'))
        <div class="container mt-5">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="container">
        <div class="card card-custom rounded-0 rounded-top mt-4">
            <div class="card-header">
                <h5 class="card-title">
                    შეტყობინების გამოგზავნა
                </h5>
            </div>
            <div class="card-body  rounded-0 border-0 bg-light">
                <div class="form-group" >
                    
                    <form method="POST" action="{{ Route('user-contacts') }}">
                        @csrf
                        <input type="hidden" name="cookie" id="cookie" value="">
                        <div class="mb-2 mt-2">
                            <input value="{{ $item_name }}" required id="name" oninput="convertToGeorgian(event)"
                                type="text" class="form-control mmb {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                name="name" placeholder="სახელი" />
                            @if ($errors->has('name'))
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input value="{{ $item_phone_number }}"  id="phone_number" type="number"
                                name="phone_number"
                                class="form-control mmb {{ $errors->has('phone_number') ? 'is-invalid' : '' }} {{ $errors->has('email_or_phone') ? 'is-invalid' : '' }}"
                                placeholder="ტელეფონის ნომერი" />

                            @if ($errors->has('phone_number'))
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <input value="{{ $item_email }}"  id="email" type="text"
                                class="form-control mmb {{ $errors->has('email') ? 'is-invalid' : '' }}  {{ $errors->has('email_or_phone') ? 'is-invalid' : '' }}" name="email"
                                placeholder="ელ-ფოსტა" />
                            @if ($errors->has('email'))
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @elseif($errors->has('email_or_phone'))
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('email_or_phone') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <textarea required id="message" style="height:100px; resize:none" type="email"
                                class="form-control mmb {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message"
                                placeholder="შეტყობინება">{{ $item_message }}</textarea>
                            @if ($errors->has('message'))
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            
                            <button id="send-submit" class="btn btn-primary" style="display:none">შეტყობინების გამოგზავნა</button>
                            <input id="send-click" type="button" class="btn btn-primary send" value="შეტყობინების გამოგზავნა">
                      
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

@endsection

@push('scripts')
    <script>
     
        $('#send-click').on('click', function(e){
            $(this).closest('form').find('#send-submit').click();
        })

        function convertToGeorgian(event) {
            const input = event.target;
            const value = input.value;
            let georgianText = '';

            for (let i = 0; i < value.length; i++) {
                const latinChar = value[i];

                if (isAlphabetic(latinChar)) {
                    const georgianChar = convertLatinToGeorgian(latinChar);
                    georgianText += georgianChar;
                } else {
                    georgianText += latinChar;
                }
            }

            input.value = georgianText;
        }

        function isAlphabetic(char) {
            return /^[a-zA-Z]+$/.test(char);
        }

        function convertLatinToGeorgian(latinChar) {
            const latinToGeorgianMap = {
                a: 'ა',
                b: 'ბ',
                g: 'გ',
                d: 'დ',
                e: 'ე',
                v: 'ვ',
                z: 'ზ',
                T: 'თ',
                i: 'ი',
                k: 'კ',
                l: 'ლ',
                m: 'მ',
                n: 'ნ',
                o: 'ო',
                p: 'პ',
                J: 'ჟ',
                r: 'რ',
                s: 'ს',
                t: 'ტ',
                u: 'უ',
                f: 'ფ',
                q: 'ქ',
                R: 'ღ',
                y: 'ყ',
                S: 'შ',
                C: 'ჩ',
                c: 'ც',
                Z: 'ძ',
                w: 'წ',
                W: 'ჭ',
                x: 'ხ',
                j: 'ჯ',
                h: 'ჰ'
            };

            return latinToGeorgianMap[latinChar] || latinChar;
        }

        function randomString(length) {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                result += characters.charAt(randomIndex);
            }

            return result;
        }
    </script>
@endpush
