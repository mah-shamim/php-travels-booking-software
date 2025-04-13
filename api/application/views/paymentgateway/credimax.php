<div class="credimax">
    <span id="loader">Loading...</span>
    <input type="button" id="showPaymentPage" value="Pay with Payment Page" style="display:none" onclick="Checkout.showPaymentPage();" />

    <script type="text/javascript">
        var conf = {
            merchant   : "<?php echo $params['merchantId']; ?>",
            session    : {
                id: "<?php echo $params['response']->session->id; ?>"
            },
            order      : {
                amount      : "<?php echo $params['amount']; ?>",
                currency    : "<?php echo $params['currency']; ?>",
                description : "<?php echo sprintf('%s (%s)', $params['invoiceData']->title, $params['invoiceData']->location); ?>",
                id          : "<?php echo $params['invoiceid']; ?>",
            },
            interaction: {
                merchant   : {
                    name   : 'Departure24',
                    address: {
                            line1: 'Building A0018 Road 0029 Block, 529 Al-Markh, Kingdom of Bahrain',
                            line2: ''            
                    },
                    email  : 'travel@departure24.bh',
                    phone  : '+973 17600214',
                    logo   : 'https://departure24.bh/uploads/global/logo.png'
                },
                locale     : 'en_US',
                theme      : 'default'
            }
        };
        
        function errorCallback(error) {
            console.log(JSON.stringify(error));
        }
        function cancelCallback() {
            console.log('Payment cancelled');
        }
        function getPageState() {
            return conf;
        }
        function restorePageState(data) {
            //set page state from data object
            console.log(data);
        }
        function completeCallback(resultIndicator, sessionVersion) {
            //handle payment completion
            console.log("After Complete Callback Response");
            console.log(resultIndicator);
            console.log(sessionVersion);
        }
        
        function loadScript(path, callback) {

            var done = false;
            var scr = document.createElement('script');

            scr.onload = handleLoad;
            scr.onreadystatechange = handleReadyStateChange;
            scr.onerror = handleError;
            scr.src = path;
            scr.setAttribute("data-error", "errorCallback");
            scr.setAttribute("data-cancel", "cancelCallback");
            scr.setAttribute("data-beforeRedirect", "getPageState");
            scr.setAttribute("data-afterRedirect", "restorePageState");
            scr.setAttribute("data-complete", "completeCallback");
            document.body.appendChild(scr);

            function handleLoad() {
                if (!done) {
                    done = true;
                    callback(path, "ok");
                }
            }

            function handleReadyStateChange() {
                var state;

                if (!done) {
                    state = scr.readyState;
                    if (state === "complete") {
                        handleLoad();
                    }
                }
            }
            function handleError() {
                if (!done) {
                    done = true;
                    callback(path, "error");
                }
            }
        }

        loadScript("https://credimax.gateway.mastercard.com/checkout/version/43/checkout.js", function(path, status) {
            Checkout.configure(conf);

            $("#showPaymentPage").css("display", "block");
            $("#loader").css("display", "none");
            console.log('CredimaxSessionCheckout: ' + '<?php echo $params['response']->result; ?>');
        });
    </script>
</div>