<?php

//require_once('credentials.php');

?><!DOCTYPE html>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <title>HiPay Fullservice Tokenization With CardJs and Promise</title>

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdn.jsdelivr.net/bluebird/3.5.0/bluebird.js"></script>
    <script src="/bower_components/axios/dist/axios.min.js"></script>
    <link href="/vendor/CardJs-master/card-js.min.css" rel="stylesheet" type="text/css" />
    <script src="/vendor/CardJs-master/card-js.min.js"></script>
    <script src="/vendor/btoa.js"></script>
    <script type="text/javascript" src="/src/hipay-fullservice-sdk.js"></script>






    <link href="./assets/basic.css" media="screen" rel="stylesheet" type="text/css">
    <link href="./assets/basic-client.css" media="screen" rel="stylesheet" type="text/css">
    <link href="./assets/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css">
    <link href="./assets/payment-methods.css" media="screen" rel="stylesheet" type="text/css">


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <!--<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
    <![endif]-->
</head>

<body>

<div class="modal fade" id="cvv-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="modal-header-title">
                    <h4 class="modal-title" id="myModalLabel">Card verification code</h4>
                </div>
                <div id="modal-header-close">
                    <button type="button" id="btn-close" data-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body">
                <p>For security reasons, you have to enter your card security code (CVC).
                    It's the 3-digits number on the back of your card for <span class="modal-bold">VISA®</span>, <span class="modal-bold">MASTERCARD®</span> and <span class="modal-bold">MAESTRO®</span></p>
                <p>The <span class="modal-bold">AMERICAN EXPRESS</span> security code is the 4-digits number on the front of your card.</p>
                <div id="cvv-img">
                    <img src="./assets/card.png">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="main" class="container">

    <div id="left-side" class="col-md-7">
        <div id="infos">
            <div id="infos-txt">
                <div id="price">HiPay Direct Post Tokenization Simulator V2</div>
                <div id="order">Submit the form in oder to tokenize the credit card details using the HiPay Fullservice SDK for JavaScript (payment details won't hit the server). You will see the HiPay Fullservice platform response below.</div>
                <div id="code"></div>
                <div id="link-area"><a href="#null" id="link">Click here</a> to fill the form with sample payment details.</div>
                <div id="charge"><button type="button" id="charge-button" style="display: none;">Create a test charge on this token (server-side PHP SDK)</button></div>
            </div>
        </div>
    </div>

    <div id="form" class="col-md-5">

        <div class="details">
            Enter your payment details:
        </div>

        <!--        <div style="margin-top: 50px">-->
        <!--            <div id="my-card-1" class="card-js" data-capture-name="true" data-icon-colour="#158CBA"></div>-->
        <!--        </div>-->


        <div id="container-hipay-cc-form"></div>
        <script>
            HiPay.getFormCC('container-hipay-cc-form');
        </script>

        <!--        <div>-->
        <!--            <div class="input-group" id="card-number">-->
        <!--                <span class="input-group-addon"></span>-->
        <!--                <input id="input-card" type="number" placeholder="Card number" maxlength="16">-->
        <!--            </div>-->
        <!--            <div class="input-group" id="name">-->
        <!--                <span class="input-group-addon"></span>-->
        <!--                <input id="input-name" type="text" placeholder="Cardholder">-->
        <!--            </div>-->
        <!---->
        <!--        </div>-->

        <!--        <div>-->
        <!--            <div class="input-group" id="date">-->
        <!--                <span class="input-group-addon"></span>-->
        <!--                <input id="input-month" type="number" placeholder="Month" maxlength="2">-->
        <!--                <input id="input-year" type="number" placeholder="Year" maxlength="4">-->
        <!--            </div>-->
        <!--            <div>-->
        <!--                <div class="input-group col-md-6" id="cvv">-->
        <!--                    <span class="input-group-addon"></span>-->
        <!--                    <input id="input-cvv" type="number" placeholder="CVV" maxlength="3">-->
        <!--                </div>-->
        <!--                <div id="cvv-button" class="col-md-6">-->
        <!--                    <button type="button" data-toggle="modal" data-target="#cvv-modal">?</button>-->
        <!--                </div>-->
        <!--            </div>-->
        <!---->
        <!--        </div>-->

        <div id="submit-zone">
            <div id="error"></div>
            <button type="button" data-toggle="modal" data-target="#other-method-modal" id="pay-button">Tokenize</button>
        </div>
    </div>

    <footer class="container">
        <div class="fcontent"><div id="certif-digicert"></div></div>
        <div class="fcontent"><div id="certif-pci"></div></div>
        <div class="fcontent"><div id="certif-mastercard"></div></div>
        <div class="fcontent"><div id="certif-visa"></div></div>
    </footer>

    <div id="brand" class="container">
        <a href="http://www.hipayfullservice.com/" target="_blank" id="fs-logo"></a>
    </div>

</div>

<script type="text/javascript" src="./assets/modal.js"></script>
<script type="text/javascript" src="./assets/links.js"></script>
<!--<script type="text/javascript" src="./assets/input.js"></script>-->

<script type="text/javascript">

    $(document).ready(function(){

        var token = null;



        $('#link').click(function() {

//            $('#input-card').prop('value', '4111111111111111');
            $('#my-card-1 .card-number').prop('value', '4111111111111111');

//            $('#input-cvv').prop('value', '123');
            $('#my-card-1 .cvc').prop('value', '123');
            $('input[name="expiry-month"]').prop('value', '12');
            $('input[name="expiry-year"]').prop('value', '20');
            $('#my-card-1  .expiry').prop('value', '12 / 20');
//            $('#my-card-1  name=["expiry-month"]').prop('value', '12');
//            $('#my-card-1  .expiry-year').prop('value', '20');
//            $('#input-name').prop('value', 'John Doe');
            $('#my-card-1 .name').prop('value', 'John Doe');
        });

        $("#charge-button").click(function() {

            $("#charge-button").text("Loading…");
            $("#charge-button").prop("disabled", true);

            $.ajax({
                url : 'order.php?token='+token,
                type : 'GET',
                dataType : 'html',
                success : function(html, status){
                    $('#order').html(html);
                    $('#code').html('');
                    $("#charge-button").hide();
                },

                error : function(result, status, error){
                    $('#order').html(result.responseText);
                    $('#code').html('');
                    $("#charge-button").text("Try again to create a charge…");
                    $("#charge-button").prop("disabled", false);
                },
            });

        });

        $("#pay-button").click(function() {

            $("#form :input").prop("disabled", true);
            $("#form :button").prop("disabled", true);
            $("#error").text("");

            $("#pay-button").text("Loading…");


//            var myCard = $('#my-card-1');



            var myCard = $('#my-card-1');
            var cardNumber = myCard.CardJs('cardNumber');
            var cardType = myCard.CardJs('cardType');
            var name = myCard.CardJs('name');
            var expiryMonth = myCard.CardJs('expiryMonth');
            var expiryYear = myCard.CardJs('expiryYear');
            var cvc = myCard.CardJs('cvc');

            console.info(cardNumber);


            var params = {
                card_number: cardNumber,
                cvc: cvc,
                card_expiry_month: expiryMonth,
                card_expiry_year: expiryYear,
                card_holder: name,
                multi_use: '0'
            };




//            var params = {
//                card_number: $('#input-card')[0].value,
//                cvc: $('#input-cvv')[0].value,
//                card_expiry_month: $('#input-month')[0].value,
//                card_expiry_year: $('#input-year')[0].value,
//                card_holder: $('#input-name')[0].value,
//                multi_use: '0'
//            };




            HiPay.setTarget('stage'); // default is production/live

//            HiPay.setCredentials('<?php //echo $credentials['public']['username']; ?>//', '<?php //echo $credentials['public']['password']; ?>//');
            HiPay.setCredentials('94656047.stage-secure-gateway.hipay-tpp.com', 'Test_pfS0ojds5ZPu1t8ow8PuASCD');
//            HiPay.setCredentials('94657921.secure-gateway.hipay-tpp.com', 'Live_MhbnSbtFzu4E0axZvPSIEeLu');

//            HiPay.create(params,
//                function(result) {
//
//                    token = result.token;
//
//                    $("#pay-button").text("Tokenize");
//                    $("#order").text("The token has been created using the JavaScript SDK (client side).");
//
//                    $('#code').text(JSON.stringify(result, null, 4));
//                    $('#link-area').text('');
//
//                    $("#charge-button").show();
//
//                }, function (errors) {
//                    $("#pay-button").text("Tokenize");
//                    $("#form :input").prop("disabled", false);
//                    $("#form :button").prop("disabled", false);
//
//                    if (typeof errors.message != "undefined") {
//                        $("#error").text("Error: " + errors.message);
//                    } else {
//                        $("#error").text("An error occurred with the request.");
//                    }
//                }
//            );



            HiPay.tokenize(params)
                .then(function(cardToken) {

                    console.log("cardToken");
                    console.log(cardToken);
//                    token = result.token;
//
                    $("#pay-button").text("Tokenize");
                    $("#order").text("The token has been created using the JavaScript SDK (client side).");

                    $('#code').text(JSON.stringify(cardToken, null, 4));
                    $('#link-area').text('');

                    $("#charge-button").show();

                    console.log("Mon token : " + cardToken.token);
                    console.log("Mon issuer : " + cardToken.issuer);

//                     console.log(j);
                    //    fn_success(response);
                    // document.body.innerHTML = body
                })
                .catch(function(error){

                    $("#pay-button").text("Tokenize");
                    $("#form :input").prop("disabled", false);
                    $("#form :button").prop("disabled", false);


                        if (error.errorCollection != undefined && error.errorCollection.length > 0) {
                            for (var i = 0; i < error.errorCollection.length; i++) {
                                console.log('collectionError[i]');
                                console.log(error.errorCollection[i]);
                                var errorParameters = error.errorCollection[i];
                                $("#error").append(errorParameters.message);
                            }
                        }

                });








            return false;
        });

    });

</script>



</body></html>